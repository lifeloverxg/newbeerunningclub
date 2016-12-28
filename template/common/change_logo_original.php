<?php
//==================================================
// change_logo.php
// 上传图片main html
// originally by Oyster
// Edit and Format by Junxiao Yi
//==================================================
?>
		<div class="div-image-upload">
			<header>
				<h1>上传图片</h1>
			</header>
			<div class="image-upload-preview">
				<div id="image-preview" style="background-image: url(<?php echo isset($preview_file)?$home.$preview_file:$home.DefaultImage::People.'_large.jpg'; ?>)">
				</div>
				<article>
					<form id="change-logo-form" action="" method="post" enctype="multipart/form-data">
<?php if (isset($show_op) && $show_op) { ?>
						<div class="div-upload-btn">
							<input type="file" id="upload_file" class="image_file" name="upload_image" onchange="this.form.submit()">
							<span>上传图片</span>
						</div>
						
						<input type="submit" class="image_form" name="done_clip" value="确定提交" method="post" />
						<input type="hidden" value="0" name="x" />
						<input type="hidden" value="0" name="y" />
						<input type="hidden" value="<?php echo $wid; ?>" name="r" />
						<input type="hidden" value="<?php echo $hid; ?>" name="t" />
						<input type="hidden" value="<?php echo $id; ?>" name="id" />
						<input type="hidden" value="<?php echo $scale; ?>" name="scale" />
						<input type="hidden" value="<?php echo $preview_file; ?>" name="preview_file" />

						<table class="ctrl-panel">
							<tbody>
								<tr>
									<td>
									</td>
									<td>
										<button type="button" name="move_up"><img src="<?php echo $home; ?>theme/glyphicons/png/glyphicons_213_up_arrow.png"></button>
									</td>
									<td>
									</td>
									<td>
									</td>
									<td>
										<button type="button" name="zoom_in"><img src="<?php echo $home; ?>theme/glyphicons/png/glyphicons_236_zoom_in.png"></button>
									</td>
								</tr>
								<tr>
									<td>
										<button type="button" name="move_left"><img src="<?php echo $home; ?>theme/glyphicons/png/glyphicons_210_left_arrow.png"></button>
									</td>
									<td>
										<button type="button" name="move_down"><img src="<?php echo $home; ?>theme/glyphicons/png/glyphicons_212_down_arrow.png"></button>
									</td>
									<td>
										<button type="button" name="move_right"><img src="<?php echo $home; ?>theme/glyphicons/png/glyphicons_211_right_arrow.png"></button>
									</td>
									<td>
									</td>
									<td>
										<button type="button" name="zoom_out"><img src="<?php echo $home; ?>theme/glyphicons/png/glyphicons_237_zoom_out.png"></button>
									</td>
								</tr>
							</tbody>
						</table>
<?php } ?>
						<!-- <input type="submit" class="image_form" name="skip_avatar" value="跳过此步"method="post" /> -->

						<ul class="ul-error-message">
<?php foreach ($upload_error as $value) { ?>
							<li>
<?php echo $value; ?>
							</li>
<?php } ?>
						</ul>
					</form>
				</article>
			</div>
		</div>