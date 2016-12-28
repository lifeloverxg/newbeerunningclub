<section class="section-map-view">
    <div class="div-map-view-yi" id="div-map-view-yi">
 <?php ?>
 		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places,weather&language=en-us"></script>
 		<script>
 			$("#map-canvas").ready(function() {
					codeAddress('<?php echo $info_list['活动地点']; ?>, USA', '<?php echo $info_list['title']; ?>');
				});
 		</script>
 <?php ?>
  		<div id="map_canvas" style="width:100%; height:200px"></div>
	</div>
	<div class="map-direction">
		<div class="map-direction-font">
			<a href="direction.php?eid=<?php echo $eid;?>" style="color: white;">查找位置和线路</a>
		</div>
    </div>
</section>
