<?php
	$home = '../';
	include_once ($home.'core.php');
$bm = new Timer();

	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @group:browser</h1>');
	}

	$title = '浏览群组 - NBRC - 纽约新蜂跑团';

	$stylesheet = array(
						'theme/zus/group_css/create_group.cs',
						'theme/zus/group_css/group_bwsr.css',
						'theme/zus/search.css',
						'theme/zus/search_css/filter.css'
		               );

	$m_stylesheet = array(			
							);

	$javascript = array("js/zus/comment.js"
					   );

	$m_javascript = array();

	$links = $_SGLOBAL['links'];
	$auth = Authority::get_auth_arr();
	$deviceType = Mobile_Detect::deviceType();

	$search_tabs = GroupSearchTabs::get_group_nav_tab_list();
	
	$search = SearchDAO::search_func();
	$catalog_list = SearchCategory::get_const_array();
	$create_catalog_list = GroupCategory::get_const_array();
	$group_filter_list = GroupFilter::get_create_filter_list();

	if (isset($_GET['catalog'])) {
		$search['catalog'] = $_GET['catalog'];
	}
	if (isset($_GET['keyword'])) {
		$search['keyword'] = $_GET['keyword'];
	}
	$group_list_container = GroupDAO::get_group_list_large($auth['uid']);
	$group_list_large = $group_list_container['group_list'];
	$next = $group_list_container['next'];
	$hot_group_list = GroupDAO::get_hot_group_list($auth['uid']);
	$button_list_large = array();
$bm->mark();

	if (PeopleDAO::get_people_privacy_pid($auth['uid']) != Privacy::NonExist)
	{
		$button_list_large = array(
								   array(
										 'title' => '创建群组',
										 'class' => 'group',
										 'action' => 'create_group(' . $auth['uid'] . ')',
										 )
								   );
	}
	else
	{
		$button_list_large = array(
								   array(
										 'title' => '创建群组',
										 'class' => 'group',
										 'action' => 'show_login_panel()',
										 )
								   );
	}
$bm->mark();

	if (isset($_POST["group_submit"]) )
	{
		$logo = DefaultImage::Group;
		if (!empty($_POST["group_logo"])) {
			$logo = $_POST["group_logo"]; 
		}
		$group = array(
					   'title' => $_POST["group_title"],
					   'owner' => $auth['uid'],
					   'group' => '',
					   'logo' => $logo,
					   'description' => $_POST["group_description"],
					   'category' => $_POST["group_category"],
					   'size' => $_POST["group_size"],
					   'tag' => $_POST["group_tag"],
						);
		$gid = GroupDAO::create_group($auth['uid'], $group);

		header('Location: '.$home.'group?gid='.$gid);
	}

$bm->mark();
	if ( ($deviceType == "phone") ) 
	{
		include S_ROOT."template/mobile/group/m_browser_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."template/group/browser_frame.php";
	}
	else 
	{
		include S_ROOT."template/group/browser_frame.php";
	}
echo '<!-- '.$bm->report().'-->';