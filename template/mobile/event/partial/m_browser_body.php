<?php

	// include_once S_ROOT.'template/mobile/shared/list/m_across_list.php';
	// // echo json_encode($event_list_large);

	// $event_list = array();
	// foreach ($event_list_large as $l_item) 
	// {
	// 	$item = array(
	// 				  'title' => $l_item['title'],
	// 				  'url'   => $home . $l_item['url'],
	// 				  'logo'  => $home . $l_item['image'],
	// 				  'sub_title' => $l_item['location']
	// 	);
	// 	array_push($event_list, $item);
	// }
	// m_across_list::render($event_list);
?>
	<section class="section-browser-body">
		<ul class="ul-mobile-event-list">
<?php foreach ($event_list_large as $key => $event_list) { ?>
			<li class="li-mobile-event-list">
				<a href="<?php echo $home . $event_list['url']; ?>">
					<div class="m-event-browser-left">
						<img class="m-event-logo" src="<?php echo $home . $event_list['image']; ?>" alt="<?php echo $event_list['alt']; ?>" title="<?php echo $event_list['title']; ?>" />
					</div>
				 	<div class="m-event-browser-right">
						<div class="m-list-content m-event-browser-title">
<?php echo $event_list['info']['title']; ?>
						</div>
						<div class="m-list-content m-event-browser-location">
<?php echo $event_list['info']['活动地点']; ?>
						</div>
						<div class="m-list-content m-event-browser-owner">
							<div class="m-title-span">创建者:</div>
<?php echo $event_list['owner']['title']; ?>
						</div>
						<div class="m-list-content m-event-browser-capacity">
							<div class="m-title-span">规模:</div>
<?php echo $event_list['info']['人数规模']; ?>
						</div>
						<div class="m-list-content m-event-browser-time">
<?php echo $event_list['info']['活动日期']; ?>
						</div>
					</div>
<?php } ?>
				</a>
			</li>
		</ul>
	</section>
