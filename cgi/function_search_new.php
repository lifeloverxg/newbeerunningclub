<?php
	
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) 
	{
		exit('<h1>503:Service Unavailable @cgi:function_search</h1>');
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

	if ($error == "none")
	{
		switch ( $args['type'] )
		{
			case '0':
				$args['type'] = '全部';
				$args['title'] = '搜索: ('.$args['keyword'].')';

				$search_result_all = SearchDAO::get_search_list_small($args['keyword']);				

				break;
			
			case '1':
				$args['type'] = '活动';
				$args['title'] = '搜索关键字为('.$args['keyword'].')的活动';

				$search_result = SearchDAO::get_search_event_list($args['keyword']);
				
				break;
			
			case '2':
				$args['type'] = '群组';
				$args['title'] = '搜索关键字为('.$args['keyword'].')的群组';
				$search_result = SearchDAO::get_search_group_list($args['keyword']);
				break;
			
			case '3':
				$args['type'] = '好友';
				$args['title'] = '搜索关键字为('.$args['keyword'].')的好友';
				$search_result = SearchDAO::get_search_people_list($args['keyword']);
				break;
			
			case '4':
				$args['type'] = '综合';
				break;
			
			default:
				$args['type'] = '活动';
				$args['title'] = '搜索关键字为('.$args['keyword'].')的活动';

				$search_result = SearchDAO::get_search_event_list($args['keyword']);
				
				break;
		}
	}

	if ( !empty($search_result) )
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
		$args['more'] = "<a href='javascript: event_search_relocation(".$args['pid'].")'>查看更多</a>";
	}
	else
	{
		switch ( $args['type'] ) 
		{
			case '全部':
				if ( !empty($search_result_all) )
				{
					
				}
				break;
			case '综合':

				break;
			
			default:
				$args['list'] .= "
											<div class='event-group-search-result-no-found'>
												没有找到关键字为(".$args['keyword'].")的".$args['type']."...
											</div>";
				break;
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

