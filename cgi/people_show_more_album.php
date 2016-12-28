<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @album:people album</h1>');
	}

	$auth = Authority::get_auth_arr();
	$tpid = $auth['uid'];
	if (isset($_GET['pid'])) {
		$tpid = $_GET['pid'];
	}
	$start = 0;
	if(isset($_GET['start'])) {
		$start = (int)$_GET['start'];
	}
 
	//echo "<script type='text/javascript'>alert($start);</script>";
	$image_list = PeopleDAO::get_album_cover_list($tpid, 4, $start);

// Friend List Content
include $home . "template/common/image_list.php";
?>