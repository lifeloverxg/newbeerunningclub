<?php
	$home = '../';
	include_once($home.'core.php');

$bm = new Timer();
	
	if (!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @about:index</h1>');
	}
	
	// $title = '关于 - NBRC - 纽约新蜂跑团';
	// $auth = Authority::get_auth_arr();
	// $links = $_SGLOBAL['links'];

	// $stylesheet = array('theme/zus/inprogress.css');
	// $javascript = array();
	
	// $image = DefaultImage::ErrPg;
	// include $home.'template/common/header.php';
	// include $home.'template/about/about.php';
	// include $home.'template/common/footer.php';

	Unicorn::show($home, '您所访问的页面正在建设中');
?>