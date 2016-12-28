<?php
	$home = '../';
	include_once ($home.'core.php');

$bm = new Timer();
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @people:detail</h1>');
	}

	$auth = Authority::get_auth_arr();
	$deviceType = Mobile_Detect::deviceType();

	$tpid = 0;

	if (isset($_GET['pid'])) {
		$tpid = $_GET['pid'];
	}
	else {
		$tpid = $auth['uid'];
		if ($tpid < 1) {
			$tpid = 99; // see alex if not assigned // 你这是要闹哪样
		}
	}

	$edit_display = false;
	$viewer_role = PeopleDAO::get_people_role_pid($auth['uid'], $tpid);
	$people_privacy = PeopleDAO::get_people_privacy_pid($tpid);
$bm->mark();

	$viewlevel = 0;
	if ($people_privacy < Privacy::Member) {
		$viewlevel = 1;
	}
	if ($viewer_role >= $people_privacy) {
		$viewlevel = 2;
	}
	if ($tpid == $auth['uid']) {
		$edit_display = true;
	}

	if ($viewlevel <= 0) {
		Unicorn::show($home, '抱歉，您要访问的页面不存在或权限不足');
	}
	if ($viewlevel > 0) 
	{
		$info_list = PeopleDAO::get_info_list($auth['uid'], $tpid);
		$gender_list = Gender::get_const_array();
		
		$title = $info_list['title'] . ' - 个人页面 - NBRC - 纽约新蜂跑团';
		$stylesheet = array('theme/zus/people_css/people.css',
							'theme/zus/event_css/event_feed_list.css',
							// 'theme/zus/group_css/group_feed_list.css',
							'theme/zus/people_css/edit_profile.css',
							'theme/zus/jquery.datetimepicker.css',
							'theme/zus/people_css/newpeople.css',
							'theme/zus/search_css/filter.css'
							);
		$m_stylesheet = array(
								'theme/zus/event_css/event_feed_list.css',
								'theme/zus/mobile_css/m_feed_list.css',			
							);
		$javascript = array('js/zus/comment.js',
							'js/zus/jquery.datetimepicker.js',
							'js/zus/rolling/rolling.js'
							);
		$m_javascript = array(
								 'js/zus/comment.js',
								'js/zus/common.js',
								'js/mobile/m_common.js'
							);
		$links = $_SGLOBAL['links'];
		$large_logo = PeopleDAO::get_people_logo($auth['uid'], $tpid);
		$button_list = PeopleDAO::get_people_oper_button_list($auth['uid'], $tpid);
		$button_list_large = $button_list['large'];
		$button_list_small = array();// $button_list['small'];
		$friend_list = PeopleDAO::get_people_friend_list($auth['uid'], $tpid);
		$common_friend_small = $friend_list["common_list"];
		$member_list_small = $friend_list["friend_list"];
		$event_list_small = PeopleDAO::get_people_event_list($auth['uid'], $tpid);
		$group_list_small = PeopleDAO::get_people_group_list($auth['uid'], $tpid);
		$type = '\'people\'';
		$people_filter_list = PeopleFilter::get_edit_filter_list($info_list['nature']);
	}
$bm->mark();

	if ($viewlevel > 1) {
		$feed_list = PeopleDAO::get_feed_list($auth['uid'], $tpid);
		
		//下面这句话请问是要闹哪样?!
		// $feed_list = BoardDAO::get_feed_list_friend($auth['uid'], $tpid, 1, 0, 3);
		//	$tag_list = $feed_list["tag_list"];
		$feed_list_trends = $feed_list["feed_list_large"];
		$display_list = AlbumDAO::get_photo_display_people($tpid);
		$photo_list = AlbumDAO::get_photo_list_people($tpid);
		$upload_error = array();		
		$trend_sorted = TrendsDAO::get_trend_sorted($auth['uid'], $tpid, 12);

		if ( isset($_POST["edit_submit"]) )
		{
			$info = array(
						  'name' => $_POST["edit_title"],
						  'signature' => $_POST["edit_signature"],
						  'gender' => $_POST["edit_gender"],
						  'nature' => $_POST["edit_nature"],
						  'education' => $_POST["edit_education"],
						  'hometown' => $_POST["edit_hometown"],
						  'hobby' => $_POST["edit_hobby"],
						  'birth' => $_POST["edit_birth"],
						  'marriage' => $_POST["edit_marriage"],
						  'phone' => $_POST["edit_phone"],
						  'email' => $_POST["edit_email"],
						  'address' => $_POST["edit_address"]
						  );
			
			PeopleDAO::edit_info($auth['uid'], $info);
			header('Location: '.$home.'people?pid='.$auth['uid']);
		}
		
		if ( isset($_POST["photo_submit"]) && ($_POST["photo_submit"]!="") && isset($_POST["photo_id"]))
		{
			$index = $_POST["display_id"];
			$old_photoid = $_POST["old_photoid"];
			$new_photoid = $_POST["photo_id"];
			AlbumDAO::set_display_aid(AlbumDAO::get_default_album_people($tpid), $index, $new_photoid);
			
			header('Location: '.$home.'people/detail.php?pid='.$tpid);
		}
	}

	// if ($_SCONFIG['version'] == 'debug' || AccountDAO::isMobile()) 
	// {
	// 	include S_ROOT."template/mobile/people/m_detail_frame.php";
	// }
	// else 
	// {
	// 	include S_ROOT."template/people/people_frame.php";
	// }

	if ( ($deviceType == "phone") ) 
	{
		include S_ROOT."template/mobile/people/m_detail_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."template/people/people_frame.php";
	}
	else 
	{
		include S_ROOT."template/people/people_frame.php";
	}

$bm->mark();
echo '<!-- '.$bm->report().'-->';
?>