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
	$param = $_SERVER['REQUEST_URI'];
	if (isset($_SERVER['HTTP_REFERER'])) {
		$param = $_SERVER['HTTP_REFERER'];
	}
	if ( preg_match('/eid=/', $param) )
	{
		$eid_array = explode('eid=', $param);
		$eid = (int)$eid_array[1];
	}
	// TO DO
	// else if (group)

	$file = fopen('php://input', 'r');
	$tempName = tempnam('/var/tmp', 'img_');
	$temp = fopen($tempName, 'w');
	$imageSize = stream_copy_to_stream($file, $temp);
	fclose($temp);

	$img = imagecreatefromstring( file_get_contents('php://input') );
	
	$file = 'upload/'.$auth['uid'].'/event/'.$eid;

	if (!file_exists($home.$file))
	{
		mkdir($home.$file, 0777, true);
	}

	$time = 10000*microtime(true);
	$file .= '/'. $time;

	//save full image
	file_put_contents( $home . $file . $fn . '_full.jpg', file_get_contents('php://input') );

	//save large image
	$img = new MyImageCrop($tempName, $home . $file . $fn . '_large.jpg');
	$img->Crop(350,350,3);
	$img->SaveAlpha(); //将补白变成透明像素保存
	$img->destory();

	//save small image
	$img = new MyImageCrop($tempName, $home . $file . $fn . '_small.jpg');
	$img->Crop(50,50,1);
	$img->SaveImage(); 
	$img->destory();

	AlbumDAO::add_photo_event($eid, $file.$fn, $auth['uid']);

	echo $file;
	echo $fn;
	exit();
?>