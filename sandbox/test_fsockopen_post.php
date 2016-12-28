<?php
	ignore_user_abort(TRUE); //如果客户端断开连接，不会引起脚本abort.
	set_time_limit(0);//取消脚本执行延时上限
	$home = '../';
	include_once ($home.'core.php');

	$auth = Authority::get_auth_arr();
	$links = $_SGLOBAL['links'];
$bm = new Timer();
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @event:ipn</h1>');
	}

	$pid = $_GET['pid'];

	$eid = $_GET['eid'];

	$title = '浏览活动 - NBRC - 纽约新蜂跑团';

	$to_self = "lifeloverxg@gmail.com";
	$subject_self = "testsubject";
	$body_self = "testbody";

	$req = "hello world";

	// foreach ($_POST as $key => $value)
	// { 
	// 	$value = urlencode(stripslashes($value)); 
	// 	$req .= "111"; 
	// }
	$subject_self = $_POST['test_1'];
	$body_self = $pid . $eid;

		// MailDAO::sendmail_event_paypalsale($to, $subject, $body);
	MailDAO::sendmail_event_paypalsale($to_self, $subject_self, $body_self);
$bm->mark();
echo '<!-- '.$bm->report().'-->';
?>