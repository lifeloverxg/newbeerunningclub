<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @login:login</h1>');
	}
	
	// header('Location: '.$home);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>利用before.after制作时尚焦点图相框 - 觉唯</title>
<style>
body, ul, li, p {margin:0; padding:0; font-family:Verdana, Geneva, sans-serif;}
ul li {list-style:none;}
img {border:0 none}
body {background:url(bg.jpg) repeat;}
.title {background-color:rgba(0,0,0,0.56); text-align:center; width:100%; position:fixed; top:0; left:0; padding:5px 0;}
.title a {color:#FFF; text-decoration:none; font-size:16px; font-weight:bolder; line-height:24px;}
.main {background-color:#FFF; width:100%; height:auto; overflow:hidden; border-top:1px solid #e8e8e8; border-bottom:1px solid #e8e8e8; position:fixed; top:50%; margin-top:-128px;}
.content {width:788px; margin:auto; height:auto; overflow:hidden; padding:30px; }
.content ul li {float:left; height:176px; border-right:1px solid #DDDDDD; position:relative; padding:10px;}
.focus {background:rgba(250,250,250,0.5); width:174px; height:174px; border:1px dashed #666; position:absolute; left:10px; top:10px; display:nne;}
.focus:before {width:174px; height:134px; border-left:1px solid #fff; border-right:1px solid #fff; content:''; position:absolute; left:-1px; top:20px;}
.focus:after {width:134px; height:174px; border-top:1px solid #fff; border-bottom:1px solid #fff; content:''; position:absolute; top:-1px; left:20px;}
.content ul li:hover .focus {display:block;}
#noborder {border-right:0 none;}
.author {display:block; text-decoration:none; color:#333; font-size:14px; font-weight:bolder; position:absolute; right:20px; bottom:15px; font-style:italic;}
</style>
</head>

<body>
<div class="title"><a href="http://www.jiawin.com/css-before-after/">利用before.after制作时尚焦点图相框（返回文章）</a></div>
<div class="main">
<div class="content">
<ul>
  <li><a href="http://www.jiawin.com" target="_blank"><img src="http://www.jiawin.com/demos/423/jiawin_1.jpg" />
  <p class="focus"></p></a></li>
  <li><a href="http://www.jiawin.com" target="_blank"><img src="http://www.jiawin.com/demos/423/jiawin_2.jpg" />
  <p class="focus"></p></a></li>
  <li><a href="http://www.jiawin.com" target="_blank"><img src="http://www.jiawin.com/demos/423/jiawin_3.jpg" />
  <p class="focus"></p></a></li>
  <li id="noborder"><a href="http://www.jiawin.com" target="_blank"><img src="http://www.jiawin.com/demos/423/jiawin_4.jpg" />
  <p class="focus"></p></a></li>
</ul>
</div>
<div ><a class="author" title="Welcome to www.jiawin.com" href="http://www.jiawin.com" target="_blank">Design by:jiawin.com</a></div>
</div>
<script type="text/javascript">
// var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
// document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F3e31620eb0a4e69c61c07f5f76cc46c8' type='text/javascript'%3E%3C/script%3E"));
</script>

</body>
</html>
