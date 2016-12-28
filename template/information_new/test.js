$(document).ready(function(){
        $(".nav-user").hover(function(){
	    $(".nav-ctrl-panel").css("display","block");
    },
    function(){
    	$(".nav-ctrl-panel").css("display","none");
});
        $(".post-article").click(function(event) {
        if (!$(event.target).isChildAndSelfOf(".post-article-frame"))
           hide_article_panel();
    });
});
function search_relocation(pid)
{
	var keyword = $("#search-content").val();
	if (keyword.length > 0)
	{
		var url = 'search/detail.php?keyword='+keyword;
		visit(url);
	}
}
function show_article_panel()
{
	$(".post-article").css("display","block");
}
function hide_article_panel()
{
	$(".post-article").css("display","none");
}