<!DOCTYPE html>
<html lang="utf-8">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="<?php echo $home; ?>theme/icon/favicon.ico" />
	<link rel="stylesheet" href="<?php echo "theme/zus/common.css"; ?>">
<?php foreach ($stylesheet as $value) { ?>
	<link rel="stylesheet" href="<?php echo $value; ?>">
<?php } ?>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="<?php echo $home . "js/zus/common.js"; ?>"></script>
<?php foreach ($javascript as $value) { ?>
	<script src="<?php echo $home . $value; ?>"></script>
<?php } ?>

	<title><?php echo $title; ?></title>
  </head>
  <body>
    <header>
      <div class="header-content">
        <a class="nav-brand" href="<?php echo $event_home; ?>">
          <img src="<?php echo $home; ?>theme/images/logo_uni.png" class="logo-inc">
        </a>
      <div class="nav-main">
      <ul>
        <li><a href="<?php echo $home; ?>event">活动</a></li>
        <li><a href="<?php echo $home; ?>group">群组</a></li>
        <li><a href="<?php echo $home; ?>people">个人</a></li>
        <li><a href="<?php echo $home; ?>faq">综合</a></li>
      </ul>
    </div>
    <div class="panel-user">
<?php if (isset($_SESSION['auth'])) { ?>
      <div class="panel-user-main">
        <a href="<?php echo $home.$auth['url']; ?>">
          <span>欢迎回来，</span><span><?php echo $auth['title']; ?></span>
          <img class="logo-medium" src="<?php echo $home.$auth['image']; ?>" alt="<?php echo $auth['alt']; ?>" title="<?php echo $auth['title']; ?>">
        </a>
<!-- panel menu (default display:none) only appears when hovering above elements -->
        <nav>
          <ul>
            <li><a href="<?php echo $home.$auth['url']; ?>">个人页面</a></li>
            <li><a href="<?php echo $event_home; ?>handler/signout.php">退出登录</a></li>
          </ul>
        </nav>
      </div>
<?php } else { ?>
      <div class="panel-user-login">
        <a href="<?php echo $event_home ?>"></a>
      </div>
<?php } ?>
      </div>
      </div>
    </header>
    <section> <!-- start of main content -->
