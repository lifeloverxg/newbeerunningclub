<?php
	$home = '../../../';
	include_once($home.'core.php');
	include_once('util.php');
	
	if (!defined('IN_ZUS') && !defined('IN_FCBS')) {
		exit('<h1>503:Service Unavailable @spec/fcbs_14_fest/handler:signout</h1>');
	}
	
	Authority::sign_out();
	header('Location: ../');
?>