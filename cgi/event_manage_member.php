<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:event_manage_member</h1>');
	}

	$auth = Authority::get_auth_arr();

	$eid = -1;
	
	if ( isset($_GET['eid']) ) 
	{
		$eid = $_GET['eid'];
	}

	$limit = 1000;

	$member_list = EventDAO::get_event_member_list_nogender($auth['uid'], $eid, $limit);

//	var_dump($member_list);

// Friend List Content
include $home . "template/event/manage_member/manage_member_board.php";
?>