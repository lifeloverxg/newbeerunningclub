<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:event_manage member</h1>');
	}

	$pid = Authority::get_uid();
	$gid = -1;
	if (isset($_GET['gid'])) {
		$gid = $_GET['gid'];
	}
	$limit = -1;

//To->liuyue, what is 'more' for?
	if (isset($_GET['more']))
		$member_list = GroupDAO::get_group_member_list_relation($pid, $gid, $limit);
	else
		$member_list = GroupDAO::get_group_member_list($pid, $gid, $limit);

// Friend List Content
include $home . "template/group/manage_member_board.php";
?>