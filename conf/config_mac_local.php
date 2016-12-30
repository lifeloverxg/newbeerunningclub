<?php
	if(!defined('IN_NBRC')) {
		exit('<h1>403:Forbidden @conf:config_mac_local.php</h1>');
	}

	// Host
	$_SCONFIG['host']               = '104.131.116.209';
	
	// Version
	$_SCONFIG['version']            = 'debug';

	// MySQL Settings
	$_SCONFIG['mysql_host']         = '127.0.0.1';
	$_SCONFIG['mysql_user']  		= 'root';
	$_SCONFIG['mysql_pass'] 		= 'Gotorun2017!';
	// $_SCONFIG['mysql_pass'] 		= 'mysql';
	$_SCONFIG['mysql_charset'] 		= 'utf8';
	$_SCONFIG['mysql_database']		= 'newbee';
	
	// Web Page Settings
	$_SCONFIG['web_charset']        = 'utf-8';
?>