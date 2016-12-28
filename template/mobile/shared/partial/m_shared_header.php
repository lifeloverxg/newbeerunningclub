<!DOCTYPE html>
<html lang="utf-8">
	<head>
		<meta charset="utf-8" />
        <meta name="keywords" content="纽约新蜂, NewBee Running Club, NewBee, 跑步, 马拉松, NYRR, nyrr, nyc, 纽约, 约跑, socialplatform, event, group, club">
        <meta name="description" content="纽约新蜂, NewBee Running Club, NewBee, 跑步, 马拉松, NYRR, nyrr, nyc, 纽约, 约跑, socialplatform, event, group, club">
        <meta property="wb:webmaster" content="9d82975a412d5dd8" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=0"/>
		
		<link rel="shortcut icon" href="<?php echo $home . $links['favicon']; ?>" />
		<link rel="stylesheet" href="<?php echo $home . "theme/bootstrap/bootstrap300.min.css"; ?>">
		<link rel="stylesheet" href="<?php echo $home . "theme/bootstrap/bootstrap.css"; ?>">
		<link rel="stylesheet" href="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/css/flat-ui.css"; ?>">
		<link rel="stylesheet" href="<?php echo $home . $links['m_css']; ?>">
		<link rel="stylesheet" href="<?php echo $home . "theme/zus/mobile_css/common.css"; ?>">
<?php foreach ($m_stylesheet as $value) { ?>
		<link rel="stylesheet" href="<?php echo $home . $value; ?>">
		<?php } ?>
		
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
        <!--<script src="<?php echo $home . "js/google/jquery.min.js"; ?>"></script>-->
		<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>-->
        <!--<script src="<?php echo $home . "js/google/mapapi.js"; ?>"></script>-->
		<!-- Load Flatui JS here for greater good =============================-->
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/jquery-1.8.3.min.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/jquery-ui-1.10.3.custom.min.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/jquery.ui.touch-punch.min.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/bootstrap.min.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/bootstrap-select.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/bootstrap-switch.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/flatui-checkbox.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/flatui-radio.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/holder.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/flatui-fileinput.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/jquery.tagsinput.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/jquery.placeholder.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/typeahead.js"; ?>"></script>
		<script src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/js/application.js"; ?>"></script>
		<!-- Load JS here for greater good =============================-->
		<script src="<?php echo $home . "js/zus/account/panel_sign.js"; ?>"></script>
		<script src="<?php echo $home . "js/analytics/google_analytics.js"; ?>"></script>
		<script src="<?php echo $home . $links['m_js']; ?>"></script>
		<?php foreach ($m_javascript as $value) { ?>
		<script src="<?php echo $home . $value; ?>"></script>
		<?php } ?>

		<script>
		function visit(url)
		{
			window.location.href='<?php echo $home; ?>'+url;
		}
		</script>

		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-35280251-1', 'nycuni.com');
		ga('send', 'pageview');
		</script>

		<title><?php echo $title; ?></title>
	</head>
	<body>
		<div class="nav-header nycuni-header">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01" onclick="header_collapse()" style="float: right;">
						<span class="sr-only">Toggle navigation</span>
					</button>

					<a class="navbar-brand" href="<?php echo $home; ?>">
						<img src="<?php echo $home."theme/images/logo_white.png"; ?>">
					</a>
					<a class="navbar-brand nav-brand-span" href="<?php echo $home; ?>">
						<!-- <img src="<?php echo $home."theme/images/header_span.png"; ?>">
						<span>
							<img  src="<?php echo $home."theme/images/header_span_span.png"; ?>">
						</span> -->
						<span style="margin-top: 8px; text-transform: none;">纽约新蜂跑团</span>
					</a>
<?php if (isset($_SESSION['auth'])) { ?>
					<a href="<?php echo $home. "people"?>" class="navbar-brand" style="float: right;">
					<img class="logo-medium" src="<?php echo $home.$auth['image']; ?>" alt="<?php echo $auth['alt']; ?>" title="<?php echo $auth['title']; ?>">
					</a>
<?php } ?>
				</div>
				<div class="header-collapse">
					<div class="collapse navbar-collapse" id="navbar-collapse-01">
						<ul class="nav navbar-nav nycuni-navbar-nav">
							<li <?php echo (preg_match("/\/event/i", $_SERVER['REQUEST_URI']) > 0)?" class='active'":""; ?>>
								<a href="<?php echo $home . $links['event']; ?>">
									<img class="img-header-logo" id="img-header-logo-event" src="<?php echo $home . "theme/images/mobile/header/event.png"; ?>">
									<img class="nycuni-navbar-nav-img" src="<?php echo $home."theme/images/header_span_event.png"; ?>">
									<span class="nycuni-navbar-nav-span">活动</span>
								</a>
							</li>
							<li<?php echo (preg_match("/\/group/i", $_SERVER['REQUEST_URI']) > 0)?" class='active'":""; ?>>
								<a href="<?php echo $home . $links['group']; ?>">
									<img class="img-header-logo" id="img-header-logo-group" src="<?php echo $home . "theme/images/mobile/header/group.png"; ?>">
									<img class="nycuni-navbar-nav-img" src="<?php echo $home."theme/images/header_span_group.png"; ?>">
									<span class="nycuni-navbar-nav-span">群组</span>
								</a>
							</li>
							<li <?php echo (preg_match("/\/people/i", $_SERVER['REQUEST_URI']) > 0)?" class='active'":""; ?>>
								<a href="<?php echo $home . $links['people']; ?>">
									<img class="img-header-logo" id="img-header-logo-personal" src="<?php echo $home . "theme/images/mobile/header/person.png"; ?>">
									<img class="nycuni-navbar-nav-img" src="<?php echo $home."theme/images/header_span_people.png"; ?>">
									<span class="nycuni-navbar-nav-span">个人</span>
								</a>
							</li>
							<li <?php echo (preg_match("/\/information/i", $_SERVER['REQUEST_URI']) > 0)?" class='active'":""; ?>>
								<a href="<?php echo $home . $links['faq']; ?>">
									<img class="img-header-logo" id="img-header-logo-about" src="<?php echo $home . "theme/images/mobile/header/about.png"; ?>">
									<img class="nycuni-navbar-nav-img" src="<?php echo $home."theme/images/header_span_faq.png"; ?>">
									<!-- <span class="nycuni-navbar-nav-span">综合</span> -->
								</a>
							</li>
							<!-- <li <?php echo (preg_match("/\/search/i", $_SERVER['REQUEST_URI']) > 0)?" class='active'":""; ?>>
								<a href="<?php echo $home . $links['search'] ?>">
									<img class="img-header-logo" id="img-header-logo-search" src="<?php echo $home . "theme/images/mobile/header/search.png"; ?>">
									<img class="nycuni-navbar-nav-img" src="<?php echo $home."theme/images/header_span_search.png"; ?>">
								</a>
							</li> -->
<?php if (isset($_SESSION['auth'])) { ?>
							<li>
								<a href="<?php echo $home . $links['logout'] ?>">
									<img class="img-header-logo" id="img-header-logo-setting" src="<?php echo $home . "theme/images/mobile/header/setting.png"; ?>">
									<img class="nycuni-navbar-nav-img" src="<?php echo $home."theme/images/header_span_logout.png"; ?>">
								</a>
							</li>
<?php } else { ?>
							<li>
								<a href="<?php echo $home; ?>">
									<img class="img-header-logo" id="img-header-logo-setting" src="<?php echo $home . "theme/images/mobile/header/setting.png"; ?>">
									<img class="nycuni-navbar-nav-img" src="<?php echo $home."theme/images/header_span_login.png"; ?>">
								</a>
							</li>
<?php } ?>
						</ul>	      
						<!-- <form class="navbar-form nycuni-navbar-form navbar-right" action="<?php echo $home . "cgi/form_actions?eid=28"; ?>" role="search" onsubmit="header_search_chk()">
							<div class="form-group">
								<div class="input-group">
									<input type="hidden" id="header-search-pid" value="<?php echo $auth['uid']; ?>">
									<input class="form-control" id="navbarInput-01" type="search" placeholder="搜索...">
									<span class="input-group-btn">
										<button type="submit" class="btn">
											<span class="fui-search"></span>
										</button>
									</span>            
								</div>
							</div>       
						</form> -->
					</div><!-- /.navbar-collapse -->
				</div>
			</nav><!-- /navbar -->
		</div>
<?php 
	$side = 1;
	include $home . "template/common/popup_frames/login_panel.php";
?>
	<section class="collapse-off">
	<!-- section start -->
