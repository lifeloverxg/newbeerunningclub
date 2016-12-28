<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @cgi:feed_list</h1>');
	}

	$auth = Authority::get_auth_arr();	

	$deviceType = Mobile_Detect::deviceType(); 

	$tag_id = 0;
	if (isset($_GET['tag']) && $_GET['tag'] != ""){
		$tag_id = $_GET['tag'];
	}

	$page_id = 0;
	if (isset($_GET['id']) && $_GET['id'] != "") {
		$page_id = $_GET['id'];
	}

	$page_type = "";
	if (isset($_GET['type']) && $_GET['type'] != "") {
		$page_type = $_GET['type'];
	}
	
	if ($page_type == "event") {
		$feed_list = EventDAO::get_feed_list($auth['uid'], $page_id, $tag_id);
	}
	else if ($page_type == "group") {
		$feed_list = GroupDAO::get_feed_list($auth['uid'], $page_id, $tag_id);
	}
	else if ($page_type == "people") {
		$feed_list = PeopleDAO::get_feed_list($auth['uid'], $page_id, $tag_id);
	}
	else if ($page_type == "article") {
		$article = ArticleDAO::get_article_bid($auth['uid'], $page_id);
		include $home . "template/common/article.php";
		return;
	}
	else {
		if (isset($_GET['eid']) && $_GET['eid'] != ""){
			$page_id = $_GET['eid'];
			$page_type = "event";
			$feed_list = EventDAO::get_feed_list($auth['uid'], $_GET['eid'], $tag_id);
		}
		else if (isset($_GET['gid']) && $_GET['gid'] != ""){
			$page_id = $_GET['gid'];
			$page_type = "group";
			$feed_list = GroupDAO::get_feed_list($auth['uid'], $_GET['gid'], $tag_id);
		}
		else if (isset($_GET['pid']) && $_GET['pid'] != ""){
			$page_id = $_GET['pid'];
			$page_type = "people";
			$feed_list = PeopleDAO::get_feed_list($auth['uid'], $_GET['pid'], $tag_id);
		}
	}

	$tag_list = $feed_list["tag_list"];
	$feed_list_large = $feed_list["feed_list_large"];
	$next = $feed_list["next"];

	if ( $deviceType == "phone" )
	{
		include $home . "template/mobile/shared/partial/m_shared_feed_list.php";
	}
	else
	{
		// if ($title == '新生社群 - NBRC - 纽约新蜂跑团')
	   //  include $home . "template/school/feed_list.php";
    // else
    	include $home . "template/common/feed_list.php";
	}
	
	
