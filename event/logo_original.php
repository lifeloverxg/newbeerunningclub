<?php
	$home = '../';
	include_once($home.'core.php');
	
	if ( !defined('IN_ZUS') )
	{
		exit('<h1>503:Service Unavailable @event:logo</h1>');
	}
	
	$title = '修改图标 - NBRC - 纽约新蜂跑团';
	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();
	$deviceType = Mobile_Detect::deviceType();
	
	$stylesheet = array('theme/zus/logo.css');
	$m_stylesheet = array();
	$javascript = array();
	$m_javascript = array();
	
	$upload_error = array();
	
	if (isset($_GET['id']) && $_GET['id'] > 0)
	{
		$id = $_GET['id'];
	}
	if (isset($_POST['id']) && $_POST['id'] > 0)
	{
		$id = $_POST['id'];
	}
	
	if ($auth['uid'] <= 0)
	{
		array_push($upload_error, '请先登录');
		header('Location: '.$home);
	}
	
	if (empty($id))
	{
		Unicorn::show($home, '@event>logo.php: Undefine $id');
	}
	else
	{
		$logo_obj = EventDAO::get_event_logo($auth['uid'], $id);
		$preview_file = $logo_obj['image'];
	}
	if ( !empty($_POST['preview_file']) )
	{
		$preview_file = $_POST['preview_file'];
	}
	
	if (PeopleDAO::get_event_role_pid($auth['uid'], $id) < Role::Admin)
	{
		array_push($upload_error, '权限不足');
		$show_op = false;
	}
	else
	{
		if ( file_exists ($home.$preview_file) )
		{
			$size = getimagesize($home.$preview_file);
			$wid = $size[0];
			$hid = $size[1];
			$scale = 100;
		}
		$show_op = true;
		if (isset($_FILES['upload_image']) && $_FILES['upload_image']['error'] != 4)
		{
			if ($_FILES['upload_image']['error'])
			{
				array_push($upload_error, '上传失败 代码：'.$_FILES['upload_image']['error']);
			}
			else
			{
				if ($_FILES['upload_image']['size'] > 64*1024*1024)
				{
					array_push($upload_error, '上传文件大于64MB');
				}
				$src = $_FILES['upload_image']['tmp_name'];
				$next = ImageDAO::generate_preview_image($home, $src);
				if ($next == '')
				{
					array_push($upload_error, '上传文件无法识别');
				}
				else
				{
					$preview_file = $next;
				}
			}
		}
		if (isset($_POST['done_clip']) && $_POST['done_clip'])
		{
			if (!empty($_POST['preview_file']))
			{
				$preview_file = $_POST['preview_file'];
				$x = 0;
				$y = 0;
				$r = 500;
				$t = 500;
				$scale = 100;
				if (isset($_POST['x']))
				{
					$x = $_POST['x'];
				}
				if (isset($_POST['y']))
				{
					$y = $_POST['y'];
				}
				if (isset($_POST['r']))
				{
					$r = $_POST['r'];
				}
				if (isset($_POST['t']))
				{
					$t = $_POST['t'];
				}
				if (isset($_POST['scale']))
				{
					$scale = $_POST['scale'];
				}
				$next = ImageDAO::clip_save_image($home, Authority::get_uid(), $preview_file, $x, $y, $r, $t, $scale, true);
				if ($next == '')
				{
					array_push($upload_error, '上传文件无法识别');
				}
				else
				{
					EventDAO::set_event_logo_eid($id, $next);
					header('Location: detail.php?eid='.$id);
				}
			}
		}
	}
	
	if ( file_exists ($home.$preview_file) )
	{
		$size = getimagesize($home.$preview_file);
		$wid = $size[0];
		$hid = $size[1];
		$scale = 100;
	}
	
	

	if ( isset($_POST['skip_avatar']) && $_POST['skip_avatar'] )
	{
		header('Location: detail.php?eid='.$id);
	}

	if ( ($deviceType == "phone") ) 
	{
		include S_ROOT."template/mobile/shared/logo/m_logo_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include $home . 'template/logo/logo_frame.php';
	}
	else 
	{
		include $home . 'template/logo/logo_frame.php';
	}

?>

