<?php

	$home = '../';
	include_once ($home.'core.php');
	
$bm = new Timer();
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @event:confirmation</h1>');
	}

	if (isset($_GET['eid'])) {
		$eid = $_GET['eid'];
	}
	else {
		header('Location: browser.php');
	}

	if (isset($_GET['oid'])) 
	{	
		$oid = $_GET['oid'];
	}
	else {
		header('Location: browser.php');
	}

	$auth = Authority::get_auth_arr();
	$deviceType = Mobile_Detect::deviceType();

	$attendee_email = '###';
	$eventpid = 0;
	$eventpid = $auth['uid'];

	if ( $eventpid == 0 )
	{
		$attendee_uid = EventDAO::get_attendee_uid_oid($oid);
		if ( $attendee_uid != 0 )
		{
			$eventpid = $attendee_uid;
		}
		else
		{
			if ( isset($_COOKIE['eventbrite']) && ($_COOKIE['eventbrite'] > 0) )
			{
				$eventpid = $_COOKIE['eventbrite'];			
			}
			else
			{
				$eventpid = (1000 + $oid);
			}
		}
	}

	$info_list = EventDAO::get_info_list($auth['uid'], $eid);
//	var_dump($info_list);
	$title = $info_list["title"].' - 付款成功 - 活动页面 - NBRC - 纽约新蜂跑团';
	$stylesheet = array(
						);
	$m_stylesheet = array(
						);
	$javascript = array(	
						);
	$m_javascript = array(
							);
	$links = $_SGLOBAL['links'];

	$back = 'detail.php?eid='.$eid;

	// $test = EventDAO::eventbrite_Sign_in('lifeloverxg@gmail.com');
	// var_dump($test);

	EventDAO::join_event($eventpid, $eid);
	EventDAO::set_event_sale_eid_oid($eventpid, $eid, $oid);

	if ( $_SCONFIG['version'] == 'debug' || ($deviceType == "phone") ) 
	{
		include $home.'template/event/confirmation_page/m_confirmation_frame.php';
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include $home.'template/event/confirmation_page/confirmation_frame.php';
	}
	else 
	{
		include $home.'template/event/confirmation_page/confirmation_frame.php';
	}

$bm->mark();


echo '<!-- '.$bm->report().'-->';
