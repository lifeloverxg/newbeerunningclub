<?php
	$home = '../../../';
	include_once($home.'core.php');
	include_once('util.php');
	
	if (!defined('IN_NBRC') && !defined('IN_FCBS')) {
		exit('<h1>503:Service Unavailable @spec/fcbs_14_fest/handler:avatar</h1>');
	}
	
	$title = '抽奖 - FCBS-2014 春节晚会 - NBRC - 纽约新蜂跑团';
	$auth = Authority::get_auth_arr();
	$event_home = '../';
	
	$stylesheet = array('spec/fcbs_14_fest/theme/enroll.css');
	$javascript = array('spec/fcbs_14_fest/js/enroll.js');

	$enroll_error = array();
	if ($auth['uid'] <= 0) {
		array_push($enroll_error, '请先登录');
		header('Location: ../');
	}

	if (isset($_POST['submit_enroll']) && $_POST['submit_enroll']) {
		if (isset($_POST['lottery_number']) && $_POST['lottery_number'] != '') {
			$pid = $auth['uid'];
			$lottery = $_POST['lottery_number'];
			if (isset($_POST['spec_desc'])) {
				$description = $_POST['spec_desc'];
			}
			else {
				$description = '';
			}
			FCBS14FestDAO::enroll($pid, $lottery, $description);
			header('Location: ../');
		}
		else {
			array_push($enroll_error, '请输入抽奖号码');
		}
	}
	
	include '../template/header.php';
	include '../template/enroll.php';
	include $home . 'template/common/footer.php';

?>