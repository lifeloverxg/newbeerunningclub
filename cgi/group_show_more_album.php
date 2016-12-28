<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @album:group album</h1>');
	}

	$gid = -1;
	$start = 0;

	if (isset($_GET['gid'])) {
		$gid = $_GET['gid'];
	}
	if(isset($_GET['start'])) {
		$start = (int)$_GET['start'];
	}

	$pid = Authority::get_uid(); 
	$add_album = false;
	$viewer_role = PeopleDAO::get_group_role_pid($pid, $gid);
	if ($viewer_role >= Role::Admin) {
		$add_album = true;
	}
	//echo "<script type='text/javascript'>alert($start);</script>";
	$image_list = GroupDAO::get_album_cover_list($pid, $gid, 4, $start);

// Friend List Content
include $home . "template/common/image_list.php";
?>