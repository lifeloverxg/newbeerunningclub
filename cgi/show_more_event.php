<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit();
	}

	$auth = Authority::get_auth_arr();	

	$catalog = 0;
	if (isset($_GET['catalog']) && $_GET['catalog'] != ""){
		$catalog = $_GET['catalog'];
	}

	$start = 0;
	if (isset($_GET['start']) && $_GET['start'] != ""){
		$start = $_GET['start'];
	}

	$num = 24;
	if (isset($_GET['num']) && $_GET['num'] != ""){
		$num = $_GET['num'];
	}

	$result = array(
					'error' => 'none',
					'more' => '',
					'list' => ''
				);

	$event_list_container = EventDAO::get_event_list_large($auth['uid'], 0, $catalog, $num, $start);
	$event_list_large = $event_list_container['event_list'];
	$next = $event_list_container['next'];

	foreach ($event_list_large as $event) {
		$result['list'] .= "
					<li>
						<div class=\"browser-logo-large div-logo-large1\">
				
							<a href=\"".$home.$event['url']."\" 
				class=\"card-photo nametag-photo\" style=\"background-image: url(".$home.$event['image']."); background-size: 249px 166px;\">
				
								<div class=\"nametag-photo-name\">
										".$event['title']."
								</div>
							</a>
							<div class=\"browser-item-info\">
								<div class=\"browser-item-info-detail\">
									<p>".$event['location']."</p>
									<p>".$event['start_time']."</p>
									<ul class=\"ul-member-list-tiny\">
		";
		foreach ($event['members'] as $member) {
			$result['list'] .= "
							<li>
								<a href=\"".$home.$member['url']."\">
									<img class=\"logo-small\" src=\"".$home.$member['image']."\" alt=\"".$member['alt']."\" title=\"".$member['title']."\">
								</a>
							</li>";
		}
		$result['list'] .= "		</ul>
									<div class=\"div-item-member\">
										<p><span>".$event['member_count']."</span>人已参加</p>
										<a class=\"button-join ".$event['action']['class']."\" href=\"javascript:\" onclick=\"".$event['action']['func']."\">".$event['action']['name']."</a>
									</div>
								</div>
							</div>
						</div>
					</li>
		";
	}
	if (isset($next) && $next != "") {
		$result['more'] = "<a href='javascript:' onclick='showMoreEvent(24, $next)';>查看更多</a>";
	}

	echo json_encode($result);