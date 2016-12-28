<?php
	
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:gmember_oper</h1>');
	}
	
	//initialize data
	$error = "none";
	$args = array(
				  'pid'  => '',
				  'tpid' => '',
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
			case "upgrade":
				GroupDAO::upgrade_admin($args['pid'], $args['tpid'], $args['gid']);
				break;
			case "degrade":
				GroupDAO::degrade_admin($args['pid'], $args['tpid'], $args['gid']);
				break;
			case "delete":
				GroupDAO::delete_member($args['pid'], $args['tpid'], $args['gid']);
				break;
		}
	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo "\n}";