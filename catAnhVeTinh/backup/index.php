<?php include("header.php")?>
		<div class="page">
			<div class="page-region">
				<div class="page-region-content">
					<div class="grid">
						<div class="row">
							<div class="span12">
								<h2 style="margin: 0px;"><b> Application </b></h2>
								<div class="span12" style="background-color: #ccc; height: 570px;">
									<div class="page snapped">
										<!--Choose periods of time -->
										<div class="grid" style="height: 100px">
											<div class="row">
												<div class="span3"><h3 style="margin: 0px;">Periods of Time:</h3></div>
											</div>
											<div class="row">
												<div class="span3" style="width: 234px; margin: 0px;">
													<div class="row">
														<div class="span1" style="margin: 0px;"><h3 style="margin: 0px; height: 32px;text-align: center;">From: </h3></div>
														<div class="input-control text datepicker span2 place-right" id="picker1" data-param-lang="en" style="margin: 0px">
															<input class="fromTime" type="text" />
															<button class="btn-date"></button>
														</div>
													</div>
												</div>
												<div class="span3" style="width: 234px; margin: 0px;">
													<div class="span1" style="margin: 0px;"><h3 style="margin: 0px; height: 32px;text-align: center;">To: </h3></div>
													<div class="input-control text datepicker span2 place-right" id="picker1" data-param-lang="en" style="margin: 0px">
														<input class="toTime" type="text" />
														<button class="btn-date"></button>
													</div>
												</div>
											</div>
										</div>
										<!--Choose bands -->
										<div class="grid">
											<div class="row span3" style="margin: 0px">
												<div class="page-sidebar" style="margin: 0px; width: 234px;">
													<ul style="margin: 0px;">
														<li class="sticker dropdown active" data-role="dropdown">
															<a><i class="icon-list"></i> Choose Band</a>
															<ul class="sub-menu light sidebar-dropdown-menu keep-opened">
																<li indexNum="1" id="bandImage" class="not">Band 1</li>
																<li indexNum="2" id="bandImage" class="chose">Band 2</li>
																<li indexNum="3" id="bandImage" class="chose">Band 3</li>
																<li indexNum="4" id="bandImage" class="not">Band 4</li>
															</ul>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<!--Search button-->
										<a class="button bg-color-blueLight place-right searchImage" style="margin: 0px">Search</a>
										<!--Show the results-->
										<div class="grid" style="height: 385px; overflow: auto;">
											<div class="row">
												<div class="span3" style="width: 234px; height: 50px; margin: 0px; margin-bottom: 5px;">
													<div class="grid">
													<div class="row">
														<img style="height: 50px; width: 50px; margin-right: 4px;" src="" >
													    <div class="grid place-left" style="width: 167px; margin: 0px;">
														<div class="row">
															<h4 class="" style="margin: 0px; text-align: left;">&nbsp;Landsat 8 - Band 1</h4>
														</div>
														<div class="row">
															<h4 class="" style="margin: 0px; text-align: left;">&nbsp;Date: 12/6/2012</h4>
														</div>
														</div>
													</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="span3" style="width: 234px; height: 50px; margin: 0px; margin-bottom: 5px;">
													<div class="grid">
													<div class="row">
														<img style="height: 50px; width: 50px; margin-right: 4px;" src="" >
													    <div class="grid place-left" style="width: 167px; margin: 0px;">
														<div class="row">
															<h4 class="" style="margin: 0px; text-align: left;">&nbsp;Landsat 8 - Band 2</h4>
														</div>
														<div class="row">
															<h4 class="" style="margin: 0px; text-align: left;">&nbsp;Date: 12/6/2012</h4>
														</div>
														</div>
													</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="span3" style="width: 234px; height: 50px; margin: 0px; margin-bottom: 5px;">
													<div class="grid">
													<div class="row">
														<img style="height: 50px; width: 50px; margin-right: 4px;" src="" >
													    <div class="grid place-left" style="width: 167px; margin: 0px;">
														<div class="row">
															<h4 class="" style="margin: 0px; text-align: left;">&nbsp;Landsat 8 - Band 3</h4>
														</div>
														<div class="row">
															<h4 class="" style="margin: 0px; text-align: left;">&nbsp;Date: 12/6/2012</h4>
														</div>
														</div>
													</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="span3" style="width: 234px; height: 50px; margin: 0px; margin-bottom: 5px;">
													<div class="grid">
													<div class="row">
														<img style="height: 50px; width: 50px; margin-right: 4px;" src="" >
													    <div class="grid place-left" style="width: 167px; margin: 0px;">
														<div class="row">
															<h4 class="" style="margin: 0px; text-align: left;">&nbsp;Landsat 8 - Band 4</h4>
														</div>
														<div class="row">
															<h4 class="" style="margin: 0px; text-align: left;">&nbsp;Date: 12/6/2012</h4>
														</div>
														</div>
													</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="span3" style="width: 234px; height: 50px; margin: 0px; margin-bottom: 5px;">
													<div class="grid">
													<div class="row">
														<img style="height: 50px; width: 50px; margin-right: 4px;" src="" >
													    <div class="grid place-left" style="width: 167px; margin: 0px;">
														<div class="row">
															<h4 class="" style="margin: 0px; text-align: left;">&nbsp;Landsat 8 - Band 5</h4>
														</div>
														<div class="row">
															<h4 class="" style="margin: 0px; text-align: left;">&nbsp;Date: 12/6/2012</h4>
														</div>
														</div>
													</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="span3" style="width: 234px; height: 50px; margin: 0px; margin-bottom: 5px;">
													<div class="grid">
													<div class="row">
														<div id="panel">
															<div id="color-palette"></div>
																<div>
																	<button id="delete-button">Delete Selected Shape</button>
																	<button id="delete-all-button">Delete All Shapes</button>
																</div>
														</div>
													</div>
													<div class="row">
														<div id="posi"></div>
													</div>
													</div>
												</div>
											</div>
											
											
										</div>
									</div>
									<div class="page fill bg-color-blueDark">
										<div id="map-canvas"></div>
									</div>
								</div>
							</div>
						</div>
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

		<script type="text/javascript">
			var drawingManager;
			var all_overlays = [];
			var selectedShape;
			var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
			var selectedColor;
			var colorButtons = {};

			function clearSelection() {
				if (selectedShape) {
					selectedShape.setEditable(false);
					selectedShape = null;
				}
			}

			function setSelection(shape) {
				clearSelection();
				selectedShape = shape;
				shape.setEditable(true);
				selectColor(shape.get('fillColor') || shape.get('strokeColor'));
			}

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

			function selectColor(color) {
				selectedColor = color;
				for (var i = 0; i < colors.length; ++i) {
					var currColor = colors[i];
					colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
				}

				// Retrieves the current options from the drawing manager and replaces the
				// stroke or fill color as appropriate.
				var polylineOptions = drawingManager.get('polylineOptions');
				polylineOptions.strokeColor = color;
				drawingManager.set('polylineOptions', polylineOptions);

				var rectangleOptions = drawingManager.get('rectangleOptions');
				rectangleOptions.fillColor = color;
				drawingManager.set('rectangleOptions', rectangleOptions);

				var circleOptions = drawingManager.get('circleOptions');
				circleOptions.fillColor = color;
				drawingManager.set('circleOptions', circleOptions);

				var polygonOptions = drawingManager.get('polygonOptions');
				polygonOptions.fillColor = color;
				drawingManager.set('polygonOptions', polygonOptions);
			}

			function setSelectedShapeColor(color) {
				if (selectedShape) {
					if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
						selectedShape.set('strokeColor', color);
					} else {
						selectedShape.set('fillColor', color);
					}
				}
			}

			function makeColorButton(color) {
				var button = document.createElement('span');
				button.className = 'color-button';
				button.style.backgroundColor = color;
				google.maps.event.addDomListener(button, 'click', function() {
					selectColor(color);
					setSelectedShapeColor(color);
				});

				return button;
			}

			function buildColorPalette() {
				var colorPalette = document.getElementById('color-palette');
				for (var i = 0; i < colors.length; ++i) {
					var currColor = colors[i];
					var colorButton = makeColorButton(currColor);
					colorPalette.appendChild(colorButton);
					colorButtons[currColor] = colorButton;
				}
				selectColor(colors[0]);
			}

			function initialize() {
				var map = new google.maps.Map(document.getElementById('map-canvas'), {
					zoom: 11,
					center: new google.maps.LatLng(21.03069,105.85252),
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					disableDefaultUI: true,
					zoomControl: true
				});

				var polyOptions = {
					strokeWeight: 0,
					fillOpacity: 0.45,
					editable: true,
					draggable: true
				};
				// Creates a drawing manager attached to the map that allows the user to draw
				// markers, lines, and shapes.
				drawingManager = new google.maps.drawing.DrawingManager({
					drawingMode: google.maps.drawing.OverlayType.POLYGON,
					markerOptions: {
						draggable: true
					},
					polylineOptions: {
						editable: true
					},
					rectangleOptions: polyOptions,
					circleOptions: polyOptions,
					polygonOptions: polyOptions,
					map: map
        }		);

				google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
					all_overlays.push(e);
					if (e.type != google.maps.drawing.OverlayType.MARKER) {
						// Switch back to non-drawing mode after drawing a shape.
						drawingManager.setDrawingMode(null);
	
						// Add an event listener that selects the newly-drawn shape when the user
						// mouses down on it.
						var newShape = e.overlay;
						newShape.type = e.type;
						google.maps.event.addListener(newShape, 'click', function() {
							setSelection(newShape);
						});
						setSelection(newShape);
					}
				});
				/*google.maps.event.addListener(map, 'mouseout', function(){
					
				});*/
				// Clear the current selection when the drawing mode is changed, or when the
				// map is clicked.
				google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
				google.maps.event.addListener(map, 'click', clearSelection);
				google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
				google.maps.event.addDomListener(document.getElementById('delete-all-button'), 'click', deleteAllShape);

				buildColorPalette();
			}
			google.maps.event.addDomListener(window, 'load', initialize);
			/*--------- ----------*/
			//Get and send data to server
			$(document).ready(function(){
				var sendData = {};
				
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
					var i = $("#bandImage");
					do{
						if((i.attr("class") == "chose") && checkBand(i.attr("indexNum")) ){
							bandImage[counts]= i.attr("indexNum");
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
					for (var i = 0; i < all_overlays.length; i++){
						if(all_overlays[i].type == google.maps.drawing.OverlayType.RECTANGLE){
							
							var neLatLg=all_overlays[i].overlay.getBounds().getNorthEast();
							var swLatLg=all_overlays[i].overlay.getBounds().getSouthWest();
							//upper left
							latLngs[counts] = neLatLg.lat(); counts++;
							latLngs[counts] = swLatLg.lng(); counts++;
							//Upper right
							latLngs[counts] = neLatLg.lat(); counts++;
							latLngs[counts] = neLatLg.lng(); counts++;
							//lower left
							latLngs[counts] = swLatLg.lat(); counts++;
							latLngs[counts] = swLatLg.lng(); counts++;
							//lower right
							latLngs[counts] = swLatLg.lat(); counts++;
							latLngs[counts] = neLatLg.lng(); counts++;
						}
					}
					$("#posi").html(latLngs.join());
					return latLngs;
				}
				//Change fromTime and toTime to be one object of sendData
				function objectTime(thisTime){
					var t = thisTime.getFullYear()+"-"+(thisTime.getMonth()+1)+"-"+thisTime.getDate();
					return t;
				}
				
				//Clicl event, send to server, check all attributes
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
								$("#posi").html(" "+data + " ");
							}
						);
					}else{
						alert("Input Wrong!");
					}
				});
			});
    	</script>
<?php include("footer.php")?>