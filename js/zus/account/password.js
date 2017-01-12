/*Created by Junxiao Yi on Mar 15 2014*/
/*+++++++++++++++password functions+++++++++++++++*/

/*++++++++++find password++++++++++*/
function findpassword()
{ 
    var email = $("#email").val(); 
    console.log(email);
    var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //匹配Email 

    var html = "正在提交中, 请稍等"+"<img src='../theme/images/account/ellipsis.gif'/>";
    if(email=='' || !preg.test(email))
    { 
        $("#chkmsg").html("请填写正确的邮箱！"); 
    }
    else
    {
        $("#sub_btn").attr("disabled","disabled").val('提交中..').css("cursor","default"); 
        $("#chkmsg").html(html);

        $.ajax({
			url: '../cgi/account/findpwd.php',
			type: 'POST',
			dataType: 'text',
			data: {
					'email': email,
			},
			success: function(data)
			{
				var obj = eval('(' + data + ')');
				console.log(obj.args);	
				if (obj.error == "none")
				{
					//++++++++++++++ 之前的 +++++++++++++++
					// $("#chkmsg").html(obj.args.list);
					// if (obj.args.param)
					// {
					// 	$("#sub_btn").attr("disabled","disabled").val('已提交').css("cursor","default");
					// }
					// else
					// {
					// 	$("#sub_btn").removeAttr("disabled").val('再次提交').css("cursor", "pointer");
					// 	$("#email").val("");
					// }
					// $("#sub_btn").removeAttr("disabled").val('已提交').css("cursor","pointer");
					// ============ 之前的 ==================
					if (obj.args.param)
					{
						window.location.href = "../account/resetpwd.php?code="+obj.args.urlcode;
					}
					else
					{
						$("#chkmsg").html(obj.args.list);
						$("#sub_btn").removeAttr("disabled").val('再次提交').css("cursor", "pointer");
						$("#email").val("");
					}
					// $("#sub_btn").removeAttr("disabled").val('已提交').css("cursor","pointer");
				}	
			},
			error: function(data)
			{
				serverError(null);
				$("#sub_btn").removeAttr("disabled").val('再次提交').css("cursor", "pointer");
			}
		})
    } 
}
/*==========find password==========*/

/*++++++++++reset password++++++++++*/
function resetpassword()
{
	$("#chkmsg").html("");
	var email = $("#email").val();
	console.log(email);
	var password = $("#password").val();
	var pass = $("#pass").val();
	if ( (password.length >= 8) && (pass.length >= 8) && (pass=password) )
	{
		$("#sub_btn").attr("disabled","disabled").val('提交中..').css("cursor","default");

		$.ajax({
			url: "../cgi/resetpwd.php",
			type: "POST",
			dataType: 'text',
			data: {
				"email": email,
				"password": password,
				"pass": pass
			},
			success: function(data){
				console.log(data)
				var obj = eval('(' + data + ')')
				if (obj.error == "none")
				{
					$("#chkmsg").html(obj.args.list);
					// $("#sub_btn").removeAttr("disabled").val('已提交').css("cursor","pointer");
					$("#sub_btn").attr("disabled","disabled").val('已提交').css("cursor","default");
				}
			},
			error: function(data){
				serverError(obj)
			}
		})
	}
	else
	{
		if ( password.length<8 )
		{
			$("#chkmsg").html("新密码的长度必须大于或等于8位");
		}
		else if ( pass != password )
		{
			$("#chkmsg").html("两次输入的密码不相同");
		}
	}
}
/*==========reset password==========*/

/*===============password functions===============*/