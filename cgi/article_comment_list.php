<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:article_feed_list</h1>');
	}

	$auth = Authority::get_auth_arr();

	if (isset($_GET['arid'])) {
		$arid = $_GET['arid'];
	} else {
		$arid = -1;
	}	

	$comment_list = BoardDAO::get_comment_list_bid($auth['uid'], $arid, 12);


	include $home . "template/information/comment_list.php";
	
	
