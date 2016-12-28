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
  <link rel="stylesheet" href="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/css/flat-ui.css"; ?>">
  <link rel="stylesheet" href="<?php echo $home . $links['m_css']; ?>">
  <link rel="stylesheet" href="<?php echo $home . "theme/zus/mobile_css/common.css"; ?>">
<?php foreach ($m_stylesheet as $value) { ?>
  <link rel="stylesheet" href="<?php echo $home . $value; ?>">
<?php } ?>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
      <div class="header-content">
       <!--  <a class="nav-brand" href="<?php echo $home; ?>">
          <img src="<?php echo $home . "theme/images/logo_white.png"; ?>" class="logo-inc">
          <div style="float: left; height: 40px; margin: 10px 0; line-height: 20px; text-align: center;">
            <span style="font-size: 0.8rem;">留学生的公共平台</span><br>
            <span style="font-size: 1.2rem;">nycuni.com</span>
          </div>
        </a> -->
        <div class="nav-main">
          <!-- <ul>
            <li<?php echo (preg_match("/\/event/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>><a href="<?php echo $home . $links['event']; ?>">活动</a></li>
            <li<?php echo (preg_match("/\/group/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>><a href="<?php echo $home . $links['group']; ?>">群组</a></li>
            <li<?php echo (preg_match("/\/people/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>><a href="<?php echo $home . $links['people']; ?>">个人</a></li>
            <li<?php echo (preg_match("/\/information/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>><a href="<?php echo $home . $links['faq']; ?>">综合</a></li>
          </ul> -->
          <ul>
            <li <?php echo (preg_match("/\/event/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>>
              <a href="<?php echo $home . $links['event']; ?>">
                <div class="m-header-logo">
                  <img class="img-header-logo" id="img-header-logo-event" src="<?php echo $home . "theme/images/mobile/header/event.png"; ?>">
                </div>
                <div class="m-header-span">活动</div>
              </a>
            </li>

            <li <?php echo (preg_match("/\/group/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>>
              <a href="<?php echo $home . $links['group']; ?>">
                <div class="m-header-logo">
                  <img class="img-header-logo" id="img-header-logo-group" src="<?php echo $home . "theme/images/mobile/header/group.png"; ?>">
                </div>
                <div class="m-header-span">群组</div>
              </a>
            </li>

            <li <?php echo (preg_match("/\/people/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>>
              <!-- <a href="<?php if(isset($_SESSION['auth']) && ($_SESSION['auth'] != "")) {echo $home . $links['people']; } else {echo "javacript:"; }?>" onclick="<?php if(isset($_SESSION['auth']) && ($_SESSION['auth'] != "")) {}else{echo "show_login_panel()"; }?>"> -->
              <!-- <a href="javascript:" onclick="<?php if(isset($_SESSION['auth']) && ($_SESSION['auth'] != "")) {echo "window.location.href='".$home."people'";}else{echo "show_login_panel()"; }?>"> -->
                <a href="javascript:" onclick="<?php if(isset($_SESSION['auth']) && ($_SESSION['auth'] != "")) {echo "window.location.href='".$home."people'";}else{echo "window.location.href='".$home."'"; }?>">
                <div class="m-header-logo">
                  <img class="img-header-logo" id="img-header-logo-personal" src="<?php echo $home . "theme/images/mobile/header/person.png"; ?>">
                </div>
                <div class="m-header-span">个人</div>
              </a>
            </li>

            <li <?php echo (preg_match("/\/search/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>>
              <a href="<?php echo $home . $links['search']; ?>">
                <div class="m-header-logo">
                  <img class="img-header-logo" id="img-header-logo-search" src="<?php echo $home . "theme/images/mobile/header/search.png"; ?>">
                </div>
                <div class="m-header-span">搜索</div>
              </a>
            </li>

            <li <?php echo (preg_match("/\/about/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>>
              <a href="<?php echo $home . $links['about']; ?>">
                <div class="m-header-logo">
                  <img class="img-header-logo" id="img-header-logo-about" src="<?php echo $home . "theme/images/mobile/header/about.png"; ?>">
                </div>
                <div class="m-header-span">关于</div>
              </a>
            </li>

            <!-- <li <?php echo (preg_match("/\/search/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>>
<?php if (isset($_SESSION['auth'])) { ?>
              <a href="<?php echo $home . $links['logout'] ?>">
                <div class="m-header-logo">
                  <img class="img-header-logo" id="img-header-logo-setting" src="<?php echo $home . "theme/images/mobile/header/setting.png"; ?>">
                </div>
                <div class="m-header-span">退出</div>
              </a>
<?php } else { ?>
              <a href="javascript:" onclick="show_login_panel()">
                <div class="m-header-logo">
                  <img class="img-header-logo" id="img-header-logo-setting" src="<?php echo $home . "theme/images/mobile/header/setting.png"; ?>">
                </div>
                <div class="m-header-span">登录</div>
              </a>
<?php } ?>
            </li> -->
            <li <?php echo (preg_match("/\/setting/i", $_SERVER['REQUEST_URI']) > 0)?" class='current'":""; ?>>
              <!-- <a href="<?php echo $home . $links['setting']; ?>"> -->
<?php if (isset($_SESSION['auth'])) { ?>
              <div class="panel-user-main" onclick="show_setting_panel_x()">
                <a href="javascript:">
                  <div class="m-header-logo">
                    <img class="img-header-logo" id="img-header-logo-setting" src="<?php echo $home . "theme/images/mobile/header/setting.png"; ?>">
                  </div>
                  <div class="m-header-span" id="m-header-span-setting">设置</div>
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
             <!--  <a href="javascript:" onclick="show_login_panel()"> -->
              <a href="<?php echo $home; ?>">
                <div class="m-header-logo">
                  <img class="img-header-logo" id="img-header-logo-setting" src="<?php echo $home . "theme/images/mobile/header/setting.png"; ?>">
                </div>
                <div class="m-header-span">登录</div>
              </a>
<?php } ?>
            </li>
          </ul>
        </div>

      </div>
    </header>
<?php 
    $side = 1;
    include $home . "template/common/popup_frames/login_panel.php";
?>
 <section>
  <!-- section start -->
