<?php
	include_once S_ROOT.'template/mobile/shared/list/m_scroll_list.php';
?>
<div class="info-list-small">
<header class="info-title-small">好友列表</header>
<?php
	$scroll_list = array();
	foreach ($member_list_small as $member) {
		$member_item = array(
							 'url' => $home . $member['url'],
							 'image' => $home . $member['image_large'],
							 'title' => $member['title'],
							 'alt' => $member['title']
		);
		array_push($scroll_list, $member_item);
	}
	m_scroll_list::render($scroll_list);
?>
</div>
<div class="info-list-small">
	<header class="info-title-small">参与活动</header>
	<ul class="ul-event-list-small">
<?php foreach ($event_list_small as $event) { ?>
		<li>
			<a href="<?php echo $home.$event['url']; ?>">
				<img class="logo-medium" src="<?php echo $home.$event['image_large']; ?>" alt="<?php echo $event['alt']; ?>" title="<?php echo $event['title']; ?>">
			</a>
			<a href="<?php echo $home.$event['url']; ?>">
				<span class="list-title-event"><?php echo $event['title']; ?></span>
			</a>
			<span class="glyphicon glyphicon-chevron-right list-more-right"></span>
		</li>
<?php } ?>
	</ul>
</div>

<div class="info-list-small">
	<header class="info-title-small">留言板</header>
<?php
	include $home . "cgi/feed_list.php";
?>
</div>