 <section class="section-find-pwd">
		<input type="email" name="email" id="email" disabled="disabled" value="<?php echo $user_email; ?>">
		<input type="password" name="password" id="password" required placeHolder="新密码">
		<input type="password" name="pass" id="pass" required placeHolder="确认密码">
		<p><span id="chkmsg"></span></p>
		<!-- <input type="text" name="username" id="username" required placeHolder="原用户名"> -->
		<input type="button" class="btn" id="sub_btn" value="提交密码" onclick="resetpassword()">
</section>