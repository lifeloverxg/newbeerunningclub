<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @album:uploader</h1>');
	}
	
	if (($_FILES['create_poster']['type'] != 'image/jpeg') || ($_FILES['create_poster']['size'] > 2*1024*1024)) {
		header('Location: create.php');
		return -1;
	}

	if ($_FILES['file']['error'] > 0) {
		echo 'Error Code: '. $_FILES['file']['error'] . '<br>';
    }
	else {
		echo 'Upload: ' . $_FILES['file']['name'] . '<br>';
		echo 'Type: ' . $_FILES['file']['type'] . '<br>';
		echo 'Size: ' . ($_FILES['file']['size'] / 1024) . ' kB<br>';
		echo 'Temp file: ' . $_FILES['file']['tmp_name'] . '<br>';
		
		move_uploaded_file($_FILES['file']['tmp_name'], $home.'upload/temp/' . $_FILES['file']['name']);
    }
?>