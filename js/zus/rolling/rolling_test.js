
var speed=30;
var tabLeft=document.getElementById("rolling");
var tab1=document.getElementById("play");
var tab2=document.getElementById("stop");
tab2.innerHTML=tab1.innerHTML;




function Marquee1()
{
	if(tabLeft.scrollLeft>=tab2.offsetWidth)
	{
		tabLeft.scrollLeft-=tab1.offsetWidth
	}
	else
	{
		tabLeft.scrollLeft+=4;
	}
}



var MyMar=setInterval(Marquee1,speed);


tabLeft.onmouseover=function() {clearInterval(MyMar)};
tabLeft.onmouseout=function() {MyMar=setInterval(Marquee1,speed)};


/*下面的已经试过有用*/

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
<head> 
<title>多张图片垂直不间断循环滚动</title> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script> 
<script type="text/javascript">
//定时器间隔 
var interval=30;
var objInterval=null;
 
$(document).ready(function(){
//用上部的内容填充下部
$("#bottom").html($("#top").html());
 
//给显示的区域绑定鼠标事件
$("#content").bind("mouseover",function(){StopScroll();});
$("#content").bind("mouseout",function(){StartScroll();});
 
//启动定时器
StartScroll();
}); 
 
//启动定时器，开始滚动
function StartScroll()
{
	objInterval=setInterval("verticalloop()",interval);
}
 
//清除定时器，停止滚动
function StopScroll(){
 window.clearInterval(objInterval);
}
 
//控制滚动
function verticalloop(){
//判断是否上部内容全部移出显示区域
//如果是，从新开始;否则，继续向上移动
if($("#top").outerHeight()-$("#content").scrollTop()<=0){
      var top=$("#content").scrollTop()-$("#top").outerHeight();
      $("#content").scrollTop(top);
}else{
      var top=$("#content").scrollTop()+1;
      $("#content").scrollTop(top);
} 
 
$("#foot").html("scrollTop:"+$("#content").scrollTop());
}
</script>
</head> 
<body> 
<div id="title" style="width:100%;height:40px;">看看滚动图片</div>
<!--// 
使用display:inline;white-space:nowrap，使不换行。 
使用overflow:hidden隐藏超出的部分。
保持top、bottom的高度一致
//-->
 
<div id="content" style="width:300px;height:300px;overflow:hidden;"> 
<div id="top" style="width:718px;height:1050px;"> 
<img src="images/1.png" /><br/>
<div><p>动态滚动</p></div>
<img src="images/2.png" /><br/>
<div><p>动态滚动</p></div>
<img src="images/3.png" /><br/>
<div><p>动态滚动</p></div>
<img src="images/3.png" /><br/>
<img src="images/3.png" /><br/>
<img src="images/3.png" /><br/>
</ul> 
</div>
<div id="bottom" style="width:1636px;height:1028px;"></div> 
</div>
<div id="foot">
</div>
<p>hello</p> 
</body>
</html>






