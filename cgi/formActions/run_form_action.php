<?php
	$home = '../../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @cgi:formActions</h1>');
	}

	/*++++++++++++++++++++++++++++++ uni_sale new ++++++++++++++++++++++++++++++*/
	if ( isset( $_POST['runcard_submit'] ) )
	{
		// $eid = $_POST['unisaleid'];
		$pid = $_POST['nbrcpid'];

		if ( isset($_POST['curMoreid']) && $_POST['curMoreid'] > 0 )
		{
			$curMoreid = $_POST['curMoreid'];
		}
		else
		{
			$curMoreid = '';
		}

		if ( isset($_POST['curMoreid']) && $_POST['curMoreid'] > 0 )
		{
			$curMoreid = $_POST['curMoreid'];
		}
		else
		{
			$curMoreid = '';
		}

		if ( isset($_POST['runningcard_description']) && $_POST['runningcard_description'] > 0 )
		{
			$runningcard_description = $_POST['runningcard_description'];
		}
		else
		{
			$runningcard_description = '';
		}

		$runningcard = array(
					   'owner' => $_POST["nbrcpid"],
					   'eowner' => $curMoreid,
					   'distance' => $_POST["card_distance"],
					   'description' => $runningcard_description
						);


		$rcid = RunDAO::create_runcard($pid, $runningcard);

		//$stmt->prepare('UPDATE event SET title=?, start_time=?, end_time=?, location=?, description=?, category=?, size=?, tag=?, price=?, privacy=? WHERE eid=?;');

		if ( $rcid > 0 && $_FILES["file"]["name"] != '' )	
		{
			/*+++++ event logo +++++*/
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

			$tempName = ImageDAO::generate_preview_image($home, $upload_temp_name);

			$full_width		=	logoCrop::getWidth($home.$tempName);
			$full_height	= 	logoCrop::getHeight($home.$tempName);
			
			$file = 'upload/'.$pid.'/runcard/'.$rcid;

			if (!file_exists($home.$file))
			{
				mkdir($home.$file, 0777, true);
			}

			$time = 10000*microtime(true);
			$file .= '/'. $time;


			//save full image
			// $img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_full.jpg');
			// $img->Crop($full_width,$full_height,3);
			// $img->SaveAlpha();
			// $img->destory();

			//save large image
			$img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_large.jpg');
			$img->Crop(320,568,4);
			$img->SaveAlpha();
			// $img->SaveImage();
			$img->destory();

			//save middle image
			// $img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_middle.jpg');
			// $img->Crop(150,100,3);
			// $img->SaveAlpha();
			// $img->destory();

			//save small image
			// $img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_small.jpg');
			// $img->Crop(50,50,1);
			// $img->SaveImage();
			// $img->destory();

			RunDAO::set_runcard_image_rcid($rcid, $file . $fn);
			/*===== event logo =====*/


			header('Location: '.$home.'information/detail.php?rcid='.$rcid);
		}
		else
		{
			header('Location: '.$home.'information/detail.php?rcid='.$rcid);
		}
	}
	/*============================== uni_sale new ==============================*/
?>