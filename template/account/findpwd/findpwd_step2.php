<section class="section-find-pwd">
			<div class="head-login_panel">
	 			<div class="head-wrap">
					<div class="login-logo">
						<img src="<?php echo $home . "theme/images/login_panel/login_logo.png"; ?>">
					</div>
					<div class="login-announce">
						<span>NYCUni</span><br>
						<span>纽约新蜂跑团</span>
					</div>
				</div>
			</div>
<?php if ($exist_email) { ?>
		<input type="email" name="email" id="email" disabled="disabled" value="<?php echo $user_email; ?>">
		<input type="password" name="password" id="password" required placeHolder="新密码">
		<input type="password" name="pass" id="pass" required placeHolder="确认密码">
		<p><span id="chkmsg"></span></p>
		<!-- <input type="text" name="username" id="username" required placeHolder="原用户名"> -->
		<input type="button" class="btn" id="sub_btn" value="提交密码" onclick="resetpassword()">
<?php } else { ?>
		<p><span id="chkmsg">您的链接已失效或不是有效链接</span></p>
<?php } ?>
			<div class="back-home">
				<a href='<?php echo $home; ?>' class="home-gateway">
					<img src="<?php echo $home . "theme/images/account/round_arrow_left.png"; ?>" />
						返回首页
				</a>
				<span class="dot"></span>
				<a href='<?php echo $home; ?>' class="signin-gateway">
					登录新蜂
					<!-- <i class="icon-sign icon-sign-arrow"></i> -->
					<img src="<?php echo $home . "theme/images/account/round_arrow_right.png"; ?>" />
				</a>
			</div>
</section>