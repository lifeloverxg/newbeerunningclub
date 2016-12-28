<?php $side = 1; ?>
			<div class="welcome-wrap">
				<div class="head-head-welcome">
					<!-- <div class="div-head-head-welcome">
						Welcome!
					</div> -->
				</div>
				<section class="section-login_panel">
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
					<article class="article-login_panel">
						<div class="div-signin <?php echo ($side<=0)?"back":""; ?>">
							<input type="text" name="username" required placeHolder="用户名/邮箱" value="<?php if ( isset($cookieuser) ) {echo $cookieuser;} ?>" onkeyup="if(event.which == 13){signin()}else{}">
							<input type="password" name="pass" required placeHolder="密码" value="<?php if ( isset($cookiepass) ){echo $cookiepass;} ?>" onkeyup="if(event.which == 13){signin()}else{}">
							<div class="div-account-pass">
								<div class="div-save-pass">
									<input type="checkbox" id="savepassbox" name="rempwd" value="1" checked>记住密码</input>
								</div>
								<div class="div-find-pass">
									<!-- <span style="border: 1px solid grey; border-radius: 100%">?</span> -->
									<a href="<?php echo $home . "account/findpwd.php"; ?>" class="find-pwd" style="color: rgb(0, 94, 172);">忘记密码</a>
								</div>
							</div>
							<ul class="ul-error-message"></ul>
							<div class="sign-button-list">
								<input type="button" name="signin_button" value="登陆" onclick="signin()">
								<button href="javascript:" onclick="switchSign(0)">注册</button>
							</div>
						</div>
							<div class="div-signup <?php echo ($side>=1)?"back":""; ?>">
								<input type="email" name="email" required placeHolder="邮箱" onkeyup="if(event.which == 13){signup()}else{}">
								<input type="text" name="username" required placeHolder="用户名" onkeyup="if(event.which == 13){signup()}else{}">
								<input type="password" name="pass" required placeHolder="密码" onkeyup="if(event.which == 13){signup()}else{}">
								<input type="password" name="pass2" required placeHolder="确认密码" onkeyup="if(event.which == 13){signup()}else{}">
								<ul class="ul-error-message"></ul>
								<div class="sign-button-list">
									<input type="button" name="signup_button" value="注册" onclick="signup()">
									<button href="javascript:" onclick="switchSign(1)">登陆</button>
								</div>
							</div>
					</article>
					<foot>
						<div class="foot-welcome">
							<ul class="ul-foot-welcome">
								<li class="li-foot-welcome li-foot-welcome-1">
									High Quality Slef-made Events
								</li>
								<li class="li-foot-welcome li-foot-welcome-2">
									Create Your own Events
								</li>
								<li class="li-foot-welcome li-foot-welcome-3">
									Meet New Friends
								</li>
								<li class="li-foot-welcome li-foot-welcome-4">
									Build Your Social Networks
								</li>
								<li class="li-foot-welcome li-foot-welcome-5">
									Get Help From Professionals
								</li>
							</ul>
						</div>
					</foot>
				</section>
			</div>