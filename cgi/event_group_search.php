<?php
	
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) 
	{
		exit('<h1>503:Service Unavailable @cgi:event_group_search</h1>');
	}
	
	//initialize data
	$error = "none";
	
	$args = array(
				  'pid'     => '',
				  'keyword' => '',
				  'type' => '',
				  'list'    => '',
				  'title' => '',
				  'more' => '',
				  'home'    => $home
				  );
	
	$search_result = array();

	//Process data
	foreach ($args as $key => $val) 
	{
		if ((isset($_POST[$key])) && ($_POST[$key] != "")) 
		{
			$args[$key] = $_POST[$key];
		}
	}
	
	if ($error = "none")
	{
		switch ($args['type']) 
		{
			case 'event':
				$args['title'] = '搜索关键字为('.$args['keyword'].')的活动';
				$search_result = SearchDAO::get_search_event_list($args['keyword']);
				break;
			
			case 'group':
				$args['title'] = '搜索关键字为('.$args['keyword'].')的群组';
				$search_result = SearchDAO::get_search_group_list($args['keyword']);
				break;
			
			default:
				$args['title'] = '';
				//以后设定默认搜索全部,暂没写DAO
				break;
		}
	}

	//搜索event或者群组时:
	if ( !empty($search_result) && (($args['type'] == 'event') || ($args['type'] == 'group')) )
	{
		foreach ($search_result as $result) 
		{
			$args['list'] .= "			
											<li class='li-search-result-event-group'>
												<a href='".$home.$result['url']."'>
													<div class='event-group-search-left-area'>
														<img class='logo-small' src='".$home.$result['image']."' alt='".$result['alt']."' title='".$result['title']."'>
													</div>
													<div class='event-group-search-right-area'>
														<span class='event-group-search-list-title-member'>".$result['title']."</span>
													</div>
												</a>
											</li>";
		}
		switch ($args['type']) 
		{
			case 'event':
				$args['more'] = "<a href='javascript: event_search_relocation(".$args['pid'].")'>查看更多</a>";
				break;
			case 'group':
				$args['more'] = "<a href='javascript: group_search_relocation(".$args['pid'].")'>查看更多</a>";
			default:
				//以后再补充吧亲
				break;
		}
	}
	else
	{
		if ($args['type'] == 'event')
		{
			$args['list'] .= "
											<div class='event-group-search-result-no-found'>
												没有找到关键字为(".$args['keyword'].")的活动...
											</div>";
		}
		else if ($args['type'] == 'group')
		{
			$args['list'] .= "
											<div class='event-group-search-result-no-found'>
												没有找到关键字为(".$args['keyword'].")的群组...
											</div>";
		}
		else
		{
			//以后再补充吧亲
		}
	}


	//return json-type test
	echo "{\n";
	echo "'error': '$error',\n";
	echo "'args': ";
	echo json_encode($args);
	echo ",\n'search_result': ";
	echo json_encode($search_result);
	echo "\n}";
?>

