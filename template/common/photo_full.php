			<section id="photo-full">
<?php if(isset($photo_src) && $photo_src!= '') { ?>
				<img src="<?php echo $home . $photo_src; ?>">
<?php } else if(isset($photo_full) && $photo_full!= '') { ?>
				<img src="<?php echo $home . $photo_full; ?>">
<?php } else { ?>
				<h3>对不起，暂无大图</h3>
<?php } ?>
			</section>