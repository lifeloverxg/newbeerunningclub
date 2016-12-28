<section class="section-group-info">
	<div class="info-list">
		<ul class="ul-info-list">
<?php foreach ($info_list as $label => $content) {
	if ($label != "title") {
		if ( ($label != "群组标签") && ($label != "群组描述") && ($label != "规模") ) {
?>
			<li>
				<div class="info-list-label"><?php echo $label; ?>:</div>
				<div class="info-list-content"><?php echo $content; ?></div>
			</li>
<?php       	}
	}
}
?>
		</ul>
	</div>
<?php include $home . "template/common/button_list.php"; ?>
</section>

