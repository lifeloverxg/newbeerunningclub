<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @event:member_list</h1>');
	}
	
	if (isset($_GET['eid'])) {
		$eid = $_GET['eid'];
	}
	else {
		header('Location: browser.php');
	}
	
	$auth = Authority::get_auth_arr();

	$deviceType = Mobile_Detect::deviceType();

	$member_list = EventDAO::get_event_member_list_all($auth['uid'], $eid);

	$title = $member_list['title'] . ' - 活动成员 - NBRC - 纽约新蜂跑团';
	
	$stylesheet = array(
						'theme/zus/people_css/friend_list_large.css',
						);
	$m_stylesheet = array(
							'theme/zus/mobile_css/member_list.css',
							);
	$javascript = array(
						);
	$m_javascript = array(
							);
	$links = $_SGLOBAL['links'];

	if ( ($deviceType == "phone") ) 
	{
		include S_ROOT."template/mobile/shared/list/member_list/m_member_list_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."template/common/new_member_list/member_list_frame.php";
	}
	else 
	{
		include S_ROOT."template/common/new_member_list/member_list_frame.php";
	}
?>