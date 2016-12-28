<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @event:handler</h1>');
	}
	
	if (Authority::get_uid() <= 0) {
		header('Location: '.$home.$_SGLOBAL['links']['auth']);
	}
	if ($_POST['create_submit']) {
		if ($_FILES['create_poster']['error']) {
			$poster = 'theme/images/logo.png';
		}
		else {
			if (($_FILES['create_poster']['type'] != 'image/jpeg') || ($_FILES['create_poster']['size'] > 2*1024*1024)) {
				header('Location: create.php');
				return -1;
			}
			$poster = 'upload/'.Authority::get_uid().'/'.$_FILES['create_poster']['name'];
			$error = move_uploaded_file($_FILES['create_poster']['tmp_name'], $home.$poster);
			if (!$error) {
				exit('<h1>403:Forbidden @event:handler</h1>');
			}
		}

		if (!empty($_POST['create_start_date'])) {
			$start_time = strtotime($_POST['create_start_date'].' '.$_POST['create_start_time']);
		}
		else {
			$start_time = 0;
		}
		if (!empty($_POST['create_end_date'])) {
			$end_time = strtotime($_POST['create_end_date'].' '.$_POST['create_end_time']);
		}
		else {
			$end_time = 0;
		}
		
		$event_info = array(
							'title'       => $_POST['create_title'], 
							'category'    => $_POST['create_category'],
							'poster'      => $poster,
							'start_time'  => $start_time,
							'end_time'    => $end_time,
							'location'    => $_POST['create_location'],
							'description' => $_POST['create_description'],
							'host'        => Authority::get_uid()
		);
		
		Event::set_event(new Event($event_info));
		return 0;
	}
	
	header('Location: '.$home.'create.php');
?>
