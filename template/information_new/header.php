<!DOCTYPE html>
<html lang="utf-8">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="<?php echo $home; ?>theme/icon/favicon.ico" />     

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"> </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"> </script>
    <script src="<?php echo $home . "js/zus/common.js"; ?>"></script> 
    <script src="<?php echo $home . "js/analytics/google_analytics.js"; ?>"> </script>
    <script src="<?php echo $home . "js/zus/account/panel_sign.js"; ?>"> </script>

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-35280251-1', 'nycuni.com');
            ga('send', 'pageview');

        </script>
        <script>
            function visit(url)
            {
                window.location.href='<?php echo $home; ?>'+url;
            }
        </script>

<?php foreach ($stylesheet as $value) { ?>
        <link rel="stylesheet" href="<?php echo $home . $value; ?>">
<?php } ?>

<?php foreach ($javascript as $value) { ?>
        <script src="<?php echo $home . $value; ?>"></script>
<?php } ?>

<title> <?php echo $title ?></title>

</head>

<body>

    <div class="nav-header">
    	<div  class="nav-bottom-layer">
           <div class="nav-middle-layer">
    		<div class="nav-upper-layer">
<!-- 网站logo和名称-->
    			<div class="nav-logo">
    				<a href="<?php echo $home; ?>">
    			         <img  src="<?php echo $home."theme/images/logo_nycuni.png"; ?>">
    			    </a>
    	        </div>
<!-- 导航栏 -->
    			<div class="nav-main-header">
                    <a href="<?php echo $home . $links['event'];?>">
    				    <div class="nav-main-topic" <?php if (preg_match("/\/event/i", $_SERVER['REQUEST_URI']) > 0) echo "style='background-color: rgba(19, 72, 110, 0.6);'"?>>
    					    <span>
    					     活动
    				        </span>
    				    </div>
                    </a>
                    <a href="<?php echo $home . $links['group'];?>">
    				<div class="nav-main-topic" <?php if (preg_match("/\/group/i", $_SERVER['REQUEST_URI']) > 0) echo "style='background-color: rgba(19, 72, 110, 0.6);'"?>>
    					<span>
    					    群组
    					</span>
    				</div>
                    </a>
                    <a <?php if(isset($_SESSION['auth']) && ($_SESSION['auth'] != "")) echo "href=\"".$home.$links['people']."\"";
                            else echo "href=\""."javascript:"."\""." "."onclick=\""."show_login_panel()"."\"";?>> 
    				<div class="nav-main-topic" <?php if (preg_match("/\/people/i", $_SERVER['REQUEST_URI']) > 0) echo "style='background-color: rgba(19, 72, 110, 0.6);'"?>>
    					<span>
    				         个人    			
    					</span>    
    				</div>
                    </a>
                    <a href="<?php echo $home . $links['faq'];?>">
    				<div class="nav-main-topic" <?php if (preg_match("/\/information/i", $_SERVER['REQUEST_URI']) > 0) echo "style='background-color: rgba(19, 72, 110, 0.6);'"?>>
    					<span>
    					    综合
    					</span>
    				</div> 
                    </a>			  
    		    </div>

 <?php if (isset($_SESSION['auth'])) { ?>      
<!-- 用户控制面板 -->
                <div class="nav-user">         
                    <div class="nav-setting">
                        <a href="<?php echo $home . $links['people']; ?>">
                	        <span name="settings">| 设置<img src= <?php echo $home."theme/images/arrow_down.png" ?> style="height: 8px; padding-left: 4px;"></span>
                	        <span name="username"> <?php echo $auth['title']; ?></span>
                        </a>
                    </div>
<!-- 细节 -->
                    <div class="nav-ctrl-panel">
                	    <ul>
                		    <li><a href="<?php echo $home . $links['setting'] ?>">账户设置 </a></li>
                		    <li><a href="<?php echo $home . $links['help'] ?>">帮助支持</a></li>
                		    <li><a href="<?php echo $home . $links['logout'] ?>">退出登录</a></li>
                	    </ul>
                    </div>
                </div>
<?php } else { ?>
                <div class="nav-login">
                    <span> 
                        <a href="javascript:" onclick="show_login_panel()">登录</a>
                    </span>
                </div>
<?php } ?>      
<?php 
                $auth = Authority::get_auth_arr();
                $friend_search = array(
                    'catalog' => 0,
                    'keyword' => '',
                    'func' => array(
                                    'assist' => 'friend_search('.$auth['uid'].')',
                                    'search' => 'search_relocation('.$auth['uid'].')'
                            )
                );
                $search = SearchDAO::search_func();
?>

<!-- 搜索栏 -->
                <div class="nav-search">
                        <input id="search-content" type="text" placeholder="Search now...">
                        <a href="javascript: <?php echo $friend_search['func']['search']; ?>">
                            <img src= "<?php echo $home."theme/images/search.png" ?>">              
                        </a>
                </div>
    		</div>
    	</div>	
        </div>
    </div>	



<!-- 浮动登录窗口 -->    
<?php 
        $side = 1;
        include $home . "template/common/popup_frames/login_panel.php";
?>

<!-- Content Start-->

   



