<?php include("header.php")?>
	<div class="page">
		<!--h2 style="margin: 0px; margin-left: 10px;"><b> Application </b></h2-->
		<div class="page-region">
			<div class="page-region-content" style="background-color: #ccc; padding-top: 5px; padding-bottom: 0px;">
				<div class="page snapped">
					<div class="page-control" data-role="page-control" style="width: 100%; height: 100%">
						<span class="menu-pull"></span>
						<div class="menu-pull-bar"></div>
						<!-- Mark for each pages -->
						<ul>
							<li class="active"><a href="#page1">Search</a></li>
							<li><a href="#page2">Result</a></li>
						</ul>
						<!--Contents inside each pages -->
						<div class="frames contentPage">
						<!--In page 1 -->
							<div class="frame active" id="page1" style="margin: 0px;">
							<!--List of accordion -->
								<ul class="accordion" data-role="accordion" style="margin:0px; width: 100%;overflow-y:auto">
									<li>
										<a href="#">Periods of Time:</a>
										<div class="grid" style="height: 100%">
											<!-- -->
											<!-- Date picker-->
											<div class="row">
												<!--From date time -->
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
												<!--To date time-->
												<div class="span3" style="width: 100%; margin: 0px;">
													<div class="span1" style="margin: 0px;">
														<h3 style="margin: 0px; height: 32px;text-align: center;">To: </h3>
													</div>
													<div class="input-control text datepicker span2 place-right" id="picker1" data-param-lang="en" data-param-year-buttons="1" style="margin: 0px">
														<input class="toTime" type="text" />
														<button class="btn-date"></button>
													</div>
												</div>
											</div>
										</div>
									</li>
									<!--Spatial-->
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
									<!-- Bands -->
									<li>
										<a href="#">Bands</a>
										<div class="grid" id="bandChoose" style="overflow: auto">
											<div class="row bandItem" style="margin: 0">
												<div class="tile tiny-vertical" id="bandImage"></div>
											</div>
										</div>
									</li>
								</ul>
								<div class="border-color-blue place-right controlButton" >
									<!--Search button-->
									<a class="button bg-color-blueLight searchImage place-right" style="margin:0;">Search</a>
									<!--Reset button-->
									<a class="button bg-color-blueLight place-right" id="resetSearch" style="margin:0; margin-right: 10px">Reset</a>
								</div>
							</div>
							<!--Contents in page 2 -->
							<div class="frame span4" id="page2" style="margin: 0px; height: 100%">
								<!--Result view-->
								<div id="posi" style="overflow: auto; height: 450px">
									
								</div>
								<!--Download all button -->
								<div class="border-color-blue place-right controlButton" >
									<a class="button bg-color-blueLight downloadAll place-right" style="margin:0;">Download</a>
								</div>
							</div>
						</div>
						<?php include("footer.php")?>
					</div>
				</div>
				<div class="page fill bg-color-blueDark">
					<!--Google Maps-->
					<div id="map-canvas"></div>
				</div>
			</div>
		</div>
	</div>
        
        <style type="text/css">
            #map-canvas { height: 100%; width: 100%; }
        </style>
        <script type="text/javascript" 
            src="http://maps.googleapis.com/maps/api/js?libraries=drawing&sensor=true">
        </script>
		<script type="text/javascript" src="js/site.js"></script>
		<script type="text/javascript" src="js/searchResult.js"></script>
		
        <script type="text/javascript">
            var drawingManager;
            var all_overlays = [];
            var selectedShape= new google.maps.Rectangle();
			var sendData = {};
			//Clear selection 
            function clearSelection() {
                if (selectedShape) {
                    selectedShape.setEditable(false);
                    selectedShape = null;
                }
            }
			//Set selection
            function setSelection(shape) {
                clearSelection();
                selectedShape = shape;
                shape.setEditable(true);
            }
			//Delete selected shape
            function deleteSelectedShape() {
                if (selectedShape) {
                    selectedShape.setMap(null);
                }
            }

            function deleteAllShape() {
                for (var i=0; i < all_overlays.length; i++){
                    all_overlays[i].overlay.setMap(null);
                }
                all_overlays = [];
            }
			
            function initialize() {
                var map = new google.maps.Map(document.getElementById('map-canvas'), {
                    zoom: 11,
                    center: new google.maps.LatLng(21.03069,105.85252),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    //disableDefaultUI: true,
                    zoomControl: true
                });
				//map.enableGoogleBar();
                var polyOptions = {
                    strokeWeight: 0,
                    fillOpacity: 0.45,
                    editable: true,
                    draggable: true
                };
                // Creates a drawing manager attached to the map that allows the user to draw
				
                // markers, lines, and shapes.
                drawingManager = new google.maps.drawing.DrawingManager({
					drawingControl: true,
					drawingControlOptions: {
						position: google.maps.ControlPosition.TOP_LEFT,
						drawingModes: [
							google.maps.drawing.OverlayType.RECTANGLE
						]
					},
                    rectangleOptions: polyOptions,
                    map: map
                });

                google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
                    all_overlays.push(e);
                    if (e.type == google.maps.drawing.OverlayType.RECTANGLE) {
                        // Switch back to non-drawing mode after drawing a shape.
                        drawingManager.setDrawingMode(null);
						
						printToInput(e.overlay);
						setSelection(e.overlay);
						google.maps.event.addListener(e.overlay, 'bounds_changed', function(){
							printToInput(this);
						});
                       /* var newShape = e.overlay;
                        newShape.type = e.type;
                        google.maps.event.addListener(newShape, 'click', function() {
                            setSelection(newShape);
                        });
                        setSelection(newShape);
						*/
						//$("#posi").html(e.overlay.getBounds().getNorthEast() + "  !");bounds_changedmouseover
                    }
                });
                
                // Clear the current selection when the drawing mode is changed, or when the
                // map is clicked.
                google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
                google.maps.event.addListener(map, 'click', clearSelection);
				google.maps.event.addDomListener(document.getElementById('resetSearch'), 'click', resetSearch);
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
				
				/*
				---------------Search button---------------
				*/
                //Click event, send to server, check all attributes
                $(".searchImage").click(function(){
                    fromTime = checkTime(getFromTime());
                    toTime = checkTime(getToTime());
                    bands = getBand();
                    latLngs = getLatLongs();
                    
                    if(checkFromTo(fromTime, toTime) && 
                        bands.length != 0 && latLngs.length != 0){
                        
                        sendData.fromTime=objectTime(fromTime);
                        sendData.toTime=objectTime(toTime);
                        sendData.numBands=bands.length;
                        for(var i = 0; i<sendData.numBands; i++){
                            Object.defineProperty(sendData, "band"+i, {value : bands[i],
                               writable : true,
                               enumerable : true,
                               configurable : true
                            });
                        }
                        for(i=0; i<8; i=i+2){
                            Object.defineProperty(sendData, "lat"+(i/2), {value : latLngs[i],
                               writable : true,
                               enumerable : true,
                               configurable : true
                            });
                            Object.defineProperty(sendData, "lg"+(i/2), {value : latLngs[i+1],
                               writable : true,
                               enumerable : true,
                               configurable : true
                            });
                        }
                        $.post("temporary.php", 
                            {
                                data: JSON.stringify(sendData)
                            },
                            function(data){
								showResultView();
								createResultView(data);
								/*
								---------------Result view---------------
								*/
								//Delete button  
								$(".removeBut").click(deleteImage);
								//Download button
								
								//Show metadata button
								
								//Show bigger preview picture
								/*$(".dialogOverlay").click(function(e){
										//e.preventDefault();
										$(".dialogOverlay, .dialogBox").remove();
								});*/
								$(".showPic").click(showPreview);
								/*
								Interact with each tile image
								*/
								$(".croppedImage").click(selectedImage);
				
                                //$("#posi").html(" "+data + " ");
                            }
                        );
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