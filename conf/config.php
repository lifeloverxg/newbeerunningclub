<?php
	if(!defined('IN_NBRC'))
	{
		exit('<h1>403:Forbidden @conf:config.php</h1>');
	}

	// Host
	$_SCONFIG['host']               = '104.131.116.209';
	
	// Version
	$_SCONFIG['version']            = 'debug22';

	if ( $_SCONFIG['version'] == 'debug' )
	{
		// MySQL Settings
		$_SCONFIG['mysql_host']         = 'localhost';
		$_SCONFIG['mysql_user']  		= 'root';
		$_SCONFIG['mysql_pass'] 		= 'Gotorun2017!';
		$_SCONFIG['mysql_charset'] 		= 'utf8';
		$_SCONFIG['mysql_database']		= 'dbzus';
		
		// Web Page Settings
		$_SCONFIG['web_charset']        = 'utf-8';
	}
	else
	{
		// MySQL Settings
		$_SCONFIG['mysql_host']         = '127.0.0.1:3306';
		$_SCONFIG['mysql_user']  		= 'runmemoryflowers';
		$_SCONFIG['mysql_pass'] 		= 'Gotorun2017!';
		$_SCONFIG['mysql_charset'] 		= 'utf8';
		$_SCONFIG['mysql_database']		= 'dbzus';

		// Web Page Settings
		$_SCONFIG['web_charset']        = 'utf-8';
	}
?>