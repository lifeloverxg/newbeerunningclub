<?php
	$home = '../../../';
	include_once($home.'core.php');
	include_once('util.php');
	
	if (!defined('IN_ZUS') && !defined('IN_FCBS')) {
		exit('<h1>503:Service Unavailable @spec/fcbs_14_fest/handler:pudding</h1>');
	}

	$title = '错误 - FCBS-2014 春节晚会';
	$auth = Authority::get_auth_arr();
	$event_home = '../';
	
	$stylesheet = array('spec/fcbs_14_fest/theme/pudding.css');
	$javascript = array();

	$image = DefaultImage::ErrPg;
	include '../template/header.php';
	include '../template/pudding.php';
	include $home . 'template/common/footer.php';
?>