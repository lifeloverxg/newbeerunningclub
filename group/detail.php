<?php
	$home = '../';
	include_once ($home.'core.php');

$bm = new Timer();

	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @group:browser</h1>');
	}

	if (isset($_GET['gid'])) {
		$gid = $_GET['gid'];
	}
	else if (isset($_GET['type']) && $_GET['type'] == 'article' && !empty($_GET['id'])) {
		$bid = $_GET['id'];
		$gid = BoardDAO::get_board_gowner_id($bid);
	}
	else {
		header('Location: browser.php');
	}

	$auth = Authority::get_auth_arr();
	$deviceType = Mobile_Detect::deviceType();
	$add_album = false;
	$viewer_role = PeopleDAO::get_group_role_pid($auth['uid'], $gid);
	$group_privacy = GroupDAO::get_group_privacy_gid($gid);
$bm->mark();

	$viewlevel = 0;
	if ($group_privacy < Privacy::Member) {
		$viewlevel = 1;
	}
	if ($viewer_role >= $group_privacy) {
		$viewlevel = 2;
	}
	if ($viewer_role >= Role::Admin) {
		$add_album = true;
	}

	if ($viewlevel <= 0) {
		Unicorn::show($home, '抱歉，您要访问的页面不存在或权限不足');
	}
	if ($viewlevel > 0) {
		$info_list = GroupDAO::get_info_list($auth['uid'], $gid);
		$title = $info_list['title'] . ' - 群组页面 - NBRC - 纽约新蜂跑团';
		$stylesheet = array('theme/zus/group_css/group_detail.css',
							'theme/zus/event_css/event_feed_list.css',
							// 'theme/zus/group_css/group_feed_list.css',
							'theme/zus/group_css/post_article.css',
							'theme/zus/people_css/edit_profile.css',
							'theme/zus/search_css/filter.css'
							);
		$m_stylesheet = array(
							'theme/zus/event_css/event_feed_list.css',
							'theme/zus/mobile_css/m_feed_list.css',
							);
		$javascript = array(
							'js/zus/comment.js',
							'js/zus/common.js'
							);
		$m_javascript = array(
								'js/zus/comment.js',
								'js/zus/common.js',
								'js/mobile/m_common.js');
		$links = $_SGLOBAL['links'];
		$large_logo = GroupDAO::get_group_logo($auth['uid'], $gid);
		$button_list = GroupDAO::get_group_oper_button_list($auth['uid'], $gid);
		$button_list_large = $button_list['large'];
		$group_catalog_list =GroupCategory::get_const_array();
		$group_filter_list = GroupFilter::get_edit_filter_list($info_list['群组标签']);
		$button_list_small = array();// $button_list['small'];
		$member_list = GroupDAO::get_group_member_list($auth['uid'], $gid, 6);
		$admin_list_small = $member_list["admins"];
		// $member_list_small_gender = $member_list["members"];
		$member_list_small = $member_list["members"];
		$m_album_cover = GroupDAO::get_album_cover_list(0, $gid, 20);
	}
$bm->mark();

	if ($viewlevel > 1)
	{
		$event_list_small = GroupDAO::get_group_event_list($auth['uid'], $gid);
		$recommend_list = GroupDAO::get_group_recommend_list($auth['uid'], $gid);
		//	$feed_list = GroupDAO::get_feed_list($auth['uid'], $gid);
		//	$tag_list = $feed_list["tag_list"];
		//	$feed_list_large = $feed_list["feed_list_large"];
		//	$add_feed_list = $feed_list["add_feed"];
		
		$article_catalog_list = ArticleCategory::get_const_array();
		$article_privacy_list = Privacy::get_const_array();
		$article_list = ArticleDAO::get_group_article_list($gid);
		
		if ( isset($_POST["edit_submit"]) && ($_POST["edit_submit"]!="") )
		{
			$info = array(
						  'title' => $_POST["edit_title"],
						  'description' => $_POST["group_description"],
						  'category' => $_POST["edit_category"],
						  'size' => $_POST["edit_size"],
						  'tag' => $_POST["edit_tag"],
						  'announcement' => $_POST["group_announcement"],
						  );
			
			GroupDAO::edit_info($auth['uid'], $gid, $info);
			
			header('Location: '.$home.'group/detail.php?gid='.$gid);
		}
		
		if ( isset($_POST["article_submit"]) && ($_POST["article_submit"]!="") )
		{
			$article = array(
							 'title' => $_POST["article_title"],
							 'category' => $_POST["article_category"],
							 'tag' => $_POST["article_tag"],
							 'privacy' => $_POST["article_privacy"],
							 'content' => $_POST["article_content"]
							 );
			
			$bid = ArticleDAO::post_article($auth['uid'], $gid, $article);
			
			if ( !empty($bid) )
			{
				// header('Location: '.$home.'information/detail.php?arid='.$bid);
				header('Location: '.$home.'group/detail.php?gid='.$gid);
			}
		}
		
		if ( isset($_POST["album_submit"]) && ($_POST["album_submit"]!="") && isset($_POST["album_title"]))
		{
			$cover = DefaultImage::Group;
			$aid = AlbumDAO::create_album($_POST["album_title"], $auth['uid'], $cover);
			GroupDAO::create_group_album($gid, $aid);
			
			header('Location: '.$home.'group/detail.php?gid='.$gid);
		}
	}

	if ( $gid == 1200 )
	{
		include S_ROOT."template/school/browser.php";
	}
	else if ( ($deviceType == "phone") ) 
	{
		include S_ROOT."template/mobile/group/m_detail_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."template/group/group_frame.php";
	}
	else 
	{
		include S_ROOT."template/group/group_frame.php";
	}
$bm->mark();
echo '<!-- '.$bm->report().'-->';
?>