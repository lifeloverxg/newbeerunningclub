<?php
	$home = '../../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @sandbox:yi_test</h1>');
	}

	$auth = Authority::get_auth_arr();
	
	$pid = Authority::get_uid();

	$title = $info_list['title'] . ' - 测试 - NBRC - 纽约新蜂跑团';
	
	$stylesheet = array();
	$javascript = array();
	
	$links = $_SGLOBAL['links'];

	//var_export($friend_list);
// HTML header
include $home . "template/common/header.php";

// Friend List Content
//include $home . "cgi/group_manage_member.php";


?>
<img src="../theme/images/index_bg.jpg" style="width: 35%; height: 35%; opacity: 0.2;"/>
<input type="text" value="sssss" style="width: 100%;"/>

<?php if (AccountDAO::isMobile()) { ?>
	<input type="text" value="sssss" style="width: 30%;"/>
<?php } ?>

<?php
	// $folder = 'upload/'."test_csv/";
	// if ( !file_exists($home.$folder) )
	// {
	// 	mkdir($home.$folder, 0777, true);
	// }
	// $file = $home.$folder."test.csv";
	// // $f = fopen('cars.csv', 'w');
	// $f = fopen($file, 'w');

	$test = xmlToCsv::xml2CSV($home);
	var_dump($test);
?>

<?php

// HTML footer
include $home . "template/common/footer.php";
?>