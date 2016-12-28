<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @group:index</h1>');
	}

	if (isset($_GET['gid'])) {
		header('Location: detail.php?gid='.$_GET['gid']);
	}
	else {
		header('Location: browser.php');
	}

?>