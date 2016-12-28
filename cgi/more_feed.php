<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @event:browser</h1>');
	}

	$auth = Authority::get_auth_arr();	

	$start = 0;
	if (isset($_GET['tag']) && $_GET['tag'] != ""){
		$tag_id = $_GET['tag'];
	}