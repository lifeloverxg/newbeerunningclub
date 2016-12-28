// function init() 
// {
// 	$('.div-signin input').keypress(submitSignIn);
// 	$('.div-signup input').keypress(submitSignUp);
// }

function signin(home)
{
	// #0 get input value
	var username = $('.div-signin input[name="username"]').val();
	var pass = $('.div-signin input[name="pass"]').val();
	var rempwd = 0;
	if ( $("#savepassbox").is(':checked') )
	{
		rempwd = 1;
	}
	
	var type = "signin";

	$.ajax({
		url: home+"cgi/auth_sign.php",
		type: "POST",
		dataType: 'text',
		data: {
			"username": username,
			"pass": pass,
			"rempwd": rempwd,
			"type": type,
		},
		success: function(data){
			console.log(data);
			var obj = eval('(' + data + ')');
			if (obj.error == 'error')	
			{
				displaySignInErrors(obj);
			}
			else
			{
				if ( rempwd == 1 )
				{
					var expireTime = new Date().getTime() + 3*30*24*3600*1000;
					document.cookie="username="+username+";expires="+date.toGMTString();
					document.cookie="password="+pass+";expires="+date.toGMTString();
				}
				else
				{
					
				}	
				url = "event/index.php";
				window.location.href = url;
				console.log(rempwd);
			}				
		},
		error: function(data){
			serverError(obj);
		}
	})
}

function signup(home){
	if ($('.div-signup input[name="pass"]').val() != $('.div-signup input[name="pass2"]').val())
	{
		$('.div-signup>.ul-error-message').html('<li>两次密码输入不一致</li>');
		return;
	}
	$.ajax({
		url: home+"cgi/auth_sign.php",
		type: "POST",
		dataType: 'text',
		data: {
			"email": $('.div-signup input[name="email"]').val(),
			"username": $('.div-signup input[name="username"]').val(),
			"pass": $('.div-signup input[name="pass"]').val(),
			"invitecode": $('.div-signup input[name="invitecode"]').val(),
			"type": "signup"
		},
		success: function(data){
			var obj = eval('(' + data + ')')
			if (obj.error == 'error')
			{
				displaySignUpErrors(obj);
			}
			else
			{
				url = "event/index.php";
				window.location.href = url;
			}
		},
		error: function(data){
			serverError(obj)
		}
	})
}

function submitSignIn(event) 
{
	if (event.which == 13) 
	{
		signin();
		return false;
	}
}

function submitSignUp(event) 
{
	if (event.which == 13) 
	{
		signup();
		return false;
	}
}

function displaySignInErrors(obj) 
{
	console.log(obj)
	var errors = obj.error_messages
		, html = ""
	for (var i = 0; i < errors.length; i++)
		html += '<li>' + errors[i] + '</li>'
	$('.div-signin>.ul-error-message').fadeOut(500).fadeIn(500)
	$('.div-signin>.ul-error-message').html(html)
}

function displaySignUpErrors(obj) 
{
	console.log(obj)
	var errors = obj.error_messages
		, html = ""
	for (var i = 0; i < errors.length; i++)
		html += '<li>' + errors[i] + '</li>'
	$('.div-signup>.ul-error-message').html(html)
}
