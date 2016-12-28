<?php
// HTML header
include $home . "template/common/header.php"; ?>

<section class="section-pwd-management">
	<form method="POST">
		<input type="password" name="old_pwd" required placeHolder="原密码">
		<input type="password" name="modified_pwd" required placeHolder="新密码">
		<input type="password" name="modified_pwd2" required placeHolder="确认密码">
<?php foreach ($error_messages as $error) { ?>
		<label id="pwd_error" style="color: yellow;"><?php echo $error; ?></label>
<?php } ?>
		<input type="submit" name="modify_pwd" value="修改密码" style="float: right; background: #da558a; width: 90px; color: white; padding-left: 0;">
	</form>
</section>

<?php
// HTML footer
include $home . "template/common/footer.php"; ?>