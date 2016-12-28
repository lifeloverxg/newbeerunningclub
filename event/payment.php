<?php

	$home = '../';
	include_once ($home.'core.php');
$bm = new Timer();
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @event:payment</h1>');
	}

	if (isset($_GET['eid']))
	{
		$eid = $_GET['eid'];
	}
	else
	{
		header('Location: browser.php');
	}

	$title = '支付 - NBRC - 纽约新蜂跑团';

	$stylesheet = array(
						'theme/zus/event_css/payment.css',
						);
	
	$m_stylesheet = array(
							'theme/zus/event_css/payment.css',		
							);

	$javascript = array(
						'js/zus/comment.js',
						'js/zus/account/mail.js',
						);
	
	$m_javascript = array();
	
	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();

	$deviceType = Mobile_Detect::deviceType();

	if ( $deviceType == "phone" )
	{
		$style = 'theme/zus/event_css/m_payment.css';
		array_push($stylesheet, $style);
	}

	$info_list = EventDAO::get_info_list($auth['uid'], $eid);

	$ticket_list = EventDAO::get_ticket_info_eid($eid);
	
	$ticket_all = $ticket_list['ticket'];
	// var_dump($ticket_list);

$bm->mark();

	if ( ($deviceType == "phone") ) 
	{
		include S_ROOT."template/event/payment/payment_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."template/event/payment/payment_frame.php";
	}
	else 
	{
		include S_ROOT."template/event/payment/payment_frame.php";
	}
$bm->mark();
echo '<!-- '.$bm->report().'-->';
