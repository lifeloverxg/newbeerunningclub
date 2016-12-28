<?php
$home = '../../';
	include_once ($home.'core.php');
	
$bm = new Timer();
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @information:browser</h1>');
	}

include ($home.'template/information_new/new/browser.php'); 
?>