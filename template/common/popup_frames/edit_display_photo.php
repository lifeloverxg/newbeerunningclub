			<div class="div-popup" id="edit-display-photo">
				<a href="javascript:" class="popup-close"><span class="glyphicon glyphicon-remove"></span></a>
				<section class="popup-main">
					<header>
						<h1>修改展示图片</h1>
					</header>
					<article class="edit-display-photo-form">
						<form id="editphotoForm" name="editphotoForm" method="post" action="" enctype="multipart/form-data" onSubmit="return edit_display_check(this)">
							<p>请先选择您要替换的图片的展示位置(从左到右依次为1到6): </p>
<?php for ($i=0; $i<=5; $i++) { ?>
							<input type="radio" name="display_id-test" id="display_id-<?php echo ($i+1); ?>" value="<?php echo ($i+1); ?>" onchange="edit_photo_display_inner(<?php echo $i; ?>, <?php echo $display_list[$i]['photo_id']; ?>)" required/><?php echo ($i+1)."&nbsp;&nbsp;&nbsp;";?>
<?php } ?>						
							<p>请选择替换图片: </p>
<?php if ($edit_display)  { ?>
<?php if (count($photo_list) == 0) { ?>
							<p>暂无可替换图片</p>
<?php if (($albumId = (isset($_GET['pid']) ? $tpid : isset($_GET['eid']) ? $eid : NULL)) != NULL) { ?>
									您可以<a href="<?php echo $home. "event/album_photo.php?eid=".$eid."&isupload=1"; ?>" style="color: rgba(0, 116, 168, 1);">上传图片
									</a>
<?php } ?>
<?php } else { ?>	
							<ul>
<?php foreach ($photo_list as $photo) { ?>
								<li>
									<img src="<?php echo $home . $photo['image']; ?>" alt="<?php echo $photo['alt']; ?>" title="<?php echo $photo['title']; ?>"><br>
									<input type="radio" name="photo_id" value="<?php echo $photo['photo_id']; ?>" required/>
								</li>
<?php } ?>
							</ul>
							<input name="display_id" id="display_id" type="text" style="display: none;" />
							<input name="old_photoid" id="old_photoid" type="text" style="display: none;" />
							<input type="submit" name="photo_submit" id="photo_submit" value="替换图片" /></td>
							<?php if (($albumId = (isset($_GET['pid']) ? $tpid : isset($_GET['eid']) ? $eid : NULL)) != NULL) { ?>
									您也可以<a href="<?php echo $home. "event/album_photo.php?eid=".$eid."&isupload=1"; ?>" style="color: rgba(0, 116, 168, 1);">上传图片
									</a>
<?php } ?>
<?php } ?>
<?php } else { ?>
							<span>权限不足</span>
<?php } ?>
						</form>
					</article>
				</section>
			</div>
