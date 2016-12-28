			<section class="section-photo-list">
				<p class="addressing">
					<span>照片集</span>
<?php if (isset($_GET['pid'])) { ?>
					<a href="javascript:" onclick="show_album_people(<?php echo $tpid; ?>)" class="list-more-small">更多</a>
<?php } ?>
<?php if (isset($_GET['eid'])) { ?>
					<a href="javascript:" onclick="show_album_event(<?php echo $eid; ?>)" class="list-more-small">更多</a>
<?php } ?>
				</div>
				<div class="photo-list" id="people-photo-list">
					<div class="photo-list-column-side">
						<div class="photo-list-column-row">
							<img src="<?php echo $home . $display_list[0]['image']; ?>" onclick="edit_photo(0, <?php echo $display_list[0]['photo_id']; ?>)" alt="点击替换图片" title="点击替换图片">
						</div>
						<div class="photo-list-column-row">
							<img src="<?php echo $home .  $display_list[1]['image']; ?>" onclick="edit_photo(1, <?php echo $display_list[1]['photo_id']; ?>)" alt="点击替换图片" title="点击替换图片">
						</div>
					</div>
					<div class="photo-list-column-middle">
						<img src="<?php echo $home . $display_list[2]['image']; ?>" onclick="edit_photo(2, <?php echo $display_list[2]['photo_id']; ?>)" alt="点击替换图片" title="点击替换图片">
					</div>
					<div class="photo-list-column-side">
						<div class="photo-list-column-row">
							<img src="<?php echo $home . $display_list[3]['image']; ?>" onclick="edit_photo(3, <?php echo $display_list[3]['photo_id']; ?>)" alt="点击替换图片" title="点击替换图片">
						</div>
						<div class="photo-list-column-row">
							<img src="<?php echo $home . $display_list[4]['image']; ?>" onclick="edit_photo(4, <?php echo $display_list[4]['photo_id']; ?>)" alt="点击替换图片" title="点击替换图片">
						</div>
					</div>
				</div>
			</section>
