<div class="div-auth">
  <div class="div-signup <?php echo ($side>0)?"back":""; ?>">
    <header>
      <h1>注册</h1>
    </header>
    <article>
      <form method="POST">
        <input type="text" name="last_name" required placeHolder="姓" value="<?php echo isset($_POST['last_name'])?$_POST['last_name']:""; ?>">
        <input type="text" name="first_name" required placeHolder="名" value="<?php echo isset($_POST['first_name'])?$_POST['first_name']:""; ?>">
        <input type="email" name="signup_email" required placeHolder="邮箱" value="<?php echo isset($_POST['signup_email'])?$_POST['signup_email']:""; ?>">
        <input type="password" name="signup_pass" required placeHolder="密码" value="<?php echo isset($_POST['signup_pass'])?$_POST['signup_pass']:""; ?>">
        <input type="password" name="signup_pass2" required placeHolder="确认密码" value="<?php echo isset($_POST['signup_pass2'])?$_POST['signup_pass2']:""; ?>">
        <ul class="ul-error-message">
<?php foreach ($signup_error as $value) { ?>
          <li><?php echo $value; ?></li>
<?php } ?>
        </ul>
        <input type="submit" name="signup" value="注册">
      </form>
    </article>
    <footer>
      <button href="javascript:" onclick="switchSign(0)">登陆</button>
    </footer>
  </div>

  <div class="div-signin <?php echo ($side<1)?"back":""; ?>">
    <header>
      <h1>登陆</h1>
    </header>
    <article>
      <form method="POST">
        <input type="text" name="signin_username" required placeHolder="邮箱" value="<?php echo isset($_POST['signin_username'])?$_POST['signin_username']:""; ?>">
        <input type="password" name="signin_pass" required placeHolder="密码" value="<?php echo isset($_POST['signin_pass'])?$_POST['signin_pass']:""; ?>">
        <ul class="ul-error-message">
<?php foreach ($signin_error as $value) { ?>
          <li><?php echo $value; ?></li>
<?php } ?>
        </ul>
        <input type="submit" name="signin" value="登陆">
      </form>
    </article>
    <footer>
    </footer>
  </div>

</div>
