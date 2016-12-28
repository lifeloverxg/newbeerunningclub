<?php
$home = '../../';
include_once ($home.'core.php');

if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @information:browser</h1>');
	}

$stylesheet = array(
					// "template/information_new/header.css"
					);

$javascript = array(
	 					// "template/information_new/test.js"
	 					);

$title = '新生社群 - NBRC - 纽约新蜂跑团';

$links = $_SGLOBAL['links'];

$auth = Authority::get_auth_arr();

$deviceType = Mobile_Detect::deviceType();

$school_list = GroupDAO::get_newcome_group_list_large($auth['uid']);

include ($home.'template/common/header.php');
include ($home.'template/information_new/new/bodypart.php');
include ($home.'template/common/footer.php');

?>