// page onsite redirect

/*++++++++++++++++++holy shit!!!!!!!!!!!!!!!!!!!!!+++++++++++++++++*/
// function visit(url)
// {
// 	window.location.href='<?php echo $home; ?>'+url;  //在javascript里嵌套php是要闹哪样?!!!
// }
/*=================holy shit!!!!!!!!!!!!!!!!!!!!!================*/

// change view tab
function changeViewTab(classPrefix, tabId)
{
	$(classPrefix).addClass('back');
	$(classPrefix+'.tab-'+tabId).removeClass('back');
}

//Page Initialization
$(function() {
	jQuery.fn.isChildOf = function(b){ return (this.parents(b).length > 0); }; 
	jQuery.fn.isChildAndSelfOf = function(b){ return (this.closest(b).length > 0); };

	$(".div-popup").click(function(event) {
        if (!$(event.target).isChildAndSelfOf(".popup-main"))
           hidePopup('.div-popup');
    });

	/*+++++popup small+++++*/
    $(".div-popup-small").click(function(event) {
        if (!$(event.target).isChildAndSelfOf(".popup-small"))
           hidePopup('.div-popup-small');
    });
    /*=====popup small=====*/
    /*+++++popup login_panel+++++*/
    $(".div-popup-login_panel").click(function(event) {
        if (!$(event.target).isChildAndSelfOf(".popup-login_panel"))
           hidePopup('.div-popup-login_panel');
    });
    /*=====popup login_panel=====*/

    /*+++++popup setting_panel+++++*/
    $(".div-popup-setting_panel").click(function(event) {
        if (!$(event.target).isChildAndSelfOf(".popup-setting_panel"))
           hidePopup_setting('.div-popup-setting_panel');
    });
    /*=====popup login_panel=====*/

	$(".div-search-catalog>select").ready(function(event) {
    	$(".div-search-catalog>div").text($(".div-search-catalog>select>option[value="+$(".div-search-catalog>select").val()+"]").text());
    });
    $(".div-search-catalog>select").change(function(event) {
    	$(".div-search-catalog>div").text($(".div-search-catalog>select>option[value="+$(".div-search-catalog>select").val()+"]").text());
    });

 //    $(".panel-user-main").ready(function(){
	// 	$(".panel-user-main nav").hide();
	// 	$('.panel-user-main .m-header-logo').click(function(e)
	// 	{
	// 		$(".panel-user-main nav").slideToggle();
	// 		e.stopPropagation();
	// 	})
	// 	$('.panel-user-main .m-header-span').click(function(e)
	// 	{
	// 		$(".panel-user-main nav").slideToggle();
	// 		e.stopPropagation();
	// 	})
	// 	$(document).click(function() {
 //                $(".panel-user-main nav").hide();
 //            });
	// });
		// $('.panel-user-main .m-header-logo').click(function(e)
		// {
		// 	$(".panel-user-main nav").toggle(function(){
		// 		$(".panel-user-main nav").show();
		// 	},
		// 	function(){
		// 		$(".panel-user-main nav").hide();
		// 	}
		// 	);
		// 	// e.stopPropagation();
		// });
		// $('.panel-user-main .m-header-span').click(function(e)
		// {
		// 	$(".panel-user-main nav").slideToggle();
		// 	e.stopPropagation();
		// });
		// $(document).click(function() {
  //               $(".panel-user-main nav").hide();
  //           });

    $('img').error(function() {
    	$(this).attr('src', '../theme/images/default/default_error.jpg')
    })

    try {
    	init();
    }
    catch(e) {}
});

function serverError(obj){
	alert("Server Error!");
}

function dataError(obj){
	alert("Data Error!");
}

function refreshPage(obj) 
{
	var hash = window.location.hash;

	if ( !(typeof(obj.args.url_address) == "undefined") && (obj.args.url_address != '') )
	{
		window.location.href = obj.args.url_address;
	}
	else if ( !(typeof(obj.args.message) == "undefined") && (obj.args.message != '') )
	{
		if ( obj.args.message )
		{
			alert('更改成功');
			window.location.href = window.location.href;
		}
		else
		{
			alert('没有更改成功');
			// window.location.href = window.location.href;
		}
	}
	else if (hash == '')
	{
		// for (var i in obj.args)
		// {
		// 	alert(i);
		// }
		window.location.href = window.location.href;
	}
	else
	{
		/*
		var url_temp = window.location.href;
		var url_temp_array_hash = url_temp.split('#');
		var url_hash = url_temp_array_hash[1];
		var url_temp_array_split = url_hash.split('/');
		var url_key = url_temp_array_split[0];
		var url_sindex = url_temp_array_split[1];
		var key_array = url_key.split('key=');
		var sindex_array = url_sindex.split('sindex=');
		var keyword = key_array[1];
		var sindex = sindex_array[1];
		*/
		var arr = getUrlHash();
		keyword = arr[0];
		sindex = arr[1];
		update_search_category(keyword, sindex);
	}
}

function action(actionName, success, error, type, formData){
	$.ajax({
		url: "../cgi/" + actionName + ".php",
		type: type,
		dataType: 'text',
		data: formData,
		success: function(data){
			console.log("### " + actionName + " ###");
			console.log(data);
			console.log("########################");
			var obj = eval('(' + data + ')');
			if (obj.error == "none"){
				success(obj);
			}
			else if (obj.error == "server"){
				serverError(obj);
			}
			else if (obj.error == "data"){
				error(obj);
			}
		},
		error: function(data){
			serverError(obj);
		}
	});
}


//Basic functions
function showPopup (e) {
	//$("body>header").addClass('back-popup');
	//$("body>section>*:not(.div-popup)").addClass('back-popup');
	//$("body>footer").addClass('back-popup');
	$(e).css("position", "fixed");
	$(e).css("left", "0");
	$(e).css("right", "0");
}

function showPopup_setting (e) 
{
	//$("body>header").addClass('back-popup');
	//$("body>section>*:not(.div-popup)").addClass('back-popup');
	//$("body>footer").addClass('back-popup');
	$(e).css("display", "block");
}

function hidePopup (e) {
	// $("body>header").removeClass('back-popup');
	// $("body>section>*:not(.div-popup)").removeClass('back-popup');
	// $("body>footer").removeClass('back-popup');
	$(e).css("position", "absolute");
	$(e).css("left", "-10000px");
	$(e).css("right", "none");
}

function hidePopup_setting (e) {
	// $("body>header").removeClass('back-popup');
	// $("body>section>*:not(.div-popup)").removeClass('back-popup');
	// $("body>footer").removeClass('back-popup');
	$(e).css("display", "none");
}

/*++++++++++显示登录/注册窗口++++++++++*/
function show_login_panel()
{
	showPopup("#show-login_panel");
}

function show_setting_panel()
{
	showPopup_setting("#show-setting_panel");
	$(document).click(function() {
                $("#show-setting_panel").hide();
            });
	$('#img-header-logo-setting').click(function(e)
	{
		$("#show-setting_panel").show();
		e.stopPropagation();
	})
}

function show_setting_panel_x()
{
	// alert("hello world!");
	$(".panel-user-main nav").slideToggle();

	// stopPropagation();

	// $(document).click(function() {
 //                $(".panel-user-main nav").css("display", "none");
 //            });
}

function switchSign(i)
{
	if (i%2 == 0)
	{
		$(".div-signin").addClass('back');
		$(".div-signup").removeClass('back');
		// document.title = "注册 ZUS";
	}
	else
	{
		$(".div-signup").addClass('back');
		$(".div-signin").removeClass('back');
		// document.title = "登陆 ZUS";
	}	
}

function textToggle() {
	$("#hide-text").toggle();
	$("#down-icon").toggle();
	$("#up-icon").toggle();
}

function mPhotoListTabRight(id) {
	var idleft = '#' + id + '-left';
	var idright = '#' + id + '-right';
	$(idleft).addClass('back');
	$(idright).removeClass('back');
}

function mPhotoListTabLeft(id) {
	var idleft = '#' + id + '-left';
	var idright = '#' + id + '-right';
	$(idleft).removeClass('back');
	$(idright).addClass('back');
}

/*++++++++++++++++++++++++++++++<manage function>++++++++++++++++++++++++++++++*/
//People Functions
function friend_oper(pid, tpid, oper) {
	action(
		"friend_oper",
		refreshPage,
		// refreshfriendOper,
		dataError,
		"POST", 
		{
		   "pid": pid,
		   "tpid": tpid,
		   "oper": oper
		}
	);
}

function refreshfriendOper()
{

}


//Group Functions
function group_oper(pid, gid, oper) {
	action(
		"group_oper",
		refreshPage,
		dataError,
		"POST", 
		{
		   "pid": pid,
		   "gid": gid,
		   "oper": oper
		}
	);
}

function gmember_oper(pid, tpid, gid, oper) {
	action(
		"gmember_oper",
		refreshPage,
		dataError,
		"POST",
		{
		   "pid": pid,
		   "tpid": tpid,
		   "gid": gid,
		   "oper": oper
		}
	);
}

function url_check(url)
{
	url = url.match(/^http:\/\/.+\..+/i);
    if (str == null)
    {
	    return false;
	}
	else
	{
	    return true;
	}
}

//Event Functions
function event_oper(pid, eid, oper)
{
	if (oper == 'manage_sale')
	{
		var address = $("input[name='edit_eventbrite_sale_address']").val();

		if ( !url_check(address) )
		{
			alert('地址不是有效地址');
			return 0;
		}

		if ( address != '' )
		{
			action(
				"event_oper",
				refreshPage,
				dataError,
				"POST", 
				{
				   "pid": pid,
				   "eid": eid,
				   "oper": oper,
				   "address": address
				}
			);
		}
		else
		{
			alert("亲爱的, 你没有输入任何有效的地址诶");
		}		
	}
	else
	{
		action(
			"event_oper",
			refreshPage,
			dataError,
			"POST", 
			{
			   "pid": pid,
			   "eid": eid,
			   "oper": oper
			}
		);
	}
}


/*+++++官方售票+++++*/
function event_buy(pid, eid)
{
	console.log(eid);

	$.ajax({
		url: '../cgi/manage_eventbuy.php',
		type: 'POST',
		dataType: 'text',
		data: {
			'pid': pid,
			'eid': eid
		},
		success: function(data){
			console.log(data);
			console.log("########################");
			var obj = eval('(' + data + ')');
			if (obj.error == "none")
			{
				// success(obj);
			}
			var url = obj.args.url_address;
			// alert(url);
			window.location.href=url;
		},
		error: function(data){
			serverError(null);
		}
	})
	// switch (eid)
	// {
	// 	case 59:
	// 		var url = "http://www.eventbrite.com/e/-rifle-shooting-tickets-11847073917";
	// 		window.location.href = url;
	// 		break;
	// 	case 56:
	// 		var url = "http://www.eventbrite.com/e/11847194277?aff=es2&rank=1";
	// 		window.location.href = url;
	// 		console.log('hehe!');
	// 		break;
	// 	case 52:
	// 		var url = "http://www.eventbrite.com/e/11737187243";
	// 		var url_test = '../event/eventbrite.php?eid='+eid;
	// 		console.log('hehe!');
	// 		// window.location.href = url;
	// 		window.location.href = url;
	// 		break;
	// 	case 48:
	// 		var url = 'http://www.eventbrite.com/e/11662852907';
	// 		var url_test = '../event/eventbrite.php?eid='+eid;
	// 		console.log('hehe!');
	// 		window.location.href = url;
	// 		break;
	// 	case 47:
	// 		var url = 'http://www.eventbrite.com/e/2014-tickets-11578201713';
	// 		var url_test = '../event/eventbrite.php?eid='+eid;
	// 		console.log('hehe!');
	// 		window.location.href = url;
	// 		break;
	// 	case 46:
	// 		var url = 'https://www.eventbrite.com/e/11535861071';
	// 		var url_test = '../event/eventbrite.php?eid='+eid;
	// 		console.log('hehe!');
	// 		window.location.href = url;
	// 		break;
	// 	case 28:
	// 		var url = 'http://www.eventbrite.com/e/11039149393?aff=es2&rank=0&sid=92bddbb0b22a11e3840612313b007891';
	// 		var url_test = '../event/eventbrite.php?eid='+eid;
	// 		console.log('hehe!');
	// 		window.location.href = url_test;
	// 		break;
	// 	case 13:
	// 	{
	// 		var url = '../event/eventbrite.php?eid='+eid;
	// 		window.location.href = url;
	// 		break;
	// 	}

	// 	default:
	// 		event_oper(pid, eid, 'join');
	// 		break;
	// }
}

function hellosale(eid)
{
	var type = 'Alex_manage';
	var address = $("input[name='edit_eventbrite_sale_address']").val();
	// alert(address);
	if ( address != '' )
	{
		$.ajax({
				url: '../cgi/manage_eventbuy.php',
				type: 'POST',
				dataType: 'text',
				data: {
					'type': type,
					'eid': eid,
					'address': address
				},
				success: function(data){
					console.log(data);
					console.log("########################");
					var obj = eval('(' + data + ')');
					if (obj.error == "none")
					{
						// success(obj);
					}
					var url = obj.args_2.message;
					// alert(url);
					window.location.href = window.location.href;
				},
				error: function(data){
					serverError(null);
				}
		})
	}
	else
	{
		alert('请填写格式正确的url');
	}
}
/*=====官方售票=====*/

function emember_oper(pid, tpid, eid, oper) 
{
	action(
		"emember_oper",
		refreshPage,
		dataError,
		"POST",
		{
		   "pid": pid,
		   "tpid": tpid,
		   "eid": eid,
		   "oper": oper
		}
	);
}

/*==============================<manage function>==============================*/

function error_redirect()
{
	var str0 = window.location.href;
	var str1 = document.referrer; 
	var str2 = "localhost";
	var str3 = "nycuni.com";
	var str4 = "8541";
	var str5 = "account";

	var self_or_not = strcomp_common(str1, str4) || strcomp_common(str1, str5);
	// alert(self_or_not);

	//for localhost test
	if ( strcomp_common(str1, str2) )
	{
		// alert(document.referrer);
		if ((str0.length > str1.length) || (self_or_not) )
		{
			window.location.href = window.location.href;
		}
		else
		{
			window.location.href = document.referrer;
		}
	}
	//for nycuni.com use
	else if ( strcomp_common(str1, str3) )
	{
		if ( self_or_not )
		{
			window.location.href = window.location.href;
		}
		window.location.href = document.referrer;
	}
	else
	{
		// alert(document.referrer);
		window.location.href = window.location.href;
	}
}

function strcomp_common(str1, str2)
{  
	var s = str1.indexOf(str2); 
	if ( s > 0 )
	{
		return true;
	}
	else
	{
		return false;
	}
}

/*++++++++++++++++++++ header search check ++++++++++++++++++++*/
function header_search_chk(headerSearchFrom)
{
	var message = new String('\nCampos obrigatórios:\n');
	var flag=new Boolean(1);
	var pid = $("#header-search-pid").val();

	if ( 1 == 1 )
	{
		message += '\nNº do processo\n'; 
		flag = new Boolean(0);
	}

	if (flag == false)
	{
		if ( event.preventDefault )
		{
			event.preventDefault();
		}
		else
		{
			event.returnValue = false; // for IE as dont support preventDefault;
		}
		// alert(message);
	}

	search_function_relocation(pid, 2);

	return flag;
}

function header_collapse()
{
	// if ( $("body>section").hasClass("collapse-off") )
	// {
	// 	$("body>section").removeClass("collapse-off").addClass("collapse-on");
	// 	$(".nycuni-header .header-collapse").css("min-height", "800px").css("width", "70%").css("background", "rgba(0, 116, 168, 1)");
	// }
	// else if ( $("body>section").hasClass("collapse-on") )
	// {
	// 	$("body>section").removeClass("collapse-on").addClass("collapse-off");
	// 	$(".nycuni-header .header-collapse").css("min-height", "").css("width", "").css("background", "");
	// }
}

function logo_header_collapse()
{
	// if ( $("#navbar-collapse-01").hasClass('in') )
	$("#navbar-collapse-01").toggleClass("in");
}


function search_function_relocation(pid, mode)
{
	var keyword = ' ';
	var keyword = $("#appendedInputButton-02").val();

	if (mode == 2)
	{
		keyword = $("#navbarInput-01").val();
	}

	if ( (keyword.length > 0))
	{
		keyword = escapeSequenceAway(keyword);
		var url = 'search/detail.php?keyword='+keyword;
		var here = window.location.href;
		window.location.href = "../"+url;
	}
}

/*++++++++++防止转义字符造成的bug++++++++++*/
function escapeSequenceAway(keyword)
{
	var EscapeSequence = '\\';
	var keylength = keyword.length;

	while ( keyword.lastIndexOf(EscapeSequence) == (keyword.length-1) )
	{
		keylength = keyword.length;
		keyword = keyword.substring(0, keylength-1);
	}

	return keyword;
}
/*==========防止转义字符造成的bug==========*/
/*==================== header search check ====================*/

