function spec_add_feed()
{
	$(".comment_textarea").autoResize({
	                // On resize:
	                onResize : function() {
	                        $(this).css({opacity:0.8});
	                },
	                // After resize:
	                animateCallback : function() {
	                        $(this).css({opacity:1});
	                },
	                // Quite slow animation:
	                animateDuration : 100,
	                // More extra space:
	                extraSpace : 0
        });
	var username = $("#user").val();
	var event = $("#event").val();
	var group = $("#group").val();
	var feed = $("#comment-textarea").val();

    if ( username == '' )
    { 
        $("#chkmsg").html("请填写您的名字"); 
    }
    else if ( event == '' )
    {
    	$("#chkmsg").html("请填写您想要的活动");
    }
    else if ( group == '' )
    {
    	$("#chkmsg").html("请填写您想要的群组");
    }
    else if ( feed == '' )
    {
    	$("#chkmsg").html("请填写您想要对我们说的话");
    }
    else
    {
        $("#sub_btn").attr("disabled","disabled").val('提交中..').css("cursor","default"); 
        
        $.ajax({
			url: '../cgi/spec_add_feed.php',
			type: 'POST',
			dataType: 'text',
			data: {
					'username': username,
					'event': event,
					'group': group,
					'feed': feed,
			},
			success: function(data){
				var obj = eval('(' + data + ')');
				console.log(obj.args);	
				if (obj.error == "none")
				{
					$(".ul-spec-feed-list-large").prepend(obj.args.list);
					$("#chkmsg").html(obj.args.success);
					// $("#sub_btn").removeAttr("disabled").val('已提交').css("cursor","pointer");
					$("#sub_btn").attr("disabled","disabled").val('已提交').css("cursor","default");
				}	
			},
			error: function(data){
				serverError(null);
			}
		})
    }

}