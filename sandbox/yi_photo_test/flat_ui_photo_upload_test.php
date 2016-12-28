<?php
/*
* photo upload function test
* Junxiao Yi
* Date: 2014-06-10
* Ver 1.2.1
*/

//Constants
//Alter these options
// $upload_dir = "upload_pic"; 				// The directory for the images to be saved in
// $upload_path = $upload_dir."/";				// The path to where the image will be saved

	$home = '../../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @sandbox:yi_test</h1>');
	}

	$auth = Authority::get_auth_arr();
	
	$pid = Authority::get_uid();

	$title = $info_list['title'] . ' - 测试 - NBRC - 纽约新蜂跑团';
	
	$stylesheet = array();
	$javascript = array();
	
	$links = $_SGLOBAL['links'];

	$deviceType = Mobile_Detect::deviceType();

// HTML header
include $home . "template/common/header.php";
?>

<?php

$upload_dir = 'up_load/';

// $file .= '/'. round(microtime(true));
// if (!file_exists($upload_dir))
// {
// 	mkdir($upload_dir, 0777, true);
// }

$upload_path = $upload_dir."/";

$large_image_name = "resized_pic.jpg"; 		// New name of the large image
$thumb_image_name = "thumbnail_pic.jpg"; 	// New name of the thumbnail image
$max_file = "1148576"; 						// Approx 1MB
$max_width = "500";							// Max width allowed for the large image
$thumb_width = "300";						// Width of thumbnail image
$thumb_height = "200";						// Height of thumbnail image

?>

<style>
	.upload_submit_btn
	{
		background: #1abc9c;
		color: white;
		width: 100px;
		height: 32px;
		border: 1px solid rgba(0, 116, 168, 0.3);
		border-radius: 7px;
		margin: 0px auto;
		margin-top: 10px;
	}

	@media (min-width: 768px)
	{
	   .div-fui-fileinput
		{
			;/*display: block;
			width: 100%;
			float: left*/
			width: 380px;
			height: 190px;
			position: relative;
		}

		.upload_submit
		{
			width: 100px;
			height: 50px;
			/*margin-top: 125px;
			float: left;
			margin-bottom: 5px;*/
			bottom: 4px;
			display: inline-block;
			vertical-align: bottom;
			position: absolute;
			right: 0;
		}

		#fui-fileinput-imageUpload
		{
			display: block;
			float: left;
		} 
	}

	@media (max-width: 767px)
	{
		.fileinput
		{
			text-align: center;
		}
		.upload_submit
		{
			margin: 0px auto;
		}
	}
</style>
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<form id="uploadForm" action="photo_action.php" method="post" enctype="multipart/form-data" onSubmit="return logo_submit_check(this)">
					<div class="div-fui-fileinput">
						<div id="fui-fileinput-imageUpload" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 270px; height: auto; max-height: 180px; border: 4px dashed #dedede;">
							<img src="<?php echo $home."theme/images/default_upload_logo.gif"; ?>" style="width: 240px; height: 160px;"/>
							<!-- <img data-src="holder.js/240x160" alt="..."> -->
						</div>
<?php if ($deviceType != "phone") { ?>
						<div class="">
						</div>
						<div class="upload_submit">
							<input type="submit" id="fileSubmit" class="upload_submit_btn form-control input-sm"/>
						</div>
<?php } ?>
					</div>
					<div>
						<span class="btn btn-primary btn-embossed btn-file">	
							<span class="fileinput-new"><span class="fui-image"></span>&nbsp;&nbsp;Select image</span>
							
							<span class="fileinput-exists"><span class="fui-gear"></span>&nbsp;&nbsp;Change</span>
							
							<input type="file" name="file" id="logo-file-id"/>
							<input type="hidden" id="fui-fileinput-imageUpload-home" value="<?php echo $home; ?>"/>
						</span>
						<a href="#" class="btn btn-primary btn-embossed fileinput-exists" data-dismiss="fileinput">
							<span class="fui-trash"></span>&nbsp;&nbsp;Remove
						</a>
					</div>
<?php if ($deviceType == "phone") { ?>
						<div class="">
						</div>
						<div class="upload_submit">
							<input type="submit" id="fileSubmit" class="upload_submit_btn form-control input-sm"/>
						</div>
<?php } ?>
				</form>
			</div>
<?php

// HTML footer
include $home . "template/common/footer.php";
?> 
