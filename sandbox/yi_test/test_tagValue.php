<?php
	$home = '../';
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
	$keyword = 'm';
	$tag = '0';
	$test = SearchDAO::get_eid_keyword_timeline('m', '2');
	 var_dump($test);
	$tag_test_1 = '0, 1, 2, 3';
	$tag_test_1_array = explode(',', $tag_test_1);
	$tag_test_2 = '1, 3';
	$tag_test_2_array = explode(',', $tag_test_2);
	$tag_test_3 = '1, 9';
	$tag_test_3_array = explode(',', $tag_test_3);
	$tag_test_0 = '1, 3';
	$tag_test_0_array = explode(',', $tag_test_0);

	$test_array_1 = array_intersect($tag_test_0_array, $tag_test_1_array);
	$test_array_2 = array_intersect($tag_test_2_array, $tag_test_0_array);
	$test_array_3 = array_intersect($tag_test_3_array, $tag_test_0_array);
	// var_dump($test_array_1);
	echo "<br>";
	// var_dump($test_array_2);
	echo "<br>";
	// var_dump($test_array_3);
	echo "<br>";

	$a = array(135, 138);
	$b = array(135,138,139);
	$c = SearchDAO::tag_array_cmp_1($b, $a);
	// var_dump($c);
	echo "</br>";

	$a_string = '1, 5';
	$b_string = '1, 2, 5, 6, 7';
	$d = SearchDAO::tag_cmp($a_string, $b_string);
	// var_dump($d);



?>

<?php

// HTML footer
include $home . "template/common/footer.php";
?>