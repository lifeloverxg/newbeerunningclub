<?php
	if (!isset($title)) {
		$home = '../';
		include_once ($home.'core.php');
		
		if(!defined('IN_ZUS')) {
			exit('<h1>503:Service Unavailable @event:browser</h1>');
		}

		
		$auth = Authority::get_auth_arr();	
	}

	$tag_id = 0;
	if (isset($_GET['tag']) && $_GET['tag'] != ""){
		$tag_id = $_GET['tag'];
	}

	$page_id = 0;
	if (isset($_GET['eid'])) {
		$page_id = $_GET['eid'];
		$feed_list = EventDAO::get_feed_list($auth['uid'], $page_id, $tag_id);
	}
	else if (isset($_GET['gid'])) {
		$page_id = $_GET['gid'];
		$feed_list = GroupDAO::get_feed_list($auth['uid'], $page_id, $tag_id);
	}
	else if (isset($_GET['pid'])) {
		$page_id = $_GET['pid'];
		$feed_list = PeopleDAO::get_feed_list($auth['uid'], $page_id, $tag_id);
	}
	else {
		header('Location: browser.php');
	}

	$tag_list = $feed_list["tag_list"];
	$feed_list_large = $feed_list["feed_list_large"];
	
	include $home . "template/common/feed_list.php";