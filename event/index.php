<?php
	$home = '../';

	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @event:index</h1>');
	}

	$auth = Authority::get_auth_arr();

	//echo "Hello World!";

	if ( isset($_GET['eid']) ) 
	{		
		if ( isset($_GET['eventid']) )
		{
			if ( isset($_GET['oid']) )
			{
				header('Location: confirmation.php?eid='.$_GET['eid'].'&oid='.$_GET['oid']);
			}
		}
		else
		{
			header('Location: detail.php?eid='.$_GET['eid']);
		}		
	}
	else 
	{
		header('Location: browser.php');
	}

?>