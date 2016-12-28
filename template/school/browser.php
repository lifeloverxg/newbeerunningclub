<?php
$home = '../';
include_once ($home.'core.php');
include_once ($home.'template/information_new/back.php');
if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @information:browser</h1>');
	}

$stylesheet = array(
	 					// "template/information_new/header.css",
	 					"template/school/create.css",
	 					'theme/zus/search_css/filter.css',
	 					"template/school/school.css",
	 					"template/school/school_feed_list.css"
	 					);

$javascript = array(
	 					"template/information_new/test.js",
	 					'js/zus/comment.js',
	 					"template/school/school.js"
	 					);

$title = '新生社群 - NBRC - 纽约新蜂跑团';

if (isset($_GET['gid'])) {
		$gid = $_GET['gid'];
	}

$links = $_SGLOBAL['links'];

$auth = Authority::get_auth_arr();

$limit = 4;

$create_event_option = EventDAO::create_event_option($auth['uid']);
$create_catalog_list = EventCategory::get_const_array();
$event_filter_list = EventFilter::get_create_filter_list();
$event_list = School::get_event_list($gid, $limit);
$article_list = FORUM::get_group_article_list($gid);
//echo var_dump($article_list);


if (isset($_POST["event_submit"]) )
	{
		$create_option = $_POST['create_option'];
		if ($create_option == 'self')
		{
			$create_option = '';
		}
		$event = array(
					   'title' => $_POST["event_title"],
					   'owner' => $auth['uid'],
					   'gowner' => $gid,
					   'start_time' => $_POST["event_start_time"],
					   'end_time' => $_POST["event_end_time"],
					   'location' => '',
					   'logo' => '',
					   'description' => $_POST["event_description"],
					   'category' => 6,
					   'size' => $_POST["event_size"],
//					   'tag' => $_POST["event_tag"],
					   'tag' => '',
					   'price' => $_POST["event_price"],
					   'privacy' => 0, // $_POST['privacy'],
					   'verify' => 0
						);

		$create_location = array(
								1 => $_POST['event_location_street'],
								2 => $_POST['event_location_city'],
								3 => $_POST['event_location_state'],
								);
		$event['location'] = implode('|', $create_location);
		$event['tag'] = $_POST['event_tag'];

		$latitude = $_POST['lat'];
		$longitude = $_POST['lon'];

//		echo $create_option;
		$eid = EventDAO::create_event_gid($auth['uid'], $event, $gid, 1);
		if ($eid > 0) {
			header('Location: '.$home.'event?eid='.$eid);
		}
		else {
			echo "<script type='text/javascript'>alert('活动创建失败');</script>";
			header('Location: '.$home.'event');
		}
	}
include $home."template/common/header.php";
include $home."template/school/bodypart.php";
include $home."template/information_new/footer.php";
include $home . "template/school/create.php";
// 
?>