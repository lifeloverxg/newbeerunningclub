<?php if (isset($map_view["lat"]) && $map_view["lat"] != ""){ ?>
			<script>
				document.write("<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false'></"+"script>");

				$("#map-canvas-view").ready(function() {
					var mapOptions = {
				        center: new google.maps.LatLng(<?php echo $map_view['lat']; ?>, <?php echo $map_view['lng']; ?>),
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
				    
				    map = new google.maps.Map(document.getElementById('map-canvas-view'), mapOptions);

				    var marker = new google.maps.Marker({
				    	position: new google.maps.LatLng(<?php echo $map_view['lat']; ?>, <?php echo $map_view['lng']; ?>),
				    	map: map,
				    	title: "<?php echo $map_view['title']; ?>",
				    });
				});
			</script>
<?php } else { ?>
			<script>
				$("#map-canvas-view").ready(function() {
					$("#map-canvas-view").css("background", "url('../theme/images/map_background.jpg') no-repeat #fff");
					$("#map-canvas-view").css("background-size", "cover");
				});
			</script>
<?php } ?>
			<div id="map-canvas-view" class="map-output"></div>
