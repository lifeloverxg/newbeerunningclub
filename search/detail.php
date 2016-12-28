<?php
	$home = '../';
	include_once ($home.'core.php');

$bm = new Timer();
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @search:detail</h1>');
	}
	
	$keyword= '';
	$sindex = 1;

	if (isset($_GET['keyword'])) {
		$keyword = $_GET['keyword'];
	}

	if (isset($_GET['sindex'])) 
	{
		$sindex = $_GET['sindex'];
	}

	$test = $_SERVER['REQUEST_URI'];
	// var_dump($test);

	$auth = Authority::get_auth_arr();

	$deviceType = Mobile_Detect::deviceType();

	$search = SearchDAO::search_func_sindex();

	$title = '搜索结果 - ' . $keyword . ' - NBRC - 纽约新蜂跑团';
	
	$stylesheet = array(
						'theme/zus/search_css/detail_search.css'
						);
	$m_stylesheet = array(
							'theme/zus/mobile_css/search_detail.css'
							);
	$javascript = array(
						);
	$m_javascript = array(
							'js/mobile/m_search.js'
							);
	$links = $_SGLOBAL['links'];

$bm->mark();
	if ( ($deviceType == "phone") ) 
	{
		$catalog_list = SearchDAO::search_func_category($keyword, $sindex);
		$search = SearchDAO::search_func_sindex();
		$limit = 20;	//暂时限定取20个

		if ($keyword == '')
		{
			$search_result = SearchDAO::get_search_list_large($auth['uid'], $keyword, $sindex, '', $limit);
		}
		else
		{
			$search_result = SearchDAO::get_search_list_large($auth['uid'], $keyword, $sindex, '', $limit);
		}
		$filter_list = $search_result['filter_list'];
		$search_result_list = $search_result['search_result'];

		include S_ROOT."template/mobile/search/m_search_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."template/search/search_frame.php";
	}
	else 
	{
		include S_ROOT."template/search/search_frame.php";
	}
$bm->mark();
echo '<!-- '.$bm->report().'-->';
?>