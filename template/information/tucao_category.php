<section class="section-tucao-<?php echo $tucao_category; ?>">
	<ul class="tucao-content">
<?php foreach ($article_category[$tucao_category] as $article) { ?>
		<li>
			<div class="information-article-title">
				<a href="<?php echo $home . $article['detail']['url']; ?>">
					<?php echo $article['detail']['title']; ?>
				</a>
			</div>
			<div class="information-article-content"><?php echo $article['detail']['content']; ?></div>
			<div class="information-article-ctime"><?php echo $article['ctime']; ?></div>
		</li>
<?php } ?>
	</ul>
	<div class="tucao-textarea-wrap">
		<input type="text" class="tucao-input" id="tucao<?php echo $tucao_category; ?>_title" placeholder="标题" required />
		<textarea class="tucao-input" id="tucao<?php echo $tucao_category; ?>_content" placeholder="发表吐槽" required></textarea>
		<input type="button" value="发表吐槽" class="button-reply" onclick="update_tucao_category(<?php echo $tucao_category; ?>)" />
		<p class="article-error"><?php echo $article_error; ?></p>
	</div>
</section>