			<section class="section-photo-list">
				<div class="info-list-label-title">
					<div class="info-list-label-title-head">照片集</div>
<?php if (($albumId = (isset($_GET['pid']) ? $tpid : isset($_GET['eid']) ? $eid : NULL)) != NULL) { ?>
					<div class="info-list-label-title-more">
						<a href="javascript:" onclick="show_album_event(<?php echo $albumId; ?>)"><?php echo $role == Role::Owner || $role == Role::Admin ? "管理" : "查看"; ?>更多图片(共<?php if ( isset($photo_list_more_count) ) {echo $photo_list_more_count;} else {echo "?"; } ?>张)
						</a>
					</div>
<?php if ( $role == Role::Owner || $role == Role::Admin ) { ?>
					<div class="info-list-label-title-more">
						<a href="javascript:" onclick="edit_photo(<?php echo 0; ?>, <?php echo $display_list[0]['photo_id']; ?>)">修改展示图片</a>
					</div>
<?php } ?>
<?php } ?>
				</div>
				<div class="photo-list">
					<ul>
<?php for ($i=0; $i<6; $i++) { ?>
<?php if ( !empty($display_list[$i]['image']) ) { ?>
						<li>
							<!-- <img src="<?php echo $home . $display_list[$i]['image']; ?>" alt="点击替换图片" title="点击替换图片" onclick="edit_photo(<?php echo $i; ?>, <?php echo $display_list[$i]['photo_id']; ?>)"> -->
							<img src="<?php echo $home . $display_list[$i]['image']; ?>" alt="点击查看大图" title="点击查看大图" onclick="show_photo_large('e_detail_full_image', <?php echo $display_list[$i]['photo_id']; ?>, '<?php echo $home; ?>')">
						</li>
<?php } ?>
<?php } ?>
					</ul>
				</div>
			</section>
