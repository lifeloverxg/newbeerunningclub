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
				  'bid'     => '',
				  'content' => '',
				  'home'    => $home
				  );
	$comment = '';

	//Process data
	foreach ($args as $key => $val) {
		if ((isset($_POST[$key])) && ($_POST[$key] != "")) {
			$args[$key] = $_POST[$key];
		}
	}
	
	//Access database
	if ($error == "none") {
		$cid = BoardDAO::add_comment_people($args['bid'], $args['pid'], $args['content']);
		$comment = BoardDAO::get_comment_cid($args['pid'], $cid);
	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo ",\n'comment': ";
	echo json_encode($comment);
	echo "\n}";
?>

