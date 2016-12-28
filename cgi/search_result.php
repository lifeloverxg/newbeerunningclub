<?php
	$home = '../';
	include_once ($home.'core.php');

$bm = new Timer();

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:search_result</h1>');
	}

	$auth = Authority::get_auth_arr();	

	$sindex = 1;
	$keyword = '';

	$limit = 20;	//暂时限制搜索结果为20个
	
	if ( isset($_GET['sindex']) && $_GET['sindex'] != "" )
	{
		$sindex = $_GET['sindex'];
	}

	if (isset($_GET['keyword']) && $_GET['keyword'] != "")
	{
		$keyword = $_GET['keyword'];
	}

	if ( isset($_GET['tag_value']) && $_GET['tag_value'] != "")
	{
		$tag_value = $_GET['tag_value'];
		$search_result = SearchDAO::get_search_list_large($auth['uid'], $keyword, $sindex, $tag_value, $limit);
		$search_result_list = $search_result['search_result'];
	}
	else
	{
		$catalog_list = SearchDAO::search_func_category($keyword, $sindex);
		$search = SearchDAO::search_func_sindex();
		$search_result = SearchDAO::get_search_list_large($auth['uid'], $keyword, $sindex, '', $limit);
		$filter_list = $search_result['filter_list'];
		$search_result_list = $search_result['search_result'];
	}
$bm->mark();
	include $home . "template/search/right_frame/search_result.php";
$bm->mark();
	
	
