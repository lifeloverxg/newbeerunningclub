<div class="div-enroll">
  <header>
    <h1>填写抽奖信息</h1>
  </header>
  <form action="enroll.php" method="post">
	<input type="text" name="lottery_number" required placeHolder="抽奖号码" />
	<input type="text" name="spec_desc" placeHolder="个人介绍" />
	<input type="submit" name="submit_enroll" value="完成" />
	<ul class="ul-error-message">
<?php foreach ($enroll_error as $value) { ?>
	  <li><?php echo $value; ?></li>
<?php } ?>
	</ul>
  </form>
  <footer>
  </footer>
</div>