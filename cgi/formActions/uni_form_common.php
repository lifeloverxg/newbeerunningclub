<?php
	$home = '../../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @cgi:formActions</h1>');
	}

	// /*++++++++++++++++++++++++++++++uni_sale++++++++++++++++++++++++++++++*/
	// if ( isset( $_POST['event_submit'] ) )
	// {
	// 	$create_option = $_POST['create_option'];
	// 	if ($create_option == 'self')
	// 	{
	// 		$create_option = '';
	// 	}

	// 	$event = array(
	// 				   'title' => $_POST["event_title"],
	// 				   'owner' => $_POST['pid_hidden'],
	// 				   'gowner' => $create_option,
	// 				   'start_time' => $_POST["event_start_time"],
	// 				   'end_time' => $_POST["event_end_time"],
	// 				   'location' => '',
	// 				   'logo' => '',
	// 				   'description' => $_POST["event_description"],
	// 				   'category' => $_POST["event_category"],
	// 				   'size' => $_POST["event_size"],
	// 				   'tag' => '',
	// 				   'price' => $_POST["event_price"],
	// 				   'privacy' => 0,
	// 				   'verify' => 0
	// 					);

	// 	$create_location = array(
	// 							1 => $_POST['event_location_street'],
	// 							2 => $_POST['event_location_city'],
	// 							3 => $_POST['event_location_state'],
	// 							);
	// 	$event['location'] = implode('|', $create_location);
	// 	$event['tag'] = $_POST['event_tag'];

	// 	$latitude = $_POST['lat'];
	// 	$longitude = $_POST['lon'];

	// 	$eid = EventDAO::create_event_gid($event['owner'], $event, $create_option);
	// 	if ($eid > 0)
	// 	{
	// 		header('Location: '.$home.'event?eid='.$eid);
	// 	}
	// 	else
	// 	{
	// 		echo "<script type='text/javascript'>alert('活动创建失败');</script>";
	// 		header('Location: '.$home.'event');
	// 	}
	// }
	// /*==============================uni_sale==============================*/
	/*++++++++++++++++++++++++++++++ uni_sale new ++++++++++++++++++++++++++++++*/
	if ( isset( $_POST['event_submit'] ) )
	{
		// $eid = $_POST['unisaleid'];
		$pid = $_POST['unisalepid'];

		$create_option = $_POST['create_option'];
		if ($create_option == 'self')
		{
			$create_option = '';
		}

		$event = array(
					   'title' => $_POST["event_title"],
					   'owner' => $pid,
					   'gowner' => $create_option,
					   'start_time' => $_POST["event_start_time"],
					   'end_time' => $_POST["event_end_time"],
					   'location' => '',
					   'logo' => '',
					   'description' => $_POST["event_description"],
					   'category' => $_POST["event_category"],
					   'size' => $_POST["event_size"],
					   'tag' => '',
					   'price' => '',
					   'privacy' => 0,
					   'verify' => 0
						);

		$create_location = array(
								1 => $_POST['event_location_street'],
								2 => $_POST['event_location_city'],
								3 => $_POST['event_location_state'],
								);
		$event['location'] = implode('|', $create_location);
		$event['tag'] = $_POST['event_tag'];

		$latitude = $_POST['lat'];
		$longitude = $_POST['lon'];

		$eid = EventDAO::create_event_gid($event['owner'], $event, $create_option);

		// $eid = 3;
		if ( $eid > 0 )
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
			
			$file = 'upload/'.$pid.'/event/'.$eid;

			if (!file_exists($home.$file))
			{
				mkdir($home.$file, 0777, true);
			}

			$time = 10000*microtime(true);
			$file .= '/'. $time;


			//save full image
			$img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_full.jpg');
			$img->Crop($full_width,$full_height,3);
			$img->SaveAlpha();
			$img->destory();

			//save large image
			$img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_large.jpg');
			$img->Crop(300,200,1);
			// $img->SaveAlpha();
			$img->SaveImage();
			$img->destory();

			//save middle image
			$img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_middle.jpg');
			$img->Crop(150,100,3);
			$img->SaveAlpha();
			$img->destory();

			//save small image
			$img = new MyImageCrop($home.$tempName, $home . $file . $fn . '_small.jpg');
			$img->Crop(50,50,1);
			$img->SaveImage();
			$img->destory();

			EventDAO::set_event_logo_eid($eid, $file . $fn);
			AlbumDAO::add_photo_event($eid, $file.$fn, $pid);
			/*===== event logo =====*/


			/*++++++++++ ticket sale ++++++++++*/
			if (  isset ($_POST['uni_sale_checknot_hidden']) )
			{
				$salenot = $_POST['uni_sale_checknot_hidden'];
			}

			if ( $salenot == "1" )
			{
				$ticket_info	=	array();
				$ticket_ids		=	array();
				$ticket_count	=	$_POST["ticket_type_nums"];
				$salecount		=	$_POST['unisalecount'];

				for ( $i = 1; $i <= $salecount; $i++ )
				{
					if ( !empty($_POST['type_'.$i]) )
					{
						$ticket['eid']			=	$eid;
						$ticket['type']			=	$_POST["type_".$i];
						$ticket['price']		=	$_POST["price_".$i];
						$ticket['volume']		=	$_POST["volume_".$i];
						$ticket['remain']		=	$_POST["volume_".$i];
						$ticket['tlimit']		=	$_POST["volume_".$i];
						$ticket['description']	=	"暂无";

						array_push($ticket_info, $ticket);
					}

					$ticket_id = EventDAO::set_uni_ticket($pid, $eid, $ticket);
					array_push($ticket_ids, $ticket_id);
				}
			}
			/*========== ticket sale ==========*/

			header('Location: '.$home.'event?eid='.$eid);
		}
		else
		{
			header('Location: '.$home.'event');
		}
	}
	/*============================== uni_sale new ==============================*/
?>