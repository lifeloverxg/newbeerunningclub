<?php

	$home = '../';
	include_once ($home.'core.php');
	
$bm = new Timer();
	
	if(!defined('IN_ZUS')) 
	{
		exit('<h1>503:Service Unavailable @event:confirmation</h1>');
	}

	if (isset($_GET['eid'])) 
	{
		$eid = $_GET['eid'];
	}
	else 
	{
		header('Location: browser.php');
	}

	$auth = Authority::get_auth_arr();
	$deviceType = Mobile_Detect::deviceType();

	setcookie("eventbrite", $auth['uid']);

	$info_list = EventDAO::get_info_list($auth['uid'], $eid);
//	var_dump($info_list);
	$title = $info_list["title"].' － 支付页面 - NBRC - 纽约新蜂跑团';
	$stylesheet = array(
						'theme/zus/event_css/eventbrite.css',
						);
	$m_stylesheet = array(
							'theme/zus/event_css/eventbrite.css',
							);

	$javascript = array(
						);

	$m_javascript = array(
							);

	$links = $_SGLOBAL['links'];

	$back = 'detail.php?eid='.$eid;

	if ( ($deviceType == "phone") ) 
	{
		include $home.'template/event/m_eventbrite.php';
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include $home.'template/event/eventbrite.php';
	}
	else 
	{
		include $home.'template/event/eventbrite.php';
	}

$bm->mark();


echo '<!-- '.$bm->report().'-->';
