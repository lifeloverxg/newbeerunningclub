			<section class="section-direction-map">
				<script>
					$("#map-canvas").ready(function() {
	                    getMyLocation();
	                });
				</script>
				<div id="panel" class="event-direction-wrap">
				    <b>去往活动<span><?php echo $info_list['title']; ?></span>:</b>
					<input type="text" id="end" value="<?php echo $location; ?>" x-webkit-speech="x-webkit-speech"/>
					<button onclick=calcRoute() style="background: white; color: black;">获取路线</button>
				    <button onclick="visit('event?eid=<?php echo $eid; ?>')" style="float: right;">返回活动页面</button>
				</div>
				<div id="map-canvas" title="route map" style="height: 600px; margin-top: 10px;"></div>
			</section>