<?php

	$home = '../';
	include_once ($home.'core.php');
$bm = new Timer();
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @account:resetpwd.php</h1>');
	}

	$title = '找回密码 - NBRC - 纽约新蜂跑团';

	$stylesheet = array(
						"theme/zus/account.css"
						);

	$javascript = array(
						"js/zus/account/password.js"
						);
	
	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();

	if ( isset($_GET['code']) && !empty($_GET['code']) )
	{
		$resetcode = $_GET['code'];
	}	

	$user_info = base64_decode($resetcode);

	$user_info_array = explode("|", $user_info);

	$user_email = $user_info_array[2];
$bm->mark();
	
//	var_dump($links);
	
$bm->mark();

	include S_ROOT."template/account/findpwd/findpwd_frame.php";
$bm->mark();
echo '<!-- '.$bm->report().'-->';
