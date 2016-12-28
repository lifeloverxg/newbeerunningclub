<?php
	$home = '../';
	include_once($home.'core.php');
	
	if (!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @faq:index</h1>');
	}
	
	$title = '求助 - NBRC - 纽约新蜂跑团';
	$auth = Authority::get_auth_arr();
	$links = $_SGLOBAL['links'];

	$stylesheet = array('theme/zus/inprogress.css');
	$javascript = array();
	
	$image = DefaultImage::ErrPg;
	include $home.'template/common/header.php';
	include $home.'template/common/inprogress.php';
	include $home.'template/common/footer.php';
?>