<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @event:manage_event_member</h1>');
	}

	$auth = Authority::get_auth_arr();
	
	$pid = Authority::get_uid();
	$eid = -1;
	if (isset($_GET['eid'])) {
		$eid = $_GET['eid'];
	}

	$info_list = EventDAO::get_info_list($auth['uid'], $eid);

	$title = $info_list['title'] . ' - 成员管理 - NBRC - 纽约新蜂跑团';
	
	$stylesheet = array(
						'theme/zus/event_css/event_manage.css',
						'theme/zus/event_css/groupmail.css'
						);

	$javascript = array(
						'js/zus/account/mail.js',
						'js/zus/comment.js',
						);

	$links = $_SGLOBAL['links'];

//	$mail_list = MailDAO::get_mail_list_eid($eid);

	$mail_list_string = MailDAO::get_mail_list_string_eid($eid);

//	$helloJson = json_encode($mail_list);
//	var_dump($mail_list);

	include $home . "template/event/manage_member/member_manage_frame.php";
// // HTML header
// include $home . "template/common/header.php";

// // Friend List Content
// include $home . "cgi/group_manage_member.php";

// // HTML footer
// include $home . "template/common/footer.php";
?>