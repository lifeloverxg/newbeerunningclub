<div class="div-browser-right">
	<div class="display-block-small">
		<div class="display-block-title">
			热门活动
			<!-- <img src="<?php echo $home . "theme/images/logo_blue.png"; ?>"> -->
		</div>
		<div class="hot-event-list">
			<ul class="display-block-items">
<?php foreach ($hot_event_list as $hot_event) { ?>
				<li>
					<a href="<?php echo $home . $hot_event['url']; ?>">
						<div class="hot-event-list-left">
							<img src="<?php echo $home . $hot_event['image']; ?>"/>
						</div>
						<div class="hot-event-list-title">
							<?php echo $hot_event['title'];?>
						</div>
					</a>
				</li>
<?php } ?>
			</ul>
		</div>
	</div>
	<div class="display-block-small">
		<div class="display-block-title">
			最新活动
			<!-- <img src="<?php echo $home . "theme/images/logo_blue.png"; ?>"> -->
		</div>
		<div class="newest-event-list">
			<ul class="display-block-items">
<?php foreach ($newest_event_list as $newest_event) { ?>
				<li>
					<a href="<?php echo $home . $newest_event['url']; ?>">
						<div class="hot-event-list-left">
							<img src="<?php echo $home . $newest_event['image']; ?>"/>
						</div>
						<div class="hot-event-list-title">
							<?php echo $newest_event['title'];?>
						</div>
					</a>
				</li>
<?php } ?>
			</ul>
		</div>
	</div>
<?php include $home . "template/common/share_frames/common_share_frame.php"; ?>
</div>
