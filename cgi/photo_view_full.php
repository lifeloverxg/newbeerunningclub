<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @album photo:view full</h1>');
	}

	if (isset($_GET['photo_src']) && $_GET['photo_src']!='') {
		$photo_src = $_GET['photo_src'];
	}

	if (isset($_GET['photo_id']) && $_GET['photo_id']!='') {
		$photo_id = $_GET['photo_id'];
		$photo_full = AlbumDAO::get_photo_full($home, $photo_id);
	}

//List Content
include $home . "template/common/popup_frames/photo_full.php";
?>