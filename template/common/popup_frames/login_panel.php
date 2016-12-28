			<div class="div-popup-login_panel" id="show-login_panel">
				<!-- <a href="javascript:" class="popup-small-close"><span class="glyphicon glyphicon-remove"></span></a> -->
				<section class="popup-login_panel">
					<div class="head-login_panel">
						<div class="login-logo">
							<img src="<?php echo $home . "theme/images/login_panel/login_logo.png"; ?>">
						</div>
						<div class="login-announce">
							<span>NewBee Running Club</span><br>
							<span>纽约新蜂跑团</span>
						</div>
					</div>
					<article class="article-login_panel">
						<div class="div-signin <?php echo ($side<=0)?"back":""; ?>">
							<input type="text" name="username" required placeHolder="用户名/邮箱" value="<?php if ( isset($cookieuser) ) {echo $cookieuser;} ?>" onkeyup="if(event.which == 13){signin('<?php echo $home; ?>')}else{}"><br>
							<input type="password" name="pass" required placeHolder="密码" value="<?php if ( isset($cookiepass) ){echo $cookiepass;} ?>" onkeyup="if(event.which == 13){signin('<?php echo $home; ?>')}else{}"><br>
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
								<button id="signin_button" href="javascript:" name="signin_button" onclick="signin('<?php echo $home; ?>')">登陆</button>
								<button href="javascript:" onclick="switchSign(0)">注册</button>
						</div>
							<div class="div-signup <?php echo ($side>=1)?"back":""; ?>">
								<input type="email" name="email" required placeHolder="邮箱" onkeyup="if(event.which == 13){signup('<?php echo $home; ?>')}else{}"><br>
								<input type="text" name="username" required placeHolder="用户名" onkeyup="if(event.which == 13){signup('<?php echo $home; ?>')}else{}"><br>
								<input type="password" name="pass" required placeHolder="密码" onkeyup="if(event.which == 13){signup('<?php echo $home; ?>')}else{}"><br>
								<input type="password" name="pass2" required placeHolder="确认密码" onkeyup="if(event.which == 13){signup('<?php echo $home; ?>')}else{}"><br>
								<ul class="ul-error-message"></ul>
								<button id="signup_button" href="javascript:" name="signup_button" onclick="signup('<?php echo $home; ?>')">注册</button>
								<button href="javascript:" onclick="switchSign(1)">登陆</button>
							</div>
					</article>
					<foot>
					</foot>
				</section>
			</div>