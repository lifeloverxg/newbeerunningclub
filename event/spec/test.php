<?php

	$event_list_container = EventDAO::get_event_list_large($auth['uid']);
	$event_list_large = $event_list_container['event_list'];
	$next = $event_list_container['next'];
	
	$button_list_large = array();
$bm->mark();
	
	if (PeopleDAO::get_people_privacy_pid($auth['uid']) != Privacy::NonExist) {
		$button_list_large = array(
								   array(
										 'title' => '创建活动',
										 'class' => 'event',
										 'action' => 'create_event(' . $auth['uid'] . ')',
										 )
								   );
	}

	$create_event_option = EventDAO::create_event_option($auth['uid']);
$bm->mark();


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
					   'gowner' => $create_option,
					   'start_time' => $_POST["event_start_time"],
					   'end_time' => $_POST["event_end_time"],
					   'location' => $_POST["event_location"],
					   'logo' => '',
					   'description' => $_POST["event_description"],
					   'category' => $_POST["event_category"],
					   'size' => $_POST["event_size"],
					   'tag' => $_POST["event_tag"],
					   'price' => $_POST["event_price"],
						);
		$latitude = $_POST['lat'];
		$longitude = $_POST['lon'];

		echo $create_option;
		$eid = EventDAO::create_event_gid($auth['uid'], $event, $create_option);
//		$test = EventDAO::set_event_geocode_eid($eid, $event['title'], $latitude, $longitude);

		header('Location: '.$home.'event?eid='.$eid);
	}

/*test*/
	$keyword = 'o';
	$test = SearchDAO::get_search_list_small($keyword);
//	var_dump($test);

	include S_ROOT."event/spec/test.php";
	include S_ROOT."template/event/browser_frame.php";
$bm->mark();
echo '<!-- '.$bm->report().'-->';
