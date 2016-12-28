<!DOCTYPE html>
<html lang="utf-8">
  <head>
    <meta charset="utf-8" />
    <meta name="keywords" content="纽约有你, 在线社交活动网站, 纽约学生活动平台, 发布参加活动群组, nycuni, nyc, uni, social, socialplatform, event, group, club">
    <meta name="description" content="纽约有你，纽约年轻华人社交活动网站，发布/参加线下活动，创建/参与交流群组，发布/游览丰富富咨讯，享受NYC Uni与合作商家优惠，满足社交、资讯、娱乐和生活多方面需求。">
    <meta property="wb:webmaster" content="9d82975a412d5dd8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=0"/>
    
    <link rel="shortcut icon" href="<?php echo $home . $links['favicon']; ?>" />
    <link rel="stylesheet" href="<?php echo $home . "theme/bootstrap/bootstrap300.min.css"; ?>">
    <link rel="stylesheet" href="<?php echo $home . "theme/bootstrap/bootstrap.css"; ?>">
    <link rel="stylesheet" href="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/css/flat-ui.css"; ?>">
    <link rel="stylesheet" href="<?php echo $home . $links['m_css']; ?>">
    <!-- <link rel="stylesheet" href="<?php echo $home . "theme/zus/mobile_css/common.css"; ?>"> -->
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
  <title><?php echo $title; ?></title>
</head>
<body id="m-index-body">
  <section>
    <!-- section start -->
