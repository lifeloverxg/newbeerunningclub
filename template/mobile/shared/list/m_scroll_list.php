<?php
	class m_scroll_list {
		public static function render($list) {
?>
<ul class="ul-m-scroll-list">
<?php foreach ($list as $member) { ?>
	<li>
		<a href="<?php echo $member['url']; ?>">
			<img class="logo-medium" src="<?php echo $member['image']; ?>" alt="<?php echo $member['alt']; ?>" title="<?php echo $member['title']; ?>">
		</a>
		<span class="list-icon-member"><?php // echo $member['icon']; ?></span>
		<br>
		<a href="<?php echo $member['url']; ?>">
			<span class="list-title-member"><?php echo $member['title']; ?></span>
		</a>
	</li>
<?php } ?> 
</ul>
<?php
	}
}
?>