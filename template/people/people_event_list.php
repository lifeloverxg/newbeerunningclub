<div class="display-block-small">
	<div class="display-block-title">
		活动
		<img src="<?php echo $home . "theme/images/logo_blue.png"; ?>">
	</div>
	<ul class="ul-event-list-small">
<?php foreach ($event_list_small as $event) { ?>
		<li>
			<a href="<?php echo $home.$event['url']; ?>">
				<img class="logo-medium" src="<?php echo $home.$event['image']; ?>" alt="<?php echo $event['alt']; ?>" title="<?php echo $event['title']; ?>">
			</a>
			<a href="<?php echo $home.$event['url']; ?>">
				<span class="list-title-event"><?php echo $event['title']; ?></span>
			</a>
		</li>
<?php } ?>
	</ul>
</div>