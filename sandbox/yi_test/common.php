<?php
	$home = '../../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @sandbox:yi_test</h1>');
	}

	$auth = Authority::get_auth_arr();
	
	$pid = Authority::get_uid();

	$title = $info_list['title'] . ' - 测试页面 - NBRC - 纽约新蜂跑团';
	
	$stylesheet = array();
	$javascript = array();
	
	$links = $_SGLOBAL['links'];

// HTML header
include $home . "template/common/header.php";
?>

<?php 
	// $uid_list = AccountDAO::user_error();
	// var_dump($uid_list);
	// $test = AccountDAO::access_Eventbrite();
	// var_dump($test);
	$eid = 59;
	$address = 'testtesttest';
	$test = EventDAO::get_eventbrite_url_eid($eid);
	// $test_2 = EventDAO::sale_eid_exist($eid);
	var_dump($test);
	var_dump($eid);
?>

<?php

// HTML footer
include $home . "template/common/footer.php";
?>