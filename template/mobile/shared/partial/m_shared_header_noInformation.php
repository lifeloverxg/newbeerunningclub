<!DOCTYPE html>
<html lang="utf-8">
<head>
  <meta charset="utf-8" />
  <meta name="keywords" content="纽约有你, 在线社交活动网站, 纽约学生活动平台, 发布参加活动群组, nycuni, nyc, uni, social, socialplatform, event, group, club">
  <meta name="description" content="纽约有你，纽约年轻华人社交活动网站，发布/参加线下活动，创建/参与交流群组，发布/游览丰富富咨讯，享受NYC Uni与合作商家优惠，满足社交、资讯、娱乐和生活多方面需求。">
  <meta property="wb:webmaster" content="9d82975a412d5dd8" />
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=0"/>
  <link rel="shortcut icon" href="<?php echo $home . $links['favicon']; ?>" />
  <link rel="stylesheet" href="<?php echo $home . "theme/bootstrap/bootstrap.css"; ?>">
  <link rel="stylesheet" href="<?php echo $home . $links['m_css']; ?>">
  <link rel="stylesheet" href="<?php echo $home . "theme/zus/mobile_css/common.css"; ?>">
<?php foreach ($m_stylesheet as $value) { ?>
  <link rel="stylesheet" href="<?php echo $home . $value; ?>">
<?php } ?>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="<?php echo $home . "js/zus/account/panel_sign.js"; ?>"></script>
  <script src="<?php echo $home . $links['m_js']; ?>"></script>
<?php foreach ($m_javascript as $value) { ?>
  <script src="<?php echo $home . $value; ?>"></script>

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
<?php } ?>

  <title><?php echo $title; ?></title>
</head>
<body>
  <header>
    </header>
<?php 
    // $side = 1;
    // include $home . "template/common/popup_frames/login_panel.php";
?>
 <section>
  <!-- section start -->
