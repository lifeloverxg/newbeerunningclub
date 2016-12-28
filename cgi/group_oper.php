<?php
	
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:group_oper</h1>');
	}
	
	//initialize data
	$error = "none";
	$args = array(
				  'pid'  => '',
				  'gid'  => '',
				  'oper' => ''
				  );
	
	//Process data
	foreach ($args as $key => $val) {
		if ((isset($_POST[$key])) && ($_POST[$key] != "")) {
			$args[$key] = $_POST[$key];
		}
	}	
	
	//Access database
	if ($error == "none") {
		switch ($args['oper']) {
			case "join":
				GroupDAO::join_group($args['pid'], $args['gid']);
				break;
			case "leave":
				GroupDAO::leave_group($args['pid'], $args['gid']);
				break;
			case "delete":
				GroupDAO::delete_group($args['pid'], $args['gid']);
				break;
		}
	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo "\n}";