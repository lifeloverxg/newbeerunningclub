<?php

	$home = '../';
	include_once ($home.'core.php');
$bm = new Timer();
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @account:findpwd.php</h1>');
	}

	$title = '找回密码 - NBRC - 纽约新蜂跑团';

	$stylesheet = array(
							"theme/zus/account.css",
						);
	$m_stylesheet = array(
							"theme/zus/mobile_css/account.css",
							);

	$javascript = array(
							"js/zus/account/password.js"
						);
	$m_javascript = array(
							//"js/zus/account/password.js",
							);
	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();

	$deviceType = Mobile_Detect::deviceType();

	//$resetcode = "test12345";

$bm->mark();
	
//	var_dump($links);
	
$bm->mark();
	include S_ROOT."template/account/findpwd/findpwd_frame.php";
$bm->mark();
echo '<!-- '.$bm->report().'-->';

