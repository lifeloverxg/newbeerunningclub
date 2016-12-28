<?php
	$home = '../';
	include_once ($home.'core.php');

$bm = new Timer();

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:search_right_list</h1>');
	}

	$auth = Authority::get_auth_arr();	

	$sindex = 1;
	$keyword = '';
	
	if (isset($_GET['sindex']) && $_GET['sindex'] != "")
	{
		$sindex = $_GET['sindex'];
	}

	if (isset($_GET['keyword']) && $_GET['keyword'] != "")
	{
		$keyword = $_GET['keyword'];
	}

	$catalog_list = SearchDAO::search_func_category($keyword, $sindex);
	$search = SearchDAO::search_func_sindex();
	$search_result = SearchDAO::get_search_list_large($auth['uid'], $keyword, $sindex);
	$filter_list = $search_result['filter_list'];

	$search_result_list = $search_result['search_result'];
$bm->mark();
	include $home . "template/search/search_func.php";
$bm->mark();