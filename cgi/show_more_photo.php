<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit();
	}

	$auth = Authority::get_auth_arr();	

	$aid = 0;
	if (isset($_GET['aid']) && $_GET['aid'] != ""){
		$aid = $_GET['aid'];
	}

	$start = 0;
	if (isset($_GET['start']) && $_GET['start'] != ""){
		$start = $_GET['start'];
	}

	$num = 20;
	if (isset($_GET['num']) && $_GET['num'] != ""){
		$num = $_GET['num'];
	}

	$result = array(
					'error' => 'none',
					'more' => '',
					'list' => '',
					'id' => $aid
				);

	$photo_list_container = AlbumDAO::get_album_aid_limit($aid, $num, $start);
	$photo_list = $photo_list_container['photo_list'];
	$next = $photo_list_container['more'];

	foreach ($photo_list as $photo) {
		$result['list'] .= "			
							<li>
								<img style='width: auto; cursor: pointer;' src='". $home . $photo['image'] . "' title='" . $photo['title'] . "' alt='" . $photo['alt'] . "' onclick='view_full(" . $photo['photo_id'] . ")'><br>
								<p style='color: #999; font-size: 0.8rem;'>". $photo['ctime'] ."</p>
								<input type='checkbox' style='display: none;' name='delete_photo[]' value='". $photo['photo_id'] ."'>
							</li>";
	}

	if (isset($next) && $next != "") {
		$result['more'] = "<a href='javascript:' style='display: none;' id='load-more-photo' onclick='".$next."';>查看更多</a>";
	}


	echo json_encode($result);