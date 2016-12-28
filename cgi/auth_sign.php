<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_NBRC')) 
		exit('<h1>503:Service Unavailable @cgi:function_sign</h1>');

	//initialize data
	$error = "none";
	$args = array(
				  'type'		=> '',
				  'username'	=> '',
				  'pass'		=> '',
				  'rempwd'		=> '',
				  'email'		=> '',
				  'invitecode'	=> '',
				  'test'		=> '',
				  'home'		=> $home
				  );
	$error_messages = array();
	//Process data
	foreach ( $args as $key => $val )
	{
		if ( (isset($_POST[$key])) && ($_POST[$key] != "") )
		{
			$args[$key] = $_POST[$key];
		}		
	}
		

	// Sign in
	if ( isset($args["type"]) && $args["type"] === "signin" ) 
	{
		if ( !isset($args["username"]) || $args["username"] == "" )
		{
			array_push($error_messages, "用户名不能为空");
		}
			
		if ( !isset($args["pass"]) || $args["pass"] == "" )
		{
			array_push($error_messages, "密码不能为空");
		}
			
		if ( empty($error_messages) )
		{
			$signin_result = Authority::sign_in($args["username"], $args["pass"]);
			
			if ( $signin_result != 0 )
			{
				array_push($error_messages, "用户名/密码错误");
			}
			else
			{
				/*+++++记住密码, 存Cookie+++++*/
				if ( $args['rempwd'] == 1 )
				{
					// setcookie("username", $args["username"], time()+3600*24*365);
					// setcookie("password", $args["pass"], time()+3600*24*365);
					setcookie("username", $args["username"]);
					setcookie("password", $args["pass"]);
					$args['test'] = 'Hello World!';
				}
				/*=====记住密码, 存Cookie=====*/
			}
		}			
	}
	// Sign up
	else if ( isset($args["type"]) && $args["type"] === "signup" ) 
	{
		if ( isset($args["email"]) && $args["email"] != "" ) 
		{
			$str = $args["email"];
			if ( Authority::isEmail($str) ) 
			{
				if ( Authority::exist_email($str) )
				{
					array_push($error_messages, "邮箱已被使用");
				}		
			}
			else
			{
				array_push($error_messages, "邮箱格式无效");
			}			
		}
		else
		{
			array_push($error_messages, "邮箱不能为空");
		}	

		if ( isset($args["pass"]) && $args["pass"] != "" ) 
		{
			$str = $args["pass"];
			if ( strlen($str) < 8 )
			{
				array_push($error_messages, "密码至少为8位");
			}	
		}
		else
		{
			array_push($error_messages, "密码不能为空");
		}
			
		if ( isset($args["username"]) && $args["username"] != "" )
		{
			$str = $args["username"];
			if ( preg_match("/^[a-zA-Z0-9\x7f-\xff_-]{3,16}$/", $str) > 0 )
			{
				if ( Authority::exist_user($str) )
				{
					array_push($error_messages, "用户名已被使用");
				}			
			}
			else
			{
				array_push($error_messages, "用户名长度为3-16位，只能包含中文、字母、数字和下划线");
			}
		}
		else
		{
			array_push($error_messages, "用户名不能为空");
		}

		// if (isset($args["invitecode"]) && $args["invitecode"] != "") {
		// 	if (Authority::consume_code($args["invitecode"]) == false)
		// 		array_push($error_messages, "邀请码无效");
		// }
		// else
		// 	array_push($error_messages, "邀请码不能为空");

		if ( empty($error_messages) ) 
		{
			$result = Authority::sign_up($args["email"], $args["pass"], 'infinity', $args["username"]);
			switch ($result) 
			{
				case 0:
					break;
				case 1:
					array_push($error_messages, "邮箱已被使用");
					break;
				case 2:
					array_push($error_messages, "用户名已被使用");
					break;
				// case 3:
				// 	array_push($error_messages, "邀请码无效");
				// 	break;
				default:
					array_push($error_messages, "对不起，有错误发生");
			}
		}
	}

	if ( !empty($error_messages) )
	{
		$error = "error";
	}

	//Return json string as result
	echo "{\n";
	echo "'error': '$error'";
	echo ",\n'args': ";
	echo json_encode($args);
	echo ",\n'error_messages': ";
	echo json_encode($error_messages);
	echo "\n}";
?>
