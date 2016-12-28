<?php
	// foreach ($group_list_large as $group) 
	// {
	// 	var_dump($group['next_event']);
	// }
?>
	<section class="section-browser-body">
		<!-- <div class="detail-title-top group-browser-detail-title-top">
			<span>您还是新生？可以加入<a href="<?php echo $home . "information/new"; ?>" style="color: rgba(200, 255, 255, 1);">新生群组</a></span>
		</div> -->
		<!-- <div class="top-margin-detail-title-top">
		</div> -->
		<ul class="ul-mobile-group-list">
<?php foreach ($group_list_large as $key => $group_list) { ?>
			<li class="li-mobile-event-list">
				<a href="<?php echo $home . $group_list['url']; ?>">
					<div class="m-event-browser-left">
						<img class="m-event-logo" src="<?php echo $home . $group_list['image']; ?>" alt="<?php echo $group_list['alt']; ?>" title="<?php echo $group_list['title']; ?>" />
					</div>
				 	<div class="m-event-browser-right">
						<div class="m-list-content m-event-browser-title">
<?php echo $group_list['info']['title']; ?>
						</div>
						<div class="m-list-content m-event-browser-description">
<?php echo $group_list['info']['群组描述']; ?>
						</div>
						<div class="m-list-content m-event-browser-capacity">
							<div class="m-title-span">已有
<?php echo $group_list['member_count']; ?> 人参加
							</div>
						</div>
						<div class="m-list-content m-event-browser-next-time">
							<div class="m-title-span">下一次活动:</div>
<?php if ( !empty($group_list['next_event']) ) { ?>
<?php echo $group_list['next_event']['title']; ?>
						</div>
<?php } else {} ?>
					</div>
<?php } ?>
				</a>
			</li>
		</ul>
	</section>
