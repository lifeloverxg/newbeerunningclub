<?php
	$home = '../../../';
	include_once($home.'core.php');
	include_once('util.php');
	
	if (!defined('IN_ZUS') && !defined('IN_FCBS')) {
		exit('<h1>503:Service Unavailable @spec/fcbs_14_fest/handler:avatar</h1>');
	}
	
	$title = '头像 - FCBS-2014 春节晚会 - NBRC - 纽约新蜂跑团';
	$auth = Authority::get_auth_arr();
	$event_home = '../';

	$stylesheet = array('spec/fcbs_14_fest/theme/avatar.css');
	$javascript = array('spec/fcbs_14_fest/js/avatar.js');
	
	$upload_error = array();

	if ($auth['uid'] <= 0) {
		array_push($upload_error, '请先登录');
		header('Location: ../');
	}
	
	if (isset($_FILES['upload_image']) && !empty($_FILES['upload_image'])) {
		if ($_FILES['upload_image']['error']) {
			array_push($upload_error, '上传失败 代码：'.$_FILES['upload_image']['error']);
		}
		else {
			if ($_FILES['upload_image']['type'] != 'image/jpeg') {
				array_push($upload_error, '仅接受jpg/jpeg格式文件');
			}
			if ($_FILES['upload_image']['size'] > 2*1024*1024) {
				array_push($upload_error, '上传文件大于2MB');
			}
			$src = $_FILES['upload_image']['tmp_name'];
			$preview_file = ImageDAO::generate_preview_image($home, $src);
			$size = getimagesize($home.$preview_file);
			$wid = $size[0];
		}
	}
	
	if (isset($_POST['done_clip']) && $_POST['done_clip']) {
		if (!empty($_POST['preview_file'])) {
			$preview_file = $_POST['preview_file'];
			$x = 0;
			$y = 0;
			$r = 500;
			if (isset($_POST['x'])) {
				$x = $_POST['x'];
			}
			if (isset($_POST['y'])) {
				$y = $_POST['y'];
			}
			if (isset($_POST['r'])) {
				$r = $_POST['r'];
			}
			$avatar = ImageDAO::clip_save_image($home, Authority::get_uid(), $preview_file, $x, $y, $r);
			PeopleDAO::set_people_avatar_pid($auth['uid'], $avatar);
			Authority::refresh_session();
			header('Location: ../');
		}
	}
	
	if (isset($_POST['skip_avatar']) && $_POST['skip_avatar']) {
		header('Location: ../');
	}
	include '../template/header.php';
	include '../template/avatar.php';
	include $home . 'template/common/footer.php';
?>

