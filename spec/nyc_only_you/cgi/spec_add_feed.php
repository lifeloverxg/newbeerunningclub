<?php
	
	$home = '../../../';
	include_once ($home.'core.php');
	
	//initialize data
	$error = "none";
	$args = array(
				  'username'  => '',
				  'event' => '',
				  'group' => '',
				  'feed' => '',
				  'list' => '',
				  'success' => '',
				  );

	$feed = array(
					'username' => '',
					'event' => '',
					'group' => '',
					'feed' => ''
					);
	
	//Process data
	foreach ($args as $key => $val) 
	{
		if ((isset($_POST[$key])) && ($_POST[$key] != "")) 
		{
			$args[$key] = $_POST[$key];
			$feed[$key] = $_POST[$key];
		}
	}	
	
	//Access database
	if ($error == "none") 
	{

		$id = NycOne::insert_feed_list($feed);
		$args['success'] = '感谢您的提议,请您继续关注我们的网站的最新信息,您也可以在下面的留言版看一看大家都说了些什么';
		$args['list'] .= '<li class="li-spec-feed-list-large">
							<div class=""spec-feed-user>'.$feed["username"].'</div>
							<div class="spec-feed-right">
							<span class="spec-addressing">活动: </span>'.$feed["event"].'
							<span class="spec-addressing">群组: </span>'.$feed["event"].'
							<span class="spec-addressing">ta的话: </span>'.$feed["feed"].'
							</div></li>';
	}
	
	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo "\n}";