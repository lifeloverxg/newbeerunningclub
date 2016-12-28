<?php
	$home = '../../';
	include_once ($home.'core.php');
$bm = new Timer();
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @event:browser</h1>');
	}

	$title = '浏览活动 - NBRC - 纽约新蜂跑团';

	$stylesheet = array(
						'spec/uni_film/css/common.css',
						);
	
	$m_stylesheet = array(
							'spec/uni_film/css/m_common.css',			
							);

	$javascript = array('js/zus/comment.js',
						'js/zus/jquery.datetimepicker.js'
						);
	
	$m_javascript = array();
	
	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();

	$username = '';
	
	if ( $auth['uid'] > 0 )
	{
		$username = $auth['title'];
	}

	$deviceType = Mobile_Detect::deviceType();

	if ( ($deviceType == "phone") ) 
	{
		include S_ROOT."spec/uni_film/mobile/m_browser_frame.php";
		// include S_ROOT."spec/uni_film/browser_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."spec/uni_film/browser_frame.php";
	}
	else 
	{
		include S_ROOT."spec/uni_film/browser_frame.php";
	}
$bm->mark();
echo '<!-- '.$bm->report().'-->';