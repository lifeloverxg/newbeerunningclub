function init() {
	makeStyle()
	$(window).resize(makeStyle)
}

function makeStyle() {
	var width = $(window).width()
		, height = $(window).height()
		, min = width > height ? height : width;
	$('.main-menu>li>a').width(height / 5.2).height($('nav>ul>li').width()).css('line-height', $('nav>ul>li').width() + 'px')
	$('.ul-recommend').height(min * 0.7).width($('.ul-recommend').height())
	$('.div-recommend').css("margin-left", (width * 0.6 - min * 0.7) > 0? (width * 0.6 - min * 0.7) : 0)
	$('.ul-recommend>li').outerWidth($('.ul-recommend').width() / 2).outerHeight($('.ul-recommend').width() / 2)
	$('.ul-recommend>li img').width($('.ul-recommend>li').innerWidth()).height($('.ul-recommend>li').innerWidth())
}