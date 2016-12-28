			<div class="div-welcome-cover">
				<figure class="img-uni-u"></figure>
				<figure class="img-uni-n"></figure>
				<figure class="img-uni-i"></figure>
				<figure class="img-uni-x uni-nomove"></figure>
			</div>
			<figure class="whiteboard"></figure>
			<section class="section-welcome">
				<h1><span>纽约</span><span style="font-size:4rem; color: #F4424A;">Uni</span><wbr><span>更精彩</span></h1>
				<article>
					<div class="div-signin">
						<input type="text" name="username" required placeHolder="用户名/邮箱" value="<?php echo $cookieuser; ?>"><br>
						<input type="password" name="pass" required placeHolder="密码" value="<?php echo $cookiepass; ?>"><br>
						<div class="div-account-pass">
							<div class="div-save-pass">
								<input type="checkbox" id="savepassbox" name="rempwd" value="1" checked>记住密码</input>
							</div>
							<div class="div-find-pass">
								<a href="<?php echo $home . "account/findpwd.php"; ?>" class="find-pwd" style="color: rgb(0, 94, 172);">忘记密码</a>
							</div>
						</div>
						<ul class="ul-error-message"></ul>
						<input type="button" value="登陆" onclick="signin()">
						<!-- facebook login
						<div id="fb-root"></div>
						<fb:login-button show-faces="true" width="200" max-rows="1">facebook login</fb:login-button> 
						-->
					</div>
				</article>
			</section>
			<section class="section-signup">
				<figure class="img-close">关闭</figure>
				<div class="div-signup">
					<h1>立即<em>注册</em></h1>
					<input type="email" name="email" required placeHolder="邮箱"><br>
					<input type="text" name="username" required placeHolder="用户名"><br>
					<input type="password" name="pass" required placeHolder="密码"><br>
					<input type="password" name="pass2" required placeHolder="确认密码"><br>
					<ul class="ul-error-message"></ul>
					<input type="button" value="注册" onclick="signup()">
				</div>
			</section>
			<footer></footer>
