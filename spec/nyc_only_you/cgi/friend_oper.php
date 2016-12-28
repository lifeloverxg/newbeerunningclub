<?php
	
	$home = '../../../';
	include_once ($home.'core.php');
	include_once('../handler/util.php');
	
	if (!defined('IN_ZUS') && !defined('IN_FCBS')) {
		exit('<h1>503:Service Unavailable @spec/fcbs_14_fest/cgi:friend_oper</h1>');
	}
	
	//initialize data
	$error = "none";
	$args = array(
				  'pid'  => '',
				  'tpid' => '',
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
			case "add":
				PeopleDAO::add_friend($args['pid'], $args['tpid']);
				break;
			case "delete":
				$err = PeopleDAO::delete_friend($args['pid'], $args['tpid']);
				if (!$err) {
					$error = "delete friend failed!";
				}
				break;
		}
	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo "\n}";