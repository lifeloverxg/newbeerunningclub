<?php
	
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:resetpwd.php</h1>');
	}
	
	//initialize data
	$error = "none";

	$args = array(
				  'email' => '',
				  'password' => '',
				  'pass' => '',
				  'list' => ''
				  );

	//Process data
	foreach ($args as $key => $val)
	{
		if ((isset($_POST[$key])) && ($_POST[$key] != "")) 
		{
			$args[$key] = $_POST[$key];
		}
	}
	
	//Access database
	if ($error == "none") 
	{
		$reset = AccountDAO::ResetPwd($args['email'], $args['password']);
		if ( $reset )
		{
			$args['list'] = '恭喜您，成功修改了您的密码';
		}
	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo "\n}";
?>

