<section class="section-ordered-photo">
	<div class="info-title">
		<div class="before-title-triangle"></div>
		照片集
<?php if ($add_photo) { ?>
<?php if (isset($_GET['pid'])) { ?>
		<a href="javascript:" onclick="window.location='upload_photo.php?pid=<?php echo $tpid; ?>'" style="display: inline-block; margin-right: 20px; font-size: 1rem;">+添加照片</a>
		<a href="javascript:" id="delete-photo" style="display: inline-block; margin-right: 20px; font-size: 1rem;">-删除照片</a>
		<a href="javascript:" id="cancel-delete" style="display: none; margin-right: 20px; font-size: 1rem;">-取消删除</a>
<?php } ?>
<?php if (isset($_GET['eid'])) { ?>
		<!-- <a href="javascript:" onclick="window.location='upload_photo_original.php?eid=<?php echo $eid; ?>'" style="display: inline-block; margin-right: 20px; font-size: 1rem;">+添加照片</a> -->
		<a href="javascript:" id="album-add-photo-a-add" onclick="album_page_addPhoto(<?php echo ($isUpload == 1)? 2 : 1; ?>)" style="display: inline-block; margin-right: 20px; font-size: 1rem;">
			<div class="tagsinput-add <?php echo ($isUpload == 1)? "tagsinput-add-on" : "tagsinput-add-off"; ?>"><?php echo ($isUpload == 1)? " 取消添加 " : " 添加照片 "; ?></div>
		</a>
<?php if ($official) { ?>
			<a href="javascript:" onclick="window.location='upload_photo_new.php?eid=<?php echo $eid; ?>'" style="display: inline-block; margin-right: 20px; font-size: 1rem; color: #009FC0;">
				<div class="tagsinput-add tagsinput-add-2"> 批量上传 </div>
			</a>
<?php } ?>
<?php } ?>
<?php } ?>
		<a href="javascript:" id="delete-photo" style="display: inline-block; margin-right: 20px; font-size: 1rem;">
			<div class="tagsinput-add-1"> <img src="../theme/images/remove_1.png" style="width: 15px;">删除照片 </div>
		</a>
		<a href="javascript:" id="cancel-delete" style="display: none; margin-right: 20px; font-size: 1rem;">
			<span style="color: red;">取消删除</span>
		</a>
	</div>

	<div id="add-photo-switch" class="<?php echo ($isUpload == 1)? "uni-switch-on" : "uni-switch-off"; ?>">
		<div class="fileinput fileinput-new" data-provides="fileinput">
			<form id="uploadForm" action="<?php echo $home."cgi/formActions/photo_upload_action.php"; ?>" method="post" enctype="multipart/form-data" onSubmit="return logo_submit_check(this)">
				<div class="div-fui-fileinput">
					<div id="fui-fileinput-imageUpload" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 270px; height: 180px; max-height: 180px; border: 4px dashed #dedede;">
						<img src="<?php echo $home."theme/images/default_upload_logo.jpg"; ?>" style="width: 240px; height: 160px;"/>
						<!-- <img data-src="holder.js/240x160" alt="..."> -->
					</div>
<?php if ($deviceType != "phone") { ?>
					<!-- <div class="cancel-upload_submit">
						<button class="cancel_upload_submit_btn form-control input-sm">取消</button>
					</div> -->
					<div class="upload_submit">
						<input type="submit" id="fileSubmit" class="upload_submit_btn form-control input-sm"/>
					</div>
<?php } ?>
				</div>
				<div class="fui-fileinput-btns-upload">
					<span class="btn btn-primary btn-embossed btn-file">	
						<span class="fileinput-new"><span class="fui-image"></span>&nbsp;&nbsp;Select image</span>
						
						<span class="fileinput-exists"><span class="fui-gear"></span>&nbsp;&nbsp;Change</span>
						
						<input type="file" name="file" id="logo-file-id"/>
						<input type="hidden" id="fui-fileinput-imageUpload-home" value="<?php echo $home; ?>"/>
						<input type="hidden" name="hidden_eid" value="<?php echo $eid; ?>"/>
					</span>
					<a href="#" class="btn btn-primary btn-embossed fileinput-exists" data-dismiss="fileinput">
						<span class="fui-trash"></span>&nbsp;&nbsp;Remove
					</a>
				</div>
			</form>
		</div>
	</div>

	<div class="ordered-photo">
		<form method="post">
			<ul class="ul-ordered-photo">
<?php foreach ($photo_list as $photo) { ?>
				<li>
					<img style="width: auto; cursor: pointer;" src="<?php echo $home . $photo['image']; ?>" title="<?php echo $photo['title']; ?>" alt="<?php echo $photo['alt']; ?>" onclick="show_photo_large('e_detail_full_image', <?php echo $photo['photo_id']; ?>, '<?php echo $home; ?>')"><br>
					<p style="color: #999; font-size: 0.8rem;"><?php echo $photo['ctime']; ?></p>
					<input type="checkbox" style="display: none;" name="delete_photo[]" value="<?php echo $photo['photo_id']; ?>">
				</li>
<?php } ?>
				<input type="submit" name="submit_delete_photo" style="display: none; position: fixed; top: 25%; left: 7%;" class="general-button-pink">
			</ul>
		</form>
		<footer class="more-photo">
<?php if (isset($next) && $next != "") { ?>
			<a href="javascript:" style="display: none;" id="load-more-photo" onclick="<?php echo $next; ?>">查看更多</a>
<?php } ?>
		</footer>
	</div>
</section>