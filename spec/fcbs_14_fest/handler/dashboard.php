<?php
	$home = '../../../';
	include_once($home.'core.php');
	include_once('util.php');
	
	if (!defined('IN_NBRC') && !defined('IN_FCBS')) {
		exit('<h1>503:Service Unavailable @spec/fcbs_14_fest/handler:avatar</h1>');
	}
	
	$title = '成员 - FCBS-2014 春节晚会 - NBRC - 纽约新蜂跑团';
	$auth = Authority::get_auth_arr();
	$event_home = '../';
	
	$stylesheet = array('spec/fcbs_14_fest/theme/dashboard.css');
	$javascript = array('spec/fcbs_14_fest/js/dashboard.js');
		
	if ($auth['uid'] <= 0) {
		header('Location: ../');
	}

	$dashboard = FCBS14FestDAO::get_dashboard($auth['uid']);
	
	include '../template/header.php';
	include '../template/dashboard.php';
	include $home . 'template/common/footer.php';
	
	?>