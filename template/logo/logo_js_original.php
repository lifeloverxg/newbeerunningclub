<script>
$("#image-preview")
.ready(
	   function() {
	   var dragging = false;
	   var startX = 0;
	   var startY = 0;
	   var originX = 0;
	   var originY = 0;
	   var newX = 0;
	   var newY = 0;
	   var scale = 100;
	   var isFirstClick = true;
	   $("#image-preview")
	   .mousedown(
				  function(event) {
				  dragging = true;
				  startX = event.offsetX;
				  startY = event.offsetY;
				  
				  originX = $("#image-preview").css('backgroundPosition').split(' ')[0];
				  originY = $("#image-preview").css('backgroundPosition').split(' ')[1];
				  originX = parseFloat(originX.replace("px", ""));
				  originY = parseFloat(originY.replace("px", ""));
				  });
	   $("#image-preview")
	   .mouseup(
				function(event) {
				dragging = false;
				});
	   $("#image-preview")
	   .mouseleave(
				   function(event) {
				   dragging = false;
				   });
	   $("#image-preview")
	   .mousemove(
				  function(event) {
				  if (dragging) {
				  var mouseX = event.offsetX;
				  var mouseY = event.offsetY;
				  newX = originX + mouseX - startX;
				  newY = originY + mouseY - startY;			
				  $("#image-preview").css("backgroundPosition", newX+"px "+newY+"px");
				  }
				  var inputX = -newX*<?php echo $wid; ?>*100/parseFloat($("#image-preview").css("width").replace("px",""))/scale;
				  var inputY = -newY*<?php echo $wid; ?>*100/parseFloat($("#image-preview").css("width").replace("px",""))/scale;
				  if (isNaN(inputX)) inputX = 0;
				  if (isNaN(inputY)) inputY = 0;
				  $("input[name=x]").val(inputX);
				  $("input[name=y]").val(inputY);
				  $("input[name=scale]").val(scale);
				  });
	   $("#image-preview")
	   .bind('mousewheel', 
			 function(event) {
			 scale = $("#image-preview").css("backgroundSize");
			 scale = parseFloat(scale.replace("%", ""));
			 if (event.originalEvent.wheelDelta/120 > 0) {
			 scale = scale + 10;
			 $("#image-preview").css("backgroundSize", scale+"%");
			 }
			 else{
			 scale = scale - 10;
			 if (scale < 50) scale = 50;
			 $("#image-preview").css("backgroundSize", scale+"%");
			 }
			 console.log(scale);
			 $("input[name=r]").val(<?php echo $wid; ?>*100/scale);
			 $("input[name=scale]").val(scale);
			 });
	   $("button[name=zoom_in]")
	   .click(function() {
				if ( isFirstClick )
				{
					$("#image-preview").css("background-size", "100%");
					isFirstClick = false;
				}
					scale = $("#image-preview").css("backgroundSize");
					scale = parseFloat(scale.replace("%", ""));
					scale = scale + 10;
					$("#image-preview").css("backgroundSize", scale+"%");
					$("input[name=r]").val(<?php echo $wid; ?>*100/scale);
					$("input[name=scale]").val(scale);
				});
	   $("button[name=zoom_out]")
	   .click(function() {
				if ( isFirstClick )
				{
					$("#image-preview").css("background-size", "100%");
					isFirstClick = false;
				}
					scale = $("#image-preview").css("backgroundSize");
					scale = parseFloat(scale.replace("%", ""));
					scale = scale - 10;
					if (scale < 50) scale = 50;
					$("#image-preview").css("backgroundSize", scale+"%");
					$("input[name=r]").val(<?php echo $wid; ?>*100/scale);
					$("input[name=scale]").val(scale);
			  });
	   $("button[name=move_up]")
	   .click(function() {
			  newY = newY - 10;
			  $("#image-preview").css("backgroundPosition", newX+"px "+newY+"px");
			  var inputY = -newY*<?php echo $wid; ?>*100/parseFloat($("#image-preview").css("width").replace("px",""))/scale;
			  if (isNaN(inputY)) inputY = 0;
			  $("input[name=y]").val(inputY);
			  });
	   $("button[name=move_down]")
	   .click(function() {
			  newY = newY + 10;
			  $("#image-preview").css("backgroundPosition", newX+"px "+newY+"px");
			  var inputY = -newY*<?php echo $wid; ?>*100/parseFloat($("#image-preview").css("width").replace("px",""))/scale;
			  if (isNaN(inputY)) inputY = 0;
			  $("input[name=y]").val(inputY);
			  });
	   $("button[name=move_left]")
	   .click(function() {
			  newX = newX - 10;
			  $("#image-preview").css("backgroundPosition", newX+"px "+newY+"px");
			  var inputX = -newX*<?php echo $wid; ?>*100/parseFloat($("#image-preview").css("width").replace("px",""))/scale;
			  if (isNaN(inputX)) inputX = 0;
			  $("input[name=x]").val(inputX);
			  });
	   $("button[name=move_right]")
	   .click(function() {
			  newX = newX + 10;
			  $("#image-preview").css("backgroundPosition", newX+"px "+newY+"px");
			  var inputX = -newX*<?php echo $wid; ?>*100/parseFloat($("#image-preview").css("width").replace("px",""))/scale;
			  if (isNaN(inputX)) inputX = 0;
			  $("input[name=x]").val(inputX);
			  });
	   });
</script>