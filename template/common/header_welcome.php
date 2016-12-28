<!DOCTYPE html>
<html lang="utf-8">
	<head>
		<meta charset="utf-8" />
        <meta name="keywords" content="纽约有你, 在线社交活动网站, 纽约学生活动平台, 发布参加活动群组, nycuni, nyc, uni, social, socialplatform, event, group, club">
        <meta name="description" content="纽约有你，纽约年轻华人社交活动网站，发布/参加线下活动，创建/参与交流群组，发布/游览丰富富咨讯，享受NYC Uni与合作商家优惠，满足社交、资讯、娱乐和生活多方面需求。">
        <link rel="shortcut icon" href="<?php echo $home; ?>theme/icon/favicon.ico" />
		<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $home . "theme/bootstrap/bootstrap.css"; ?>">
<!--		<link rel="stylesheet" href="<?php echo $home . "theme/zus/common.css"; ?>">-->
<?php foreach ($stylesheet as $value) { ?>
		<link rel="stylesheet" href="<?php echo $home . $value; ?>">
<?php } ?>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="<?php echo $home . "js/zus/common.js"; ?>"></script>
<?php foreach ($javascript as $value) { ?>
		<script src="<?php echo $home . $value; ?>"></script>
<?php } ?>
		
		<script>
			function visit(url)
			{
				window.location.href='<?php echo $home; ?>'+url;
			}
		</script>


		<title><?php echo $title; ?></title>
	</head>
	<body>
		<div class="index-cover">
			<div class="index-cover-wrap">
                <div class="puzzle-top-left"></div>
                <div class="puzzle-bottom-left"></div>
                <div class="puzzle-bottom-right"></div>
            </div>
		</div>
		<div class="index-below">
			<header>
				<div class="header-content">
					<a class="nav-brand" href="<?php echo $home; ?>">
						<img src="<?php echo $home . "theme/images/logo_2.png"; ?>" class="logo-inc">
					</a>

					<div class="panel-user">
	<?php if (isset($_SESSION['auth'])) { ?>
						<div class="panel-user-notice">
							<span></span> <!-- display number of notices -->
						</div>
						
						<div class="panel-user-main">
							<a href="<?php echo $home . $links['people']; ?>">
								<span>欢迎回来，</span><span><?php echo $auth['title']; ?></span>
								<img class="logo-medium" src="<?php echo $home.$auth['image']; ?>" alt="<?php echo $auth['alt']; ?>" title="<?php echo $auth['title']; ?>">
							</a>
							<!-- panel menu (default display:none) only appears when hovering above elements -->
							<nav>
								<ul>
									<li><a href="<?php echo $home . $links['setting'] ?>">账户设置</a></li>
									<li><a href="<?php echo $home . $links['help'] ?>">帮助支持</a></li>
									<li><a href="<?php echo $home . $links['logout'] ?>">退出登录</a></li>
								</ul>
							</nav>
						</div>
	<?php } else { ?>
						<div class="panel-user-login">
							<a href="<?php echo $home ?>">登录</a>
						</div>
	<?php } ?>
					</div>

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
	?>
				
				</div>
			</header>
			<section> <!-- start of main content -->