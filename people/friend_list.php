<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @people:friend list</h1>');
	}

	$auth = Authority::get_auth_arr();
	
	$pid = Authority::get_uid();
	$tpid = $pid;
	$info_list = PeopleDAO::get_info_list($auth['uid'], $tpid);

	$title = $info_list['title'] . ' - 好友列表 - NBRC - 纽约新蜂跑团';
	
	$stylesheet = array('theme/zus/common.css',
						'theme/zus/people_css/friend_list_large.css'
						);
	$javascript = array('js/zus/common.js'
						);
	$links = $_SGLOBAL['links'];

	$test = MailDAO::update_mail_list_for_login();
	//var_dump($test);
	// foreach ($test as )
	//var_dump($test);
	//var_export($friend_list);
// HTML header
include $home . "template/common/header.php";

// Friend List Content
include $home . "cgi/friend_list.php";

// HTML footer
include $home . "template/common/footer.php";
?>