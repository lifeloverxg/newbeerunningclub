<?php
	$home = "../../";
	include_once($home.'core.php');

	$auth = Authority::get_auth_arr();

	if ($_FILES["file"]["error"] > 0)
	{
		echo "Error: " . $_FILES["file"]["error"] . "<br />";
	}
	else
	{
		// echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		// echo "Type: " . $_FILES["file"]["type"] . "<br />";
		// echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		// echo "Stored in: " . $_FILES["file"]["tmp_name"] . "<br />";
		// echo "full: " . $_FILES["file"]["tmp_name"] . $_FILES["file"]["name"];
		$upload_temp_file = $_FILES["file"]["name"];
		$upload_temp_type = $_FILES["file"]["type"];
		$upload_temp_size = $_FILES["file"]["size"];
		$upload_temp_name = $_FILES["file"]["tmp_name"];
	}

	//get file name 
	$fn = ".jpg";
	$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
	$fn_arr = explode('.', $fn);
	$fn = $fn_arr[0];

	$eid = 0;
	if ( isset($_POST['hidden_eid']) )
	{
		$eid = $_POST['hidden_eid'];
	}

	$tempName = ImageDAO::generate_preview_image($home, $upload_temp_name);

	$full_width		=	logoCrop::getWidth($home.$tempName);
	$full_height	= 	logoCrop::getHeight($home.$tempName);
	
	$file = 'upload/'.$auth['uid'].'/event/'.$eid;

	if (!file_exists($home.$file))
	{
		mkdir($home.$file, 0777, true);
	}

	$time = 10000*microtime(true);
	$file .= '/'. $time;

	//save full image
	// file_put_contents( $home . $file . $fn . '_full.jpg', file_get_contents('php://input') );
	// file_put_contents( $home . $file . $fn . '_full.jpg', $home.$tempName );
	$img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_full.jpg');
	$img->Crop($full_width,$full_height,3);
	$img->SaveAlpha(); //将补白变成透明像素保存
	$img->destory();

	//save large image
	$img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_large.jpg');
	$img->Crop(350,350,3);
	$img->SaveAlpha(); //将补白变成透明像素保存
	$img->destory();

	//save small image
	$img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_small.jpg');
	$img->Crop(50,50,1);
	$img->SaveImage(); 
	$img->destory();

	AlbumDAO::add_photo_event($eid, $file.$fn, $auth['uid']);
	header('Location: '.$home.'event/album_photo.php?eid='.$eid);

	// echo $file;
	// echo $fn;
	exit();
?>