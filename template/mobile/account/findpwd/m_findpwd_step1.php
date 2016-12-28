		<section class="section-find-pwd">
	 		<div class="head-login_panel">
	 			<div class="head-wrap">
					<div class="login-logo">
						<img src="<?php echo $home . "theme/images/login_panel/login_logo.png"; ?>">
					</div>
					<div class="login-announce">
						<span>NewBee Running Club</span><br>
						<span>纽约新蜂跑团</span>
					</div>
				</div>
			</div>
			<input type="email" name="email" id="email" required placeHolder="原邮箱">
			<p><span id="chkmsg"></span></p>
			<!-- <input type="text" name="username" id="username" required placeHolder="原用户名"> -->
			<input type="button" class="btn" id="sub_btn" value="重设密码" onclick="findpassword()">
			<div class="back-home">
				<a href='<?php echo $home; ?>' class="home-gateway">
					<!-- <img src="<?php echo $home . "theme/images/account/round_arrow_left.png"; ?>" /> -->
						返回首页
				</a>
				<span class="dot"></span>
				<a href='<?php echo $home; ?>' class="signin-gateway">
					登录新蜂
					<!-- <i class="icon-sign icon-sign-arrow"></i> -->
					<!-- <img src="<?php echo $home . "theme/images/account/round_arrow_right.png"; ?>" /> -->
				</a>
			</div>
		</section>