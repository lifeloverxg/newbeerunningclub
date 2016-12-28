<?php

	$home = '../';
	include_once ($home.'core.php');
	
$bm = new Timer();
	
	if(!defined('IN_NBRC'))
	{
		exit('<h1>503:Service Unavailable @event:detail</h1>');
	}

	//if(isset($_SESSION['auth']) && ($_SESSION['auth'] != "")) { } else { header("Location: $home"); }	

	if ( isset($_GET['ipn_pid']) && isset($_GET['ipn_finish']) )
	{
		$ipn_finish	=	$_GET['ipn_finish'];
		$ipn_pid	=	$_GET['ipn_pid'];
		EventDAO::join_event($ipn_pid, $eid);
	}

	$auth = Authority::get_auth_arr();

	$deviceType = Mobile_Detect::deviceType();

	$stylesheet = array(
						// 'theme/zus/event_css/payment.css',
						'theme/zus/album_photo.css',
						'theme/zus/event_create_new.css',
						// 'theme/zus/jquery.datetimepicker.css',
						// 'theme/bootstrap/bootstrap-timepicker.min.css',
						'theme/zus/search.css',
						'theme/zus/search_css/filter.css',
						);
	
	$m_stylesheet = array(			
							);

	$javascript = array(
						'js/zus/comment.js',
						'js/zus/account/c_s_c.js',
						'js/zus/account/DateFormat.js',
						// 'js/zus/jquery.datetimepicker.js'
						// 'js/bootstrap/bootstrap-timepicker.js',
						);
	
	$m_javascript = array();
	
	$links = $_SGLOBAL['links'];

	$create_event_option = EventDAO::create_event_option($auth['uid']);
	$create_catalog_list = EventCategory::get_const_array();

	$hour_array = time_Hour::get_const_array();
	$minute_array = time_Minute::get_const_array();
	$event_filter_list = EventFilter::get_create_filter_list();	
	
	include S_ROOT . "template/newrun/run_frame.php";

$bm->mark();
echo '<!-- '.$bm->report().'-->';
