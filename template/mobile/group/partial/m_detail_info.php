<?php
	include_once S_ROOT.'template/mobile/shared/list/m_photo_list.php';
	include_once S_ROOT.'template/mobile/shared/list/m_down_list.php';
?>
<div class="info-list-large">
	<header class="info-title-large" onclick="textToggle()">
		群组描述
		<span class="glyphicon glyphicon-chevron-down" id="down-icon"></span>
		<span class="glyphicon glyphicon-chevron-up" id="up-icon"></span>
	</header>
	<div class="info-content-large" id="hide-text"><?php echo $info_list['群组描述']; ?></div>
</div>
<div class="info-list-small">
<header class="info-title-small">群组成员</header>
<?php
	$m_admin_list = array();
	foreach (array_slice($member_list['admins'], 0, 4) as $admin) {
		$admin_item = array(
							'url' => $home . $admin['url'],
							'logo' => $home . $admin['image'],
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
							 'logo' => $home . $member['image'],
							 'title' => $member['title']
		);
		array_push($m_member_list, $member_item);
	}
	m_down_list::render($m_member_list, 'member_list.php?gid='.$gid);
?>
</div>
<!-- <div class="info-list-small"> -->
<!-- <header class="info-title-small">群组相册</header> -->
<?php
	// $m_photo_list = array();
	// foreach (array_slice($m_album_cover['albums'], 0, 8) as $photo_item) {
	// 	$photo_item['logo'] = $home .  $photo_item['image'];
	// 	array_push($m_photo_list, $photo_item);
	// }
	// m_photo_list::render($m_photo_list);
?>
<!-- </div> -->

<!-- <div class="info-list-small">
	<header class="info-title-small">
		文章列表 -->
		<!-- <a href="javascript:" onclick="" style="float: right;">查看更多</a> -->
	<!-- </header>
	<div class="section-article-list-small">
		<div class="div-article-list-small">
			<table width="300px" border="0" cellpadding="0" cellspacing="0" class="article-small-table" id="article-table-small">
				<tbody align="left" width="300px">
					<tr class="articke-small-table-head">
						<td width="35%" nowrap="nowrap">文章名</td> -->
						<!-- <td>Sales End</td> -->
						<!-- <td width="25%" nowrap="nowrap">作者</td> -->
						<!-- <td>Tax</td> -->
						<!-- <td width="40%" nowrap="nowrap">发表时间</td>
					</tr> -->
<?php // foreach ( $article_list as $key => $article) { ?>
					<!-- <tr nowrap="nowrap">
						<td nowrap="nowrap" width="35%" verticle-align="middle">
							<div style="width: 112px;">
								<a href="<?php echo $home.$article['url']; ?>">
									<p style="margin-bottom: 10px; font-size:16px;color: rgba(0, 116, 168, 1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $article['title']; ?></p>
								</a>
							</div>
						</td>
						<td nowrap="nowrap" width="25%">
							<div style="width: 80%;">
								<a href="<?php echo $home.$article['author']['url']; ?>">
									<img style="width: 35px;" src="<?php echo $home.$article['author']['image'];?>">
									<p style="margin-bottom: 10px; font-size:12px; color: rgba(0, 116, 168, 0.6); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $article['author']['title']; ?></p>
								</a>
							</div>
						</td>
						<td nowrap="nowarp" width="40%">
							<div style="width: 128px;">
								<p style="margin-bottom: 10px; font-size:12px; color: #ccc; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"> <?php echo $article['ctime']; ?> </p>
							</div>
						</td>
					</tr> -->
<?php //} ?>
				<!-- </tbody>
			</table>
		</div>
	</div>
</div> -->

<div class="info-list-small">
<header class="info-title-small">群组活动</header>
<?php
	$m_event_list = array();
	foreach ($event_list_small as $event) {
		$event_item = array(
							'url' => $home . $event['url'],
							'logo' => $home . $event['image_large'],
							'title' => $event['title']
		);
		array_push($m_event_list, $event_item);
	}
	m_down_list::render($m_event_list, '');
?>

	<div class="group-feed-list">
		<header class="info-title-small">
			留言板
		</header>
<?php
	include $home . "cgi/feed_list.php";
?>
	</div>
