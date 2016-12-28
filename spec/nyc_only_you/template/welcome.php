			<div class="div-welcome">
								<div class="div-auth">
				<div class="div-signin <?php echo ($side<=0)?"back":""; ?>">
					<header>
						<h1>登陆</h1>
					</header>
					<article>
						<form method="POST">
							<input type="text" name="signin_username" required placeHolder="用户名/邮箱" value="<?php echo isset($_POST['signin_username'])?$_POST['signin_username']:""; ?>">
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
						<button href="javascript:" onclick="switchSign(0)">注册</button>
					</footer>
				</div>
				<div class="div-signup <?php echo ($side>=1)?"back":""; ?>">
					<header>
						<h1>注册</h1>
					</header>
					<article>
						<form method="POST">
							<input type="email" name="signup_email" required placeHolder="邮箱" value="<?php echo isset($_POST['signup_email'])?$_POST['signup_email']:""; ?>">
							<input type="text" name="signup_username" required placeHolder="用户名" value="<?php echo isset($_POST['signup_username'])?$_POST['signup_username']:""; ?>">
							<input type="password" name="signup_pass" required placeHolder="密码" value="<?php echo isset($_POST['signup_pass'])?$_POST['signup_pass']:""; ?>">
							<input type="password" name="signup_pass2" required placeHolder="确认密码" value="<?php echo isset($_POST['signup_pass2'])?$_POST['signup_pass2']:""; ?>">
							<!-- <input type="text" name="signup_invitecode" required placeHolder="邀请码" value="<?php echo isset($_POST['signup_invitecode'])?$_POST['signup_invitecode']:""; ?>"> -->
							<ul class="ul-error-message">
<?php foreach ($signup_error as $value) { ?>
								<li><?php echo $value; ?></li>
<?php } ?>
							</ul>
							<input type="submit" name="signup" value="注册">
						</form>
					</article>
					<footer>
						<button href="javascript:" onclick="switchSign(1)">登陆</button>
					</footer>
				</div>
			</div>
			</div>





