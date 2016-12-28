			<section class="section-button-list-small">
				<ul class="ul-button-list-small-large-button">
<?php foreach ($button_list_large as $button) { ?>
					<li><button onclick="<?php echo $button['action']; ?>" class="button_large_<?php echo $button['class']; ?>"><?php echo $button['title']; ?></button></li>
<?php } ?>					
				</ul>
				
<!--
				<ul class="ul-button-list-small-small-button">
<?php foreach ($button_list_small as $button) { ?>
					<li><button onclick="<?php echo $button['action']; ?>" class="button_small_<?php echo $button['class']; ?>"><?php echo $button['title']; ?></button></li>
<?php } ?>
				</ul>
-->
			</section>
