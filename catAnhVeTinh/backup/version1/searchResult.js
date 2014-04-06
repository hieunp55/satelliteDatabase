/*
------------Interact with Result page------------

*/

/*
------------Function for Button------------
Function about 4 button: show pic, show meta data, 
download, delete, (show popup noti - 4 function)
*/
//Show preview picture
function showPreview(){
	$.Dialog({
		'content'     : '<img src="http://farm8.staticflickr.com/7418/9203930462_49bc5cefa8_z.jpg" style="margin: 0"/>',
		'draggable'   : true,
		'closeButton' : true,
		'buttonsAlign': 'right',
		'keepOpened'  : true,
		'position'    : {
			'zone'    : 'center'
		},
		'buttons'     : {
			'Close'     : {
				'action': function(){}
			}
		}
	});
	selectedImageParaDelete(this);
}
//Show metadata

//Download this picture

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

*/