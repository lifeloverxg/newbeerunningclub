<?php

	$home = '../../';
	include_once ($home.'core.php');
$bm = new Timer();
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @event:browser</h1>');
	}

	$title = '支付 - NBRC - 纽约新蜂跑团';

	$stylesheet = array(
						'theme/zus/event_css/payment.css',
						);
	
	$m_stylesheet = array(
							'theme/zus/event_css/payment.css',		
							);

	$javascript = array('js/zus/comment.js',
						);
	
	$m_javascript = array();
	
	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();

	$deviceType = Mobile_Detect::deviceType();

	$ticket_all = array(
						array(
								'type'		=>		'early bird',
								// 'end'		=>		'Juy 12 2014',
								'price'		=>		'12.99',
								// 'tax'		=>		'2.99',
								'quantity'	=>		'10',
								),
						array(
								'type'		=>		'regular ticket',
								// 'end'		=>		'Juy 12 2014',
								'price'		=>		'14.99',
								// 'tax'		=>		'3.99',
								'quantity'	=>		'10',
								),
						array(
								'type'		=>		'premium ticket',
								// 'end'		=>		'Juy 12 2014',
								'price'		=>		'19.99',
								// 'tax'		=>		'6.99',
								'quantity'	=>		'10',
								),
						array(
								'type'		=>		'final ticket',
								// 'end'		=>		'Juy 12 2014',
								'price'		=>		'29.99',
								// 'tax'		=>		'9.99',
								'quantity'	=>		'10',
								),
						);

	// var_dump($ticket_all);
	// var_dump(sizeof($ticket_all));

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
