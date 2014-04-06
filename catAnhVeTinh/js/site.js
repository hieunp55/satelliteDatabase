/*Other function */
function closeDatePicker(){
	var targetClose = $(this).parent().parent().find('.span4').find('.calendar');
	if (targetClose.css("display") == "block")
		targetClose.css({"display" : "none"});
}

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
				//latLngs[counts] = neLatLg.lat().toFixed(5); counts++;
				latLngs[counts] = neLatLg.lat(); counts++;
				latLngs[counts] = swLatLg.lng(); counts++;
				//Upper right
				latLngs[counts] = neLatLg.lat(); counts++;
				latLngs[counts] = neLatLg.lng(); counts++;
				//lower right
				latLngs[counts] = swLatLg.lat(); counts++;
				latLngs[counts] = neLatLg.lng(); counts++;
				//lower left
				latLngs[counts] = swLatLg.lat(); counts++;
				latLngs[counts] = swLatLg.lng(); counts++;
			}
	}
	return latLngs;
}
//Print data lat long to input text
function printToInput(e_overlay){
	var NELatLg=e_overlay.getBounds().getNorthEast();
	var SWLatLg=e_overlay.getBounds().getSouthWest();
	
	//Upper left
	$("input[name=upperLeft]").val(NELatLg.lat().toFixed(6)+" | " + SWLatLg.lng().toFixed(5));
	//Upper right
	$("input[name=upperRight]").val(NELatLg.lat().toFixed(6)+" | " + NELatLg.lng().toFixed(5));
	//lower right
	$("input[name=lowerLeft]").val(SWLatLg.lat().toFixed(6)+" | " + NELatLg.lng().toFixed(5));
	//lower left
	$("input[name=lowerRight]").val(SWLatLg.lat().toFixed(6)+" | " + SWLatLg.lng().toFixed(5));
	
}
//Change fromTime and toTime to be one object of sendData
function objectTime(thisTime){
	var t = thisTime.getFullYear()+"-"+(thisTime.getMonth()+1)+"-"+thisTime.getDate();
	return t;
}

//get Commune/Ward/Townlet
function getCWT(){
	if($('div.selected.cwt').length != 0)
		return parseInt($('div.selected.cwt').attr('cwtId'));
	return -1;
}

//get district
function getDistrict(){
	if ($('div.selected.district').length != 0)
		return parseInt($('div.selected.district').attr('districtId'));
	return -1;
}

//getprovince
function getProvince(){
	if($('div.selected.proCit').length != 0)
		return parseInt($('div.selected.proCit').attr('proCitId'));
	return -1;
}

//get type of process
function getProcess(){
	return parseInt($('div.selected.features').attr('processId'))
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

//Select province or city
function selectProCit(){
	//unselect if this location was chosen
	if($(this).hasClass("selected")){
		$(this).removeClass("selected");
		
		//Show other Province
		$(this).parent().children().each(function(){
			if ($(this).css("display") == "none"){
				$(this).show();
			}
		});
		$('div.selected.cwt').each(function(){
			if ($(this).hasClass("selected")){
				$(this).removeClass("selected");
				$(this).hide();
			}
		});
		$('div.selected.district').each(function(){
			if ($(this).hasClass("selected")){
				$(this).removeClass("selected");
				$(this).hide();
			}
		});
		//hidden district list of the province
		$(".CWTPa").hide();
		$(".districtPa").hide();
		return;
	}
	//selected
	$(this).addClass("selected");
	$(this).parent().children().each(function(){
		if (!$(this).hasClass("selected")){
			$(this).hide();
		}
	});
	//get parent object
	var parentLo = $(this).parent().parent().parent().find("#districtList");
	//get id of this province or city
	var proCitId = parseInt($(this).attr("proCitId"));
	//if this province or city already exists => show it


	if($("div[proCityID = "+proCitId+"]").length != 0){
		$("div[proCityID = "+proCitId+"]").show();
		$("div[proCityID = "+proCitId+"]").children().each(function(){
			$(this).show();
		});
	}else{
		//if not: request server to get this list
		$.post("http://localhost/catAnhVeTinh/tableList/requestDistrict.php", 
			{
				'data': JSON.stringify(proCitId)
			},
			function(data){
				//parse json data
				console.log(data);
				var getData=JSON.parse(data);
				//create div parent
				var divButton=$('<div>', {
					class:'span3 districtPa',
					style: 'width: 100%;margin: 0px;overflow: auto',
					proCityID: proCitId
				});

				//create list district
				$.each(getData, function(key, value){
				    var divChild=$('<div>', {
						class:'tile tiny-vertical district',
						districtId: key
					});
					$(divChild).html("<p style='margin-top:5px;margin-bottom:2px'>"+value+"</p>");
					$(divChild).appendTo($(divButton));	
					$(divChild).click(selectDistrict);
				});
				//insert divButton

				$(divButton).appendTo(parentLo);

			}
		);
	}
}
//inside Select district
function selectDistrict(){
//unselect if this location was chosen
	if($(this).hasClass("selected")){
		$(this).removeClass("selected");

		//hidden district list of the province
		$(".CWTPa").hide();
		//Show other Province
		$(this).parent().children().each(function(){
			if ($(this).css("display") == "none"){
				$(this).show();
			}
		});
		$('div.selected.cwt').each(function(){
			if ($(this).hasClass("selected")){
				$(this).removeClass("selected");
				$(this).hide();
			}
		});
		return;
	}
	//selected
	$(this).addClass("selected");
	$(this).parent().children().each(function(){
		if (!$(this).hasClass("selected")){
			$(this).hide();
		}
	});
	//get parent object
	var parentLo = $(this).parent().parent().parent().find("#CWTList");
	//get id of this province or city
	var districtId = parseInt($(this).attr("districtId"));
	//if this province or city already exists => show it


	if($("div[distId = "+districtId+"]").length != 0){
		$("div[distId = "+districtId+"]").show();
		$("div[distId = "+districtId+"]").children().each(function(){
			$(this).show();
		});
	}else{
		//if not: request server to get this list
		$.post("http://localhost/catAnhVeTinh/tableList/requestCWT.php", 
			{
				'data': JSON.stringify(districtId)
			},
			function(data){
				//parse json data
				console.log(data);
				var getData=JSON.parse(data);
				//create div parent
				var divButton=$('<div>', {
					class:'span3 CWTPa',
					style: 'width: 100%;margin: 0px;overflow: auto',
					distID: districtId
				});

				//create list district
				$.each(getData, function(key, value){
				    var divChild=$('<div>', {
						class:'tile tiny-vertical cwt',
						cwtId: key
					});
					$(divChild).html("<p style='margin-top:5px;margin-bottom:2px'>"+value+"</p>");
					$(divChild).appendTo($(divButton));	
					$(divChild).click(selectCWT);
				});
				//insert divButton
				$(divButton).appendTo(parentLo);
			}
		);
	}
}
//Select Commune/Ward/Townlet
function selectCWT () {
	// body...
	//we unselect  if this band was chosen
	if($(this).hasClass("selected")){
		$(this).removeClass("selected");
		$(this).parent().children().each(function(){
			if ($(this).css("display") == "none"){
				$(this).show();
			}
		});
		return;
	}
	
	$(this).addClass("selected");
	$(this).parent().children().each(function(){
		if (!$(this).hasClass("selected")){
			$(this).hide();
		}
	});
}

//select type of process
function selectProcess(){
	//we unselect  if this type of process was chosen
	if($(this).hasClass("selected")){
		$(this).removeClass("selected");
		return;
	}
	
	$(this).addClass("selected");
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
	resetResult();
}

//auto create result 
/*
Du lieu tra ve tu image server bao gom ca thong tin ve buc anh crop ra - ten cua anh goc va file metadata, 
ten cua buc anh duoc crop ra, vi tri cua buc anh duoc crop ra so voi cac buc anh khac (co the vung crop 
nam trong nhieu buc  anhr khac nhau
*/
function createResultView(data){
	var datas=JSON.parse(data);
	console.log(datas);
	var errorNumber = datas['ErrorCode'];
	var resultData = datas["resultList"];
	if ( errorNumber == 5){
		for (var i=0; i < resultData.length; i++){
			//Create tile and add to result view
			var tile=$('<div>',{
				class: 'tile half-vertical bg-color-blueDark croppedImage'
			}).appendTo($("#posi"));
			//Create tile-content and add to tile
			var tileContent=$('<div>',{
				class: 'tile-content',
				style: 'margin: 0px; padding: 0px'
			}).appendTo($(tile));
			//add image preview and name of this image
			console.log(resultData[i]);
			$('<img alt = ""/>').attr('src',resultData[i].LinkPreview/*.substring(1, (datas[i].LinkPreview.length-1))*/).attr('class','place-right').attr('style','margin: 0; height: 100px; width: 100px').appendTo($(tileContent));
			$("<b style='margin-bottom: 5px;'>Name: "+resultData[i].ImageName+"</b>").appendTo($(tileContent));
			//create div around of band date and some div button
			var divAround=$('<p>');
			//add 
			$("<p>Date: "+resultData[i].ArquiredDate+"</p>").appendTo($(divAround));
			$("<p>Band: "+resultData[i].BandName+"</p>").appendTo($(divAround));
			$("<p></p><br/>").appendTo($(divAround));
			//creat div button
			var divButton=$('<div>', {
				class:'place-left',
				style: 'margin-left: 25px'
			});
			$("<button class='mini bg-color-darken showPic' style='z-index: 100; margin: 01px; margin-left: 5px'><i class='icon-pictures'></i></button>").appendTo($(divButton));
			$("<button class='mini bg-color-darken downloadBut' style='z-index: 100; margin: 01px'><i class='icon-download'></i></button>").appendTo($(divButton));
			$("<button class='mini bg-color-darken removeBut' style='z-index: 100; margin: 01px'><i class='icon-remove'></i></button>").appendTo($(divButton));
			//add
			$(divAround).appendTo($(tileContent));
			$(divButton).appendTo($(tileContent));
			$(tileContent).appendTo($(tile));
		}
	}else if(errorNumber == 0){
		$("#posi").html("Your input is wrong!");
	}else if(errorNumber == 1){
		$("#posi").html("Database is not available for this region!");
	}else if(errorNumber == 2){
		$("#posi").html("We can not crop images!");
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

//FIx and change size of some div elements
function changeSize(){
	var x = $(window).width();
	var y = $(window).height();
	
	$(".metrouicss").css("width",x);
	$(".page-region-content").css("height", (y-50));
	$("#bandChoose").css("height", y/3);
	$(".contentPage").css("height", (y-135));
	$(".accordion").css("height", (y-195));
	$("#dialogBox").css("top", ((x-$("#dialogBox").height())/2));
	$("#dialogBox").css("left", ((y-$("#dialogBox").width())/2));
}