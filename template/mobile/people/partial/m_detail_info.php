<section class="section-people-detail-info">
	<div class="people-detail-title"><?php echo $info_list['title']; ?></div>
	<div class="people-detail-logo">
		<img src="<?php echo $home . $large_logo['image']; ?>" title="<?php echo $large_logo['title']; ?>" alt="<?php echo $large_logo['alt']; ?>">
		<div class="people-detail-info">
			<p><label>个人签名：</label><?php echo $info_list['个人签名']; ?></p>
			<section class="section-button-list-small">
				<ul class="ul-button-list-small-large-button">
<?php foreach ($button_list_large as $button) { ?>
					<li><button onclick="<?php echo $button['action']; ?>" class="button_large_<?php echo $button['class']; ?>"><?php echo $button['title']; ?></button></li>
<?php } ?>					
				</ul>
			</section>
		</div>
	</div>
	<div class="info-list-large">
		<header class="info-title-large" onclick="textToggle()">
			详细信息
			<span class="glyphicon glyphicon-chevron-down" id="down-icon"></span>
			<span class="glyphicon glyphicon-chevron-up" id="up-icon"></span>
		</header>
		<div class="info-content-large info-content-large-people" id="hide-text">
		<?php foreach ($info_list as $key => $value) { 
			if ( ($key != "title") && ($key != "个人签名") && ($key != "nature") ) {
		?>
			<label><?php echo $key; ?>：</label><?php echo $value; ?><br>
		<?php 
			}
		} ?>
		</div>
	</div>
</section>