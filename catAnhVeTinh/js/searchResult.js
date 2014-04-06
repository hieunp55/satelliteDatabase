/*
------------Interact with Result page------------

*/
//take the picture to the center
function changeSizePic(){
	var x = $(window).height();
	var y = $(window).width();
	
	$("#dialogBox").css("top", ((x-$("#dialogBox").height())/2));
	$("#dialogBox").css("left", ((y-$("#dialogBox").width())/2));
}
/*
------------Function for Button------------
Function about 4 button: show pic, show meta data, 
download, delete, (show popup noti - 4 function)
*/
//Show preview picture
function showPreview(){
	$.Dialog({
		'content' : '',
		'draggable' : true,
		'closeButton' : true,
		'buttonsAlign': 'right',
		'keepOpened' : true,
		'position' : {
			'zone' : 'center'
		},
		'buttons' : {
			'Close' : {
				'action': function(){}
			}
		}
	});
	$("<img>", {src: ''}).appendTo($(".content")).load(function(){
			changeSizePic();
	});
	//Close the window when click
	$("#dialogOverlay").click(function() {
		// Prevent using function without dialog opened
		if(!$.Dialog.opened) {
			return false;
		}

		$('#dialogOverlay').fadeOut(function() {
			$.Dialog.opened = false;
			$(this).remove();
		});
	});
}

//Download this picture
function downloadPic(){
	var tempt = $(this).parent().parent().find('img').attr('src');
	//Lay ten file bang cach tach cai tempt ra va lay phan tu cuoi
	fileName = tempt.split('/');
	var a = $("<a>").attr("href", tempt).attr("download", fileName[fileName.length-1]).appendTo("body");

	a[0].click();

	a.remove();
}
//Delete this cropped picture
function deleteImage(){
	var i=this;
	$.Dialog({
		'title'      : 'Message',
		'content'    : 'Do you want to remove this image?',
		'draggable'  : true,
		'keepOpened'  : true,
		'buttonsAlign': 'right',
		'buttons'    : {
			'Yes'    : {
				'action': function() {
					//Remove
					$(i).parent().parent().parent().remove();
					//Co the dem va luu tai localstorage vaf check de gui len server xoa bot nhung buc anh nay di
					//Xoa anh trong thu muc band
				}
			},
			'No' : {
				'action': function() {
					
				}
			}
		}
	});
	selectedImageParaDelete(i);
}
/*
Function about tiles result: selected, unselectd, 
*/
//Selected/Unselected cropped image
function selectedImage(){
	if($(this).hasClass("selected")){
		$(this).removeClass("selected");
		return;
	}
	$(this).addClass("selected");
}
//Selected/Unselected with parameter
function selectedImageParaDelete(i){
	if($(i).parent().parent().parent().hasClass("selected")){
		$(i).parent().parent().parent().removeClass("selected");
		return;
	}
	$(i).parent().parent().parent().addClass("selected");
}
/*
------------Chuoi cac ham quan ly viec download, tai du lieu ve------------
*/


/*
____________________________	Maps search ___________________________
*/
 function selectFirstResult() {
    infowindow.close();
    var firstResult = $(".pac-container .pac-item:first").text();

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({"address":firstResult }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var lat = results[0].geometry.location.lat(),
                lng = results[0].geometry.location.lng(),
                placeName = results[0].address_components[0].long_name,
                latlng = new google.maps.LatLng(lat, lng);

            moveMarker(placeName, latlng);
            $("#searchTextField").val(firstResult);
        }
    });   
 }