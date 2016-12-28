<?php
	
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:event_oper</h1>');
	}
	
	//initialize data
	$error = "none";
	$args = array(
				  'pid'				=>	'',
				  'eid'				=>	'',
				  'oper'			=>	'',
				  'address'			=>	'',
				  'url_address'		=>	'',
				  'unisalemode'		=>	'',
				  'del_id'			=>	'',
				  'message'			=>	'',
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
				EventDAO::join_event($args['pid'], $args['eid']);
				break;
			case "leave":
				EventDAO::leave_event($args['pid'], $args['eid']);
				break;
			case "delete":
				EventDAO::delete_event($args['pid'], $args['eid']);
				break;
			case "buy":
				$args['url_address'] = EventDAO::get_eventbrite_url_eid($args['eid']);
				break;
			case "uni_sale":
				$args['message'] = 'hello test!';
				break;
			case "other_sale":
				$args['message'] = EventDAO::insert_eventbrite_url($args['eid'], $args['address']);
				break;
			case "modify_sale_del":
				$args['message'] = EventDAO::del_paypalsale_type_id($args['pid'], $args['del_id']);
				break;
		}
	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo "\n}";