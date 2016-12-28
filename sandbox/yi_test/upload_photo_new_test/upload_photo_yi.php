<?php
/*
* photo upload function test
* Junxiao Yi
* Date: 2014-06-10
* Ver 1.2.1
*/

//Constants
//Alter these options
$upload_dir = "upload_pic"; 				// The directory for the images to be saved in
$upload_path = $upload_dir."/";				// The path to where the image will be saved
$large_image_name = "resized_pic.jpg"; 		// New name of the large image
$thumb_image_name = "thumbnail_pic.jpg"; 	// New name of the thumbnail image
$max_file = "1148576"; 						// Approx 1MB
$max_width = "500";							// Max width allowed for the large image
$thumb_width = "300";						// Width of thumbnail image
$thumb_height = "200";						// Height of thumbnail image

//Image functions
//Not need to alter these functions
function resizeImage($image,$width,$height,$scale)
{
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType)
	{
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	
	switch($imageType)
	{
		case "image/gif":
	  		imagegif($newImage,$image); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$image,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$image);  
			break;
    }
	
	chmod($image, 0777);
	return $image;
}
//You do not need to alter these functions
function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale)
{
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType)
	{
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType)
	{
		case "image/gif":
	  		imagegif($newImage,$thumb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thumb_image_name,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);  
			break;
    }
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}
//You do not need to alter these functions
function getHeight($image)
{
	$sizes = getimagesize($image);
	$height = $sizes[1];
	return $height;
}
//You do not need to alter these functions
function getWidth($image)
{
	$sizes = getimagesize($image);
	$width = $sizes[0];
	return $width;
}

//Image Locations
$large_image_location = $upload_path.$large_image_name;
$thumb_image_location = $upload_path.$thumb_image_name;

//Create the upload directory with the right permissions if it doesn't exist
if ( !is_dir($upload_dir) )
{
	mkdir($upload_dir, 0777);
	chmod($upload_dir, 0777);
}

//Check to see if any images with the same names already exist
if (file_exists($large_image_location))
{
	if (file_exists($thumb_image_location))
	{
		$thumb_photo_exists = "<img src=\"".$upload_path.$thumb_image_name."\" alt=\"Thumbnail Image\"/>";
	}
	else
	{
		$thumb_photo_exists = "";
	}
   	$large_photo_exists = "<img src=\"".$upload_path.$large_image_name."\" alt=\"Large Image\"/>";
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
			chmod($large_image_location, 0777);
			
			$width = getWidth($large_image_location);
			$height = getHeight($large_image_location);
			//Scale the image if it is greater than the width set above
			if ($width > $max_width)
			{
				$scale = $max_width/$width;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}
			else
			{
				$scale = 1;
				$uploaded = resizeImage($large_image_location,$width,$height,$scale);
			}
			//Delete the thumbnail file so the user can create a new one
			if (file_exists($thumb_image_location))
			{
				unlink($thumb_image_location);
			}
		}
		//Refresh the page to show the new uploaded image
		header("location:".$_SERVER["PHP_SELF"]);
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
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	//Reload the page again to view the thumbnail
	header("location:".$_SERVER["PHP_SELF"]);
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WebMotionUK - PHP &amp; Jquery image upload &amp; crop</title>
	<script type="text/javascript" src="js/jquery-pack.js"></script>

	<script type="text/javascript" src="js/photo_upload_new.js"></script>
</head>
<body>
<?php
//Only display the javacript if an image has been uploaded
if ( strlen($large_photo_exists) > 0 )
{
	$current_large_image_width = getWidth($large_image_location);
	$current_large_image_height = getHeight($large_image_location);?>
<script type="text/javascript">
function preview(img, selection)
{ 
	var scaleX = <?php echo $thumb_width;?> / selection.width; 
	var scaleY = <?php echo $thumb_height;?> / selection.height; 
	
	$('#thumbnail + div > img').css({ 
		width: Math.round(scaleX * <?php echo $current_large_image_width;?>) + 'px', 
		height: Math.round(scaleY * <?php echo $current_large_image_height;?>) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
} 

$(document).ready(function () { 
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if ( x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h=="" )
		{
			alert("You must make a selection first");
			return false;
		}
		else
		{
			return true;
		}
	});
}); 

$(window).load(function () { 
	$('#thumbnail').imgAreaSelect({ aspectRatio: '3:2', onSelectChange: preview }); 
});

</script>
<?php }?>
<h1>Junxiao's Test</h1>
<?php
//Display error message if there are any
if ( strlen($error)>0 )
{
	echo "<ul><li><strong>上传失败!</strong></li><li>".$error."</li></ul>";
}
if ( strlen($large_photo_exists)>0 && strlen($thumb_photo_exists)>0 )
{
	echo "<p><strong>提示:</strong> 如果图片未更新, 请刷新当前页面.</p>";
	echo $large_photo_exists."&nbsp;".$thumb_photo_exists;
	echo "<p><a href=\"".$_SERVER["PHP_SELF"]."?a=delete\">删除该图片</a></p>";
}
else
{
		if ( strlen($large_photo_exists)>0 )
		{
?>
		<h2>开始裁剪(可以放大,缩小,拖动,当前设置比例为3:2)</h2>
		<!-- <h4></h4> -->
		<div align="center">
			<img src="<?php echo $upload_path.$large_image_name;?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
			
			<!-- <div style="position: absolute; line-height: 0px; font-size: 0px; border-style: solid; border-width: 1px; opacity: 0.5; width: 107px; height: 71px; left: 247px; top: 362px; background-color: rgb(255, 255, 255);"></div>
			<div style="position: absolute; line-height: 0px; font-size: 0px; border: 1px solid rgb(0, 0, 0); width: 107px; height: 71px; left: 247px; top: 362px;"></div>
			<div style="position: absolute; line-height: 0px; font-size: 0px; border: 1px dashed rgb(255, 255, 255); width: 107px; height: 71px; left: 247px; top: 362px; cursor: move;"></div>
 -->
			<div style="float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
				<img src="<?php echo $upload_path.$large_image_name;?>" style="position: relative;" alt="Thumbnail Preview" />
			</div>
			<br style="clear:both;"/>
			<form name="thumbnail" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="submit" name="upload_thumbnail" value="保存图片" id="save_thumb" />
			</form>
		</div>
	<hr />
	<?php 	} ?>
	<h2>上传</h2>
	<form name="photo" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	照片 <input type="file" name="image" size="30" /> <input type="submit" name="upload" value="上传" />
	</form>
<?php } ?>
<!-- Copyright (c) 2008 http://www.webmotionuk.com -->
</body>
</html>
