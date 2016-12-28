<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @group:browser</h1>');
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

	$group_list_container = GroupDAO::get_group_list_large($auth['uid'], $catalog, $num, $start);
	$group_list_large = $group_list_container['group_list'];
	$next = $group_list_container['next'];

	foreach ($group_list_large as $group) {
		$result['list'] .= "
		<li>
		<div class=\"item-info-gr\">
		<div class=\"item-left\">
		<div class=\"item-left-top\">
		<a href=\"".$home.$group['url']."\">".$group['title']."&nbsp</a>
</div>
<div class=\"item-left-mid\">
<a href=\"".$home.$group['url']."\">
<img class=\"logo-group\" src=\"".$home.$group['image']."\" alt=\"".$group['alt']."\" title=\"".$group['title']."\">
</a>
</div>
<div class=\"item-left-bot\">
<a class=\"button-join-gr ".$group['action']['class']."\" href=\"javascript:\" onclick=\"".$group['action']['func']."\">".$group['action']['name']."</a>
</div>
</div>
<div class=\"item-right\">
<div class=\"item-right-top\">
<h3 id=\"gr-desc-head\">群组介绍</h3>
<p id=\"gr-desc-body\">".$group['info']['群组描述']."</p>
</div>
<div class=\"item-right-mid\">
<p id=\"gr-label-body\">";
if (isset($group['info']['群组标签'])) {
	$result['list'] .= "标签: ".$group['info']['群组标签'];
}
		$result['list'] .= "
</p>
</div>
<div class=\"item-right-bot\">
<ul class=\"ul-member-list-tiny\">";
foreach ($group['members'] as $member) { 
	$result['list'] .= "
<li>
<a href=\"".$home.$member['url']."\">
<img class=\"logo-small\" src=\"".$home.$member['image']."\" alt=\"".$member['alt']."\" title=\"".$member['title']."\">
</a>
</li>
</ul>";
}
		$result['list'] .= "
</div>
</div>
</div>
</li>";



}
	if (isset($next) && $next != "") {
		$result['more'] = "<a href='javascript:' onclick='showMoreGroup(24, ".$next.")';>查看更多</a>";
	}

	echo json_encode($result);
?>