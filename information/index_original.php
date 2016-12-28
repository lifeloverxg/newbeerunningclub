<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @information:index</h1>');
	}

	if (isset($_GET['arid'])) {
		header('Location: detail.php?arid='.$_GET['arid']);
	}
	else {
		header('Location: browser.php');
	}

?>