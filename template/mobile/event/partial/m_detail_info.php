<?php
	include_once S_ROOT.'template/mobile/shared/list/m_photo_list_more.php';
	include_once S_ROOT.'template/mobile/shared/list/m_down_list.php';
?>
<div class="info-list-small">
	<header class="info-title-small">活动时间</header>
	<div class="info-content-small"><?php echo $info_list['活动时间']; ?></div>
</div>
<div class="info-list-small">
	<header class="info-title-small">活动地点</header>
	<div class="info-content-small"><?php echo $info_list['活动地点']; ?></div>
</div>
<div class="info-list-large">
	<header class="info-title-large" onclick="textToggle()">
		活动描述
		<span class="glyphicon glyphicon-chevron-down" id="down-icon"></span>
		<span class="glyphicon glyphicon-chevron-up" id="up-icon"></span>
	</header>
	<div class="info-content-large" id="hide-text">
		<?php echo $info_list['活动描述']; ?>
		<div class="view-info-list-content-more">
			<a style="color: black;" href="javascript:" onclick="textToggle();">收起</a>
		</div>
	</div>
</div>
<div class="info-list-small">
<header class="info-title-small">参与成员</header>
<?php
	$m_admin_list = array();
	foreach (array_slice($member_list['admins'], 0, 4) as $admin) {
		$admin_item = array(
							'url' => $home . $admin['url'],
							'logo' => $home . $admin['image_large'],
							'title' => $admin['title']
		);
		array_push($m_admin_list, $admin_item);
	}
	m_down_list::render($m_admin_list, '');
?>
<header class="info-title-none"></header>
<?php
	$m_member_list = array();
	foreach (array_slice($member_list['members'], 0, 4) as $member) {
		$member_item = array(
							 'url' => $home . $member['url'],
							 'logo' => $home . $member['image_large'],
							 'title' => $member['title']
		);
		array_push($m_member_list, $member_item);
	}
	m_down_list::render($m_member_list, 'member_list.php?eid='.$eid);
?>
</div>
<!-- <div class="info-list-small">
<header class="info-title-small">活动图片</header> -->
<?php
	// $m_photo_list = array();
	// foreach (array_slice($photo_list, 0, 4) as $photo_item) {
	// 	$photo_item['logo'] = $home .  $photo_item['image'];
	// 	array_push($m_photo_list, $photo_item);
	// }
	// m_photo_list_more::render($m_photo_list, $eid);
?>
<!-- </div> -->
<div class="info-list-small">
	<header class="info-title-small">留言板</header>
<?php
	include $home . "cgi/feed_list.php";
?>
</div>
