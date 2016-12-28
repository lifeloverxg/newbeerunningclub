<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @about:team info</h1>');
	}

	$title = '开发团队 - NBRC - 纽约新蜂跑团';

	$stylesheet = array(
						"theme/zus/about_css/about_team.css"
						);

	$javascript = array(
						"js/zus/about.js"
						);
	$links = $_SGLOBAL['links'];
	$auth = Authority::get_auth_arr();

	$nav_list = array(
					  'about1' => '关于我们', 
					  'about2' => '开发团队', 
					  'about3' => '团队成员', 
					  'about4' => '联系我们'
					  );
	$member_list = GroupDAO::get_group_member_list(98, 1);


	include S_ROOT."template/about/team_frame.php";
?>
