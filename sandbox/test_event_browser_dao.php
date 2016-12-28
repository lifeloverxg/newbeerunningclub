<?php
	$home = '../';
	include_once ($home.'core.php');

	if (isset($_GET['category'])) {
		$category = $_GET['category'];
	}
	else {
		$category = 0;
	}

	$result = GroupDAO::get_group_list_large(Authority::get_uid());
	print_r ($result);
	
	echo '<br>';
	echo '<br>';

	$result = GroupDAO::get_group_list_large(Authority::get_uid(), 0, 1000, 0);
	print_r ($result);
	

	
?>