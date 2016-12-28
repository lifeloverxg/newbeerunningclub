<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @event:album</h1>');
	}

	if ( isset($_GET['eid']) )
	{
		$eid = $_GET['eid'];
	}
	else
	{
		header('Location: browser.php');
	}
	$auth = Authority::get_auth_arr();
	$deviceType = Mobile_Detect::deviceType();

	$add_photo = false;
	$official = false;
	// if (PeopleDAO::get_event_role_pid($auth['uid'], $eid) >= Role::Member) {
	// 	$add_photo = true;
	// }
	if ( PeopleDAO::get_event_role_pid($auth['uid'], $eid) >= Role::Admin )
	{
		$add_photo = true;
		$official = true;
	}

	$info_list = EventDAO::get_info_list($auth['uid'], $eid);
	$title = $info_list['title'] . ' - 活动相册 - NBRC - 纽约新蜂跑团';
	// $photo_list = AlbumDAO::get_photo_list_event($eid);
	$aid = AlbumDAO::get_default_album_event($eid);
	$photo_list_container = AlbumDAO::get_album_aid_limit($aid);
	$photo_list = $photo_list_container['photo_list'];
	// var_dump($aid);
	$next = $photo_list_container['more'];
	
	$stylesheet = array(
						'theme/zus/album_photo.css'
						);	
	$m_stylesheet = array();
	
	$javascript = array(
						'js/zus/common.js'
						);
	$m_javascript = array(
							'js/zus/common.js',
							'js/mobile/m_common.js'
						);
	
	$links = $_SGLOBAL['links'];

	$isUpload = 0;
	if ( isset($_GET['isupload']) )
	{
		$isUpload = 1;
	}

	if ( isset($_POST['submit_delete_photo']) && ($_POST['submit_delete_photo']!="") )
	{
		$photoids = array();
		foreach ($_POST['delete_photo'] as $photo_id)
		{
			array_push($photoids, (int)$photo_id);
		}
		AlbumDAO::delete_photo_photoids($photoids);
		header('Location: '.$home.'event/album_photo.php?eid='.$eid);
	}

	if ( ($deviceType == "phone") ) 
	{
		include S_ROOT."template/mobile/event/m_photo_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."template/event/album_photo_frame.php";
	}
	else 
	{
		include S_ROOT."template/event/album_photo_frame.php";
	}

?>