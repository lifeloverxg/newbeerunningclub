<?php
	$home = '../../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @cgi:findpwd.php</h1>');
	}
	
	//initialize data
	$error = "none";

	$args = array(
				  'email' => '',
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
		$url = MailDAO::get_mail_url($args['email']);

//		var_dump($url);

		if ( $url == "" )
		{
			$args['list'] = "大圣，请您不要戏弄小神<br>您输入的邮箱:<br>".$args['email']."<br>根本没有在小神的土地上注册过";
		}
		else
		{
			$subject = "找回密码 - NBRC - 纽约新蜂跑团";
			$email_result = MailDAO::sendmail($args['email'], $subject, $url);
			
			if ($email_result == "yi")
			{
				$args['list'] = "您的修改密码链接已经发到您的邮箱<br>请登录您的邮箱进行重置密码";
				$args['param'] = true;
			}
			else
			{
				$args['list'] = "发送邮件失败";
			}
		}

	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo "\n}";
?>

