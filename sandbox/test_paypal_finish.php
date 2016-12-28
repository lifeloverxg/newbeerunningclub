<?php
	$home = '../';
	include_once ($home.'core.php');
	
	$result = $_GET;
	echo json_encode($result);
	
	?>