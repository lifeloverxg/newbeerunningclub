	<section class="section-error-page">
		<div class="div-pudding">
		<div class="error-message">
			<?php echo $message; ?>
		</div>
		<!-- <a href="../event/detail.php?eid=52"> -->
		<a href="javascript:" onclick="error_redirect()">
			<img class="logo-large" src="<?php echo $home.$image; ?>">
		</a>
		<footer>
			<div class="error-message">
				<?php echo "请点击图片返回"; ?>
			</div>
		</footer>
		</div>
	</section>