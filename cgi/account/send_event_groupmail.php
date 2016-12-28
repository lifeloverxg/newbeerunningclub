<?php
	
	$home = '../../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @cgi>account:send_event_groupmail.php</h1>');
	}
	
	//initialize data
	$error = "none";

	$args = array(
				  'mailto' => '',
				  'subject' => '',
				  'content' => '',
				  'list_length' => '',
				  'count' => '',
				  'list' => '',
				  'param' => false,
				  );

	$email_result = '';
	$url = '';

	//Process data
	foreach ($args as $key => $val)
	{
		if ((isset($_POST[$key])) && ($_POST[$key] != "")) 
		{
			$args[$key] = $_POST[$key];
		}
	}
	
	//Access database, determine whether the email exists or not
	if ($error == "none") 
	{
		$subject = args['subject'].' - NBRC - 纽约新蜂跑团';
		$count = ++$args['count'];
		$rest = $args['list_length'] - $count;

		$email_result = MailDAO::sendmail_event_groupmail_version1($args['mailto'], $subject, $args['content']);
		
		if ($email_result == "yi")
		{
			$args['list'] = "成功发送第".$count."封邮件, 还剩".$rest."封, 一共".$args['list_length']."封";
			$args['param'] = true;
		}
		else
		{
			$args['list'] = "该邮箱可能不存在, 发送邮件失败";
		}
	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo "\n}";
?>

