/*
------------Get and format sending data ------------
*/

function changeMonth(textMonth){
	switch(textMonth){
		case "Jan": return 0;
		case "Feb": return 1;
		case "Mar": return 2;
		case "Apr": return 3;
		case "May": return 4;
		case "Jun": return 5;
		case "Jul": return 6;
		case "Aug": return 7;
		case "Sep": return 8;
		case "Oct": return 9;
		case "Nov": return 10;
		case "Dec": return 11;
	}
}
//Check format time and return true format of date object
function checkTime(inputTime){
	var parseText = inputTime.split(" ");
	return new Date(parseInt(parseText[2]), changeMonth(parseText[0]), parseInt(parseText[1]));
}
//Lay thoi diem ket thuc
function getToTime(){
	return $(".toTime").val();
}
//Lay thoi diem bat dau
function getFromTime(){
	return $(".fromTime").val();
}
//Kiem tra tinh hop le cua thoi gian
function checkFromTo(fromTime,toTime){
	//If we start after endin: this is an error
	if(fromTime.valueOf() > toTime.valueOf()){
		return false;
	}else {
		return true;
	}
}
//kIEM TRA tinh hop le cua gia tri cac bands
function checkBand(band){
	if (band > 15 || band <= 0){
		return false;
	}
	return true;
}
//Lay gia tri cua cac band 
function getBand(){
	var bandImage = new Array();
	var counts = 0;
	var i = $(".bandItem");
	do{
		var j = i.children(":first")
		if(j.hasClass("selected") && checkBand(parseInt(j.attr("data-band-index"))) ){
			bandImage[counts]= j.attr("data-band-index");
			counts++;
		}
		i = i.next();
	}while (i.length != 0);
	return bandImage;
}
//Lay cac toa do cua vung can crop and generate to 4 point of rectangle
//If nothing found, return undefined
function getLatLongs(){
	var latLngs = new Array();
	var counts = 0;
	if(all_overlays != undefined)
		for (var i = 0; i < all_overlays.length; i++){
			if(all_overlays[i].type == google.maps.drawing.OverlayType.RECTANGLE){
				
				var neLatLg=all_overlays[i].overlay.getBounds().getNorthEast();
				var swLatLg=all_overlays[i].overlay.getBounds().getSouthWest();
				//upper left
				latLngs[counts] = neLatLg.lat().toFixed(5); counts++;
				latLngs[counts] = swLatLg.lng().toFixed(5); counts++;
				//Upper right
				latLngs[counts] = neLatLg.lat().toFixed(5); counts++;
				latLngs[counts] = neLatLg.lng().toFixed(5); counts++;
				//lower left
				latLngs[counts] = swLatLg.lat().toFixed(5); counts++;
				latLngs[counts] = swLatLg.lng().toFixed(5); counts++;
				//lower right
				latLngs[counts] = swLatLg.lat().toFixed(5); counts++;
				latLngs[counts] = neLatLg.lng().toFixed(5); counts++;
			}
	}
	return latLngs;
}
//Print data lat long to input text
function printToInput(e_overlay){
	var NELatLg=e_overlay.getBounds().getNorthEast();
	var SWLatLg=e_overlay.getBounds().getSouthWest();
	
	//Upper left
	$("input[name=upperLeft]").val(NELatLg.lat().toFixed(5)+" | " + SWLatLg.lng().toFixed(5));
	//Upper right
	$("input[name=upperRight]").val(NELatLg.lat().toFixed(5)+" | " + NELatLg.lng().toFixed(5));
	//lower left
	$("input[name=lowerLeft]").val(SWLatLg.lat().toFixed(5)+" | " + SWLatLg.lng().toFixed(5));
	//lower right
	$("input[name=lowerRight]").val(SWLatLg.lat().toFixed(5)+" | " + NELatLg.lng().toFixed(5));
}
//Change fromTime and toTime to be one object of sendData
function objectTime(thisTime){
	var t = thisTime.getFullYear()+"-"+(thisTime.getMonth()+1)+"-"+thisTime.getDate();
	return t;
}
//Select band
function selectBand(){
	//we unselect  if this band was chosen
	if($(this).children(":first").hasClass("selected")){
		$(this).children(":first").removeClass("selected");
		return;
	}
	
	$(this).children(":first").addClass("selected");
}

/*
------------Show result------------
*/

//Change view page from Search to result after success query
function showResultView(){
	var pageUL_1=$("[href='#page1']");
	var pageUL_2=$("[href='#page2']");
	//If li have been active, remove and add active class to second li
	if(pageUL_1.parent('li').hasClass('active')){
		pageUL_1.parent('li').removeClass('active');
		pageUL_2.parent('li').addClass('active');
		//hidden page 1 and show page 2
		$("#page1").hide();//hide page1
		$("#page2").slideUp("fast", function(){
			pageUL_2.css("overflow", "").css("display", "block");
		});	
		//show all elements in page2
		$(pageUL_2.attr('href')).show();
		//Get the value of current menu-pull-bar
		$(".page-control .menu-pull-bar").text($(".page-control ul li.active a").text());
		//assign above value to menu-pull-bar
		pageUL_2.parent("li").parent("ul").parent(".page-control").find(".menu-pull-bar").text(pageUL_2.text());
	}
}

//auto create result 
/*
Du lieu tra ve tu image server bao gom ca thong tin ve buc anh crop ra - ten cua anh goc va file metadata, 
ten cua buc anh duoc crop ra, vi tri cua buc anh duoc crop ra so voi cac buc anh khac (co the vung crop 
nam trong nhieu buc  anhr khac nhau
*/
function createResultView(data){
	resetResult();
	var datas=JSON.parse(data);
	for (var i=1; i<=parseInt(datas['numberImage']); i++){
		//Create tile and add to result view
		var tile=$('<div>',{
			class: 'tile half-vertical bg-color-blueDark croppedImage'
		}).appendTo($("#posi"));
		//Create tile-content and add to tile
		var tileContent=$('<div>',{
			class: 'tile-content'
		}).appendTo($(tile));
		//add image preview and name of this image
		$("<img src='"+datas[i].LinkPreview/*.replace('\\', '')*/+ "' class='place-right' style='margin: 0'/>").appendTo($(tileContent));
		$("<b style='margin-bottom: 5px;'>Name: "+datas[i].ImageName+"</b>").appendTo($(tileContent));
		//create div around of band date and some div button
		var divAround=$('<p>');
		//add 
		$("<p>Date: "+datas[i].ArquiredDate+"</p>").appendTo($(divAround));
		$("<p>Band: "+datas[i].BandName+"</p>").appendTo($(divAround));
		$("<p></p><br/>").appendTo($(divAround));
		//creat div button
		var divButton=document.createElement('div');
		$("<button class='mini bg-color-darken showPic' style='margin: 01px'><i class='icon-pictures'></i></button>").appendTo($(divButton));
		$("<button class='mini bg-color-darken showMeta' style='margin: 01px'><i class='icon-file-css'></i></button>").appendTo($(divButton));
		$("<button class='mini bg-color-darken downloadBut' style='margin: 01px'><i class='icon-download'></i></button>").appendTo($(divButton));
		$("<button class='mini bg-color-darken removeBut' style='margin: 01px'><i class='icon-remove'></i></button>").appendTo($(divButton));
		//add
		$(divAround).appendTo($(tileContent));
		$(divButton).appendTo($(tileContent));
		$(tileContent).appendTo($(tile));
	}
}

/*
----------Reset function----------
*/

//reset periods of time

//reset band
function resetBand(){
	var i = $(".bandItem");
	do{
		var j = i.children(":first")
		if(j.hasClass("selected") && checkBand(parseInt(j.attr("data-band-index"))) ){
			j.removeClass("selected");
		}
		i = i.next();
	}while (i.length != 0);
}
//reset input lat long data
function resetInput(){
	//Upper left
	$("input[name=upperLeft]").val("");
	//Upper right
	$("input[name=upperRight]").val("");
	//lower left
	$("input[name=lowerLeft]").val("");
	//lower right
	$("input[name=lowerRight]").val("");
}
//reset result page
function resetResult(){
	$("#posi").html("");
}

//-------Reset search or new search---------
function resetSearch(){
	$.Dialog({
		'title'      : 'Message!',
		'content'    : 'Do you want to reset current search?',
		'draggable'  : true,
		'buttonsAlign': 'right',
		'keepOpened'  : false,
		'position'    :{
			'zone'	: 'center'
		},
		'buttons'    : {
			'Yes'    : {
				'action': function() {
					//reset periods of time
	
					//Reset band
					resetBand();
					//Reset input latitude longitude  
					resetInput();
					//Reset maps 
					deleteAllShape();
					//reset send data
					sendData={};
					//Reset result
					resetResult();
				}
			},
			'No' : {
				'action': function() {}
			}
		}
	});
}

/*
------------Search place-using maps api------------
*/

/*
------------control the window size------------
*/

//FIx and change size of some div elements
function changeSize(){
	var windowsize = $(window).width();
	var h = $(window).height();
	
	$(".metrouicss").css("width", windowsize);
	$(".page-region-content").css("height", (h-50));
	$("#bandChoose").css("height", h/3);
	$(".contentPage").css("height", (h-135));
	$(".accordion").css("height", (h-195));
}