<?php
/*
* photo upload function test
* Junxiao Yi
* Date: 2014-06-10
* Ver 1.2.3
*/

//Constants
//Alter these options

$home = '../';
include_once($home.'core.php');
	
if ( !defined('IN_NBRC') )
{
	exit('<h1>503:Service Unavailable @people:logo</h1>');
}

$title = '修改图标 - NBRC - 纽约新蜂跑团';
$links = $_SGLOBAL['links'];

$auth = Authority::get_auth_arr();
$deviceType = Mobile_Detect::deviceType();

$stylesheet = array('theme/zus/logo.css');
$m_stylesheet = array();
$javascript = array(
					'js/zus/photo/jquery-pack.js',
					'js/zus/photo/photo_upload_new.js',
					);
$m_javascript = array(
						'js/zus/photo/jquery-pack.js',
						'js/zus/photo/photo_upload_new.js',
						);

$upload_error = array();

if (isset($_GET['pid']) && $_GET['pid'] > 0)
{
	$pid = $_GET['pid'];
}
if (isset($_POST['pid']) && $_POST['pid'] > 0)
{
	$pid = $_POST['pid'];
}

if ($auth['uid'] <= 0)
{
	array_push($upload_error, '请先登录');
	header('Location: '.$home);
}

if (empty($pid))
{
	Unicorn::show($home, '@people>logo.php: Undefine $id');
}
else
{
	$logo_obj = PeopleDAO::get_people_logo($auth['uid'], $pid);
	$preview_file = $logo_obj['image'];
}

// echo "<img src=".$home.$preview_file."/>";

$pid = $auth['uid'];

$file = 'upload/'.$pid;
if (!file_exists($home.$file))
{
	mkdir($home.$file, 0777, true);
}
// $file .= '/'. round(microtime(true));

$upload_dir = "upload_pic"; 				// The directory for the images to be saved in
$upload_path = $home.$file."/";				// The path to where the image will be saved

$large_image_name = "resized_pic.jpg"; 		// New name of the large image

// $thumb_image_name = "thumbnail_pic"; 		// New name of the thumbnail image
$thumb_image_name = round(microtime(true));		// New name of the thumbnail image
$max_file = "11485760"; 					// Approx 1MB
$max_width = "500";							// Max width allowed for the large image
$thumb_width = "300";						// Width of thumbnail image
$thumb_height = "200";						// Height of thumbnail image
$thumb_width_middle = "150";				// middle image width
$thumb_height_middle = "100";				// middle image height
$thumb_width_small = "50";					// small image width
$thumb_height_small = "50";					// small image height

//Image functions
//Not need to alter these functions

//You do not need to alter these functions
//You do not need to alter these functions


//Image Locations
$large_image_location = $upload_path.$large_image_name;

// if ( file_exists($home.$preview_file) )
// {
// 	$large_image_location = $home.$preview_file;
// }
// else
// {
// 	$large_image_location = $upload_path.$large_image_name;
// }

$thumb_image_location = $upload_path.$thumb_image_name."_large.jpg";

$save_path = $file."/".$thumb_image_name;

// var_dump($save_path);

$thumb_image_location_middle = $upload_path.$thumb_image_name."_middle.jpg";
$thumb_image_location_small = $upload_path.$thumb_image_name."_small.jpg";

if (file_exists($large_image_location))
{
	if (file_exists($thumb_image_location))
	{
		$thumb_photo_exists = "<img src=\"".$thumb_image_location."\" alt=\"Thumbnail Image\"/>";
	}
	else
	{
		$thumb_photo_exists = "";
	}
   	$large_photo_exists = "<img src=\"".$large_image_location."\" alt=\"Large Image\"/>";
}
else
{
   	$large_photo_exists = "";
	$thumb_photo_exists = "";
}

if (isset($_POST["upload"]))
{ 
	//Get the file information
	$userfile_name = $_FILES['image']['name'];
	$userfile_tmp = $_FILES['image']['tmp_name'];
	$userfile_size = $_FILES['image']['size'];
	$filename = basename($_FILES['image']['name']);
	$file_ext = substr($filename, strrpos($filename, '.') + 1);
	
	//Only process if the file is a JPG and below the allowed limit
	if ( (!empty($_FILES["image"])) && ($_FILES['image']['error'] == 0) )
	{
		if (($file_ext!="jpg") && ($userfile_size > $max_file))
		{
			$error= "ONLY jpeg images under 1MB are accepted for upload";
		}
	}
	else
	{
		$error= "未选择图片或者图片格式不正确(请确保上传gif/png/jpg格式图片)";
	}
	//Everything is ok, so we can upload the image.
	if (strlen($error)==0)
	{
		
		if (isset($_FILES['image']['name']))
		{	
			move_uploaded_file($userfile_tmp, $large_image_location);
			// chmod($large_image_location, 0777);
			
			$width = logoCrop::getWidth($large_image_location);
			$height = logoCrop::getHeight($large_image_location);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width)
			{
				$scale = $max_width/$width;
				$uploaded = logoCrop::resizeImage($large_image_location,$width,$height,$scale);
			}
			else
			{
				$scale = 1;
				$uploaded = logoCrop::resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location))
			{
				unlink($thumb_image_location);
			}
		}
		//Refresh the page to show the new uploaded image
		// header("location:".$_SERVER["PHP_SELF"]);

		header('Location: logo.php?pid='.$pid);
		
		exit();
	}
}

if (isset($_POST["upload_thumbnail"]) && strlen($large_photo_exists)>0)
{
	//Get the new coordinates to crop the image.
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = logoCrop::resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);

	$scale_middle = $thumb_width_middle/$w;
	$cropped = logoCrop::resizeThumbnailImage($thumb_image_location_middle, $large_image_location,$w,$h,$x1,$y1,$scale_middle);

	$scale_small = $thumb_width_small/$w;
	$cropped = logoCrop::resizeThumbnailImage($thumb_image_location_small, $large_image_location,$w,$h,$x1,$y1,$scale_small);

	//Reload the page again to view the thumbnail
	PeopleDAO::set_people_avatar_pid($pid, $save_path);
	Authority::refresh_session();
	header('Location: detail.php?pid='.$pid);

	exit();
}

if ($_GET['a']=="delete")
{
	if (file_exists($large_image_location))
	{
		unlink($large_image_location);
	}
	if (file_exists($thumb_image_location))
	{
		unlink($thumb_image_location);
	}
	header("location:".$_SERVER["PHP_SELF"]);
	exit(); 
}

if ( strlen($large_photo_exists) > 0 )
{
	$current_large_image_width = logoCrop::getWidth($large_image_location);
	$current_large_image_height = logoCrop::getHeight($large_image_location);
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
