<?php
	$home = '../../../';
	include_once($home.'core.php');
	include_once('util.php');
	
	if (!defined('IN_ZUS') && !defined('IN_FCBS')) {
		exit('<h1>503:Service Unavailable @spec/nyc_only_you/handler:signout</h1>');
	}
	
	Authority::sign_out();
	header('Location: ../');
?>