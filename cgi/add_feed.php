<?php
	
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:reply_to</h1>');
	}
	
	//initialize data
	$error = "none";
	$args = array(
				  'pid'     => '',
				  'page_id' => '',
				  'type'	=> '',
				  'content' => '',
				  'image'	=> '',
				  'home'    => $home
				  );
	$feedcontent = array(
						'content' => '',
						'image'	  => ''
						);
						
	$newfeed = '';

	//Process data
	foreach ($args as $key => $val) {
		if ((isset($_POST[$key])) && ($_POST[$key] != "")) {
			$args[$key] = $_POST[$key];
		}
	}

	$feedcontent['content'] = $args['content'];
	$feedcontent['image']   = $args['image'];
	
	//Access database
	if ($error == "none") {
		if ($args['type'] == "event") {
			$bid = BoardDAO::create_feed_people($args['pid'], $feedcontent, array(), array($args['page_id']));
		}
		else if ($args['type'] == "group") {
			$bid = BoardDAO::create_feed_people($args['pid'], $feedcontent, array($args['page_id']));
		}
		else if ($args['type'] == "people") {
			$bid = BoardDAO::create_feed_people($args['pid'], $feedcontent);
		}
		if ($bid > 0) {
			$newfeed = BoardDAO::get_feed_bid($args['pid'], $bid);
		}
		else {
			$newfeed = array();
		}
	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo ",\n'newfeed': ";
	echo json_encode($newfeed);
	echo ",\n'bid': ";
	echo json_encode($bid);
	echo "\n}";
?>

