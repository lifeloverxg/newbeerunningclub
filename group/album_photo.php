<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @group:album</h1>');
	}

	$auth = Authority::get_auth_arr();
	$gid = -1;
	$aid = -1;
	$add_photo = false;
	if (isset($_GET['aid'])) {
		$aid = $_GET['aid'];
	}
	if (isset($_GET['gid'])) {
		$gid = $_GET['gid'];
	}
	if (PeopleDAO::get_group_role_pid($auth['uid'], $gid) >= Role::Admin) {
		$add_photo = true;
	}

	$info_list = GroupDAO::get_info_list($auth['uid'], $gid);
	$title = $info_list['title'] . ' - 群组相册 - NBRC - 纽约新蜂跑团';
	$photo_list = AlbumDAO::get_album_aid($aid);
	
	$stylesheet = array('theme/zus/album_photo.css'
						);
	$javascript = array('js/zus/common.js'
						);
	$links = $_SGLOBAL['links'];

	// if ( isset($_POST['submit_delete_photo']) && ($_POST['submit_delete_photo']!="") )
	// {
	// 	$photoids = array();
	// 	foreach ($_POST['delete_photo'] as $photo_id) {
	// 		array_push($photoids, (int)$photo_id);
	// 	}
	// 	AlbumDAO::delete_photo_photoids($photoids, 0);
	// 	header('Location: '.$home.'group/album_photo.php?aid='.$aid.'&gid='.$gid.'&start='.$start);
	// }

	include S_ROOT."template/group/album_photo_frame.php";

?>