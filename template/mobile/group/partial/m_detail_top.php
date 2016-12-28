<section class="event-detail-top">
	<div class="event-detail-title"><?php echo $info_list['title']; ?></div>
	<div class="event-detail-logo">
		<img src="<?php echo $home . $large_logo['image']; ?>" title="<?php echo $large_logo['title']; ?>" alt="<?php echo $large_logo['alt']; ?>">
		<div class="event-detail-join">
			<div class="info-list">
				<ul class="ul-info-list">
		<?php foreach ($info_list as $label => $content) {
			if ($label != "title") {
				if ( $label == "群组类型" ) {
		?>
					<li>
						<div class="info-list-label">类型:</div>
						<div class="info-list-content"><?php echo $content; ?></div>
					</li>
		<?php   } else if ( $label == "人数规模" ) { ?>
					<li>
						<div class="info-list-label">规模:</div>
						<div class="info-list-content"><?php echo $content; ?></div>
					</li>
		<?php   } else if ( $label == "标签内容" ) { ?>
					<li>
						<div class="info-list-label">标签:</div>
						<div class="info-list-content"><?php echo $content; ?></div>
					</li>
		<?php   } else if ( $label == "成立时间" ) { ?>
					<li>
						<div class="info-list-label">成立时间:</div>
						<div class="info-list-content"><?php echo $content; ?></div>
					</li>
		<?php   }
			}
		}
		?>
				</ul>
			</div>
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