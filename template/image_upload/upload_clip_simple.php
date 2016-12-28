<?php
	$home = "../../";
	include_once($home.'core.php');

	$auth = Authority::get_auth_arr();

	//get file name 
	$fn = ".jpg";
	$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
	$fn_arr = explode('.', $fn);
	$fn = $fn_arr[0];

	$eid = 0;
	/*在action页面无法获得get, 即QUERY_STRING cannot be accessed的值*/
	// $param = $_SERVER['QUERY_STRING'];
	$param = $_SERVER['REQUEST_URI'];
	if (isset($_SERVER['HTTP_REFERER'])) {
		$param = $_SERVER['HTTP_REFERER'];
	}
	//$eid = $param;
	if ( preg_match('/eid=/', $param) )
	{
		$eid_array = explode('eid=', $param);
		$eid = (int)$eid_array[1];
	}
	// TO DO
	// else if (group)

// if ($fn) 
// {
	$img = imagecreatefromstring( file_get_contents('php://input') );
	
	$file = 'upload/'.$auth['uid'].'/event/'.$eid;

	if (!file_exists($home.$file))
	{
		mkdir($home.$file, 0777, true);
	}

	$time = 10000*microtime(true);
	$file .= '/'. $time;

	// imagejpeg($img, $home.$file.$fn . '_full.jpg');  #也是被压缩过的,这是为什么？不应该是原图么
	file_put_contents( $home . $file . $fn . '_full.jpg', file_get_contents('php://input') );
	// file_put_contents( $home . $file . $fn, $_POST['file']);
	// list($width, $height) = getimagesize($img);
	$width_orig = imagesx($img);
	$height_orig = imagesy($img);
	$percent = 0.5;
	
	$width = 350;
	$height = ($height_orig/$width_orig)*$width;
	$dest = imagecreatetruecolor($width, $height);

	// $bg = imagecolorallocate($dest, 255, 255, 255);
	// imagefill($dest,0,0,$bg);

	imagecopyresampled($dest, $img, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	imagejpeg($dest, $home . $file . $fn . '_large.jpg');
	
	$width = 50;
	$height = ($height_orig/$width_orig)*$width;
	$dest = imagecreatetruecolor($width, $height);
	
	// $bg = imagecolorallocate($dest, 255, 255, 255);
	// imagefill($dest,0,0,$bg);

	imagecopyresampled($dest, $img, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	imagejpeg($dest, $home . $file . $fn . '_small.jpg');

	/*++++++++++yi请不要删除我的注释++++++++++*/
	// $filename = 'test.jpg'; 
	// $percent = 0.5; 
	// // 指定头文件Content typezhi值 
	// header('Content-type: image/jpeg'); 
	// // 获取图片的宽高 
	// list($width, $height) = getimagesize($filename); 
	// $newwidth = $width * $percent; 
	// $newheight = $height * $percent; 
	// // 创建一个图片。接收参数分别为宽高，返回生成的资源句柄 
	// $thumb = imagecreatetruecolor($newwidth, $newheight); 
	// //获取源文件资源句柄。接收参数为图片路径，返回句柄 
	// $source = imagecreatefromjpeg($filename); 
	// // 将源文件剪切全部域并缩小放到目标图片上。前两个为资源句柄 
	// imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height); 
	// // 输出给浏览器 
	// imagejpeg($thumb); 
	/*==========yi请不要删除我的注释==========*/

	//AlbumDAO::add_photo_event($eid, $file, $auth['uid']);

	echo $file;
	echo $fn;
	exit();
// }
?>