<?php
	$home = '../';
	include_once ($home.'core.php');

	if (isset($_POST['submit_image']) && $_POST['submit_image']) {
		if ($_FILES['upload_image']['error']) {
			echo 'Upload Error: '.$_FILES['upload_image']['error'];
			return -1;
		}
		else {
			if ($_FILES['upload_image']['type'] != 'image/jpeg') {
				echo 'Only jpg/jpeg Accepted.';
				return -2;
			}
			if ($_FILES['upload_image']['size'] > 64*1024*1024) {
				echo 'At Most 64MB';
				return -3;
			}
			$x = 0;
			$y = 0;
			$r = 500;
			if (isset($_POST['x'])) {
				$x = $_POST['x'];
			}
			if (isset($_POST['y'])) {
				$y = $_POST['y'];
			}
			if (isset($_POST['r'])) {
				$r = $_POST['r'];
			}
			$src = $_FILES['upload_image']['tmp_name'];
			$preview_file = ImageDAO::generate_preview_image($home, $src);
			$file = ImageDAO::clip_save_image($home, Authority::get_uid(), $src, $x, $y, $r);
		}
	}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
	$(function() {
		var dragging = false;
		var startX = 0;
		var startY = 0;
		var originX = 0;
		var originY = 0;
		var newX = 0;
		var newY = 0;
		var scale = 0;
		$("#image-preview").mousedown(function(event) {
			dragging = true;
			startX = event.offsetX;
			startY = event.offsetY;

			originX = $("#image-preview").css('backgroundPosition').split(' ')[0];
			originY = $("#image-preview").css('backgroundPosition').split(' ')[1];
			originX = parseFloat(originX.replace("px", ""));
			originY = parseFloat(originY.replace("px", ""));
		});
		$("#image-preview").mouseup(function(event) {
			dragging = false;
		});
		$("#image-preview").mouseleave(function(event) {
			dragging = false;
		});
		$("#image-preview").mousemove(function(event) {
			if (dragging) {
				var mouseX = event.offsetX;
				var mouseY = event.offsetY;
				console.log(mouseX+", "+mouseY);
				newX = originX + mouseX - startX;
				newY = originY + mouseY - startY;			
				$("#image-preview").css("backgroundPosition", newX+"px "+newY+"px");
			}
			$("input[name=x]").val(-newX);
			$("input[name=y]").val(-newY);
		});
		$("#image-preview").bind('mousewheel', function(event) {
			scale = $("#image-preview").css("backgroundSize");
			scale = parseFloat(scale.replace("%", ""));
			if(event.originalEvent.wheelDelta/120 > 0) {
				scale = scale + 10;
	            $("#image-preview").css("backgroundSize", scale+"%");
	        }
	        else{
	            scale = scale - 10;
	            if (scale < 100) scale = 100;
	            $("#image-preview").css("backgroundSize", scale+"%");
	        }
			$("input[name=r]").val(<?php echo isset($preview_file)?getimagesize($home.$preview_file)[0]:0; ?>/scale*100);
		});


	});
</script>
<div id="image-preview" style="width: 350px; height: 350px; background: url(<?php echo isset($preview_file)?$home.$preview_file:"" ;?>) 0px 0px no-repeat #222; background-size: 100%;">
	
</div>
<form action="test_event_uploader.php" method="post" enctype="multipart/form-data">
<input type="file" name="upload_image" />
<input name="submit_image" type="submit" method="post" />
<input type="hidden" value="0" name="x" />
<input type="hidden" value="0" name="y" />
<input type="hidden" value="<?php echo isset($preview_file)?getimagesize($home.$preview_file)[0]:0; ?>" name="r" />
</form>
