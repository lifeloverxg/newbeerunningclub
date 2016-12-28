<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @account:index</h1>');
	}

	$title = '账户管理 - NBRC - 纽约新蜂跑团';

	$stylesheet = array(
						"theme/zus/account.css"
						);

	$javascript = array(
						);
	$links = $_SGLOBAL['links'];
	$auth = Authority::get_auth_arr();

	if ( isset($_GET['findpwd']) )
	{
		header("location: findpwd.php");
	}

	if ( isset($_GET['code'] ) )
	{
		header("location: resetpwd.php?code=".$_GET['code']);
	}

	// $title = "发送邮件 - NBRC - 纽约新蜂跑团";
 //    $to = "lifeloverxg@gmail.com";
 //    $subject = "test for email Junxiao";
 //    $content = "testtesttest";
 //    sendmail($to,$subject,$content);

	include S_ROOT."template/account/account_frame.php";
?>
