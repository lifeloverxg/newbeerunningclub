<div class="display-block-small">
	<div class="display-block-title">
		群组
		<!-- <img src="<?php echo $home . "theme/images/logo_blue.png"; ?>"> -->
	</div>
	<ul class="ul-group-list-small">
<?php foreach ($group_list_small as $group) { ?>
		<li>
			<a href="<?php echo $home.$group['url']; ?>">
				<img class="logo-medium" src="<?php echo $home.$group['image']; ?>" alt="<?php echo $group['alt']; ?>" title="<?php echo $group['title']; ?>">
			</a>
			<a href="<?php echo $home.$group['url']; ?>">
				<span class="list-title-group"><?php echo $group['title']; ?></span>
			</a>
		</li>
<?php } ?>		
	</ul>
</div>
