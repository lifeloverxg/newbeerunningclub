<?php
// HTML header
include $home . "template/common/header.php";
?>

<?php include $home . "template/common/navigation/navi_group_detail.php"; ?>
<section class="view-top">
<?php echo $info_list['title'];?>
</section>

<div class="group-detail-left">
	<div class="group-detail-left-top">
		<div class="group-detail-left-top-left">
<?php
			include $home . "template/common/large_logo.php";
?>
		</div>
<?php
		include $home . "template/group/group_info.php";
?>
	</div>

	<div class="info-list-label-title">
		<div class="info-list-label-title-head">详细信息</div>
		<div class="info-list-label-title-more glyphicon-toggle-icon">
			<a style="color: black;" href="javascript:" onclick="showMoreInfoContent();">
				<span class="glyphicon glyphicon-chevron-down" id="down-icon"></span>
			</a>
		</div>
	</div>
	<div class="view-info-list-content">
		<?php echo $info_list['群组描述']; ?>
	</div>
	<div class="view-info-list-content-more">
		<a style="color: black;" href="javascript:" onclick="showMoreInfoContent();">查看详细</a>
	</div>

<?php
	include $home . "template/common/event_list.php";
?>

	<!--  <div class="section-article-list-small">
		<p class="addressing">
			<span>文章</span>
			<a href="javascript:" onclick="" style="float: right;">查看更多</a>
		</p>
		<div class="div-article-list-small">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="article-small-table" id="article-table-small">
				<tbody align="center">
					<tr class="articke-small-table-head">
						<td width="35%" nowrap="nowrap">文章名</td> -->
						<!-- <td>Sales End</td> -->
						<!-- <td width="25%" nowrap="nowrap" align="center">作者</td> -->
						<!-- <td>Tax</td> -->
						<!-- <td width="40%" nowrap="nowrap">发表时间</td>
					</tr> -->
<?php // foreach ( $article_list as $key => $article) { ?>
					<!-- <tr nowrap="nowrap">
						<td>
							<a href="<?php echo $home.$article['url']; ?>">
								<p style="font-size:16px;color: rgba(0, 116, 168, 1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $article['title']; ?></p>
							</a>
						</td>
						<td nowrap="nowrap">
							<a href="<?php echo $home.$article['author']['url']; ?>">
								<img style="width: 35px;" src="<?php echo $home.$article['author']['image'];?>">
								<p style="font-size:12px; color: rgba(0, 116, 168, 0.6); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $article['author']['title']; ?></p>
							</a>
						</td>
						<td nowrap="nowarp">
							<p style="color: #ccc;"> <?php echo $article['ctime']; ?> </p>
						</td>
					</tr> -->
<?php //} ?>
				<!-- </tbody>
			</table>
		</div>
	</div> -->

	<section class="section-group-album">
		<?php include $home . "cgi/group_show_more_album.php"; ?>
	</section>

	<div class="group-feed-list">
		<p class="addressing">
			<span>留言板</span>
		</p>
<?php
	include $home . "cgi/feed_list.php";
?>
	</div>
</div>

<div class="group-detail-right">
<?php
include $home . "template/common/share_frames/common_share_frame.php";
include $home . "template/common/new_member_list/admin_list.php";
include $home . "template/common/new_member_list/group_member_list.php";
?>
</div>

<?php 
// popup frames
include $home . "template/group/edit_group_info.php";
include $home . "template/common/popup_frames/create_album.php";
include $home . "template/group/post_article.php";
?>

<?php
// HTML footer
include $home . "template/common/footer.php";
?>