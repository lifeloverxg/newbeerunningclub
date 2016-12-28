							<script>
								document.write("<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'></"+"script>");

								$("#map-canvas-form").ready(function() {
									var mapOptions = {
										center: new google.maps.LatLng(<?php echo isset($map_view["lat"])?$map_view["lat"]:"40.731129";?>, <?php echo isset($map_view["lng"])?$map_view["lng"]:"-74.007683";?>),
										zoom: 13,
										zoomControl: true,
										styles: [
											{
												featureType: "all",
												elementType: "labels",
												stylers: [
													{ visibility: "on" }
												]
											}
										]
									};
								
									map = new google.maps.Map(document.getElementById('map-canvas-form'), mapOptions);
								
									var marker = new google.maps.Marker({
										position: new google.maps.LatLng(<?php echo isset($map_view["lat"])?$map_view["lat"]:"40.731129";?>, <?php echo isset($map_view["lng"])?$map_view["lng"]:"-74.007683";?>),
										map: map,
										draggable: true
									});
									google.maps.event.addDomListener(map, "click", function(event){
										var lat = event.latLng.lat();
										var lng = event.latLng.lng();
										marker.setPosition(new google.maps.LatLng(lat, lng));
										$("#lat_value").val(lat);
										$("#lng_value").val(lng);
									});

									google.maps.event.addListener(marker, 'dragend', function(event) {
										var lat = event.latLng.lat();
										var lng = event.latLng.lng();
										$("#lat_value").val(lat);
										$("#lng_value").val(lng);
									});

								});
							</script>
							<div id="map-canvas-form" class="map-input"></div>
							<input type="hidden" value="" name="lat" id="lat_value">
							<input type="hidden" value="" name="lon" id="lng_value">
