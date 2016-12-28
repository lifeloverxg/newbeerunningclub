<?php
include_once ('util/timer.php');
$bm = new Timer();

	$home = './';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @root:index</h1>');
	}
$bm->mark();

	$title = '首页 - NBRC - 纽约新蜂跑团';
	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();

	$stylesheet = array(
						'theme/zus/welcome_in2.css');
	$javascript = array('js/zus/home.js',
						);
	$links = $_SGLOBAL['links'];
	$side = 1;
	$signin_error = array();
	$signup_error = array();

	$index_event_list = EventDAO::get_index_event_list();

//	var_dump($index_event_list);
$bm->mark();

	include S_ROOT.'template/index_frame_in.php';
$bm->mark();
echo '<!-- '.$bm->report().'-->';

	?>
