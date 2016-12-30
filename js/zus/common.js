//Page Initialization
$(function() {
	jQuery.fn.isChildOf = function(b){ return (this.parents(b).length > 0); }; 
	jQuery.fn.isChildAndSelfOf = function(b){ return (this.closest(b).length > 0); };

	$(".div-popup").click(function(event) {
        if (!$(event.target).isChildAndSelfOf(".popup-main"))
           hidePopup('.div-popup');
    });

	/*+++++popup normal, no border, no padding+++++*/
    $(".div-popup-normal").click(function(event) {
        if (!$(event.target).isChildAndSelfOf(".popup-normal"))
           hidePopup('.div-popup-normal');
    });
    /*=====popup normal, no border, no padding=====*/

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

	$(".div-search-catalog>select").ready(function(event) {
    	$(".div-search-catalog>div").text($(".div-search-catalog>select>option[value="+$(".div-search-catalog>select").val()+"]").text());
    });
    $(".div-search-catalog>select").change(function(event) {
    	$(".div-search-catalog>div").text($(".div-search-catalog>select>option[value="+$(".div-search-catalog>select").val()+"]").text());
    });

    // $('img').error(function() {
    // 	$(this).attr('src', '../theme/images/default/default_error.jpg');
    // })

	$("#dropdown-nycuni-show-id").mouseenter(function(){
		$(".dropdown-nycuni-show").addClass("open");
	})

	$("#dropdown-nycuni-show-id").mouseleave(function(){
		$(".dropdown-nycuni-show").removeClass("open");
	})

	// today = new Date();
	// var dateString = today.format("d mmmm, yyyy");
	// $("#datepicker-01").val(dateString);
	// $("#datepicker-02").val(dateString);

    try {
    	init();
    }
    catch(e) {}
});

//群组首页动画
$(".ul-browser-list-gr").ready(function() {
	//$(".list-animate").show();
	$(".list-animate").animate({opacity: '1', fontSize: '1rem'}, 800);
	$(".item-left-mid").animate({width: '100%', height: 'auto'}, 800);
});

//相册高度自适应
$(".section-photo-list").ready(function() {
	$("#people-photo-list").height($("#people-photo-list").width()/2);
});

//首页动画
$(".section-home").ready(function() {
	$("#li-recommend-0").animate({left: '0', top: '0'}, 800);
	$("#li-recommend-1").animate({left: '0', top: '0'}, 800);
	$("#li-recommend-2").animate({left: '0', top: '0'}, 800);
	$("#li-recommend-3").animate({left: '0', top: '0'}, 800);
});
// $(".index-cover").ready(function() {
// 	$(".index-cover").click(function() {
//         $(".index-cover").animate({opacity: '0', zIndex: '0'}, 800);
//         $(".index-below").animate({opacity: '1'}, 800);
//         $(".puzzle-top-left").animate({top: '-100px', left: '-200px'}, 800);
//         $(".puzzle-bottom-left").animate({top: '100px', left: '-200px'}, 800);
//         $(".puzzle-bottom-right").animate({top: '100px', left: '200px'}, 800);
//     });
// });

//活动详细页面顶端按钮
$(".section-event-detail-top").ready(function() {
	$("#info-button").click(function() {
		$("#info-button").css("color", "black");
		$("#member-button").css("color", "white");
		$("#map-button").css("color", "white");
		$("#event-detail-info").show();
		$("#event-detail-member").hide();
		$("#event-detail-map").hide();
	});
	$("#member-button").click(function() {
		$("#info-button").css("color", "white");
		$("#member-button").css("color", "black");
		$("#map-button").css("color", "white");
		$("#event-detail-info").hide();
		$("#event-detail-member").show();
		$("#event-detail-map").hide();
	});
	$("#map-button").click(function() {
		$("#info-button").css("color", "white");
		$("#member-button").css("color", "white");
		$("#map-button").css("color", "black");
		$("#event-detail-info").hide();
		$("#event-detail-member").hide();
		$("#event-detail-map").show();
	});
});

//图片下拉加载更多
$(".ordered-photo").ready(function() {
    $(window).scroll(function() {
    	//$("#test-window").val($(window).scrollTop() + "|" + $(window).height() + "|" + $("html").height());
    	var scrollBottom = $(window).scrollTop() + $(window).height();
    	if(scrollBottom == $("html, body").height()) {
    		$("#load-more-photo").click();
    	}
    });
});

//Basic functions
function showPopup (e) {
	//$("body>header").addClass('back-popup');
	//$("body>section>*:not(.div-popup)").addClass('back-popup');
	//$("body>footer").addClass('back-popup');
	$(e).css("position", "fixed");
	$(e).css("left", "0");
	$(e).css("right", "0");
}

function hidePopup (e) {
	// $("body>header").removeClass('back-popup');
	// $("body>section>*:not(.div-popup)").removeClass('back-popup');
	// $("body>footer").removeClass('back-popup');
	$(e).css("position", "absolute");
	$(e).css("left", "-10000px");
	$(e).css("right", "none");
}

/*++++++++++显示登录/注册窗口++++++++++*/
function show_login_panel()
{
	showPopup("#show-login_panel");
}

function switchSign(i)
{
	if (i%2 == 0)
	{
		$(".div-signin").addClass('back');
		$(".div-signup").removeClass('back');
		// document.title = "注册 - NBRC - 纽约新蜂跑团";
	}
	else
	{
		$(".div-signup").addClass('back');
		$(".div-signin").removeClass('back');
		// document.title = "登陆 - NBRC - 纽约新蜂跑团";
	}	
}
/*==========显示登录窗口==========*/
/*++++++++++popup-small++++++++++*/
// function showPopup (e) {
// 	//$("body>header").addClass('back-popup');
// 	//$("body>section>*:not(.div-popup)").addClass('back-popup');
// 	//$("body>footer").addClass('back-popup');
// 	$(e).css("position", "fixed");
// 	$(e).css("left", "0");
// 	$(e).css("right", "0");
// }

// function hidePopup (e) {
// 	// $("body>header").removeClass('back-popup');
// 	// $("body>section>*:not(.div-popup)").removeClass('back-popup');
// 	// $("body>footer").removeClass('back-popup');
// 	$(e).css("position", "absolute");
// 	$(e).css("left", "-10000px");
// 	$(e).css("right", "none");
// }
/*==========popup-small==========*/

//Dynamic HTML
function displayMoreGroupList(obj) {
	$(".ul-browser-list-gr").append(obj.list);
	$(".more-list-large").html(obj.more);
}

function displayMoreEventList(obj) {
	$(".ul-browser-list").append(obj.list);
	$(".more-list-large").html(obj.more);
}

function displayMoreFeed(obj) {
	$(".ul-feed-list-large").append(obj.list);
	$(".more-list-large").html(obj.more);
}

function displayMoreComment(obj) {
	$("#ul-feed-list-comment-list-"+obj.id).prepend(obj.list);
	$("#div-feed-list-more-comment-"+obj.id).html(obj.more);
}

function displayMorePhoto(obj) {
	$(".ul-ordered-photo").append(obj.list);
	$(".more-photo").html(obj.more);
}

function displayReply(obj) {
	var html = "<li><a href='"+obj.comment.owner.url
			+"'><img class='logo-small' src='"
	        +obj.args.home
			+obj.comment.owner.image
			+"' alt='"
			+obj.comment.owner.alt
			+"' title='"
			+obj.comment.owner.title
			+"'></a><div class='comment-right-area'><a class='replyer-title' href='"
	        +obj.args.home
			+obj.comment.owner.url+"'>"
			+obj.comment.owner.title
			+"</a><p>"
			+obj.comment.content
			+"</p><span class='comment-time-feed'>"
			+obj.comment.timestamp
			+"</span></div></li>";
	$('#ul-feed-list-comment-list-'+obj.args.bid).append(html);
	$("#comment-textarea-"+obj.args.bid).val("");
	// $(".comment_textarea").autoResize({
	//                 // On resize:
	//                 onResize : function() {
	//                         $(this).css({opacity:0.8});
	//                 },
	//                 // After resize:
	//                 animateCallback : function() {
	//                         $(this).css({opacity:1});
	//                 },
	//                 // Quite slow animation:
	//                 animateDuration : 100,
	//                 // More extra space:
	//                 extraSpace : 0
 //        });
}
/*++++++++++获取hash中的keyword和sindex++++++++++*/
function getUrlHash()
{
	var arr = new Array(2);
	var arr_array = new Array(1);
	var url_temp = window.location.href;
	var url_hash = window.location.hash;
	if (url_hash != '')
	{
		var url_temp_array_hash = url_temp.split('#');
		var url_hash = url_temp_array_hash[1];
		var url_temp_array_split = url_hash.split('/');
		var url_key = url_temp_array_split[0];
		var url_sindex = url_temp_array_split[1];
		var key_array = url_key.split('key=');
		var sindex_array = url_sindex.split('sindex=');
		var keyword = key_array[1];
		var sindex = sindex_array[1];
		arr[0] = keyword;
		arr[1] = sindex;
		return arr;
	}
	return 	arr_array;
}
/*==========获取hash中的keyword和sindex==========*/

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

function get_superior_member(pid)
{
	superior_member = new Array();
	if ( pid > 0 )
	{
		pid = 2;
		superior_member[0] = pid;

		pid = 99;
		superior_member[1] = pid;

		pid = 244;
		superior_member[2] = pid;

		pid = 1529;
		superior_member[3] = pid;
	}
	
	return superior_member;
}

function define_superior_member(pid)
{
	superior_member = get_superior_member(pid);
	for ( var i = 0; i < superior_member.length; i++ )
	{
		if ( pid == superior_member[i] )
		{
			return true;
		}
	}

	return false;
}

//Library functions
function serverError(obj){
	alert("Server Error!");
}

function dataError(obj){
	alert("Data Error!");
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

/*============================== <common function> ============================== */

/*++++++++++++++++++++++++++++++<showMore function>++++++++++++++++++++++++++++++*/
function showMoreEvent(num, start) {
	action(
		"show_more_event",
		displayMoreEventList,
		dataError,
		"GET",
		{
			"num": num,
			"start": start,
			"catalog": $(".option-catalog-list[selected]").val()
		}
	);
}

function showMoreGroup(num, start) {
	action(
		"show_more_group",
		displayMoreGroupList,
		dataError,
		"GET",
		{
			"num": num,
			"start": start,
			"catalog": $(".option-catalog-list[selected]").val()
		}
	);
}

function showMoreFeed(tag, id, type, num, start) {
	action(
		"show_more_feed",
		displayMoreFeed,
		dataError,
		"GET",
		{
			"tag": tag,
			"id": id,
			"type": type,
			"num": num,
			"start": start
		}
	);
}

function showMoreComment(bid, num, start) {
	action(
		"show_more_comment",
		displayMoreComment,
		dataError,
		"GET",
		{
			"bid": bid,
			"num": num,
			"start": start
		}
	);
}

function showMorePhoto(aid, num, start) {
	action(
		"show_more_photo",
		displayMorePhoto,
		dataError,
		"GET",
		{
			"aid": aid,
			"num": num,
			"start": start
		}
	);
}

function showMoreInfoContent()
{
	$(".view-info-list-content").css("white-space", "pre-wrap").css("max-height", "none");
	$(".view-info-list-content-more").html("<a style='color: black;' href='javascript:' onclick='hideMoreInfoContent();'>收起</a>");
	$(".glyphicon-toggle-icon").html("<a style='color: black;' href='javascript:' onclick='hideMoreInfoContent();'><span class='glyphicon glyphicon-chevron-up' id='up-icon'></span></a>");
}

function hideMoreInfoContent()
{
	$(".view-info-list-content").css("white-space", "").css("max-height", "100px");
	$(".view-info-list-content-more").html("<a style='color: black;' href='javascript:' onclick='showMoreInfoContent();'>查看详细</a>");
	$(".glyphicon-toggle-icon").html("<a style='color: black;' href='javascript:' onclick='showMoreInfoContent();'><span class='glyphicon glyphicon-chevron-down' id='down-icon'></span></a>");
}
/*==============================<showMore function>==============================*/

/*++++++++++++++++++++++++++++++<feed function>++++++++++++++++++++++++++++++*/
function reply_to(pid, bid) {
	var content = $("#comment-textarea-"+bid).val();
	if (content.length > 0) {
		action(
			"reply_to",
			displayReply,
			dataError,
			"POST", 
			{
				"pid": pid,
				"bid": bid,
				"content": content
			}
		);
	}
}

function update_feed_tag(tag_id, id, type) 
{
	$.ajax({
		url: '../cgi/feed_list.php',
		type: 'GET',
		dataType: 'text',
		data: {
			'tag': tag_id,
			'id': id,
			'type': type
		},
		beforeSend:function(data){ // Are not working with dataType:'jsonp'  		
      		$('.feed-list-content').html("<div><img src='../theme/images/loading.gif'/><div>");
    	},
		success: function(data){
			$(".section-feed-list-large").replaceWith(data);
			$('.comment-textarea').autoResize({
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
		},
		error: function(data){
			serverError(null);
		}
	})
}

//update friend list large
function update_friend_list_large(category) {
	$.ajax({
		url: '../cgi/friend_list.php',
		type: 'GET',
		dataType: 'text',
		data: {
			'category': category
		},
		success: function(data){
			$(".section-friend-list-large").replaceWith(data);
		},
		error: function(data){
			serverError(null);
		}
	})
}

function displayfeed(obj) {
	var html = "<li class='li-feed-list-large'><div class='feed-left-area'><a href='"
        	+obj.args.home
			+obj.newfeed.owner.url
			+"'><img class='logo-medium' src='"
	        +obj.args.home
			+obj.newfeed.owner.image
			+"' alt='"
			+obj.newfeed.owner.alt
			+"' title='"
			+obj.newfeed.owner.title
			+"'></a></div><div class='feed-right-area'><div class='div-feed-list-feed'><a href='"
        	+obj.args.home
			+obj.newfeed.owner.url+"'><span class='list-title-member'</span>"
			+obj.newfeed.owner.title
			+"</a><p>"
			+obj.newfeed.content
			+"</p><span class='time-feed'>"
			+obj.newfeed.timestamp
			+"</span></div><div class='ul-feed-list-comment-list' id='ul-feed-list-comment-list-"
			+obj.bid
			+"'></div><div class='ul-feed-list-reply'><a href='"
        	+obj.args.home
			+obj.newfeed.owner.url
			+"'><img class='self-logo-small' src='"
		    +obj.args.home
			+obj.newfeed.owner.image
			+"' alt='"
			+obj.newfeed.owner.alt
			+"' title='"
			+obj.newfeed.owner.title
			+"'></a><div><textarea class='comment-textarea' id='comment-textarea-"
			+obj.bid
			+"' placeholder='发表评论' title='发表评论' value='发表评论' style='max-width: 420px;'></textarea><button class='button-reply' onclick='reply_to("
			+obj.args.pid
			+", "
			+obj.bid
			+")'>评论</button></div></div></li>";

/*	alert(JSON.stringify(obj.newfeed)); */
	$('.ul-feed-list-large').prepend(html);
	$("#newfeed-textarea-id").val("");
	$(".comment-textarea").autoResize({
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
}

function add_feed(pid, page_id, type)
{
	var content = $("#newfeed-textarea-id").val();
	var image = '';
	if(content.length > 0) 
	{
		action(
			"add_feed",
			displayfeed,
			dataError,
			"POST",
			{
				"pid": pid,
				"page_id": page_id,
				'type': type,
				"content": content,
				"image": image
			}
		);
	}
}
/*==============================<feed function>==============================*/

//Edit Functions
function refreshLogo(obj) {
	
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
	url_http = url.match(/^http:\/\/.+\..+/i);
	url_https = url.match(/^https?:\/\/.+..+/i);
    if ( (url_http == null) && (url_https == null) )
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
	// if ( oper == 'uni_sale' )
	// {
	// 	var ticket_info = new Array();
	// 	var ticket_count = $("input[name='ticket_type_nums']").val();
	// 	for ( var i = 1; i <= ticket_count; i++ )
	// 	{

	// 	}
	// 	alert(ticket_count);

	// 	$.ajax({
	// 			url: '../cgi/event_oper.php',
	// 			type: 'POST',
	// 			dataType: 'text',
	// 			data: {
	// 					"pid": pid,
	// 					"eid": eid,
	// 					"oper": oper,
	// 					"address": ticket_count
	// 			},
	// 			success: function(data){
	// 				console.log(data);
	// 				console.log("########################");
	// 				var obj = eval('(' + data + ')');
	// 				if (obj.error == "none")
	// 				{
	// 					// success(obj);
	// 				}
	// 				var message = obj.args.address;

	// 				alert(message);
	// 			},
	// 			error: function(data){
	// 				serverError(null);
	// 			}
	// 		})	
	// }
	if ( oper == 'other_sale' )
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

function event_manage_sale(pid, eid)
{
	showPopup("#event-manage-sale");
}

function event_delete_oper(pid, eid, oper)
{
	if ( window.confirm("Alex童鞋, 你真的确定要取消活动么?") )
	{
		event_oper(pid, eid, oper);
	}
	else
	{
		alert("好吧, 你可以再想想");
	}
}


/*+++++官方售票+++++*/
function event_buy(pid, eid)
{
	// var oper = 'join';
	// action(
	// 	"event_oper",
	// 	refreshPage,
	// 	dataError,
	// 	"POST", 
	// 	{
	// 	   "pid": pid,
	// 	   "eid": eid,
	// 	   "oper": oper
	// 	}
	// );
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
				url: '../cgi/manage_eventbrite_sale.php',
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
					var url = obj.args.message;
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

/*+++sale form functions+++*/
function showSaleForm(id, tid)
{
	if ( $("#sale-form-"+id).hasClass("sale-form-off") )
	{
		if ( $("#sale-form-"+tid).hasClass("sale-form-on") )
		{
			$("#sale-form-"+tid).removeClass("sale-form-on").addClass("sale-form-off");
		}

		$("#sale-form-"+id).removeClass("sale-form-off").addClass("sale-form-on");
	}
	else if ( $("#sale-form-"+id).hasClass("sale-form-on") )
	{
		$("#sale-form-"+id).removeClass("sale-form-on").addClass("sale-form-off");
	}
}

/*+++++++++++++++++++ event create new ++++++++++++++++++++*/
function eventCreateSale(mode, home, pid)
{
	switch(mode)
	{
		case 1:
			var createsale_temp = $("#sale-form-"+1);
			if ( !(typeof(createsale_temp) == "undefined") && (createsale_temp != '') )
			{
				// createsale_temp.removeClass("sale-form-off");
				$(".event-details-sale-cover").fadeOut("slow", 0);
				// $(".event-details-sale-cover").addClass("uni-show-off");
				setTimeout(function(){
					addTicketType(home, "free", pid);
					createsale_temp.fadeTo("slow", 1);
				}, 500);
			}
			break;

		case 2:
			if ( define_superior_member(pid) )
			{
				var createsale_temp = $("#sale-form-"+1);
				if ( !(typeof(createsale_temp) == "undefined") && (createsale_temp != '') )
				{
					createsale_temp.removeClass("sale-form-off");
					$(".event-details-sale-cover").fadeOut("slow", 0);

					setTimeout(function(){
						addTicketType(home, "paid", pid);
						createsale_temp.fadeTo("slow", 1);
					}, 500);
				}
			}
			else 				//对于其他人员暂无权限开启收费票
			{
				show_form_error("eventCreateForm", "defineSuper");
			}
			break;

		default:
			break;
	}
}
/*=================== event create new ====================*/

function addTicketType(home, type, pid)
{
	var type_nums 	=	parseInt( $("#ticket-type-nums").val() );
	var unisalemode	=	$("input[name='unisalemode']").val();
	// var cur_nums 	=	type_nums + 1;
	var html_add	=	"hello world!";
	var salecount	=	parseInt( $("#unisalecount").val() );
	var cur_nums 	=	salecount + 1;

	if ( cur_nums >= 0 )
	{
		if ( unisalemode == "modify" )
		{
			html_add = "<tr class='ticket_row' id='tic_info_row_"+cur_nums+"'>"
				        +"<td class='ticket_type_name'>"
				            +"<input type='text' class='form-control input-sm type-input' name='type_"+cur_nums+"' id='type-"+cur_nums+"' placeholder='Example: Early Bird...' value=''>"
				        +"</td>"    
				        +"<td nowrap='nowrap' class='price_td'>"
				            +"<input type='text' class='form-control input-sm' name='price_"+cur_nums+"' id='price-"+cur_nums+"' placeholder='No $' value=''>"
				        +"</td>"
				        +"<td width='15%' nowrap='nowrap'>"
				            +"<span class='ui-spinner ui-widget ui-widget-content ui-corner-all'>"
				                +"<input type='text' name='volume_"+cur_nums+"' id='spinner-02' placeholder='' value='0' class='form-control spinner ui-spinner-input volume-input' aria-valuemin='0' aria-valuemax='99' aria-valuenow='0' autocomplete='off' role='spinbutton'>"
				                +"<a class='ui-spinner-button ui-spinner-up ui-corner-tr' tabindex='-1'>"
				                	+"<span class='ui-icon ui-icon-triangle-1-n'></span>"
				                +"</a>"
				                 +"<a class='ui-spinner-button ui-spinner-down ui-corner-tr' tabindex='-1'>"
				                	+"<span class='ui-icon ui-icon-triangle-1-s'></span>"
				                +"</a>"
				            +"</span>"
				            +"<input type='hidden' name='remain_"+cur_nums+"' id='remain-"+cur_nums+"' value=''>"
				        +"</td>"
				        +"<td width='15%' nowrap='nowrap'>"
				            +"<input type='number' min='0' class='form-control input-sm' name='remain_"+cur_nums+"' id='remain-"+cur_nums+"' placeholder='remain...'' value=''>"
				        +"</td>"
				        +"<td width='15%' nowrap='nowrap'>"
				            +"<input type='number' min='0' class='form-control input-sm' name='tlimit_"+cur_nums+"' id='tlimit-"+cur_nums+"' placeholder='limit...'' value=''>"
				        +"</td>"
				        +"<td width='15%' nowrap='nowrap'>"
				            +"<input type='text' class='form-control input-sm' name='description_"+cur_nums+"' id='description-"+cur_nums+"' placeholder='description...' value=''>"
				        +"</td>"
				        +"<td width='5%' nowrap='nowrap'>"
				        	+"<a href='javascript: ' onclick='delTicketType("+cur_nums+", 0)'>"
				            	+"<img src='"+home+"theme/images/remove_1.png'/>"
				            +"</a>"
				        +"</td>"
				    +"</tr>";

			$("table tr:eq("+type_nums+")").after(html_add);
		}
		else if ( unisalemode == "new" )
		{
			html_add = "<tr class='ticket_row' id='tic_info_row_"+cur_nums+"'>"
				        +"<td class='ticket_type_name'>"
				            +"<input type='text' class='form-control input-sm type-input' name='type_"+cur_nums+"' id='type-"+cur_nums+"' placeholder='Example: Early Bird...' value=''>"
				        +"</td>"    
				        +"<td nowrap='nowrap' class='price_td'>"
				            +"<input type='text' class='form-control input-sm' name='price_"+cur_nums+"' id='price-"+cur_nums+"' placeholder='No $' value=''>"
				        +"</td>"
				        +"<td width='15%' nowrap='nowrap'>"
				            +"<span class='ui-spinner ui-widget ui-widget-content ui-corner-all'>"
				                +"<input type='text' name='volume_"+cur_nums+"' id='spinner-02' placeholder='' value='0' class='form-control spinner ui-spinner-input volume-input' aria-valuemin='0' aria-valuemax='99' aria-valuenow='0' autocomplete='off' role='spinbutton'>"
				                +"<a class='ui-spinner-button ui-spinner-up ui-corner-tr' tabindex='-1'>"
				                	+"<span class='ui-icon ui-icon-triangle-1-n'></span>"
				                +"</a>"
				                 +"<a class='ui-spinner-button ui-spinner-down ui-corner-tr' tabindex='-1'>"
				                	+"<span class='ui-icon ui-icon-triangle-1-s'></span>"
				                +"</a>"
				            +"</span>"
				            +"<input type='hidden' name='remain_"+cur_nums+"' id='remain-"+cur_nums+"' value=''>"
				        +"</td>"
				        +"<td width='15%' nowrap='nowrap'>"
				            +"<input type='number' min='0' class='form-control input-sm' name='tlimit_"+cur_nums+"' id='tlimit-"+cur_nums+"' placeholder='limit...'' value=''>"
				        +"</td>"
				        +"<td width='15%' nowrap='nowrap'>"
				            +"<input type='text' class='form-control input-sm' name='description_"+cur_nums+"' id='description-"+cur_nums+"' placeholder='description...' value=''>"
				        +"</td>"
				        +"<td width='5%' nowrap='nowrap'>"
				        	+"<a href='javascript: ' onclick='delTicketType("+cur_nums+", 0)'>"
				            	+"<img src='"+home+"theme/images/remove_1.png'/>"
				            +"</a>"
				        +"</td>"
				    +"</tr>";

			$("table tr:eq("+type_nums+")").after(html_add);
		}
		else if ( unisalemode == "create_new" )
		{
			if ( (type == "paid") && !define_superior_member(pid) )
			{
				show_form_error("eventCreateForm", "defineSuper");
				return;
			}
			html_add = '<div class="ticket-row" id="tic_info_row_'+cur_nums+'">'
											+'<div class="ticket-table-sale-type">'
												+'<input type="text" class="form-control input-sm type-input" name="type_'+cur_nums+'" id="type-'+cur_nums+'" placeholder="Example: Early Bird..." value="">'
											+'</div>'
											+'<div class="ticket-table-sale-quantity">'
												+'<input type="number" class="form-control input-sm type-input" name="volume_'+cur_nums+'" id="volume-'+cur_nums+'" placeholder="number..." value="" min="1" max="30000">'
											+'</div>'
											+'<div class="ticket-table-sale-price" style="height: 35px; line-height: 35px;">';
			if ( type == "free" )
			{
				html_add += 'Free'
							+'<input type="hidden" class="form-control input-sm" name="price_'+cur_nums+'" id="price-'+cur_nums+'" placeholder="No \'$\'" value="free">';
			}
			else
			{
				html_add += '<input type="number" class="form-control input-sm" name="price_'+cur_nums+'" id="price-'+cur_nums+'" placeholder="No \'$\'" value="" min="1" max="30000">';
			}

			html_add += '</div>'
											+'<div class="ticket-table-sale-actions">'
												+'<a class="ico-medium" href="javascript:">'
													+'<span class="fui-gear"></span>'
												+'</a>'
												+'<a class="ico-medium" href="javascript:" onclick="delTicketType('+cur_nums+', 0)">'
													+'<span class="fui-trash"></span>'
												+'</a>'
											+'</div>'
										+'</div>';
		}

		$(".ticket-table-detail").append(html_add);

		$("#ticket-type-nums").val(cur_nums);

		$("#unisalecount").val(salecount+1);
	}	
}

function delTicketType(id, del_mode)
{
	var unisaleid		=	$("input[name='unisaleid']").val();
	var unisalepid		=	$("input[name='unisalepid']").val();
	var unisalemode		=	$("input[name='unisalemode']").val();
	var oper 			=	"modify_sale_del";
	
	if ( ( unisalemode == "new" ) || ( del_mode == 0 ) || ( unisalemode == "create_new" ) )
	{
		var cur_nums = parseInt( $("#ticket-type-nums").val() );
		if ( id > 0 )
		{
			// $("table tr:eq("+id+")").remove();
			$("#tic_info_row_"+id).remove();

			$("#ticket-type-nums").val(cur_nums-1);

			if ( unisalemode == "create_new" )
			{
				if ( $("#ticket-type-nums").val() == 0 )
				{
					var createsale_temp = $("#sale-form-"+1);
					if ( !(typeof(createsale_temp) == "undefined") && (createsale_temp != '') )
					{
						// $("#sale-cover-adds-free").addClass("uni-show-off");
						// $(".event-details-sale-cover").removeClass("uni-show-off");
						createsale_temp.fadeOut("slow", 0);
						$(".event-details-sale-cover").fadeTo("slow", 1);
						// setTimeout(function(){createsale_temp.addClass("sale-form-off");}, 1000);
					}
				}
			}
		}
	}
	else if ( unisalemode == "modify" )
	{
		var del_id		=	$("input[name='ticket_id_"+id+"']").val();
		var del_type	=	$("input[name='type_"+id+"']").val();

		if ( window.confirm("Alex童鞋, 你真的确定要删除该票种(\""+del_type+"\")么, 此操作不可逆?") )
		{
			// alert("你好绝情!");
			$.ajax({
				url: '../cgi/event_oper.php',
				type: 'POST',
				dataType: 'text',
				data: {
						"pid": unisalepid,
						"eid": unisaleid,
						"oper": oper,
						"unisalemode": unisalemode,
						"del_id": del_id,
				},
				success: function(data){
					console.log(data);
					console.log("########################");
					var obj = eval('(' + data + ')');
					if (obj.error == "none")
					{
						// success(obj);
					}
					var message = obj.args.message;

					if ( message )
					{
						alert("好吧, 现在你成功删除了票: ("+del_type+")");
						window.location.href = window.location.href;
					}
				},
				error: function(data){
					serverError(null);
				}
			})
		}
		else
		{
			alert("好吧, 你可以再想想");
		}
	}
}
/*===sale form functions===*/

/*+++paypal checkout functions+++*/
function updateCheckout(ticket_id, ticket_type, ticket_price, ticket_num)
{
	var quantity_temp = $("#flat-ui_quantity_"+ticket_id).val();
	$("#quantity_"+ticket_id).val(quantity_temp);
	var quantity = $("#quantity_"+ticket_id).val();
	var ticket_0_type = $("#ticket_0_type_id").val();
	var ticket_0_price = $("#ticket_0_price_id").val();
	var ticket_0_quantity = $("#quantity_1").val();
	var price_count = 0.00;
	var quantity_count = 0;
	var count = 0.00;
	var tax_count = 0.00;
	var flag = 0;
	var flag_zero = ticket_num;
	var flag_max = 0;
	var ticket_flag = 0;
	var tax_ratio = 0.08;
	var variable_x = 1;
	var ticket_count_all = $("#ticket-count-all").val();

	if ( quantity > 0 )
	{
		/*+++若商品paypal-id已经存在,则只更改数量信息+++*/
		var prevLength = $("#paypal-ticket-info-id-"+ticket_id).html().length
		if ( prevLength > 100 )
		{
			ticket_flag = $("#flag_ticket_"+ticket_id).val();
			$("input[name='quantity_"+ticket_flag+"']").val(quantity);
		}
		else
		{
			/*+++flag_zero代表当前quantity不为0的总数+++*/
			for ( var k = 1; k <= ticket_count_all; k++)
			{
				if ( $("#quantity_"+k).val() == 0 )
				{
					--flag_zero;
				}
			}
			/*===flag_zero===*/

			var html_add = "<input type='hidden' name='item_name_"+flag_zero+"' value='"+ticket_type+"'>"
							+"<input type='hidden' name='amount_"+flag_zero+"' value='"+ticket_price+"'>"
							+"<input type='hidden' name='quantity_"+flag_zero+"' value='"+quantity+"'>"
							+"<input type='hidden' name='flag_"+ticket_id+"' id='flag_ticket_"+ticket_id+"' value='"+flag_zero+"'>";
			$("#paypal-ticket-info-id-"+ticket_id).html(html_add);
		}
	}

	if ( quantity == 0 )
	{
		/*+++保证product顺序执行的情况下删除该product+++*/
		ticket_flag = $("#flag_ticket_"+ticket_id).val();
		
		var html_empty = "";
		$("#paypal-ticket-info-id-"+ticket_id).html(html_empty);

		for ( var ticket_large = ticket_flag; ticket_large <= ticket_num; ticket_large++ )
		{
			for ( var m = 1; m <= ticket_num; m++ )
			{
				var ticket_val_length = $("#flag_ticket_"+m).length;
				var ticket_val_val = $("#flag_ticket_"+m).val();
				var ticket_val_type = $("input[name='item_name_"+ticket_val_val+"']").val();
				var ticket_val_amount = $("input[name='amount_"+ticket_val_val+"']").val();
				var ticket_val_quantity = $("input[name='quantity_"+ticket_val_val+"']").val();	
				
				if ( ticket_val_length > 0 )
				{					
					if ( ticket_val_val == ticket_large )
					{
						var html_del =	"<input type='hidden' name='item_name_"+(ticket_val_val-1)+"' value='"+ticket_val_type+"'>"
										+"<input type='hidden' name='amount_"+(ticket_val_val-1)+"' value='"+ticket_val_amount+"'>"
										+"<input type='hidden' name='quantity_"+(ticket_val_val-1)+"' value='"+ticket_val_quantity+"'>"
										+"<input type='hidden' name='flag_"+m+"' id='flag_ticket_"+m+"' value='"+(ticket_val_val-1)+"'>";
						
						$("#paypal-ticket-info-id-"+m).html(html_del);
					}
				}
			}
		}
		/*===保证product顺序执行的情况下删除该product===*/

		for ( var j = 1; j <= ticket_num; j++)
		{
			if ( $("#quantity_"+j).val() != 0 )
			{
				flag = 1;
			}
		}
		if ( flag == 0 )
		{
			// alert('请至少选择一种购票方式!');
			// $("#quantity_1").val(1);
			// var html_1 = "<input type='hidden' name='item_name_"+1+"' value='"+ticket_0_type+"'>"
			// 		+"<input type='hidden' name='amount_"+1+"' value='"+ticket_0_price+"'>"
			// 		+"<input type='hidden' name='quantity_"+1+"' value='"+1+"'>";

			// $("#paypal-ticket-info-id-"+1).html(html_1);
		}
		else
		{

		}
	}

	/*+++计算税, 现在按照tax_ratio = 0.08算的*/
	for (var i = 1; i <= ticket_num; i++)
	{
		var amount = $("input[name='amount_"+i+"']").val();
		if ( !(typeof(amount) == "undefined") && (amount != '') )
		{
			price_count = $("input[name='amount_"+i+"']").val();
			quantity_count = $("input[name='quantity_"+i+"']").val();

			count = price_count * quantity_count;
			tax_count = tax_count + count;
		}
	};

	tax_count = parseFloat(Math.round(tax_count*tax_ratio*100))/100;  //paypal的tax只认小数点后两位的float
	$("#paypal-ticket-tax-all-id").val(tax_count);
}
/*===paypal checkout functions===*/
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

/*+++++活动成员－邮件+++++*/
function mail_oper()
{
	showPopup("#show-mail_oper");
	$('.textarea-mail-content').autoResize({
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
}
/*=====活动成员－邮件=====*/
/*==============================<manage function>==============================*/

/*++++++++++++++++++++++++++++++<album function>++++++++++++++++++++++++++++++*/
function showMoreAlbum_group(gid, start) {
	$.ajax({
		url: '../cgi/group_show_more_album.php',
		type: 'GET',
		dataType: 'text',
		data: {
			'gid': gid,
			'start': start
		},
		success: function(data){
			$(".section-image-list").replaceWith(data);
		},
		error: function(data){
			serverError(null);
		}
	})
}

function showMoreAlbum_people(pid, start) {
	$.ajax({
		url: '../cgi/people_show_more_album.php',
		type: 'GET',
		dataType: 'text',
		data: {
			'pid': pid,
			'start': start
		},
		success: function(data){
			$(".section-image-list").replaceWith(data);
		},
		error: function(data){
			serverError(null);
		}
	})
}

function show_album_group(gid, aid, start) {
	window.location.href = "../group/album_photo.php?aid="+aid+"&gid="+gid+"&start="+start;
}

function show_album_people(pid) {
	window.location.href = "../people/album_photo.php?pid="+pid;
}

function show_album_event(eid) {
	window.location.href = "../event/album_photo.php?eid="+eid;
}

function edit_photo(index, old_photoid) {
	// $("#display_id").val(index);
	// $("#old_photoid").val(old_photoid);
	showPopup("#edit-display-photo");
}

function edit_photo_display_inner(index, old_photoid)
{
	$("#display_id").val(index);
	$("#old_photoid").val(old_photoid);
}


function edit_photo_done() {
	$("#photo-frame").hide();
	$("#edit-photo").show();
	$("#edit-photo-done").hide();
}

function create_album() {
	showPopup("#create-album");
}

/*++++++++++ albumPage addPhoto Function ++++++++++*/
function album_page_addPhoto(i)
{
	switch(i)
	{
		case 1:
			$("#add-photo-switch").removeClass("uni-switch-off").addClass("uni-switch-on");
			$("#album-add-photo-a-add").attr('onclick','album_page_addPhoto(2)');
			$("#album-add-photo-a-add>.tagsinput-add").html(" 取消添加 ");
			$("#album-add-photo-a-add>.tagsinput-add").removeClass("tagsinput-add-off").addClass("tagsinput-add-on	");
			break;
		case 2:
			$("#add-photo-switch").removeClass("uni-switch-on").addClass("uni-switch-off");
			$("#album-add-photo-a-add").attr('onclick','album_page_addPhoto(1)');
			$("#album-add-photo-a-add>.tagsinput-add").html(" 添加照片 ");
			$("#album-add-photo-a-add>.tagsinput-add").removeClass("tagsinput-add-on").addClass("tagsinput-add-off");
			break;
		default:
			break;
	}
}
/*========== albumPage addPhoto Function ==========*/
/*==============================<album function>==============================*/


/*++++++++++++++++++++++++++++++<create function>++++++++++++++++++++++++++++++*/
function create_event(pid)
{
	showPopup("#create-event");

	// $("#datetimepicker-start").datetimepicker({
	// 	autoclose: true,
 //    	todayBtn: true,
 //    	minuteStep: 10
	// });

	// $("#datetimepicker-start").on('changeDate', function() {
	// 	$("#datetimepicker-end").datetimepicker(
	// 		'setStartDate', $('#datetimepicker-start').val()
	// 	);
	// });

 //    $("#datetimepicker-end").datetimepicker({
 //    	autoclose: true,
 //    	todayBtn: true,
 //    	startDate: $('#datetimepicker-start').val(),
 //    	minuteStep: 10
 //    });

	// $("#add-end-time").click(function() {
	// 	$("#datetimepicker-end").show();
	// 	$("#cancel-end-time").show();
	// 	$("#add-end-time").hide();
	// 	$("#datetimepicker-end").val($('#datetimepicker-start').val());
	// });
	// $("#cancel-end-time").click(function() {
	// 	$("#datetimepicker-end").hide();
	// 	$("#cancel-end-time").hide();
	// 	$("#add-end-time").show();
	// });
	$(".event_description").autoResize({
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
}

function update_form_select(selection, selection_1)
{
	/*
		*selection
					1: create event identity
					2: create event type
					3: create event time

		#selection_1
						1: start_time hour
						2: start_time minute
						3: end_time hour
						4: end_time minute
	*/
	var option_temp = '';
	switch(selection)
	{
		case 1:
			option_temp = $("#flat-ui-event-option").val();
			$("input[name='create_option']").val(option_temp);
			break;
		case 2:
			option_temp = $("#flat-ui-event-category").val();
			$("input[name='event_category']").val(option_temp);
			break;
		case 3:
			switch(selection_1)
			{
				case 10:
					option_temp = $("#datepicker-01").val();
					var start_hh = $("#event-time-start-hh").val();
					var start_mm = $("#event-time-start-mm").val();
					var d = Date.parse(option_temp);
					var date = Trans_php_time_to_str(d, 2);
					$("input[name='event_start_time']").val(date+' '+start_hh+':'+start_mm);
					break;
				case 11:
					option_temp = $("#datepicker-02").val();
					var end_hh = $("#event-time-end-hh").val();
					var end_mm = $("#event-time-end-mm").val();
					var d = Date.parse(option_temp);
					var date = Trans_php_time_to_str(d, 2);
					$("input[name='event_end_time']").val(date+' '+end_hh+':'+end_mm);
					break;
				case 1:
					option_temp = $("#flat-ui-event-time-start-hh").val();
					$("#event-time-start-hh").val(option_temp);

					option_temp = $("#datepicker-01").val();
					if ( option_temp == "" )
					{
						option_temp = (new Date).getTime();
					}
					var start_hh = $("#event-time-start-hh").val();
					var start_mm = $("#event-time-start-mm").val();
					var date = Trans_php_time_to_str(option_temp, 2);
					$("input[name='event_start_time']").val(date+' '+start_hh+':'+start_mm);
					break;
				case 2:
					option_temp = $("#flat-ui-event-time-start-mm").val();
					$("#event-time-start-mm").val(option_temp);

					option_temp = $("#datepicker-01").val();
					if ( option_temp == "" )
					{
						option_temp = (new Date).getTime();
					}
					var start_hh = $("#event-time-start-hh").val();
					var start_mm = $("#event-time-start-mm").val();
					var date = Trans_php_time_to_str(option_temp, 2);
					$("input[name='event_start_time']").val(date+' '+start_hh+':'+start_mm);
					break;
				case 3:
					option_temp = $("#flat-ui-event-time-end-hh").val();
					$("#event-time-end-hh").val(option_temp);

					option_temp = $("#datepicker-02").val();
					if ( option_temp == "" )
					{
						option_temp = (new Date).getTime();
					}
					var end_hh = $("#event-time-end-hh").val();
					var end_mm = $("#event-time-end-mm").val();
					var date = Trans_php_time_to_str(option_temp, 2);
					$("input[name='event_end_time']").val(date+' '+end_hh+':'+end_mm);
					break;
				case 4:
					option_temp = $("#flat-ui-event-time-end-mm").val();
					$("#event-time-end-mm").val(option_temp);

					option_temp = $("#datepicker-02").val();
					if ( option_temp == "" )
					{
						option_temp = (new Date).getTime();
					}
					var end_hh = $("#event-time-end-hh").val();
					var end_mm = $("#event-time-end-mm").val();
					var date = Trans_php_time_to_str(option_temp, 2);
					$("input[name='event_end_time']").val(date+' '+end_hh+':'+end_mm);
					break;
			}
			break;
		case 4:
			option_temp = $("#flat-ui-event-location-state").val();
			$("#event-location-state").val(option_temp);
			break;
		case 5:
			// alert();
			break;
	}
}

function free_order_btn()
{
	document.getElementById("paypal-free-order-submit").click();
}

function create_event_btn()
{
	document.getElementById("event-create-submit").click();
}

function photo_upload_btn()
{
	document.getElementById("photo-upload-submit").click();
	// window.location.href = window.location.href;
}

function create_runningcard_btn()
{
	document.getElementById("runcard-create-submit").click();
}

function Trans_php_time_to_str(timestamp,n)
{
	// update = new Date(timestamp*1000);//时间戳要乘1000
	update = new Date(timestamp);
	year   = update.getFullYear();
	month  = (update.getMonth()+1<10)?('0'+(update.getMonth()+1)):(update.getMonth()+1);
	day    = (update.getDate()<10)?('0'+update.getDate()):(update.getDate());
	hour   = (update.getHours()<10)?('0'+update.getHours()):(update.getHours());
	minute = (update.getMinutes()<10)?('0'+update.getMinutes()):(update.getMinutes());
	second = (update.getSeconds()<10)?('0'+update.getSeconds()):(update.getSeconds());
	
	if ( n==1 )
	{
		return (year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second);
	}
	else if ( n==2 )
	{
		return (year+'-'+month+'-'+day);
	}
	else
	{
		return 0;
 	}
}

/*+++++++++++++++update function ~ update filter+++++++++++++++*/
/*++++++++++删除数组中指定元素++++++++++*/
Array.prototype.deleteElementByValue = function(varElement)
{
    var numDeleteIndex = -1;
    for (var i=0; i<this.length; i++)
    {
        // 严格比较，即类型与数值必须同时相等。
        if (this[i] === varElement)
        {
            this.splice(i, 1);
            numDeleteIndex = i;
            break;
        }
    }
    return numDeleteIndex;
}
/*测试数据
var arr = new Array("31","52","73","24");
alert(arr.deleteElementByValue("73")); // 2
alert(arr); // 31,52,24
alert(arr.deleteElementByValue("99")); // -1
alert(arr); // 31,52,24
*/
/*==========删除数组中指定元素==========*/
/*++++++++++共用更新filter++++++++++*/
function update_filter(id)
{
	//#0 default value
	var tag_value_temp = '0';
	var tag_value_arr = new Array();

	//filter-on to filter-off
	if ( $("#search-filter-list-"+id).hasClass("search-filter-list-filter-off") )
	{
		$("#search-filter-list-"+id).removeClass("search-filter-list-filter-off");
		$("#search-filter-list-"+id).addClass("search-filter-list-filter-on");
		tag_value_temp = $(".tag-value").val();
		if ( tag_value_temp != '' )
		{
			if ( tag_value_temp == '0' )
			{
				tag_value_temp == '';
				tag_value_temp = id;
			}
			else
			{
				tag_value_arr = tag_value_temp.split(',');
				tag_value_temp = tag_value_temp+","+id;
				for (var i=0; i<tag_value_arr.length; i++)
				{
					if ( (tag_value_arr[i] > id) )
					{
						tag_value_arr.splice(i, 0, id);
						tag_value_temp = tag_value_arr.join(",");
						break;
					}
				}		
			}
		}
		$(".tag-value").val(tag_value_temp);
//		alert($(".tag-value").val());		
	}
	//filter-off to filter-on
	else if ( $("#search-filter-list-"+id).hasClass("search-filter-list-filter-on") )
	{
		$("#search-filter-list-"+id).removeClass("search-filter-list-filter-on");
		$("#search-filter-list-"+id).addClass("search-filter-list-filter-off");
		tag_value_temp = $(".tag-value").val();
		if ( tag_value_temp != '' )
		{
			tag_value_arr = tag_value_temp.split(',');
			for (var i=0; i<tag_value_arr.length; i++)
			{
				if ( tag_value_arr[i] == id )
				{
					tag_value_arr.splice(i, 1);
				}
			}
			tag_value_temp = tag_value_arr.join(",");
		}
		if ( tag_value_temp == '' )
		{
			$(".tag-value").val(0);
		}
		else
		{
			$(".tag-value").val(tag_value_temp);
		}
//		alert($(".tag-value").val());		
	}	
}
/*==========共用update filter==========*/

/*++++++++++search页面专用update search filter++++++++++*/
function update_search_filter(id, sid)
{
	//filter-on to filter-off
	if ( $("#search-filter-list-"+id).hasClass("search-filter-list-filter-off") )
	{
		$("#search-filter-list-"+id).removeClass("search-filter-list-filter-off");
		$("#search-filter-list-"+id).addClass("search-filter-list-filter-on");	
		
		/*++++++++++关于filter的蛋疼往事++++++++++*/
		tag_value_temp = $(".search-tag-value").val();
		if ( tag_value_temp != '' )
		{
			if ( tag_value_temp == '0' )
			{
				tag_value_temp == '';
				tag_value_temp = id;
			}
			else
			{
				tag_value_arr = tag_value_temp.split(',');
				tag_value_temp = tag_value_temp+","+id;
				for (var i=0; i<tag_value_arr.length; i++)
				{
					if ( (tag_value_arr[i] > id) )
					{
						tag_value_arr.splice(i, 0, id);
						tag_value_temp = tag_value_arr.join(",");
						break;
					}
				}		
			}
		}
		$(".search-tag-value").val(tag_value_temp);
//		alert($(".search-tag-value").val());
		/*==========关于filter的蛋疼往事==========*/
	}
	//filter-off to filter-on
	else if ( $("#search-filter-list-"+id).hasClass("search-filter-list-filter-on") )
	{
		$("#search-filter-list-"+id).removeClass("search-filter-list-filter-on");
		$("#search-filter-list-"+id).addClass("search-filter-list-filter-off");
		
		/*++++++++++关于filter的蛋疼往事++++++++++*/	
		tag_value_temp = $(".search-tag-value").val();
		if ( tag_value_temp != '' )
		{
			tag_value_arr = tag_value_temp.split(',');
			for (var i=0; i<tag_value_arr.length; i++)
			{
				if ( tag_value_arr[i] == id )
				{
					tag_value_arr.splice(i, 1);
				}
			}
			tag_value_temp = tag_value_arr.join(",");
		}

		if ( tag_value_temp == '' )
		{
			$(".search-tag-value").val(0);
		}
		else
		{
			$(".search-tag-value").val(tag_value_temp);
		}
//		alert($(".search-tag-value").val());
		/*==========关于filter的蛋疼往事==========*/	
	}
	var sindex = 2;
	var keyword = $('#search-form-search-input').val();

	sindex = sid;

	var arr = getUrlHash();
	if ( arr[1] != 'sid' )
	{
		var hash = 'key='+keyword+'/sindex='+sindex;
		window.location.hash = hash;
	}

	$.ajax({
		url: '../cgi/search_result.php',
		type: 'GET',
		dataType: 'text',
		data: {
			'keyword': keyword,
			'sindex': sindex,
			'tag_value': tag_value_temp,
		},
		beforeSend:function(data){ // Are not working with dataType:'jsonp'  		
      		$('.section-search-result-list-large').html("<div><img src='../theme/images/loading.gif'/><div>");
    	},
		success: function(data){
			$(".section-search-result-list-large").replaceWith(data);
			console.log(data);
			// var hash = 'key='+keyword+'/sindex='+sindex;
			// window.location.hash = hash;
		},
		error: function(data){
			serverError(null);
		}
	})

}
/*==========search页面专用update search filter==========*/

/*
$("#search-filter-list-id").click(function(){
	$(".search-filter-list-filter-off").toggle(function(){
		$(".search-filter-list-filter-off").removeClass("search-filter-list-filter-off").addClass("search-filter-list-filter-on");
	},function(){
		$(".search-filter-list-filter-on").removeClass("search-filter-list-filter-on").addClass("search-filter-list-filter-off");
	})
});
function update_create_filter(id)
{

}
*/
/*===============create event function ~ update create event filter===============*/

function create_group()
{
	showPopup("#create-group");
	
	$(".group_description").autoResize({
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
}

function edit_info(pid, id, type) {
	if ( type == "event" )
	{
		showPopup("#edit-event-info");
		
		$("#datetimepicker-start").datetimepicker({
			autoclose: true,
	    	todayBtn: true,
	    	minuteStep: 10
		});

		$("#datetimepicker-start").on('changeDate', function() {
			$("#datetimepicker-end").val("");
			$("#datetimepicker-end").datetimepicker(
				'setStartDate', $('#datetimepicker-start').val()
			);
		});

	    $("#datetimepicker-end").datetimepicker({
	    	autoclose: true,
	    	todayBtn: true,
	    	startDate: $('#datetimepicker-start').val(),
	    	minuteStep: 10
	    });

		$("#add-end-time").click(function() {
			$("#datetimepicker-end").show();
			$("#cancel-end-time").show();
			$("#add-end-time").hide();
		});
		$("#cancel-end-time").click(function() {
			$("#datetimepicker-end").hide();
			$("#cancel-end-time").hide();
			$("#add-end-time").show();
		});
		$(".event_description").autoResize({
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
	}
	else if ( type == "group" )
	{
		showPopup('#edit-group-info');
	}
	else if ( type == "people" )
	{
		showPopup('#edit-profile-info');
		
		// $("#datetimepicker-start").datetimepicker({
		// 	autoclose: true,
	 //    	todayBtn: true,
	 //    	startView: 'decade'
		// });
	}	
}

function post_article(pid, gid, type)
{
	showPopup("#post-article");
}

function show_photo_large(id, image_id, home)
{
	var image_temp = $("#"+id).html();
	if ( !(typeof(image_temp) == "undefined") && (image_temp != '') )
	{
		$("#"+id).remove();
	}
	
	$.ajax({
		url: '../cgi/account/popup_use.php',
		type: 'POST',
		dataType: 'text',
		data: {
			'id': id,
			'image_id': image_id,
			'home': home,
		},
		beforeSend:function(data){ // Are not working with dataType:'jsonp'
    	},
		success: function(data){
					console.log(data);
					console.log("########################");
					var obj = eval('(' + data + ')');
					if (obj.error == "none")
					{
						$('body > section').append(obj.args.list);
						showPopup("#"+id);
					}
					$(".div-popup-normal").click(function(event) {
				        if (!$(event.target).isChildAndSelfOf(".popup-normal"))
				           hidePopup('.div-popup-normal');
				    });
		},
		error: function(data){
			serverError(null);
		}
	})
}

function show_qr(id, share_url, home)
{
	// showPopup("#show-qr");
	// showPopup("#show-wechat");
	var share_temp = $("#"+id).html();
	// alert(share_temp);
	if ( !(typeof(share_temp) == "undefined") && (share_temp != '') )
	{
		showPopup("#"+id);
	}
	else
	{
		if ( (share_url == "") || (id == 'qr') )
		{
			share_url = home+"theme/images/NBRC_Wechat.jpg";
		}
		$.ajax({
			url: '../cgi/account/popup_use.php',
			type: 'POST',
			dataType: 'text',
			data: {
				'id': id,
				'share_url': share_url,
			},
			beforeSend:function(data){ // Are not working with dataType:'jsonp'
	    	},
			success: function(data){
						console.log(data);
						console.log("########################");
						var obj = eval('(' + data + ')');
						if (obj.error == "none")
						{
							$('body > section').append(obj.args.list);
							showPopup("#"+id);
						}
			},
			error: function(data){
				serverError(null);
			}
		})
	}

	$(".div-popup-small").click(function(event) {
        if (!$(event.target).isChildAndSelfOf(".popup-small"))
           hidePopup('.div-popup-small');
    });
}

function show_wechatShare()
{
	showPopup("#show-wechat");
}

function show_form_error(id, error_type)
{
	var image_temp = $("#"+id).html();
	if ( !(typeof(image_temp) == "undefined") && (image_temp != '') )
	{
		$("#"+id).remove();
	}
	
	$.ajax({
		url: '../cgi/account/popup_use.php',
		type: 'POST',
		dataType: 'text',
		data: {
			'id': id,
			'error_type': error_type,
		},
		beforeSend:function(data){ // Are not working with dataType:'jsonp'
    	},
		success: function(data){
					console.log(data);
					console.log("########################");
					var obj = eval('(' + data + ')');
					if (obj.error == "none")
					{
						$('body > section').append(obj.args.list);
						showPopup("#"+id);
					}
					$(".div-popup-normal").click(function(event) {
				        if (!$(event.target).isChildAndSelfOf(".popup-normal"))
				           hidePopup('.div-popup-normal');
				    });
		},
		error: function(data){
			serverError(null);
		}
	})
}
/*==============================<create function>==============================*/

/*++++++++++++++++++++++++++++++<search function>++++++++++++++++++++++++++++++*/
/*++++++++++#0 search_function++++++++++*/
function search_function_assist(pid)
{
	$("#event-group-search-result").show();
	var type = $("#search-type").val();
	var keyword = $("#event-group-search-input").val();
	if (keyword.length > 0) 
	{
		action(
			"function_search",
			function_searchResult,
			dataError,
			"POST", 
			{
				"pid": pid,
				"keyword": keyword,
				"type": type
			}
		);
	}
	else
	{
		$("#event-group-search-result").hide();
	}
}

function function_searchResult(obj)
{
	$('.event-group-search-result-title').html(obj.args.title);
	$('.ul-search-result-event-group').html(obj.args.list);
	$('.event-group-search-result-more').html(obj.args.more);
	$(document).click(function() {
                $("#event-group-search-result").hide();
            });
	$('#event-group-search-input').click(function(e)
	{
		$("#event-group-search-result").show();
		e.stopPropagation();
	})
	$("#event-group-search-result").click(function(e){
		$("#event-group-search-result").show();
		e.stopPropagation();
	})
	$('#search-type').click(function(e)
	{
		$("#event-group-search-result").show();
		e.stopPropagation();
	})
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
		visit(url);
	}
}

/*==========#0 search_function==========*/

/*++++++++++#1 friend_search++++++++++*/
function friend_search(pid)
{
	$("#search-result").show();
	var keyword = $("#friend-search-input").val();
	var s=event.which;
	if (s==13 || s==32)
	{
	//	console.log("你按了回车键！");
	}
	else if (keyword.length > 0) 
	{
		action(
			"friend_search",
			searchResult,
			dataError,
			"POST", 
			{
				"pid": pid,
				"keyword": keyword
			}
		);
	}
}

function searchResult(obj)
{
	$('.search-result-title').html(obj.args.title);
	$('.ul-search-result-friends').html(obj.args.list);
	$('.search-result-more').html(obj.args.more);
	$(document).click(function() {
                $("#search-result").hide();
            });
	$('#friend-search-input').click(function(e)
	{
		$("#search-result").show();
		e.stopPropagation();
	})
}

function search_relocation(pid)
{
	var keyword = $("#friend-search-input").val();
	if (keyword.length > 0)
	{
		var url = 'search/detail.php?keyword='+keyword;
		visit(url);
	}
}
/*
function search_relocation(pid)
{
	var keyword = $("#friend-search-input").val();
	if (keyword.length > 0) {
		action(
			"search_relocation",
			searchRelocation,
			dataError,
			"POST", 
			{
				"pid": pid,
				"keyword": keyword
			}
		);
	}
}
*/
function searchRelocation(obj)
{
	visit(obj.args.url);
}
/*==========#1 friend_search==========*/

/*++++++++++#2 event_group_search++++++++++*/
function event_group_search(pid, type)
{
	$("#event-group-search-result").show();
	var keyword = $("#event-group-search-input").val();
	if (keyword.length > 0) 
	{
		action(
			"event_group_search",
			event_group_searchResult,
			dataError,
			"POST", 
			{
				"pid": pid,
				"keyword": keyword,
				"type": type
			}
		);
	}
}

function event_group_searchResult(obj)
{
	$('.event-group-search-result-title').html(obj.args.title);
	$('.ul-search-result-event-group').html(obj.args.list);
	$('.event-group-search-result-more').html(obj.args.more);
	$(document).click(function() {
                $("#event-group-search-result").hide();
            });
	$('#event-group-search-input').click(function(e)
	{
		$("#event-group-search-result").show();
		e.stopPropagation();
	})
}
/*==========#2 event_group_search==========*/

/*++++++++++search detail page function++++++++++*/
function update_search_category(keyword, sindex) 
{
	$.ajax({
		url: '../cgi/search_list.php',
		type: 'GET',
		dataType: 'text',
		data: {
			'keyword': keyword,
			'sindex': sindex,
		},
		beforeSend:function(data){ // Are not working with dataType:'jsonp'  		
      		$('.section-search-right-frame').html("<div><img src='../theme/images/loading.gif'/><div>");
    	},
		success: function(data){
			$(".section-search-frame-wrap").replaceWith(data);
			var hash = 'key='+keyword+'/sindex='+sindex;
			window.location.hash = hash;
		},
		error: function(data){
			serverError(null);
		}
	})
//	var url = 'search/detail.php?keyword='+keyword+'&sindex='+sindex;
//	visit(url);
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

function search_function_sindex()
{
	var sindex = 1;
	var keyword = $('#search-form-search-input').val();
/*++++++++++防止转义字符造成的bug++++++++++*/
	if ( keyword.length > 0 )
	{
		keyword = escapeSequenceAway(keyword);
	}
	
/*==========防止转义字符造成的bug==========*/
	var hash = window.location.hash;
	var URL = window.location.href;
	if (URL.indexOf("#key") == -1)
	{
		sindex = 1;
	}
	else
	{
		var index = URL.split("sindex=");
		sindex = index[1];
	}
	update_search_category(keyword, sindex);
}
/*==========search detail page function==========*/
/*==============================<search function>==============================*/

/*++++++++++++++++++++++++++++++<Screen Resolution>++++++++++++++++++++++++++++++*/
function screenResolution()
{
document.write(
"屏幕分辨率为："+screen.width+"*"+screen.height
+""+
"屏幕可用大小："+screen.availWidth+"*"+screen.availHeight
+""+
"网页可见区域宽："+document.body.clientWidth
+""+
"网页可见区域高："+document.body.clientHeight
+""+
"网页可见区域宽(包括边线的宽)："+document.body.offsetWidth
+""+
"网页可见区域高(包括边线的宽)："+document.body.offsetHeight
+""+
"网页正文全文宽："+document.body.scrollWidth
+""+
"网页正文全文高："+document.body.scrollHeight
+""+
"网页被卷去的高："+document.body.scrollTop
+""+
"网页被卷去的左："+document.body.scrollLeft
+""+
"网页正文部分上："+window.screenTop
+""+
"网页正文部分左："+window.screenLeft
+""+
"屏幕分辨率的高："+window.screen.height
+""+
"屏幕分辨率的宽："+window.screen.width
+""+
"屏幕可用工作区高度："+window.screen.availHeight
+""+
"屏幕可用工作区宽度："+window.screen.availWidth
);
}

function screenResolution_a()
{
	winWidth = $(window).width(),
    winHeight= $(window).height();
    console.log(winWidth);
    console.log(winHeight);
	console.log(screen.width);
	console.log(screen.height);
}
/*==============================<Screen Resolution>==============================*/


/* ^O^~^O^~^O^~^O^ <相册图片操作START> ^O^~^O^~^O^~^O^ */
$(".section-ordered-photo").ready(function() {
	$("#delete-photo").click(function() {
		$("#delete-photo").hide();
		$("#cancel-delete").show();
		$("input[name='delete_photo[]']").show();
		$("input[name='submit_delete_photo']").show();
	});
	$("#cancel-delete").click(function() {
		$("#delete-photo").show();
		$("#cancel-delete").hide();
		$("input[name='delete_photo[]']").hide();
		$("input[name='submit_delete_photo']").hide();
	});
});

// function view_full(photo_src) {
// 	$.ajax({
// 		url: '../cgi/photo_view_full.php',
// 		type: 'GET',
// 		dataType: 'text',
// 		data: {
// 			// 'photo_id': photo_id
// 			 'photo_src': photo_src
// 		},
// 		success: function(data){
// 			$("#photo-full").replaceWith(data);
// 			showPopup("#photo-view-full");
// 		},
// 		error: function(data){
// 			serverError(null);
// 		}
// 	})
// }

function view_full(photo_id) {
	$.ajax({
		url: '../cgi/photo_view_full.php',
		type: 'GET',
		dataType: 'text',
		data: {
			'photo_id': photo_id
		},
		success: function(data){
			$("#photo-full").replaceWith(data);
			showPopup("#photo-view-full");
		},
		error: function(data){
			serverError(null);
		}
	})
}

function view_full_group(photo_id) {
	$.ajax({
		url: '../cgi/photo_view_full.php',
		type: 'GET',
		dataType: 'text',
		data: {
			 'photo_id': photo_id
		},
		success: function(data){
			$("#photo-full").replaceWith(data);
			showPopup("#photo-view-full");
		},
		error: function(data){
			serverError(null);
		}
	})
}
/* TOT~TOT~TOT~TOT <相册图片操作END> TOT~TOT~TOT~TOT */

function error_redirect()
{
	var str0 = window.location.href;
	var str1 = document.referrer; 
	var str2 = "localhost";
	var str3 = "newbeerunningclub.org";
	var str4 = "8541";
	var str5 = "account";

	var self_or_not = strcomp_common(str1, str4) || strcomp_common(str1, str5);

	//for localhost test
	if ( strcomp_common(str1, str2) )
	{
		if (str0.length == str1.length)
		{
			window.location.href = window.location.href;
		}
		else
		{
			window.location.href = document.referrer;
		}
	}
	//for newbeerunningclub.org use
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

/*++++++++++++++++++++++++++++++++++++++++表单提交的检查++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++ #0 header search check ++++++++++++++++++++*/
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
/*==================== #0 header search check ====================*/

/*++++++++++++++++++++ #1 saleForm check ++++++++++++++++++++*/
function chk_saleForm(setSaleForm)
{
	var ticket_count = $("input[name='ticket_type_nums']").val();
	var unisale_count = $("input[name='unisalecount']").val();

	if ( ticket_count == 0 )
	{
		var alert_add = "<tr class='ticket_foot_before'>"
                            +"<td colspan='6'>"
								+"<div class='alert alert-info'>"
				            		+"<button type='button' class='close fui-cross' data-dismiss='alert'></button>"
				            		+"<span style='color: red;'>你什么都没有设置, 让我怎么让你通过?</span>"
				          		+"</div>"
				          	+"</td>"
				          +"</tr>";
		$(".ticket_foot").before(alert_add);

		return false;
	}

	for ( var i = 1; i <= unisale_count; i++ )
	{
		// console.log(setSaleForm.type_+i.value);
		if ( $("input[name='type_"+i+"']").val() == "" )
		{
			alert("第"+i+"种票的类型不能为空");
			$("input[name='type_"+i+"']").focus();

			return false;
		}
		else if ( $("input[name='price_"+i+"']").val() == "" )
		{
			alert("第"+i+"种票的票价不能为空");
			$("input[name='price_"+i+"']").focus();

			return false;
		}
		else if ( $("input[name='volume_"+i+"']").val() == "" )
		{
			alert("第"+i+"种票的数量不能为空");
			$("input[name='volume_"+i+"']").focus();

			return false;
		}
		else if ( $("input[name='volume_"+i+"']").val() == 0 )
		{
			alert("第"+i+"种票的数量不能为零");
			$("input[name='volume_"+i+"']").focus();

			return false;
		}
		else if ( $("input[name='tlimit_"+i+"']").val() == "" )
		{
			if ( $("input[name='volume_"+i+"']").val() < 20 )
			{
				$("input[name='tlimit_"+i+"']").val( $("input[name='volume_"+i+"']").val() );
			}
			else
			{
				$("input[name='tlimit_"+i+"']").val(20);
			}		
		}
		else if ( $("input[name='tlimit_"+i+"']").val() > $("input[name='volume_"+i+"']").val() )
		{
			$("input[name='tlimit_"+i+"']").val( $("input[name='volume_"+i+"']").val() );
		}
	}

	return true;
}

function chk_ModifysaleForm(setSaleForm)
{
	return true;
}
/*==================== #1 saleForm check ====================*/

/*++++++++++++++++++++ #2 ticketForm check ++++++++++++++++++++*/
function chk_ticketSale(home, devicetype, ticket_num)
{
	var custom = $("input[name='custom']").val();
	var custom_arr = custom.split('nycuni');
	var pid = custom_arr[0];

	var flag_zero 	=	ticket_num;
	var flag_nozero	=	-1;

	for ( var k = 1; k <= ticket_num; k++)
	{
		if ( $("#quantity_"+k).val() == 0 )
		{
			--flag_zero;
		}
		else
		{
			flag_nozero = k-1;
		}	
	}

	$("#nozero-flag-quantity").val($("#quantity_"+flag_nozero).val());

	var ticket_count 	=	$("input[name='ticket_type_nums']").val();
	var tax_count		=	$("#paypal-ticket-tax-all-id").val();

	if ( pid == 0 )
	{
		if ( devicetype == "phone" )
		{
			window.location.href = home;
		}
		else
		{
			show_login_panel();
		}

		return false;
	}
	else if ( flag_zero <= 0 )
	{
		alert('请至少选择一种购票方式');
		return false;
	}
	else if ( tax_count <= 0 )
	{
		showPopup('#show-free-order');
		return false;
	}

	return true;
}

function chk_paypal_free_order(paypalfreeorderForm)
{
	var item_name = '';
	var item_name_temp = '';
	var quantity = 0;
	var items = '';
	var num_cart_items = 0;
	var allowance = $("#paypal-free-order-allowance").val();

	// var html = "正在提交中, 请稍等"+"<img src='../theme/images/account/ellipsis.gif'/>";
	$(".btn-primary").attr("disabled","disabled").val('提交中..').css("cursor","default"); 
	$("#chkmsg").show();

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

	$("#free-order-num-cart-items").val(num_cart_items);
	$("#free-order-items").val(items);

    return true;
}

/*==================== #2 ticketForm check ====================*/

/*++++++++++++++++++++ #3 eventCreateForm check ++++++++++++++++++++*/
function event_create_check(eventCreateForm)
{
	/*++++++++++ first of all check uid ++++++++++*/
	var pid = $("#unisalepid").val();
	if ( pid <= 0 || pid == null )
	{
		alert("请先登陆");
		return false;
	}
	/*========== first of all check uid ==========*/
	var html = "<p>hello</p>";

	var url_hash = window.location.hash;
	if ( url_hash != '' )
	{
		window.location.hash = "";
	}

	for ( var i = 0; i < 10; i++ )
	{
		$("#ul-errorlist-"+i).html("");
	}

	/*+++++ check event title +++++*/
	var title = $("input[name='event_title']").val();
	if ( (typeof(title) == "undefined") || (title == '') )
	{
		html = "<li>您必须输入活动名称.</li>";
		$("#ul-errorlist-1").html(html);
		$("input[name='event_title']").focus();
		return false;
	}
	/*===== check event title =====*/

	/*+++++ check event location +++++*/
	var location_locale 	=	$("input[name='event_location_locale']").val();
	var location_street 	=	$("input[name='event_location_street']").val();
	var location_city 		=	$("input[name='event_location_city']").val();
	var location_state		=	$("#flat-ui-event-location-state").val();
	if ( (typeof(location_locale) == "undefined") || (location_locale == '') )
	{
		html = "<li>您必须输入活动地址.</li>";
		$("#ul-errorlist-2").html(html);
		$("input[name='event_location_locale']").focus();
		return false;
	}
	else if ( (typeof(location_street) == "undefined") || (location_street == '') )
	{
		html = "<li>请输入街道名, 门牌号.</li>";
		$("#ul-errorlist-2").html(html);
		$("input[name='event_location_street']").focus();
		return false;
	}
	else if ( (typeof(location_city) == "undefined") || (location_city == '') )
	{
		html = "<li>请输入城市名.</li>";
		$("#ul-errorlist-2").html(html);
		$("input[name='event_location_city']").focus();
		return false;
	}
	// if ( (typeof(location_state) == "undefined") || (location_state == '') || (location_state == null) )
	// {
	// 	html = "<li>请选择州.</li>";
	// 	$("#ul-errorlist-2").html(html);
	// 	$(".event_location_state .dropdown-toggle").focus();
	// 	return false;
	// }
	/*===== check event location =====*/

	/*+++++ check event time +++++*/
	var time_start_date	=	$("#datepicker-01").val();
	var time_start_hh 	=	$("#flat-ui-event-time-start-hh").val();
	var time_start_mm 	=	$("#flat-ui-event-time-start-mm").val();
	var time_end_date	=	$("#datepicker-02").val();
	var time_end_hh 	=	$("#flat-ui-event-time-end-hh").val();
	var time_end_mm 	=	$("#flat-ui-event-time-end-mm").val();
	if ( (typeof(time_start_date) == "undefined") || (time_start_date == '') )
	{
		html = "<li>请选择活动开始日期.</li>";
		$("#ul-errorlist-3").html(html);
		$("#datepicker-01").focus()
		return false;
	}
	else if ( (typeof(time_start_hh) == "undefined") || (time_start_hh == '') || (time_start_hh == null) )
	{
		html = "<li>请选择活动开始日期的具体时间.</li>";
		$("#ul-errorlist-3").html(html);
		$(".input-time-start-hh .dropdown-toggle").focus();
		return false;
	}
	else if ( (typeof(time_start_mm) == "undefined") || (time_start_mm == '') || (time_start_mm == null) )
	{
		html = "<li>请选择活动开始日期的具体时间.</li>";
		$("#ul-errorlist-3").html(html);
		$(".input-time-start-mm .dropdown-toggle").focus();
		return false;
	}
	else if ( (typeof(time_end_date) == "undefined") || (time_end_date == '') )
	{
		html = "<li>请选择活动结束日期.</li>";
		$("#ul-errorlist-3").html(html);
		$("#datepicker-02").focus()
		return false;
	}
	else if ( (typeof(time_end_hh) == "undefined") || (time_end_hh == '') || (time_end_hh == null) )
	{
		html = "<li>请选择活动结束日期的具体时间.</li>";
		$("#ul-errorlist-3").html(html);
		$(".input-time-end-hh .dropdown-toggle").focus();
		return false;
	}
	else if ( (typeof(time_end_mm) == "undefined") || (time_end_mm == '') || (time_end_mm == null) )
	{
		html = "<li>请选择活动结束日期的具体时间.</li>";
		$("#ul-errorlist-3").html(html);
		$(".input-time-end-mm .dropdown-toggle").focus();
		return false;
	}
	/*===== check event time =====*/

	/*+++++ check event logo +++++*/
	var logo_file_value = $("#logo-file-id").val();

	if ( !(typeof(logo_file_value) == "undefined") && (logo_file_value != '') )
	{
		if ( !Check_FileType(logo_file_value) )
		{
			show_form_error("uploadLogoForm", "uploadPhotoTypeError");
			return false;
		}
	}
	else
	{
		html = "<li>请上传活动海报</li>";
		$("#ul-errorlist-4").html(html);
		// $("input[name='file']").focus();
		document.getElementById("trigger-go-set-sale-href-id-1").click();
		return false;
	}
	/*===== check event logo =====*/

	/*+++++ check event description +++++*/
	var description = $("textarea[name='event_description']").val();
	if ( (typeof(description) == "undefined") || (description == '') )
	{
		html = "<li>请添加活动描述.</li>";
		$("#ul-errorlist-5").html(html);
		$("textarea[name='event_description']").focus();
		return false;
	}
	/*===== check event description =====*/

	/*+++++ check event sale +++++*/
	var unisalenot = document.getElementById("uni-sale-checknot").checked;

	if ( !(typeof(unisalenot) == "undefined") )
	{
		if ( unisalenot )
		{
			var ticket_count = $("input[name='ticket_type_nums']").val();
			var unisale_count = $("input[name='unisalecount']").val();
			var event_size_temp = 0;

			if ( ticket_count == 0 )
			{
				document.getElementById("trigger-go-set-sale-href-id-2").click();
				alert("请至少添加一个票种, 否则请取消售票");

				html = "<li>请至少添加一个票种, 否则请取消售票.</li>";
				$("#ul-errorlist-6").html(html);
				
				return false;
			}

			for ( var i = 1; i <= unisale_count; i++ )
			{
				var type_val = $("input[name='type_"+i+"']").val();
				
				if ( !(typeof(type_val) == "undefined") )
				{
					if ( $("input[name='type_"+i+"']").val() == "" )
					{
						$("input[name='type_"+i+"']").focus();
						html = "<li>票的类型不能为空.</li>";
						$("#ul-errorlist-6").html(html);

						return false;
					}
					else if ( $("input[name='volume_"+i+"']").val() == "" )
					{
						$("input[name='volume_"+i+"']").focus();
						html = "<li>票的数量不能为空.</li>";
						$("#ul-errorlist-6").html(html);

						return false;
					}
					else if ( $("input[name='volume_"+i+"']").val() == 0 )
					{
						$("input[name='volume_"+i+"']").focus();
						html = "<li>票的数量不能为零.</li>";
						$("#ul-errorlist-6").html(html);

						return false;
					}
					else if ( $("input[name='price_"+i+"']").val() == "" )
					{
						$("input[name='price_"+i+"']").focus();
						html = "<li>票价不能为空.</li>";
						$("#ul-errorlist-6").html(html);

						return false;
					}

					if ( $("input[name='price_"+i+"']").val() == "free" )
					{
						$("input[name='price_"+i+"']").val(0);
					}
					// parseInt( $("#ticket-type-nums").val() );

					event_size_temp += parseInt( $("input[name='volume_"+i+"']").val() );
				}
			}
			$("input[name='event_size']").val(event_size_temp);
		}
		else
		{
			/*+++++  check event population +++++*/
			var population = $("input[name='event_size']").val();
			if ( (typeof(population) == "undefined") || (population == '') || (population == null) )
			{
				$("input[name='event_size']").focus();
				html = "<li>若不售票, 请填写活动允许参与人数.</li>";
				$("#ul-errorlist-9").html(html);
				return false;
			}
			/*===== check event population =====*/
		}
	}
	/*===== check event sale =====*/

	// /*+++++ check event category +++++*/
	// var event_category = $("#flat-ui-event-category").val();
	// if ( (typeof(event_category) == "undefined") || (event_category == '') || (event_category == null) )
	// {
	// 	html = "<li>您必须选择活动类型.</li>";
	// 	$("#ul-errorlist-7").html(html);
	// 	$(".div-event-create-category .dropdown-toggle").focus();
	// 	return false;
	// }
	// /*===== check event category =====*/

	// /*+++++ check event create option +++++*/
	// var create_option = $("#flat-ui-event-option").val();
	// if ( (typeof(create_option) == "undefined") || (create_option == '') || (create_option == null) )
	// {
	// 	html = "<li>请选择创建活动身份.</li>";
	// 	$("#ul-errorlist-8").html(html);
	// 	$(".div-event-create-option .dropdown-toggle").focus();
	// 	return false;
	// }
	// /*===== check event create option =====*/

	return true;

}

function uniSalechecknot()
{
	var unisalenot = document.getElementById("uni-sale-checknot").checked;
	if ( unisalenot )
	{
		$("#event_details_sale").removeClass("uni-switch-off").addClass("uni-switch-on");
		$("#event_details_numbers").removeClass("uni-switch-on").addClass("uni-switch-off");
		$("input[name='uni_sale_checknot_hidden']").val("1");
		// $(".uni-salenot .g-cell-v3").removeClass("uni-switch-on").addClass("uni-switch-off");
	}
	else
	{
		$("#event_details_sale").removeClass("uni-switch-on").addClass("uni-switch-off");
		$("#event_details_numbers").removeClass("uni-switch-off").addClass("uni-switch-on");
		$("input[name='uni_sale_checknot_hidden']").val("0");
		$("input[name='event_size']").val("");
		// $(".uni-salenot .g-cell-v3").removeClass("uni-switch-off").addClass("uni-switch-on");
	}
}
/*==================== #3 eventCreateForm check ====================*/

/*++++++++++++++++++++ #4 uploadLogoForm Check ++++++++++++++++++++*/
function logo_submit_check(uploadLogoForm)
{
	var logo_file_value = $("#logo-file-id").val();

	if ( !(typeof(logo_file_value) == "undefined") && (logo_file_value != '') )
	{
		if ( Check_FileType(logo_file_value) )
		{
			return true;
		}
		else
		{
			show_form_error("uploadLogoForm", "uploadPhotoTypeError");
			return false;
		}
	}

	show_form_error("uploadLogoForm", "uploadPhotoNoSet");
	return false;
}

function Check_FileType(str)
{
	if(str.length>0)
	{
		var pos = str.lastIndexOf(".");
		var lastname = str.substring(pos,str.length)  //此处文件后缀名也可用数组方式获得str.split(".")
		if (lastname.toLowerCase()!=".jpg" && lastname.toLowerCase()!=".gif" && lastname.toLowerCase()!=".png")
		{
			// alert("您上传的文件类型为"+lastname+"，图片必须为.jpg,.gif,.png类型，请重新上传");
			return false;
		}
	}

	return true;
}

/*==================== #4 uploadLogoForm Check ====================*/

/*++++++++++++++++++++ #5 runningcardForm check ++++++++++++++++++++*/
function run_card_check(eventCreateForm)
{
	/*++++++++++ first of all check uid ++++++++++*/
	var pid = $("#nbrcpid").val();
	if ( pid <= 0 || pid == null )
	{
		//alert("请先登陆");
		show_login_panel();
		return false;
	}
	/*========== first of all check uid ==========*/
	var html = "<p>hello</p>";

	var url_hash = window.location.hash;
	if ( url_hash != '' )
	{
		window.location.hash = "";
	}

	for ( var i = 0; i < 10; i++ )
	{
		$("#ul-errorlist-"+i).html("");
	}

	/*+++++ check card distance +++++*/
	var distance = $("input[name='card_distance']").val();
	if ( (typeof(distance) == "undefined") || (distance == '') )
	{
		html = "<li>您必须输入奔跑距离.</li>";
		$("#ul-errorlist-1").html(html);
		$("input[name='card_distance']").focus();
		return false;
	}
	else if ( isNaN(distance) )
	{
		html = "<li>请输入数字.</li>";
		$("#ul-errorlist-1").html(html);
		$("input[name='card_distance']").focus();
		return false;
	}
	/*===== check card distance =====*/

	/*+++++ check card image +++++*/
	var logo_file_value = $("#logo-file-id").val();

	if ( !(typeof(logo_file_value) == "undefined") && (logo_file_value != '') )
	{
		if ( !Check_FileType(logo_file_value) )
		{
			show_form_error("uploadLogoForm", "uploadPhotoTypeError");
			return false;
		}
	}
	// else
	// {
	// 	html = "<li>请上传活动海报</li>";
	// 	$("#ul-errorlist-4").html(html);
	// 	document.getElementById("trigger-go-set-sale-href-id-1").click();
	// 	return false;
	// }
	/*===== check card image =====*/

	/*+++++ check card description +++++*/
	var description = $("textarea[name='runningcard_description']").val();
	if ( (typeof(description) == "undefined") || (description == '') )
	{
		html = "<li>请添加活动描述.</li>";
		$("#ul-errorlist-5").html(html);
		$("textarea[name='runningcard_description']").focus();
		return false;
	}
	/*===== check card description =====*/


	return true;
}
/*==================== #4 uploadLogoForm Check ====================*/

/*
To Do...
*/

/*========================================表单提交的检查========================================*/


