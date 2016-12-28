<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @login:login</h1>');
	}
	
	if (isset($_GET["m"]) && $_GET["m"] == "signup") {
		header('Location: auth.php?m=signup');
	}
	if (isset($_GET["m"]) && $_GET["m"] == "signin") {
		header('Location: auth.php?m=signin');
	}
	
	header('Location: auth.php');
?>