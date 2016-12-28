<?php
	$home = '../';
	include_once ($home.'core.php');
$bm = new Timer();
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @event:browser</h1>');
	}

	$title = '浏览活动 - NBRC - 纽约新蜂跑团';

	$stylesheet = array('theme/zus/event_create.css',
						// 'theme/zus/jquery.datetimepicker.css',
						// 'theme/bootstrap/bootstrap-timepicker.min.css',
						'theme/zus/search.css',
						'theme/zus/search_css/filter.css'
						);
	
	$m_stylesheet = array(			
							);

	$javascript = array(
						'js/zus/comment.js',
						'js/zus/account/c_s_c.js',
						// 'js/zus/jquery.datetimepicker.js'
						// 'js/bootstrap/bootstrap-timepicker.js',
						);
	
	$m_javascript = array();
	
	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();

	$deviceType = Mobile_Detect::deviceType();

/*	搜索_Original
	$search = SearchDAO::event_search_func();
	$catalog_list = EventCategory::get_const_array();
*/

/*	搜索_New*/
	$search = SearchDAO::search_func();
	$catalog_list = SearchCategory::get_const_array();
	
	if (isset($_GET['catalog'])) {
		$search['catalog'] = $_GET['catalog'];
	}
	if (isset($_GET['keyword'])) {
		$search['keyword'] = $_GET['keyword'];
	}

	$search_tabs = EventSearchTabs::get_event_nav_tab_list();
	$search_event_time_tabs = EventSearchTabs::get_event_time_seach_tabs();
	
	$event_list_container = EventDAO::get_event_list_large($auth['uid']);
	$event_list_large = $event_list_container['event_list'];
	$next = $event_list_container['next'];
	$hot_event_list = EventDAO::get_hot_event_list($auth['uid']);
	$newest_event_list = EventDAO::get_newest_event_list($auth['uid']);
	
	$button_list_large = array();
$bm->mark();
	
	if (PeopleDAO::get_people_privacy_pid($auth['uid']) != Privacy::NonExist) {
		$button_list_large = array(
								   array(
										 'title' => '创建活动',
										 'class' => 'event',
										 'action' => 'create_event(' . $auth['uid'] . ')',
										 )
								   );
	}
	else
	{
		$button_list_large = array(
								   array(
										 'title' => '创建活动',
										 'class' => 'event',
										 'action' => 'show_login_panel()',
										 )
								   );
	}

	$create_event_option = EventDAO::create_event_option($auth['uid']);
	$create_catalog_list = EventCategory::get_const_array();

	$hour_array = time_Hour::get_const_array();
	$minute_array = time_Minute::get_const_array();
	$event_filter_list = EventFilter::get_create_filter_list();

	// $test = AccountDAO::define_superior_member(244);
	// var_dump($test);
$bm->mark();

	if ( ($deviceType == "phone") ) 
	{
		include S_ROOT."template/mobile/event/m_browser_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."template/event/browser_frame.php";
	}
	else 
	{
		include S_ROOT."template/event/browser_frame.php";
	}
$bm->mark();
echo '<!-- '.$bm->report().'-->';
