<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @account:password management</h1>');
	}

	$title = '修改密码 - NBRC - 纽约新蜂跑团';

	$stylesheet = array(
						"theme/zus/account.css"
						);

	$javascript = array(
						);
	$links = $_SGLOBAL['links'];
	$auth = Authority::get_auth_arr();

	$error_messages = array();
	if (isset($_POST["modify_pwd"])) {
		if (isset($_POST["modified_pwd"]) && $_POST["modified_pwd"] != "") {
			if (strlen(trim($_POST["modified_pwd"])) < 8) {
				array_push($error_messages, "新密码不能少于8位");
			}
			else if (isset($_POST["modified_pwd2"])) {
				if (trim($_POST["modified_pwd"]) != trim($_POST["modified_pwd2"]))
					array_push($error_messages, "确认密码匹配失败");
			}
			else 
				array_push($error_messages, "请再次确认密码");
		}
		else {
			array_push($error_messages, "请输入新密码");
		}
		
		if (empty($error_messages)) {
			if (AccountDAO::check_pwd($auth["uid"], trim($_POST["old_pwd"]))) {
				AccountDAO::modify_pwd($auth["uid"], trim($_POST["modified_pwd"]));
				header('Location: ' . $home . 'account');
			}
			else {
				array_push($error_messages, "原密码错误");
			}
		}
		
	}

	include S_ROOT."template/account/pwd_frame.php";
?>
