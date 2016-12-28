			<section class="section-article-detail-large">
				<ul class="ul-article-list-large">
<?php foreach ($article_list_large as $article) { ?>
					<li>
						<p class="article-addressing">
							<a href="<?php echo $home.$article['detail']['url']; ?>">
								<span class="list-title-article"><?php echo $article['detail']['title']; ?></span>
							</a>
							<a href="<?php echo $home.$article['detail']['url']; ?>" class="list-more-small">详细文章</a>
							<span class="list-article-timestamp">作者: <?php echo $article['author']['title']; ?></span>
						</p>
						<div class="article-detail">
							<p>
								正文：<?php echo $article['detail']['content']; ?>
							</p>
							<p class="article-post-time">
								发表于<?php echo $article['ctime']; ?>
							</p>
						</div>

					</li>
<?php } ?>
				</ul>
				<footer class="more-list-small">
				</footer>
			</section>
