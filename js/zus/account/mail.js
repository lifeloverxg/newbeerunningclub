/*+++++++++++++++mail functions+++++++++++++++*/
/*Created by Junxiao Yi on April 25 2014*/

/*++++++++++ event - send - groupmail ++++++++++*/
function send_event_groupmail(maillist)
{
	var mailto = $("#mail_oper_receiver").val(); 
	var mailsubject = $("#mail_oper_subject").val();
	var mailcontent = $("#mail_oper_content").val();

	mail_list = maillist.split('yiuniim');

	var list_length = mail_list.length;

	var count = 0;

	/*+++++如果收件人不是To: All的情况,要一一验证邮件+++++*/
    //var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //匹配Email 
    //if(email=='' || !preg.test(email))
    //{ 
     //   $("#chkmsg").html("请填写正确的邮箱！"); 
    //}
    /*=====如果收件人不是To: All的情况,要一一验证邮件=====*/
    
    if (list_length == 0)
    {
    	$("#chkmsg").html("该活动没有参与者!");
    }
    if (mailto == '')
    {
    	$("#chkmsg").html("Wrong!");
    }
    else if (mailsubject == '')
    {
    	$("#chkmsg").html("请填写邮件主题");
    }
    else if (mailcontent == '')
    {
    	$("#chkmsg").html("邮件内容不能为空");
    }
    else if (mailto == 'To: All')
    {
    	$("#chkmsg").html("正在提交中,请稍等...");
        for (count; count<=(list_length-1); count++)
        {
        	$.ajax({
					url: '../cgi/account/send_event_groupmail.php',
					type: 'POST',
					dataType: 'text',
					data: {
							'mailto': mail_list[count],
							'subject': mailsubject,
							'content': mailcontent,
							'list_length': list_length,
							'count': count,
					},
					success: function(data)
					{
						var obj = eval('(' + data + ')');
						console.log(obj.args);	
						if (obj.error == "none")
						{
							if ( obj.args.count < (obj.args.list_length) )
							{
								$("#chkmsg").html(obj.args.list);
								$("#sub_btn").attr("disabled","disabled").val('正在发送第'+(obj.args.count+1)+'封...').css("cursor","default").css("width","50%").css("margin","10px 10px 0px 50%"); 
							}
							else
							{
								$("#chkmsg").html("已完成发送所有邮件");
								$("#sub_btn").attr("disabled","disabled").val('已完成').css("cursor","default").css("width","20%").css("margin","10px 10px 0px 80%"); 
							}
							
							// $("#sub_btn").removeAttr("disabled").val('已提交').css("cursor","pointer");
							
						}	
					},
					error: function(data)
					{
						alert("Hello World!");
						serverError(null);
						$("#sub_btn").removeAttr("disabled").val('再次提交').css("cursor", "pointer");
					}
			})
        }
    }
    //如果收件人不是To: All的情况, 只针对该接受人或这些接受人进行处理
    else
    {
        $("#sub_btn").attr("disabled","disabled").val('提交中..').css("cursor","default"); 
        $("#chkmsg").html("正在提交中,请稍等...");

        $.ajax({
			url: '../cgi/findpwd.php',
			type: 'POST',
			dataType: 'text',
			data: {
					'email': email,
			},
			success: function(data){
				var obj = eval('(' + data + ')');
				console.log(obj.args);	
				if (obj.error == "none")
				{
					$("#chkmsg").html(obj.args.list);
					if (obj.args.param)
					{
						$("#sub_btn").attr("disabled","disabled").val('已提交').css("cursor","default");
					}
					else
					{
						$("#sub_btn").removeAttr("disabled").val('再次提交').css("cursor", "pointer");
						$("#email").val("");
					}
					// $("#sub_btn").removeAttr("disabled").val('已提交').css("cursor","pointer");
					
				}	
			},
			error: function(data){
				serverError(null);
			}
		})
    } 
}
/*========== event - send - groupemail ==========*/

/*++++++++++ paypal_free_order ++++++++++*/
// function paypal_free_order(home, pid, eid, email, allowance)
// {
// 	var html = "正在提交中, 请稍等"+"<img src='../theme/images/account/ellipsis.gif'/>";
// 	var item_name = '';
// 	var item_name_temp = '';
// 	var quantity = 0;
// 	var items = '';
// 	var num_cart_items = 0;

// 	for ( var m = 1; m <= allowance; m++ )
// 	{
// 		item_name_temp = $("input[name='item_name_"+m+"']").val();
// 		if ( !(typeof(item_name_temp) == "undefined") && (item_name_temp != '') )
// 		{
// 			item_name = $("input[name='item_name_"+m+"']").val();
// 			quantity = $("input[name='quantity_"+m+"']").val();
// 			items += item_name+'uni_sm'+quantity+'uni_lg';

// 			num_cart_items += 1;
// 		}
// 	}

// 	// var flag_nozero_quantity = $("#nozero-flag-quantity").val();

//     if ( email == '' )
//     { 
//         $("#chkmsg").html("您的注册邮箱是无效邮箱！"); 
//     }
//     else
//     {
//         $(".btn-primary").attr("disabled","disabled").val('提交中..').css("cursor","default"); 
//         $("#chkmsg").html(html);

//         $.ajax({
//         	timeout: 25000,
// 			url: '../cgi/account/paypal_free_order.php',
// 			type: 'POST',
// 			dataType: 'text',
// 			data: {
// 					'email': email,
// 					'pid': pid,
// 					'eid': eid,
// 					'num_cart_items': num_cart_items,
// 					'items': items,
// 			},
// 			success: function(data)
// 			{
// 				var obj = eval('(' + data + ')');
// 				if (obj.error == "none")
// 				{
// 					$("#chkmsg").html(obj.args.list);
// 					if (obj.args.param)
// 					{
// 						$(".btn-primary").attr("disabled","disabled").val('已提交').css("cursor","default");
// 						$(".btn-default").attr("disabled","disabled").css("display","none");
// 						setTimeout("top.location.href='" + home + "event/detail.php?eid=" + obj.args.eid + "'", 3000);
// 					}
// 					else
// 					{
// 						$(".btn-primary").removeAttr("disabled").val('再次提交').css("cursor", "pointer");
// 						$("#email").val("");
// 					}
// 				}	
// 			},
// 			error: function(data)
// 			{
// 				//serverError(null);
// 				$("#chkmsg").html("已完成");
// 				// $(".btn-primary").removeAttr("disabled").val('再次提交').css("cursor", "pointer");
// 			}
// 		})
//     }
// }
function paypal_free_order(home, pid, eid, email, allowance)
{
	var html = "正在提交中, 请稍等"+"<img src='../theme/images/account/ellipsis.gif'/>";
	var item_name = '';
	var item_name_temp = '';
	var quantity = 0;
	var items = '';
	var num_cart_items = 0;

	for ( var m = 1; m <= allowance; m++ )
	{
		item_name_temp = $("input[name='item_name_"+m+"']").val();
		if ( !(typeof(item_name_temp) == "undefined") && (item_name_temp != '') )
		{
			item_name = $("input[name='item_name_"+m+"']").val();
			quantity = $("input[name='quantity_"+m+"']").val();
			items += item_name+'uni_sm'+quantity+'uni_lg';

			num_cart_items += 1;
		}
	}

	// var flag_nozero_quantity = $("#nozero-flag-quantity").val();

    if ( email == '' )
    { 
        $("#chkmsg").html("您的注册邮箱是无效邮箱！"); 
    }
    else
    {
        $(".btn-primary").attr("disabled","disabled").val('提交中..').css("cursor","default"); 
        $("#chkmsg").html(html);

        $.ajax({
        	timeout: 25000,
			url: '../cgi/account/paypal_free_order.php',
			type: 'POST',
			dataType: 'text',
			data: {
					'email': email,
					'pid': pid,
					'eid': eid,
					'num_cart_items': num_cart_items,
					'items': items,
			},
			success: function(data)
			{
				var obj = eval('(' + data + ')');
				if (obj.error == "none")
				{
					$("#chkmsg").html(obj.args.list);
					if (obj.args.param)
					{
						$(".btn-primary").attr("disabled","disabled").val('已提交').css("cursor","default");
						$(".btn-default").attr("disabled","disabled").css("display","none");
						setTimeout("top.location.href='" + home + "event/detail.php?eid=" + obj.args.eid + "'", 3000);
					}
					else
					{
						$(".btn-primary").removeAttr("disabled").val('再次提交').css("cursor", "pointer");
						$("#email").val("");
					}
				}	
			},
			error: function(data)
			{
				//serverError(null);
				$("#chkmsg").html("已完成");
				// $(".btn-primary").removeAttr("disabled").val('再次提交').css("cursor", "pointer");
			}
		})
    }
}
/*========== paypal_free_order ==========*/

/*===============mail functions===============*/