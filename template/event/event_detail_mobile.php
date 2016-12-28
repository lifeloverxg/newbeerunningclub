<section class="section-event-detail-mobile">
	<div class="detail-logo-mobile">
		<div class="middle-logo">
			<?php include $home . "template/common/large_logo.php"; ?>
		</div>
		<div class="middle-jiathis">
			<?php include $home . "template/common/jia_button.php"; ?>
		</div>
	</div>
	<div class="detail-button-list">
		<?php include $home . "template/common/button_list.php"; ?>
	</div>
	<ul class="ul-info-list">
<?php foreach ($info_list as $label => $content) {
	if ( ($label == "活动时间") || ($label == "活动地点") || ($label == "人数规模") || ($label == "活动类型") || ($label == "活动描述") ) {
?>
		<li>
			<div class="info-list-label"><?php echo $label; ?>：</div>
			<div class="info-list-content"><?php echo $content; ?></div>
		</li>
<?php       }
}
?>
	</ul>
</section>