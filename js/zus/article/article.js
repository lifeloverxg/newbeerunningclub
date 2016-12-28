//综合页面效果
// $(".information-browser-wrap").ready(function() {
// 	$(".locate-first").click(function() {
// 		$(".information-top").animate({top: '0', opacity: '0.8'}, 800);
// 		$(".information-middle").animate({top: '0', opacity: '0.2'}, 800);
// 		$(".information-bottom").animate({top: '0', opacity: '0.2'}, 800);
// 	});
// 	$(".locate-second").click(function() {
// 		$(".information-top").animate({top: '-350px', opacity: '0.2'}, 800);
// 		$(".information-middle").animate({top: '-350px', opacity: '0.8'}, 800);
// 		$(".information-bottom").animate({top: '-350px', opacity: '0.2'}, 800);
// 	});
// 	$(".locate-third").click(function() {
// 		$(".information-top").animate({top: '-750px', opacity: '0.2'}, 800);
// 		$(".information-middle").animate({top: '-750px', opacity: '0.2'}, 800);
// 		$(".information-bottom").animate({top: '-750px', opacity: '0.8'}, 800);
// 	});
// });

function init() {
    $(window).scroll(function() {
        if($(window).scrollTop() <= 600) {
            $(".locate-first").css("background", "rgba(235, 70, 162, 0.8)");
            $(".locate-second").css("background", "rgba(0, 0, 0, 0.8)");
            $(".locate-third").css("background", "rgba(0, 0, 0, 0.8)");
        }
        if($(window).scrollTop() > 600 && $(window).scrollTop() < 1200) {
            $(".locate-first").css("background", "rgba(0, 0, 0, 0.8)");
            $(".locate-second").css("background", "rgba(211, 203, 7, 0.8)");
            $(".locate-third").css("background", "rgba(0, 0, 0, 0.8)");
        }
        if($(window).scrollTop() >= 1200) {
            $(".locate-first").css("background", "rgba(0, 0, 0, 0.8)");
            $(".locate-second").css("background", "rgba(0, 0, 0, 0.8)");
            $(".locate-third").css("background", "rgba(61, 149, 228, 0.8)");
        }
    });

    $(".popup-main").click(function(event) {
        if (!$(event.target).isChildAndSelfOf(".add-expression-wrap"))
            $(".show-expression").hide();
    });
}

//综合页面滑动标签
function scrollToAnchor(id){
    var aTag = $(".information-" + id);
    $('html,body').animate({scrollTop: aTag.offset().top - 60}, 800);
}

//综合页面吐槽版块效果
function information_3_viewleft() {
    if($("#information-3-index").val() > 1) {
        $("#information-3-index").val($("#information-3-index").val() - 1);
        $(".information-3-left").animate({left: '+=60%'}, 800);
        $(".information-3-middle").animate({left: '+=60%'}, 800);
        $(".information-3-right").animate({left: '+=60%'}, 800);
        set_tucao_position($("#information-3-index").val());
    }
}
function information_3_viewright() {
    if($("#information-3-index").val() < 3) {
        $("#information-3-index").val($("#information-3-index").val() - (-1));
        $(".information-3-left").animate({left: '-=60%'}, 800);
        $(".information-3-middle").animate({left: '-=60%'}, 800);
        $(".information-3-right").animate({left: '-=60%'}, 800);
        set_tucao_position($("#information-3-index").val());
    }
}

//吐槽定位
function set_tucao_position(index_x) {
    switch (index_x) {
            case "1":
                $(".information-3-left").css({"background-color": "rgb(255, 255, 255)", "opacity": "1"});
                $(".information-3-middle").css({"background-color": "rgb(189, 207, 207)", "opacity": "0.6"});
                $(".information-3-right").css({"background-color": "rgb(189, 207, 207)", "opacity": "0.6"});
                $("#tucao-title-1").css({"text-align": "center"});
                $("#tucao-title-2").css({"text-align": "left"});
                $("#tucao-title-3").css({"text-align": "left"});
                break;
            case "2":
                $(".information-3-left").css({"background-color": "rgb(189, 207, 207)", "opacity": "0.6"});
                $(".information-3-middle").css({"background-color": "rgb(255, 255, 255)", "opacity": "1"});
                $(".information-3-right").css({"background-color": "rgb(189, 207, 207)", "opacity": "0.6"});
                $("#tucao-title-1").css({"text-align": "right"});
                $("#tucao-title-2").css({"text-align": "center"});
                $("#tucao-title-3").css({"text-align": "left"});
                break;
            case "3":
                $(".information-3-left").css({"background-color": "rgb(189, 207, 207)", "opacity": "0.6"});
                $(".information-3-middle").css({"background-color": "rgb(189, 207, 207)", "opacity": "0.6"});
                $(".information-3-right").css({"background-color": "rgb(255, 255, 255)", "opacity": "1"});
                $("#tucao-title-1").css({"text-align": "right"});
                $("#tucao-title-2").css({"text-align": "right"});
                $("#tucao-title-3").css({"text-align": "center"});
                break;
            default:
                break;
    }
}

//吐槽版块ajax
function update_tucao_category(category) {
    var title = $("#tucao"+category+"_title").val();
    var content = $("#tucao"+category+"_content").val();
    var data = {};
    switch (category) {
        case 6:
            data = {'tucao6_title': title, 'tucao6_content': content}; break;
        case 7:
            data = {'tucao7_title': title, 'tucao7_content': content}; break;
        case 8:
            data = {'tucao8_title': title, 'tucao8_content': content}; break;
        default:
            break;
    }
    $.ajax({
        url: '../cgi/tucao_' + category + '.php',
        type: 'POST',
        dataType: 'text',
        data: data,
        success: function(data){
            $(".section-tucao-"+category).replaceWith(data);
        },
        error: function(data){
            serverError(null);
        }
    })
}

//插入表情
function show_expression() {
    $(".show-expression").toggle();
}

function choose_exp(obj) {
    $("#post-article-div").focus();
    var image = "<img src='" + $(obj).attr("src") + "' value='" + $(obj).attr("value") + "' class='article-expression' title='" + $(obj).attr("title") + "' alt='" + $(obj).attr("alt") + "'>";
    insertHtmlAtCaret(image);
    $(".show-expression").hide();
}

function insertHtmlAtCaret(html) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();
            // Range.createContextualFragment() would be useful here but is
            // non-standard and not supported in all browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);
            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }
}

function copyTotextarea() {
    var str = String($("#post-article-div").html()).replace(/<img/g, '{[img}').replace(/<div>/g, '{[br]}');
    $("#post-article-content").text(str);
}