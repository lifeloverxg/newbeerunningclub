<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @group:index</h1>');
	}

	
	header('Location: detail.php');
?>