<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @people:friend list</h1>');
	}

	$pid = Authority::get_uid();
	$category = 'following';
	if (isset($_GET['category']) && $_GET['category'] != ""){
		$category = $_GET['category'];
	}
	$friend_list = PeopleDAO::get_friend_list_large($pid, $category);

// Friend List Content
include $home . "template/people/friend_list_board.php";
?>