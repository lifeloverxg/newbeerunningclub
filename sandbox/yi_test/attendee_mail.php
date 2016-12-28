<?php
	$home = '../../';
	include_once ($home.'core.php');

	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @sandbox:yi_test</h1>');
	}

	$auth = Authority::get_auth_arr();
	
	$pid = Authority::get_uid();

	$title = $info_list['title'] . ' - 参与成员 - NBRC - 纽约新蜂跑团';
	
	$stylesheet = array();
	$javascript = array();
	
	$links = $_SGLOBAL['links'];

// HTML header
include $home . "template/common/header.php";
?>

<?php 
	$attendee_array = MailDAO::get_eventbrite_attendee_mail_list();
	
	$test = xmlToCsv::array2CSV($home, $attendee_array);
	var_dump($test);
?>

<?php

// HTML footer
include $home . "template/common/footer.php";
?>