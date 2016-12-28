<?php
	$home = '../../../';
	include_once($home.'core.php');
	include_once('util.php');
	
	if (!defined('IN_ZUS') && !defined('IN_FCBS')) {
		exit('<h1>503:Service Unavailable @spec/fcbs_14_fest/handler:signup</h1>');
	}

	$title = '注册 - FCBS-2014 春节晚会';
	$auth = Authority::get_auth_arr();
	$event_home = '../';
	
	$stylesheet = array('spec/fcbs_14_fest/theme/signup.css');
	$javascript = array('spec/fcbs_14_fest/js/signup.js');

	$side = 1;
	$signin_error = array();
	$signup_error = array();

	if (isset($_POST['signup'])) {
		$side = 1;
		array_push($signup_error, '活动已结束');
	}
	
	if (isset($_POST['signin'])) {
		$side = 1;
		if (isset($_POST['signin_username']) && $_POST['signin_username'] != '') {
			
		}
		else {
			array_push($signin_error, '邮箱不能为空');
		}
		
		if (isset($_POST['signin_pass']) && $_POST['signin_pass'] != '') {
			
		}
		else {
			array_push($signin_error, '密码不能为空');
		}
		
		if (empty($signin_error)) {
			if (Authority::sign_in($_POST['signin_username'], $_POST['signin_pass']) == 0){
				header('Location: ../');
			}
			else {
				array_push($signin_error, '邮箱/密码错误');
			}
		}		
	}
	
	include '../template/header.php';
	include '../template/signup.php';
	include $home . 'template/common/footer.php';
	?>
