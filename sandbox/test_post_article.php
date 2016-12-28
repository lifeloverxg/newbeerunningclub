<?php
	$home = '../';
	include_once ($home.'core.php');
	$article = GroupDAO::get_feed_list($auth['uid'], 1);
	
	echo json_encode($article);	

	?>

