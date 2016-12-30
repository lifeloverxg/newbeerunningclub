<?php

	$home = '../';
	include_once ($home.'core.php');
	
$bm = new Timer();
	
	if(!defined('IN_NBRC'))
	{
		exit('<h1>503:Service Unavailable @event:detail</h1>');
	}

	//if(isset($_SESSION['auth']) && ($_SESSION['auth'] != "")) { } else { header("Location: $home"); }	

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

	$rundata = RunDAO::get_sorted_rank_list();

	$rundata_dis = RunDAO::get_sorted_rank_list(0, 1);

	$manage_tabs = RunDAO::get_run_nav_tab_list($auth['uid']);

	$curMorningruneid = RunDAO::get_curMorningrun_eid();
	
	include S_ROOT . "template/newrun/runcard_frame.php";

$bm->mark();
echo '<!-- '.$bm->report().'-->';
