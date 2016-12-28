<?php
	if (!isset($title)) {
		$home = '../';
		include_once ($home.'core.php');
		
		if(!defined('IN_ZUS')) {
			exit('<h1>503:Service Unavailable @event:browser</h1>');
		}

		if (isset($_GET['gid'])) {
			$gid = $_GET['gid'];
		}
		else {
			header('Location: browser.php');
		}
		$auth = Authority::get_auth_arr();	
	}

	$tag_id = 0;
	if (isset($_GET['tag']) && $_GET['tag'] != ""){
		$tag_id = $_GET['tag'];
	}

	$feed_list = BoardDAO::get_feed_list($auth['uid'], $gid, $tag_id);
	$tag_list = $feed_list["tag_list"];
	$feed_list_large = $feed_list["feed_list_large"];
	
	include $home . "template/common/feed_list.php";