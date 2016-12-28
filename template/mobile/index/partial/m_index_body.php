<div class="index-welcome">
  <div class="top-logo">
    <img src="<?php echo $home . "theme/images/logo_white.png"; ?>" class="logo-inc">
  </div>
  <div class="index-announcement">
    <div id="index-a-1">NewBee Running Club</div>
    <div id="index-a-2">纽约新蜂跑团</div>
  </div>
  <article class="article-login_panel">
      <div class="div-signin <?php echo ($side>=1)?"back":""; ?>">
        <input type="text" name="username" required placeHolder="用户名/邮箱" value="<?php if ( isset($cookieuser) ) {echo $cookieuser;} ?>" onkeyup="if(event.which == 13){signin('<?php echo $home; ?>')}else{}"><br>
        <input type="password" name="pass" required placeHolder="密码" value="<?php if ( isset($cookiepass) ){echo $cookiepass;} ?>" onkeyup="if(event.which == 13){signin('<?php echo $home; ?>')}else{}"><br>
        <div class="div-account-pass">
          <div class="div-save-pass">
            <input type="checkbox" id="savepassbox" name="rempwd" value="1" checked>记住密码</input>
          </div>
          <div class="div-find-pass">
            <!-- <span style="border: 1px solid grey; border-radius: 100%"> --><!-- <img src="<?php echo $home . "theme/images/Question_Mark.png"; ?>"> --><!-- </span> -->
            <a href="<?php echo $home . "account/findpwd.php"; ?>" class="find-pwd">忘记密码</a>
          </div>
        </div>
        <ul class="ul-error-message"></ul>
          <!-- <input type="button" name="signin_button" value="登陆" onclick="signin('<?php echo $home; ?>')"> -->
        <button class="submit-button" href="javascript:" onclick="signin('<?php echo $home; ?>')">登陆</button>
        <div class="text-recommend">
          <div class="div-float">
            <div class="text-recommend-text">还没加入新蜂?</div>
            <button href="javascript:" onclick="switchSign(0)">注册</button>
          </div>
        </div>
      </div>
        <div class="div-signup <?php echo ($side<=0)?"back":""; ?>">
          <input type="email" name="email" required placeHolder="邮箱" onkeyup="if(event.which == 13){signup('<?php echo $home; ?>')}else{}"><br>
          <input type="text" name="username" required placeHolder="用户名" onkeyup="if(event.which == 13){signup('<?php echo $home; ?>')}else{}"><br>
          <input type="password" name="pass" required placeHolder="密码" onkeyup="if(event.which == 13){signup('<?php echo $home; ?>')}else{}"><br>
          <input type="password" name="pass2" required placeHolder="确认密码" onkeyup="if(event.which == 13){signup('<?php echo $home; ?>')}else{}"><br>
          <ul class="ul-error-message"></ul>
          <!-- <input type="button" name="signup_button" value="注册" onclick="signup('<?php echo $home; ?>')"> -->
          <button class="submit-button" href="javascript:" onclick="signup('<?php echo $home; ?>')">注册</button>
          <div class="text-recommend">
            <div class="div-float">
              <div class="text-recommend-text">已是新蜂的用户?</div>
              <button href="javascript:" onclick="switchSign(1)">登陆</button>
            </div>
          </div>
        </div>
    </article>
</div>
