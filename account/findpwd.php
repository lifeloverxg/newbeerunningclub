<?php

	$home = '../';
	include_once ($home.'core.php');
$bm = new Timer();
	
	if(!defined('IN_ZUS')) {
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
							"js/zus/account/password.js",
							);
	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();

	$deviceType = Mobile_Detect::deviceType();

$bm->mark();
	
//	var_dump($links);
	
$bm->mark();
	if ( ($deviceType == "phone") ) 
	{
		include S_ROOT."template/mobile/account/findpwd/m_findpwd_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."template/account/findpwd/findpwd_frame.php";
	}
	else 
	{
		include S_ROOT."template/account/findpwd/findpwd_frame.php";
	}
$bm->mark();
echo '<!-- '.$bm->report().'-->';

