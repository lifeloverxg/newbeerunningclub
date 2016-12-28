<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @people:album</h1>');
	}

	$auth = Authority::get_auth_arr();
	$tpid = $auth['uid'];
	$add_photo = false;
	if (isset($_GET['pid'])) {
		$tpid = $_GET['pid'];
	}
	if ($auth['uid'] == $tpid) {
		$add_photo = true;
	}

	$info_list = PeopleDAO::get_info_list($auth['uid'], $tpid);
	$title = $info_list['title'] . ' - 个人相册 - NBRC - 纽约新蜂跑团';
	$photo_list = AlbumDAO::get_photo_list_people($tpid);
	
	$stylesheet = array('theme/zus/album_photo.css'
						);
	$javascript = array('js/zus/common.js'
						);
	$links = $_SGLOBAL['links'];

	if ( isset($_POST['submit_delete_photo']) && ($_POST['submit_delete_photo']!="") )
	{
		$photoids = array();
		foreach ($_POST['delete_photo'] as $photo_id) {
			array_push($photoids, (int)$photo_id);
		}
		AlbumDAO::delete_photo_photoids($photoids);
		header('Location: '.$home.'people/album_photo.php?pid='.$tpid);
	}

include S_ROOT."template/people/album_photo_frame.php";

?>