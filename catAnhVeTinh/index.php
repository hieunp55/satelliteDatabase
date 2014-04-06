<?php 
	include("header.php");
	include($_SERVER['DOCUMENT_ROOT'] . '/catAnhVeTinh/tableList/listProvince.php');
?>
	<div class="page">
		<!--h2 style="margin: 0px; margin-left: 10px;"><b> Application </b></h2-->
		<div class="page-region">
			<div class="page-region-content" style="background-color: #ccc; padding-top: 5px; padding-bottom: 0px;">
				<div class="page snapped">
					<div class="page-control" data-role="page-control" style="width: 100%; height: 100%">
						<span class="menu-pull"></span>
						<div class="menu-pull-bar"></div>
						<!-------------------- Mark for each pages -------------------->
						<ul>
							<li class="active"><a href="#page1">Search</a></li>
							<li><a href="#page2">Result</a></li>
							<!--li><a href="#page3">Image Processing</a></li--->
						</ul>
						<!--------------------Contents inside each pages -------------------->
						<div class="frames contentPage">
						<!---------------------------------In page 1 ------------------------>
							<div class="frame active" id="page1" style="margin: 0px; overflow: auto">
							<!--------------------List of accordion -------------------->
								<ul class="accordion" data-role="accordion" style="margin:0px; width: 100%;overflow-y:auto">
									<li>
										<a href="#">Time</a>
										<div class="grid" style="height: 100%">
											<!-- -->
											<!-- ------------------Date picker-------------------->
											<div class="row">
												<!--------------------From date time -------------------->
												<div class="span3" style="width: 100%; margin: 0px;">
													<div class="row">
														<div class="span1" style="margin: 0px;">
															<h3 style="margin: 0px; height: 32px;text-align: center;">From: </h3>
														</div>
														<div class="input-control text datepicker span2 place-right" id="picker1" data-param-lang="en" data-param-year-buttons="1" style="margin: 0px">
															<input class="fromTime" type="text" />
															<button class="btn-date" style="width: 100%"></button>
														</div>
													</div>
												</div>
												<!--------------------To date time-------------------->
												<div class="span3" style="width: 100%; margin: 0px;">
													<div class="span1" style="margin: 0px;">
														<h3 style="margin: 0px; height: 32px;text-align: center;">To: </h3>
													</div>
													<div class="input-control text datepicker span2 place-right" id="picker2" data-param-lang="en" data-param-year-buttons="1" style="margin: 0px">
														<input class="toTime" type="text" />
														<button class="btn-date"></button>
													</div>
												</div>
											</div>
										</div>
									</li>
									<!-------------------- Locations -------------------->
									<li>
										<a href="#">Locations</a>
										<div class="grid" style="height:100%">
											<div class="row" style="margin: 0">
												<div id="provCityList">
													<div class="span1" style="margin: 0px;">
														<h3 style="margin: 0px; height: 32px;text-align: center;">Province/City</h3>
													</div>
													<div id="proCitPa" class="span3" style="width: 100%;margin: 0px;overflow: auto">
													<?php
														$getList = getResultProvince();
														//Print list of province
														foreach ($getList as $key=>$value) {
													?>
														<div class="tile tiny-vertical proCit" proCitId=<?php echo $key; ?> >
															<p style='margin-top:5px;margin-bottom:2px'>
													<?php
															echo $value;
													?>
															</p>
														</div>
													<?php
														}
													?>
														
													</div>
												</div>
												<div id="districtList">
													<div class="span1" style="margin: 0px;">
														<h3 style="margin: 0px; height: 32px;text-align: center;">District</h3>
													</div>
													<div class="span3" style="width: 100%;margin: 0px;overflow: auto"></div>
												</div>
												<div id="CWTList">
													<div class="span1" style="margin: 0px;">
														<h3 style="margin: 0px; height: 32px;text-align: center;">Commune/Ward/Townlet</h3>
													</div>
													<div class="span3" style="width: 100%;margin: 0px;overflow: auto"></div>
												</div>

											</div>
										</div>
									</li>
									<!------------------------------Spatial-------------------------------->
									<li class="active">
										<a href="#">Spatial</a>
										<div>
											<form>
												<div class="input-control text">
													<input type="text" placeholder="Enter or Get the lat long value!" name="upperLeft" style="width: 90%"/>
													<button class="btn-clear" />
												</div>
												<div class="input-control text">
													<input type="text" placeholder="Enter or Get the lat long value!" name="upperRight" style="width: 90%"/>
													<button class="btn-clear" />
												</div>
												<div class="input-control text">
													<input type="text" placeholder="Enter or Get the lat long value!" name="lowerLeft" style="width: 90%"/>
													<button class="btn-clear" />
												</div>
												<div class="input-control text">
													<input type="text" placeholder="Enter or Get the lat long value!" name="lowerRight" style="width: 90%"/>
													<button class="btn-clear" />
												</div>
											</form>
										</div>
									</li>
									<!-------------------- Bands -------------------->
									<li>
										<a href="#">Bands</a>
										<div class="grid" id="bandChoose" style="overflow: auto">
											<div class="row bandItem" style="margin: 0">
												<div class="tile tiny-vertical" id="bandImage"></div>
											</div>
										</div>
									</li>
									<!-------------------- Processing -------------------->
									<li>
										<a href="#">Processing</a>
										<div class="grid" id="processes" style="overflow: auto">
											<div class="row processFeature" style="margin: 0">
												<div class="tile tiny-vertical features"  processId = "1">
													<p style="margin-top:5px;margin-bottom:2px">Crop</p>
												</div>
											</div>
											<div class="row processFeature" style="margin: 0">
												<div class="tile tiny-vertical features"  processId = "2">
													<p style="margin-top:5px;margin-bottom:2px">Combination Color</p>
												</div>
											</div>
											<div class="row processFeature" style="margin: 0">
												<div class="tile tiny-vertical features" processId = "3">
													<p style="margin-top:5px;margin-bottom:2px">NDVI</p>
												</div>
											</div>
										</div>
									</li>
									<!-------------------- Others -------------------->
									<li>
										<a href="#">Others</a>
										<div class="grid" id="otherChoice" style="overflow: auto">
											<div class="row choiceFeature" style="margin: 0">
												<div class="tile tiny-vertical choices"></div>
											</div>
										</div>
									</li>
								</ul>
								<div class="border-color-blue place-right controlButton" >
									<!--------------------Search button-------------------->
									<a class="button bg-color-blueLight searchImage place-right" style="margin:0;">Search</a>
									<!--------------------Reset button-------------------->
									<a class="button bg-color-blueLight place-right" id="resetSearch">Reset</a>
								</div>
							</div>
							
							<!--------------------Contents in page 2------------------ -->
							<div class="frame span4" id="page2" style="margin: 0px; height: 100%">
								<!--------------------Result view-------------------->
								<div id="posi" class="grid" style="overflow: auto; height: 100%">
									
								</div>
								<!--------------------Download all button------------------ -->
								<div class="border-color-blue place-right controlButton" >
									<a class="button bg-color-blueLight place-right" id="downloadAll" style="margin:0;">Download</a>
								</div>
							</div>
							
							<!--------------------Contents in page 3 -------------------->
							<div class="frame span4" id="page3" style="margin: 0px; height: 100%">
								<!--------------------List view 
								
								<div style="overflow: auto; width: 100%; height: 100%">
									<ul class="listview" style=" margin: 0px; padding: 5px; height: 100%">
										<li class="bg-color-pinkDark fg-color-white" style="width: 100%">
											<div class="icon">
												<img src="images/onenote2013icon.png" />
											</div>

											<div class="data">
												<h4 class="fg-color-white">OneNote 2013</h4>
												<div class="static-rating small">
													<div class="rating-value" style="width: 75%"></div>
												</div>
												<p>1 RUB</p>
											</div>
										</li>

										<li style="width: 100%">
											<div class="icon">
												<img src="images/excel2013icon.png" />
											</div>

											<div class="data">
												<h4>Excel 2013</h4>
												<div class="static-rating small">
													<div class="rating-value" style="width: 75%"></div>
												</div>
												<p>1 RUB</p>
											</div>
										</li>
										
										<li class="selected" style="width: 100%">
											<div class="icon">
												<img src="images/word2013icon.png" />
											</div>

											<div class="data">
												<h4>Word 2013</h4>
												<div class="static-rating small">
													<div class="rating-value" style="width: 75%"></div>
												</div>
												<p>1 RUB</p>
											</div>
										</li>
										
										<li style="width: 100%">
											<div class="icon">
												<img src="images/firefox.png" />
											</div>

											<div class="data">
												<h4>Firefox</h4>
												<div class="progress-bar">
													<div class="bar" style="width: 75%"></div>
												</div>
												<p>Download...</p>
											</div>
										</li>
									</ul>
								</div> -------------------->
								<!--------------------Submit button button -------------------->
								<div class="border-color-blue place-right controlButton" >
									<a class="button bg-color-blue processImage2 place-right" style="margin:0;">Image Processing</a>
								</div>
							</div>
						</div>
						<?php include("footer.php")?>
					</div>
				</div>
				<div class="page fill bg-color-blueDark">
						<div id="panel">
							<form>
								<div class="input-control text searchBoxStyle">
									<input id="searchTextField" type="text" placeholder="Enter a location" />
									<button class="btn-clear buttonClearBox"/>
								</div>
							
								<div class="choiceTypeResult">
									Type of result: 
									<input type="radio" name="type" id="changetype-all" checked="checked"/>
									<label for="changetype-all" class="formatBoxChoice">All</label>

									<input type="radio" name="type" id="changetype-establishment"/>
									<label for="changetype-establishment" class="formatBoxChoice">Establishments</label>

									<input type="radio" name="type" id="changetype-geocode"/>
									<label for="changetype-geocode" class="formatBoxChoice">Geocodes</lable>
								</div>
							</form>
						</div>
					
					<!--------------------Google Maps-------------------->
					<div id="map-canvas"></div>
				</div>
			</div>
		</div>
	</div>
		<style type="text/css">
            #map-canvas { height: 100%; width: 100%; }
        </style>
        		
        <script type="text/javascript">
            var drawingManager;
            var all_overlays = [];
            var selectedShape= new google.maps.Rectangle();
            var overlay = [];
			var sendData = {};
			var googleMaps;

			//USGSOverlay.prototype = new google.maps.OverlayView();
			
            function initialize() {
				var mapOptions = {
                    zoom: 11,
                    center: new google.maps.LatLng(21.03069,105.85252),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    zoomControl: true
                };
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                
				//map.enableGoogleBar();
                var polyOptions = {
                    strokeWeight: 0,
                    fillOpacity: 0.45,
                    editable: true,
                    draggable: true
                };
				//Map search
				var input = /** @type {HTMLInputElement} */(document.getElementById('searchTextField'));
				//Auto complete
				var autocomplete = new google.maps.places.Autocomplete(input);
				autocomplete.bindTo('bounds', map);
				
				var infowindow = new google.maps.InfoWindow();
				var marker = new google.maps.Marker({
					map: map
				});
				
				
                // markers, lines, and shapes.
                drawingManager = new google.maps.drawing.DrawingManager({
					drawingControl: true,
					drawingControlOptions: {
						position: google.maps.ControlPosition.TOP_LEFT,
						drawingModes: [
							google.maps.drawing.OverlayType.POLYGON,
							google.maps.drawing.OverlayType.RECTANGLE
						]
					},
                    rectangleOptions: polyOptions,
                    polygonOptions: polyOptions,
                    map: map
                });
				
				 //places search autocomplete event
				google.maps.event.addListener(autocomplete, 'place_changed', function() {
					infowindow.close();
					marker.setVisible(false);
					//input - no class
					input.className = '';
					//get place from google database
					var place = autocomplete.getPlace();
					
					if (!place.geometry) {
						// Inform the user that the place was not found and return.
						input.className = 'notfound';
						return;
					}

					// If the place has a geometry, then present it on a map.
					if (place.geometry.viewport) {
						map.fitBounds(place.geometry.viewport);
					} else {
						map.setCenter(place.geometry.location);
						map.setZoom(17);  // Why 17? Because it looks good.
					}
					marker.setIcon(/** @type {google.maps.Icon} */({
						url: place.icon,
						size: new google.maps.Size(71, 71),
						origin: new google.maps.Point(0, 0),
						anchor: new google.maps.Point(17, 34),
						scaledSize: new google.maps.Size(35, 35)
					}));
					//show this position on the maps
					marker.setPosition(place.geometry.location);
					marker.setVisible(true);
					//Information about result
					var address = '';
					if (place.address_components) {
						address = [
							(place.address_components[0] && place.address_components[0].short_name || ''),
							(place.address_components[1] && place.address_components[1].short_name || ''),
							(place.address_components[2] && place.address_components[2].short_name || '')
						].join(' ');
					}
					//Show note about this place result
					infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
					infowindow.open(map, marker);
				});
				
                google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
					if (all_overlays != null){
						deleteAllShape();
					}
                    all_overlays.push(e);
                    if (e.type == google.maps.drawing.OverlayType.RECTANGLE ||
                    		e.type == google.maps.drawing.OverlayType.POLYGON) {
                        // Switch back to non-drawing mode after drawing a shape.
                        drawingManager.setDrawingMode(null);
						
						printToInput(e.overlay);
						setSelection(e.overlay);
						google.maps.event.addListener(e.overlay, 'bounds_changed', function(){
							printToInput(this);
						});
                    }
                });

                // Clear the current selection when the drawing mode is changed, or when the
                // map is clicked.
                //google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
                //google.maps.event.addListener(map, 'click', clearSelection);
				google.maps.event.addDomListener(document.getElementById('resetSearch'), 'click', resetSearch);
				
				// Sets a listener on a radio button to change the filter type on Places
				// Autocomplete.
				function setupClickListener(id, types) {
					var radioButton = document.getElementById(id);
					google.maps.event.addDomListener(radioButton, 'click', function() {
						autocomplete.setTypes(types);
					});
				}
				//Set up
				setupClickListener('changetype-all', []);
				setupClickListener('changetype-establishment', ['establishment']);
				setupClickListener('changetype-geocode', ['geocode']);
				
				google.maps.event.addDomListener(document.getElementById("downloadAll"), 'click', function(){
				//function showPicture(){
					var getLink = $(this).parent().parent().find('img');
					var srcImage = getLink.attr('src');
					var bounds = getBoundShowpicLatLg();
					console.log(getLink);
					console.log(srcImage);
					console.log(bounds);
					var customOverlay = new USGSOverlay(bounds, srcImage, map);
        			overlay.push(customOverlay);
    			});
                //google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
                //google.maps.event.addDomListener(document.getElementById('delete-all-button'), 'click', deleteAllShape);

                //buildColorPalette();
            }
            google.maps.event.addDomListener(window, 'load', initialize);
			
            /*---------Main program ----------*/
            //Get and send data to server
            $(document).ready(function(){
                
                //Fill all screen of the browser
                $(window).ready(changeSize);
				$(window).resize(changeSize);
                
                //Close datepicker 
                $("#picker1, #picker2, .toTime, .fromTime").click(function(){
                	closeDatePicker();
                });
                $("#picker2").click(function(){
                	closeDatePicker();
                });

				//Create bands to select 
				for(var i = 0; i < 12; i++){
					$(".bandItem:first-child").clone().appendTo("#bandChoose");
				}
				
                //initialize each band
				$("#bandChoose").children().each(function(index){	
					//add index to each div band
					$(this).children(":first").attr("data-band-index", (index+1));
					//Add name band to each tile 
					$(this).children(":first").html("<p style='margin-top:5px;margin-bottom:2px'>Band "+(index+1)+"</p>");
					//Listen the click event on each band DIV element.
					$(this).click(selectBand);	
				});
				$(".proCit").click(selectProCit);
				$(".features").click(selectProcess);

				/*
				---------------Search button---------------
				*/
                //Click event, send to server, check all attributes
                $(".searchImage").click(function(){
                    fromTime = checkTime(getFromTime());
                    toTime = checkTime(getToTime());
                    bands = getBand();
                    latLngs = getLatLongs();
                    oneCwt = getCWT();
                    oneDist = getDistrict();
                    onePro = getProvince();
                    processType = getProcess();

                    if(checkFromTo(fromTime, toTime) && 
                        bands.length != 0 && (latLngs.length != 0 || oneCwt != -1 || oneDist != -1 || onePro != -1) && processType != null){
                        //Type of data: select by province: 1, district 2, cwt 3 or by latlong: 0
                        sendData.typeData = 1;
                        sendData.fromTime=objectTime(fromTime);
                        sendData.toTime=objectTime(toTime);
                        sendData.process = processType;
                        sendData.numBands=bands.length;
                        for(var i = 0; i<sendData.numBands; i++){
                            Object.defineProperty(sendData, 'band'+i, {value : bands[i],
                               writable : true,
                               enumerable : true,
                               configurable : true
                            });
                        }
                        if (latLngs.length != 0){
                        	sendData.typeData = 0;
	                        for(i=0; i<8; i=i+2){
	                            Object.defineProperty(sendData, 'lat'+(i/2), {value : latLngs[i],
	                               writable : true,
	                               enumerable : true,
	                               configurable : true
	                            });
	                            Object.defineProperty(sendData, 'lg'+(i/2), {value : latLngs[i+1],
	                               writable : true,
	                               enumerable : true,
	                               configurable : true
	                            });
	                        }
	                    }else{
	                    	if (oneCwt == -1){
	                    		if (oneDist == -1){
	                    			sendData.cwt = onePro;
	                    		}else{
	                    			sendData.cwt = oneDist;
	                    			sendData.typeData = 2;
	                    		}
	                    	}else{
	                    		sendData.cwt = oneCwt;
	                    		sendData.typeData = 3;
	                    	}
	                    }
	                    
                        //$.post("http://localhost/catAnhVeTinh/getDownload/sendData.php", 
                        $.ajax({
                        	type: 'post',
                        	url: "http://localhost/catAnhVeTinh/postgisviewer/show.php",     
                            data: { 'data':JSON.stringify(sendData)},
                            beforeSend: function(){
                            	showResultView();
                            	var divLoading=$('<div>', {
									class:'span3',
									style: 'margin: 0px',
								});
								var rowBound = $('<div>', {
									class: 'row'
								});
								var textLoading  = $("<div class='span2' style = 'margin: 0px'></div>");
								var iconLoading = $('<div>', {
									class: 'loadingIcon place-right span1',
									style: 'margin: 0px',
								});
								$("<h3 style='margin: 0px; text-align: center; height: 25px'>Processing</h3>").appendTo($(textLoading));
								$(textLoading).appendTo($(rowBound));
								$(iconLoading).appendTo($(rowBound));
								$(rowBound).appendTo($(divLoading));
								$(divLoading).appendTo($("#posi"));
                            },
                            success: function(data){
								//Test sendData show 
								//alert(data);
								console.log(data);
								showResultView();
								createResultView(data);
								/*
								---------------Result view---------------
								*/

								//Delete button  
								$(".removeBut").click(deleteImage);
								//Download button
								$(".downloadBut").click(downloadPic);
								//Show bigger preview picture
								$(".dialogOverlay").click(function(e){
									//e.preventDefault();
									$(".dialogOverlay, .dialogBox").remove();
								});
								//------------------SHOW PICTURES HERE-------------------------
								
								//$(".showPic").click(showPicture);
								/*{
									/*
									selectedImageParaDelete(this);
									showPreview();
									//changeSizePic();
										
									var getLink = $(this).parent().parent().find('img');
									var srcImage = getLink.attr('src');
									var bounds = getBoundShowpicLatLg();

									console.log(srcImage);
									console.log(bounds);
									var customOverlay = new USGSOverlay(bounds, srcImage, googleMaps);
									console.log(customOverlay);
				        			//overlay.push(customOverlay);
								});*/
							

								/*
								Interact with each tile image
								*/
								$(".croppedImage").click(selectedImage);
				
                                //$("#posi").html(" "+ data + " ");
                            }
                        });
                    }else{
                        $.Dialog({
							'title'      : 'Wrong Input!',
							'content'    : 'Please choose area on the <b>maps</b>!</br>Choose bands (You have to do this)! </br>And choose time, from time must be smaller than to time!',
							'draggable'  : true,
							'buttonsAlign': 'right',
							'keepOpened'  : true,
							'buttons'    : {
								'Ok'    : {
									'action': function() {}
								},
								'Cancel' : {
									'action': function() {}
								}
							}
						});
                    }
                });
            });
			/*
			Can chinh lai getLatLongs-get o o input;
			Khi nao nhap xong toa do thi ve hinh ra -neu co the thi chinh lai thnah
			hinh chu nhat
			Chinh lai khung hien thi ket qua, viet ham resize, 
			Sua ham resize, den mot kich thuoc window nhat dinh thi giu nguyen chieu rong
			Chinh lai bang chon band -luu cac band do trong co so du lieu
			Chinh lai footer;
			Su dung ham ajax thay cho post
			
			*/
        </script>
    </body>
</html>