<div class="view-left-top-info">
	<ul class="ul-info-list">
		<li>
			<div class="info-list-label info-list-label-spec">活动时间：</div>
			<div class="info-list-content info-list-content-spec"><?php echo $info_list['活动时间']; ?></div>
		</li>
		<li>
			<div class="info-list-label info-list-label-spec">活动地点：</div>
			<div class="info-list-content info-list-content-spec" style="white-space:initial; width: 210px;">
				<?php echo $info_list['活动地址']['street']; ?><br/>
				<?php echo $info_list['活动地址']['city']; ?><br/>
				<?php echo $info_list['活动地址']['state']; ?><br/>
			</div>
		</li>
		<li>
			<div class="info-list-label">人数规模：</div>
			<div class="info-list-content"><?php echo $info_list['人数规模']; ?></div>
		</li>
		<li>
			<div class="info-list-label">活动类型：</div>
			<div class="info-list-content"><?php echo $info_list['活动类型']; ?></div>
		</li>
	</ul>
</div>
<!-- 地址 -->