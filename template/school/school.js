 $(window).load(function(){
 
    var h1 = $("#school-logo").height()+50;
    $(".school-intro").height(h1);

     var h2 = $(".event-logo").width();
    $(".event-logo").height(h2*2/3);
    $(".event-place").height(h2*0.4);

    var h3 = $(".event-title").height()+$(".school-event-list").height()+40;
    $(".school-event").height(h3);

    var h7 = $(".school-comment").height();

    $(".school-frame").height(h1+h3+h7+300);

    var h4 = $(".share-frame").width();
    $(".share-frame").height(h4*0.5);

    $(".share-header").height(h4/7);

    $(".school-admin").height(h4*0.6);

    $(".school-member").height(h4*0.95);

    var h5 = $(".share-header").height();
    $(".right-title").css("line-height",h5+"px");

    var h6 = $(".share-wechat").height();
    $(".NYCuni-com").css("line-height",0.32*h6+"px");
 
   
    })