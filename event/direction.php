<?php

	$home = '../';
	include_once ($home.'core.php');
	
$bm = new Timer();
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @event:detail</h1>');
	}

	if (isset($_GET['eid'])) {
		$eid = $_GET['eid'];
	}
	else {
		header('Location: browser.php');
	}

	$auth = Authority::get_auth_arr();

	$info_list = EventDAO::get_info_list($auth['uid'], $eid);
	$location = $info_list['活动地点'];
	$title = '路线 - '. $info_list['title'] . ' - 活动页面 - NBRC - 纽约新蜂跑团';
	$stylesheet = array(
						);
	$javascript = array(
						'js/zus/map/route.js'
						);
	$links = $_SGLOBAL['links'];
$bm->mark();
	
$bm->mark();

	include S_ROOT."template/event/map/direction_frame.php";
$bm->mark();
echo '<!-- '.$bm->report().'-->';
