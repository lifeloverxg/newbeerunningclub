<?php
	
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:search_relocation</h1>');
	}
	
	//initialize data
	$error = "none";
	
	$args = array(
				  'pid'     => '',
				  'keyword' => '',
				  'url'		=> '',
				  'home'    => $home
				  );

	//Process data
	foreach ($args as $key => $val) 
	{
		if ((isset($_POST[$key])) && ($_POST[$key] != "")) 
		{
			$args[$key] = $_POST[$key];
		}
	}

	$args['url'] = 'search/detail.php?keyword='.$args['keyword'];

	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo "\n}";
?>

