<div class="div-browser-right">
	<div class="display-block-small">
		<div class="display-block-title">
			活跃群组
			<!-- <img src="<?php echo $home . "theme/images/logo_blue.png"; ?>"> -->
		</div>
		<div class="hot-event-list">
			<ul class="display-block-items">
<?php foreach ($hot_group_list as $hot_group) { ?>
				<li>
					<a href="<?php echo $home . $hot_group['url']; ?>">
						<div class="hot-event-list-left">
							<img src="<?php echo $home . $hot_group['image']; ?>"/>
						</div>
						<div class="hot-event-list-title">
							<?php echo $hot_group['title'];?>
						</div>
					</a>
				</li>
<?php } ?>
			</ul>
		</div>
	</div>
<?php include $home . "template/common/share_frames/common_share_frame.php"; ?>
</div>
