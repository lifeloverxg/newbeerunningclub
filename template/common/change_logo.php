<?php
//==================================================
// change_logo.php
// 上传图片main html
// Junxiao Yi
//==================================================
?>
	<form name="photo" enctype="multipart/form-data" action="" method="post">
		<input type="file" name="image" size="30" />
		<!-- <input type="submit" name="upload" value="上传" /> -->
		<div class="add-event-btn">
            <a href="javascript: " onclick="photo_upload_btn()">
                <div class="tagsinput-add"> 上传 </div>
            </a>
        </div>
		<input type="submit" style="display:none;" name="upload" id="photo-upload-submit" value="上传" />
		<h6>点击上传后若图片未更新请手动刷新页面</h6>
	<!-- </form> -->
<?php
if ( strlen($error)>0 )
{
	echo "<ul><li><strong>上传失败!</strong></li><li>".$error."</li></ul>";
}
?>
<?php
//Display error message if there are any
	if ( strlen($large_photo_exists)>0 )
	{
?>
		<h6>开始裁剪(可以放大,缩小,拖动,当前设置比例为3:2)</h6>
		<!-- <h4></h4> -->
		<div align="center">
			<img src="<?php echo $large_image_location;?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" />
			
			<!-- test -->


			<!-- test -->

			<div style="float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;">
				<img src="<?php echo $large_image_location;?>" style="position: relative;" alt="Thumbnail Preview" />
			</div>
			
			<br style="clear:both;"/>
			
			<!-- <form name="thumbnail" action="" method="post"> -->
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="submit" name="upload_thumbnail" value="保存图片" id="save_thumb" />
			</form>
		</div>
	<hr />

	<div style="display: block; width: <?php echo $width; ?>; height: <?php echo $height; ?>; background-image: url(<?php echo $large_image_location; ?>); background-size: 300px 200px;"></div>
<?php 
} 
?>


