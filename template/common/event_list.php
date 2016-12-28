	<section class="section-event-list-small">
		<p class="addressing">
			<span>活动</span>
			<a href="javascript:" onclick="" style="float: right;">查看更多</a>
		</p>
		<div class="div-event-list-detail">
			<ul class="ul-browser-list">
<?php foreach ($event_list_small as $event) { ?>
				<li>
					<div class="browser-logo-large div-logo-large1-event-list">
						<a href="<?php echo $home.$event['url']; ?>" class="card-photo nametag-photo nametag-photo-event-list" style="background-image: url(<?php echo $home.$event['image_large']; ?>); background-size: 129px 86px;">
							<div class="nametag-photo-name">
									<?php echo $event['title']; ?>
							</div>
						</a>
						<div class="browser-item-info browser-item-info-event-list">
							<div class="browser-item-info-detail">
								<p><?php echo $event['start_time']; ?></p>
								<p>已有<?php echo $event['size']; ?>人参加</p>
								<p><?php echo $event['活动地点']; ?></p>
							</div>
						</div>
					</div>
				</li>
<?php } ?>
			</ul>
		</div>
	</section>
