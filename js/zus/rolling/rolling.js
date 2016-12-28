//定时器间隔 
var interval=30;
var objInterval=null;
 
$("#trend-wrap").ready(function(){
//用上部的内容填充下部
$("#trend-bottom").html($("#trend-top").html());
 
//给显示的区域绑定鼠标事件
$("#trend-content").bind("mouseover",function(){StopScroll();});
$("#trend-content").bind("mouseout",function(){StartScroll();});
 
//启动定时器
StartScroll();
}); 
 
//启动定时器，开始滚动
function StartScroll()
{
	objInterval=setInterval("verticalloop()",interval);
}
 
//清除定时器，停止滚动
function StopScroll()
{
	window.clearInterval(objInterval);
}
 
//控制滚动
function verticalloop()
{
//判断是否上部内容全部移出显示区域
//如果是，从新开始;否则，继续向上移动
	if ( $("#trend-top").outerHeight()-$("#trend-content").scrollTop() <= 0 )
	{
		var top=$("#trend-content").scrollTop()-$("#trend-top").outerHeight();
		$("#trend-content").scrollTop(top);
	}
	else
	{
		var top=$("#trend-content").scrollTop()+1;
		$("#trend-content").scrollTop(top);
	} 
	 
//	$("#trend-foot").html("scrollTop:"+$("#trend-content").scrollTop());
}
