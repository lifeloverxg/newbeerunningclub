<?php

	if (isset($_POST["signin"])) {
		$side = 1;
		if (isset($_POST["signin_username"]) && $_POST["signin_username"] != "") {
			
		}
		else {
			array_push($signin_error, "用户名不能为空");
		}
		
		if (isset($_POST["signin_pass"]) && $_POST["signin_pass"] != "") {
			
		}
		else {
			array_push($signin_error, "密码不能为空");
		}
		
		if (empty($signin_error)) {
			if (Authority::sign_in($_POST["signin_username"], $_POST["signin_pass"]) == 0){
				header('Location: ' . $home);
			}
			else {
				array_push($signin_error, "用户名/密码错误");
			}
		}
		
	}
	else if (isset($_POST["signup"])) {
		$side = 0;
		if (isset($_POST["signup_email"]) && $_POST["signup_email"] != "") {
			$str = $_POST["signup_email"];
			if (preg_match("/^[a-z][a-z0-9]*(\.[a-z0-9]+)*@[a-z0-9]+(\.[a-z0-9]+)*\.[a-z]+$/i", $str) > 0) {
				if (Authority::exist_email($str)) {
					array_push($signup_error, "邮箱已被使用");
				}
			}
			else {
				array_push($signup_error, "邮箱格式无效");
			}
		}
		else {
			array_push($signup_error, "邮箱不能为空");
		}
		
		if (isset($_POST["signup_pass"]) && $_POST["signup_pass"] != "") {
			$str = $_POST["signup_pass"];
			if (strlen($str) >= 8) {
				if (isset($_POST["signup_pass2"]) && $_POST["signup_pass2"] != "") {
					$str2 = $_POST["signup_pass2"];
					if ($str2 != $str) {
						array_push($signup_error, "两次输入的密码不一致");
					}
				}
				else {
					array_push($signup_error, "请输入两次密码");
				}
			}
			else {
				array_push($signup_error, "密码至少为8位");
			}
		}
		else {
			array_push($signup_error, "密码不能为空");
		}
		
		if (isset($_POST["signup_username"]) && $_POST["signup_username"] != "") {
			$str = $_POST["signup_username"];
			if (preg_match("/^[a-zA-Z0-9\x7f-\xff_-]{3,16}$/", $str) > 0) {
				if (Authority::exist_user($str)) {
					array_push($signup_error, "用户名已被使用");
				}
			}
			else {
				array_push($signup_error, "用户名只能包含字母、数字和下划线");
			}
		}
		else {
			array_push($signup_error, "用户名不能为空");
		}
		
		if (isset($_POST["signup_invitecode"]) && $_POST["signup_invitecode"] != "") {
			if (Authority::consume_code($_POST["signup_invitecode"]) == false) {
				array_push($signup_error, "邀请码无效");
			}
		}
		else {
			array_push($signup_error, "邀请码不能为空");
		}
		
		if (empty($signup_error)) {
			$result = Authority::sign_up($_POST["signup_email"], $_POST["signup_pass"], $_POST["signup_invitecode"], $_POST["signup_username"]);
			switch ($result) {
				case 0:
					header('Location: '.$home);
					break;
				case 1:
					array_push($signup_error, "邮箱已被使用");
					break;
				case 2:
					array_push($signup_error, "用户名已被使用");
					break;
				case 3:
					array_push($signup_error, "邀请码无效");
					break;
				default:
					
			}
		}
		
	}
	