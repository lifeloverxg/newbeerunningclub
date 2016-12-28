<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @logout:index</h1>');
	}

	if (isset($_SESSION['auth'])) 
	{
		Authority::sign_out();
		setcookie("username", "");
		setcookie("password", "");
		// var_dump($_COOKIE);
		//header('Location: ' . $home);
		
		/*+++++回到点退出登陆的页面+++++*/
		$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if (isset($_SERVER['HTTP_REFERER'])) {
			$url = htmlspecialchars($_SERVER['HTTP_REFERER']);
		}
		
		header('location:'.$url);
		/*=====回到点退出登陆的页面=====*/
	}
	// setcookie('username', '', time()-3600);
	// 	setcookie("password", '');

	// 	//setcookie('hello', 'helloworld', time()+3600);
	// 	//var_dump($_COOKIE);
	// 	setcookie('hello', '', time()-3600);
	// 	var_dump($_COOKIE);
?>