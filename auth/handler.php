<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @auth:handler</h1>');
	}
	
	if ($_POST['signin_submit']) {
		$email = $_POST['signin_email'];
		$pass  = $_POST['signin_password'];
		
		$error = Authority::sign_in($email, $pass);
		
		switch ($error) {
			case 0:
				header('Location: '.$home);
				break;
			case -1:
				header('Location: .');
				break;
			default:
				header('Location: '.$home);
		}
		return 0;
	}
	
	if ($_POST['signup_submit']) {
		$email = $_POST['signup_email'];
		$pass  = $_POST['signup_password'];
		$code  = $_POST['signup_code'];

		$error = Authority::sign_up($email, $pass, $code);

		switch ($error) {
			case 0:
				header('Location: '.$home);
				break;
			case -1:
				header('Location: .');
				break;
			case -2:
				header('Location: .');
				break;
			case -3:
				header('Location: .');
				break;
			default:
				header('Location: '.$home);
		}
		return 0;
	}
	
	if ($_POST['signout_submit']) {
		Authority::sign_out();		
		header('Location: '.$home);
		return 0;
	}
	
	Authority::sign_out();		
	header('Location: '.$home);
?>