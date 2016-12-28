<?php
// HTML header
include $home . "template/about/header.php"; ?>

<?php foreach ($nav_list as $key => $nav) { ?>

<section class="section-about-<?php echo $key; ?>">
	<div class="about-title">
		<div class="before-title-triangle"></div><?php echo $nav; ?>
	</div>
	<?php include $home . "template/about/about_". $key . ".php"; ?>
</section>

<?php } ?>

	</body>
</html>