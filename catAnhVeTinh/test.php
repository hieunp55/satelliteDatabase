<?php
	$a = array();
    $
/*

The issue was that File needs more than just the content. Instead of trying to use File and doing this:

image_file = File(downloaded, name=file_name)
image_file.size = len( downloaded )
I should use ContentFile and do this:

image_file = ContentFile(downloaded)
From the documentation:

The ContentFile class inherits from File, but unlike File it operates on string content, rather than an actual file.

____________________________________________________________

def file_download(request, filename):
from django.core.servers.basehttp import FileWrapper
import mimetypes
import settings
import os

filepath = os.path.join(settings.MEDIA_ROOT, filename)    
wrapper = FileWrapper(open(filepath))
content_type = mimetypes.guess_type(filepath)[0]
response = HttpResponse(wrapper, mimetype='content_type')
response['Content-Disposition'] = "attachment; filename=%s" % filename
return response
However, it doesn't work for images (I tries jpg files), but do work for txt files. Why?

probably you need to open the file in binary mode:

wrapper = FileWrapper(open(filepath, 'rb'))
____________________________________________________________
FileWrapper won't work when GZipMiddleware is installed (Django 1.4 and below): https://code.djangoproject.com/ticket/6027

If using GZipMiddleware, a practical solution is to write a subclass of FileWrapper like so:

from wsgiref.util import FileWrapper
class FixedFileWrapper(FileWrapper):
    def __iter__(self):
        self.filelike.seek(0)
        return self

import mimetypes, os
my_file = '/some/path/xy.ext'
response = HttpResponse(FixedFileWrapper(open(my_file, 'rb')), content_type=mimetypes.guess_type(my_file)[0])
response['Content-Length'] = os.path.getsize(my_file)
response['Content-Disposition'] = "attachment; filename=%s" % os.path.basename(my_file)
return response
As of Python 2.5, there's no need to import FileWrapper from Django.
----------------------------------------------------------------------
You can use the 'sendfile' method as described in this answer.

Practically you need this (c&p):

response = HttpResponse(mimetype='application/force-download')
response['Content-Disposition'] = 'attachment; filename=%s' % smart_str(file_name)
response['X-Sendfile'] = smart_str(path_to_file)
# It's usually a good idea to set the 'Content-Length' header too.
# You can also set any other required headers: Cache-Control, etc.
return response
This requires mod_xsendfile (which is also supported by nginx or lighty)

----------------------------------------------------------------------
If the file is static (i.e not generated specifically for this request) you shouldn't be serving it through django anyway. You should configure some path (like /static/) to be served by your webserver, and save all the django overhead.

If the file is dynamic, there are 2 options:

Create it in memory and serve it from django.
Create it on the disk, and return a HttpResponseRedirect to it, so that your webserver deals with the download itself (if the file is very large, you should use this option).
As for serving it dynamically, I've been using the following code (which is a simplified version of ExcelResponse)

import StringIO
from django.db.models.query import ValuesQuerySet, QuerySet

class CSVResponse(HttpResponse):

  def __init__(self, data, output_name='data', headers=None, encoding='utf8'):

    # Make sure we've got the right type of data to work with
    valid_data = False
    if isinstance(data, ValuesQuerySet):
        data = list(data)
    elif isinstance(data, QuerySet):
        data = list(data.values())
    if hasattr(data, '__getitem__'):
        if isinstance(data[0], dict):
            if headers is None:
                headers = data[0].keys()
            data = [[row[col] for col in headers] for row in data]
            data.insert(0, headers)
        if hasattr(data[0], '__getitem__'):
            valid_data = True
    assert valid_data is True, "CSVResponse requires a sequence of sequences"

    output = StringIO.StringIO()
    for row in data:
        out_row = []
        for value in row:
            if not isinstance(value, basestring):
                value = unicode(value)
            value = value.encode(encoding)
            out_row.append(value.replace('"', '""'))
        output.write('"%s"\n' %
                     '","'.join(out_row))            
    mimetype = 'text/csv'
    file_ext = 'csv'
    output.seek(0)
    super(CSVResponse, self).__init__(content=output.getvalue(),
                                        mimetype=mimetype)
    self['Content-Disposition'] = 'attachment;filename="%s.%s"' % \
        (output_name.replace('"', '\"'), file_ext)
To use it, just use return CSVResponse(...) passing in a list of lists, a list of dicts (with same keys), a QuerySet, a ValuesQuerySet


Did you try specifying the content-type? e.g.

response['Content-Type'] = 'application/x-download';
Edit:

Note, this code successfully triggers a "Save As" dialog for me. Note I specify "application/x-download" directly in the mimetype argument. You also might want to recheck your code, and ensure your file path is correct, and that FileWrapper() isn't doing something weird.

def save_file(request):
    data = open(os.path.join(settings.PROJECT_PATH,'data/table.csv'),'r').read()
    resp = django.http.HttpResponse(data, mimetype='application/x-download')
    resp['Content-Disposition'] = 'attachment;filename=table.csv'
    return resp
	
	
------------------------------------------------------------------------
	
Using Django as a Pass Through Image Proxy
Sunday, March 21 2010 8:39 p.m.
An earlier post shows you how to setup Nginx as a pass through image proxy. This post shows you how to do it with just Django and nothing else.

The Problem
We've solving the same problem as the earlier post. However, I will repeat it here for clarity as there's been some confusion.

You have a production DB with lots of images uploaded by users. For example, NationalGeographic.com has over 11gb of user uploaded images. When you download a data dump of the production database, it has links to all these images which you don't have. You either have to download and sync all the images locally every time you copy the database, live with broken images or point your static images to the prod server.

Copying images locally is the brute force method and will work. If you have all day to sync up images.

Pointing to the images in prod also works, but if you upload your own images to test functionality... You will not be able to see those new images.

You have a prod site with gigabytes and gigabytes of user generated static content. Whenever the database from production is copied to some lesser environment, like your sandbox, you either need to copy all the images locally, point static to the production server or live with broken images.

Solution
Django allows you to serve static files through your sandbox. By replacing Django's standard static "serve" function with the one below, you will be able to serve images locally, but look for them on a remote URL if it's not found locally.

Thanks to Johnny Dobbins for the idea.

"""
Views and functions for serving static files. These are only to be used
during development, and SHOULD NOT be used in a production setting.

file: static_fallback.py
"""

import mimetypes
import os
import posixpath
import urllib
import urllib2

import django
from django.conf import settings
from django.http import Http404, HttpResponse, HttpResponseRedirect
from django.views.static import serve as django_serve

def serve(request, path, document_root=None, show_indexes=False, cache=True,
          fallback_server=None):
    """
    Serve static files using Django's static file function but if it returns a
    404, then attempt to find the file on the fallback_server. Optionally and by
    default, cache the file locally.
    
    To use, put a URL pattern such as::

        (r'^(?P<path>.*)$', 'static_fallback.serve', {'document_root' : '/path/to/my/files/'})

    in your URLconf. You must provide the ``document_root`` param (required by 
    Django). You may also set ``show_indexes`` to ``True`` if you'd like to 
    serve a basic index of the directory. These parameters are passed through
    directly to django.views.static.serve. You should see the doc_string there 
    for details.
    
    Passing cache to True (default) copies the file locally.
    
    Be sure to set settings.FALLBACK_STATIC_URL to something like:
    
    FALLBACK_STATIC_URL = 'http://myprodsite.com'
    
    Alternatively, you can also tell it the fallback server as a parameter
    sent in the URLs.
    
    Author: Ed Menendez (ed@menendez.com)
    Concept: Johnny Dobbins
    """
    
    # This was mostly copied from Django's version. We need the filepath for 
    # caching and it also serves as an optimization. If the file is not found
    # then there's no reason to go through the Django process.
    try:
        fallback_server = settings.FALLBACK_STATIC_URL
    except AttributeError:
        print u"You're using static_fallback.serve to serve static content " + \
               "however settings.FALLBACK_STATIC_URL has not been set."
    
    # Save this for later to pass to Django.
    original_path = path
    
    path = posixpath.normpath(urllib.unquote(path))
    path = path.lstrip('/')
    newpath = ''
    for part in path.split('/'):
        if not part:
            # Strip empty path components.
            continue
        drive, part = os.path.splitdrive(part)
        head, part = os.path.split(part)
        if part in (os.curdir, os.pardir):
            # Strip '.' and '..' in path.
            continue
        newpath = os.path.join(newpath, part).replace('\\', '/')
    if newpath and path != newpath:
        return HttpResponseRedirect(newpath)                    # RETURN
    fullpath = os.path.join(document_root, newpath)
    # End of the "mostly from Django" section.

    try:
        # Don't bother trying the Django function if the file isn't there.
        if not os.path.isdir(fullpath) and not os.path.exists(fullpath):
            raise Http404, '"%s" does not exist' % fullpath     # RAISE
        else:
            # Pass through cleanly to Django's verson
            return django_serve(                                # RETURN
                        request, original_path, document_root, show_indexes)
    except Http404:
        if fallback_server:
            # Attempt to find it on the remote server.
            fq_url = '%s%s' % (fallback_server, request.path_info)
            try:
                contents = urllib2.urlopen(fq_url).read()
            except urllib2.HTTPError:
                # Naive to assume a 404 - ed
                raise Http404, '"%s" does not exist' % fq_url   # RAISE
            else:
                # Found the doc. Return it to response.
                mimetype = mimetypes.guess_type(fq_url)
                response = HttpResponse(contents, mimetype=mimetype)
                
                # Do we need to cache the file?
                if cache:
                    if not os.path.exists(os.path.split(fullpath)[0]):
                        os.makedirs(os.path.split(fullpath)[0])
                    f = open(fullpath, 'wb+')
                    f.write(contents)
                    f.close()
                
                # Success! We have the file. Send it back.
                return response                                 # RETURN
        else:
            # No fallback_server was defined. So, it's really a 404 now.
            raise Http404                                       # RAISE

			
			
			
			
			
			
			------------------------------------------------------------------------------------------------------------------------------------------------
			------------------------------------------------------------------------
			
			------------------------------------------------------------------------
			Managing files
This document describes Django’s file access APIs.

By default, Django stores files locally, using the MEDIA_ROOT and MEDIA_URL settings. The examples below assume that you’re using these defaults.

However, Django provides ways to write custom file storage systems that allow you to completely customize where and how Django stores files. The second half of this document describes how these storage systems work.

Using files in models

When you use a FileField or ImageField, Django provides a set of APIs you can use to deal with that file.

Consider the following model, using an ImageField to store a photo:

class Car(models.Model):
    name = models.CharField(max_length=255)
    price = models.DecimalField(max_digits=5, decimal_places=2)
    photo = models.ImageField(upload_to='cars')
Any Car instance will have a photo attribute that you can use to get at the details of the attached photo:

>>> car = Car.objects.get(name="57 Chevy")
>>> car.photo
<ImageFieldFile: chevy.jpg>
>>> car.photo.name
u'cars/chevy.jpg'
>>> car.photo.path
u'/media/cars/chevy.jpg'
>>> car.photo.url
u'http://media.example.com/cars/chevy.jpg'
This object – car.photo in the example – is a File object, which means it has all the methods and attributes described below.

Note
The file is saved as part of saving the model in the database, so the actual file name used on disk cannot be relied on until after the model has been saved.
The File object

Internally, Django uses a django.core.files.File instance any time it needs to represent a file. This object is a thin wrapper around Python’s built-in file object with some Django-specific additions.

Most of the time you’ll simply use a File that Django’s given you (i.e. a file attached to a model as above, or perhaps an uploaded file).

If you need to construct a File yourself, the easiest way is to create one using a Python built-in file object:

>>> from django.core.files import File

# Create a Python file object using open()
>>> f = open('/tmp/hello.world', 'w')
>>> myfile = File(f)
Now you can use any of the documented attributes and methods of the File class.

File storage

Behind the scenes, Django delegates decisions about how and where to store files to a file storage system. This is the object that actually understands things like file systems, opening and reading files, etc.

Django’s default file storage is given by the DEFAULT_FILE_STORAGE setting; if you don’t explicitly provide a storage system, this is the one that will be used.

See below for details of the built-in default file storage system, and see Writing a custom storage system for information on writing your own file storage system.

Storage objects
Though most of the time you’ll want to use a File object (which delegates to the proper storage for that file), you can use file storage systems directly. You can create an instance of some custom file storage class, or – often more useful – you can use the global default storage system:

>>> from django.core.files.storage import default_storage
>>> from django.core.files.base import ContentFile

>>> path = default_storage.save('/path/to/file', ContentFile('new content'))
>>> path
u'/path/to/file'

>>> default_storage.size(path)
11
>>> default_storage.open(path).read()
'new content'

>>> default_storage.delete(path)
>>> default_storage.exists(path)
False
See File storage API for the file storage API.

The built-in filesystem storage class
Django ships with a built-in FileSystemStorage class (defined in django.core.files.storage) which implements basic local filesystem file storage. Its initializer takes two arguments:

Argument	Description
location	Optional. Absolute path to the directory that will hold the files. If omitted, it will be set to the value of your MEDIA_ROOT setting.
base_url	Optional. URL that serves the files stored at this location. If omitted, it will default to the value of your MEDIA_URL setting.
For example, the following code will store uploaded files under /media/photos regardless of what your MEDIA_ROOT setting is:

from django.db import models
from django.core.files.storage import FileSystemStorage

fs = FileSystemStorage(location='/media/photos')

class Car(models.Model):
    ...
    photo = models.ImageField(storage=fs)
Custom storage systems work the same way: you can pass them in as the storage argument to a FileField.

http://www.djangospirit.org/topics/files.html

--------------------------------------------------------
t looks like your issue is not with the FileField, but occurs when saving the VoiceMessage instance instead.

In the traceback, the failure occurs at the end of FieldFile.save():

  File "/home/israelord/.virtualenvs/ringtu-env/local/lib/python2.7/site-packages/django/db/models/fields/files.py", line 95, in save
    self.instance.save()
Which means that everything went fine there, and only when this method in turns call save() on the vm object does the problem arise:

# FileField.save() calls instance.save() just before returning
# Here, self.instance is the vm object
def save(self, name, content, save=True): 
    name = self.field.generate_filename(self.instance, name) 
    self.name = self.storage.save(name, content) 
    setattr(self.instance, self.field.name, self.name) 

    # Update the filesize cache 
    self._size = content.size 
    self._committed = True 

    # Save the object because it has changed, unless save is False 
    if save: 
        self.instance.save() 
My best guess is the problem is on vm.date or another DateTimeField field, as the exception is raised in DateTimeField.to_python function. Can you check the type of msg['when']? You can also confirm this by skipping the instance save step:

vm.message.save(filename, File(msg['file']), False) # Added False
msg['file'].close()
vm.save() # Error should now be raised here
share|improve this answer

http://stackoverflow.com/questions/16048395/how-to-save-a-local-file-in-a-filefield-in-django?rq=1

-------------------------------------------------------------

Awww... you guys! I was really hoping someone would come up with an answer. Anyway, I was able to come up with my own solution; not sure if it's the optimal one but it works.

I made a slight mod to FooFile so it also stores the content_type of the uploaded file:

class FooFile(models.Model):
    name = models.CharField(max_length=100)
    file = models.FileField(upload_to='foo_folder')
    content_type = models.CharField(max_length=254) # max length given by RFC 4288 
    foo = models.ForeignKey(Foo, related_name='files')
and then, in the view, I create a SimpleUploadedFile object for each FooFile record:

from django.core.files.uploadedfile import SimpleUploadedFile
import os

def example(request, record=1, template_name="form.html")
    foo_obj = Foo.objects.get(pk=record)
    SAVED_FILES = {}
    for saved_file in foo_obj.files.all():
        SAVED_FILES[file.name]=SimpleUploadedFile(os.path.basename(saved_file.file.path), saved_file.file.read(), saved_file.content_type)
    if request.method == 'POST':
        form = MyForm(data=request.POST, files=SAVED_FILES)
        if form.is_valid():
            form.save() 
            # rest of view
    else:
        form = MyForm()
    return render(request, template_name, locals())
	
	http://stackoverflow.com/questions/5826572/copying-files-from-a-saved-filefield-to-an-uploadedfile-in-django?rq=1
	
	-----------------------------------------------------------
name = models.FileField(upload_to=get_absolute_url, max_length=255)
upload_to usually looks like this

upload_to ='./files'
It will be stored as ./files/your.file in the db and as <MEDIA_ROOT>/files/your.file at your disk

You can change the upload_to-String to whatever fits best for you programatically

upload_to ='./files'+'/subdir'
but it should start with './'

FileField-Reference

get_absolute_url() should return a url like http://domain.com/sitemedia/files/your.file

EDIT:

to remove the path from the file name you could do string operations in File.save() like

def save(self, force_insert=False, force_update=False):
    self.name = self.name[self.name.rfind('/')+1:]
    super(File, self).save(force_insert, force_update)
http://stackoverflow.com/questions/920279/file-uploads-in-django-prevent-filefield-from-writing-the-full-path-to-the-data?rq=1	
	
	
	
	The problem is that jQuery doesn't trigger the native click event for <a> elements so that navigation doesn't happen (the normal behavior of an <a>), so you need to do that manually. For almost all other scenarios, the native DOM event is triggered (at least attempted to - it's in a try/catch).

To trigger it manually, try:

var a = $("<a>").attr("href", "http://i.stack.imgur.com/L8rHf.png").attr("download", "img.png").appendTo("body");

a[0].click();

a.remove();
DEMO: http://jsfiddle.net/HTggQ/

Relevant line in current jQuery source: https://github.com/jquery/jquery/blob/master/src/event.js#L309

if ( (!special._default || special._default.apply( eventPath.pop(), data ) === false) &&
        jQuery.acceptData( elem ) ) {
*/
	?>

