<section class="event-detail-top">
	<div class="event-detail-title"><?php echo $info_list['title']; ?></div>
	<div class="event-detail-logo">
		<img src="<?php echo $home . $large_logo['image']; ?>" title="<?php echo $large_logo['title']; ?>" alt="<?php echo $large_logo['alt']; ?>">
		<div class="event-detail-join">
			<p><?php echo $info_list['活动描述']; ?></p>
		</div>
		<section class="section-button-list-small">
			<ul class="ul-button-list-small-large-button">
<?php foreach ($button_list_large as $button) { ?>
				<li><button onclick="<?php echo $button['action']; ?>" class="button_large_<?php echo $button['class']; ?>"><?php echo $button['title']; ?></button></li>
<?php } ?>					
			</ul>
		</section>
	</div>
</section>