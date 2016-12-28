$(".about-nav").ready(function() {
	$(window).scroll(function() {
		// $("#location").text(($(".about-video").offset().top + $(".about-video").height()) + "|" + $(window).scrollTop());
    	if(($(".about-video").offset().top + $(".about-video").height()) <= $(window).scrollTop()) {
    		$(".about-nav").css({"position": "fixed", "top": "0"});
    	}
    	else {
    		$(".about-nav").css({"position": "relative", "top": "0"});
    	}
    });
});

function about_scrollTo(id) {
	var aTag = $(".section-about-" + id);
	$('html,body').animate({scrollTop: aTag.offset().top}, 800);
}