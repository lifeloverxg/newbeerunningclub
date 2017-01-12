<?php
	$home = '../../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @cgi:popup_use.php</h1>');
	}
	
	//initialize data
	$error = "none";

	if ( isset($_POST['share_url']) && !empty($_POST['share_url']) )
	{
		$args = array(
				  'id' => '',
				  'share_url' => '',
				  'param' => false,
				  'list' => '',
				  );

		//Process data
		foreach ($args as $key => $val)
		{
			if ((isset($_POST[$key])) && ($_POST[$key] != "")) 
			{
				$args[$key] = $_POST[$key];
			}
		}

		$content = "打开微信，点击底部的“发现”，使用 “扫一扫” 即可将网页分享到我的朋友圈";

		if ( $args['id'] == 'qr' )
		{
			$content = "打开微信, 点击底部的“发现”, 使用 “扫一扫” 加入纽约新蜂跑团官方微信群";
		}
		
		//Access database, determine whether the email exists or not
		if ($error == "none") 
		{
			$html = spec_popup::popup_render_share($args['id'], $args['share_url'], $content);
			$args['list'] = $html;
		}
	}
	else if ( isset($_POST['image_id']) )
	{
		$args = array(
						'id'		=>	'',
						'image_id'	=>	'',
						'home'		=>	'',
						'param'		=>	false,
						'full'		=>	'',
						'list'		=>	'',
					);

		//Process data
		foreach ($args as $key => $val)
		{
			if ((isset($_POST[$key])) && ($_POST[$key] != "")) 
			{
				$args[$key] = $_POST[$key];
			}
		}

		if ($error == "none") 
		{
			if ( $args['image_id'] != 0 )
			{
				$args['full'] = AlbumDAO::get_photo_full($home, $args['image_id']);
				$full = $args['home'].$args['full'];
			}
			else
			{
				$full = '';
			}

			$html = spec_popup::popup_render_large_photo($args['id'], 'NBRC - 查看大图', $full);
			$args['list'] = $html;
		}
	}
	else if ( isset($_POST['error_type']) )
	{
		$args = array(
						'id'			=>	'',
						'error_type'	=>	'',
						'param'			=>	false,
						'list'			=>	'',
					);

		//Process data
		foreach ($args as $key => $val)
		{
			if ((isset($_POST[$key])) && ($_POST[$key] != "")) 
			{
				$args[$key] = $_POST[$key];
			}
		}

		if ($error == "none") 
		{
			switch ( $args['error_type'] )
			{
				case "uploadPhotoNoSet":
					$notification = "出错了, 您没有选择任何图片";
					break;
				case "uploadPhotoTypeError":
					$notification = "出错了，您上传的图片必须为.jpg,.gif,.png类型，请重新上传";
					break;
				case "defineSuper":
					$notification = "您暂无权限开启收费票, 您可以联系uni官方申请权限; 或者您没有登录";
					break;
				default:
					$notification = "出错了, 请您检查您的输入";
					break;
			}

			$html = spec_popup::popup_render_error($args['id'], 'NBRC - error', $notification);
			$args['list'] = $html;
		}
	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo "\n}";
?>