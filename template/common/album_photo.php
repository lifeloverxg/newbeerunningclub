<section class="section-album-photo">
	<div class="info-title">
		<div class="title-left">
			<div class="before-title-triangle"></div>
			<?php echo $photo_list['cover']['title']; ?>
		</div>
<?php if ($add_photo) { ?>
<?php if (isset($_GET['gid'])) { ?>
		<button class="album-photo-button" onclick="window.location='upload_photo.php?id=<?php echo $aid; ?>&gid=<?php echo $gid; ?>&isalbum=<?php echo 1;?>'">上传照片</button>
		<button class="album-photo-button" onclick="window.location='edit_album_cover.php?id=<?php echo $aid; ?>&gid=<?php echo $gid; ?>'">修改相冊封面</button>
<?php } ?>
<?php if (isset($_GET['pid'])) { ?>
		<button class="album-photo-button" onclick="window.location='upload_photo.php?id=<?php echo $aid; ?>&pid=<?php echo $tpid; ?>'">上传照片</button>
<?php } ?>
<?php } ?>
	</div>
	<div class="info-list">
		<ul class="ul-album-photo">
<?php foreach ($photo_list['photo_list'] as $photo) { ?>
			<li>
				<img class="image-photo" src="<?php echo $home . $photo['image']; ?>" title="<?php echo $photo['title']; ?>" alt="<?php echo $photo['alt']; ?>" onclick="view_full_group(<?php echo $photo['photo_id']; ?>)">
			</li>
<?php } ?>
		</ul>
	</div>
</section>
