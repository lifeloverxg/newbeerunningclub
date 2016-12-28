<?php if ( isset($article_list_small) && !empty($article_list_small) ) { ?>
			<section class="section-article-list-small">
				<ul class="ul-article-list-small">
<?php foreach ($article_list_small as $article) { ?>
					<li>
						<p class="article-addressing">
<?php echo $article['head']; ?>
							<a href="article_list.php?pid=<?php echo $pid; ?>" class="list-more-small">更多</a>
						</p>
						<ul class="ul-article-list-detail">
<?php foreach ($article['list'] as $article_list) { ?>
							<li>
								<a href="<?php echo $home.$article_list['detail']['url']; ?>">
									<span class="list-title-article"><?php echo $article_list['detail']['title']; ?></span>
								</a>
								<a href="<?php echo $home.$article_list['author']['url']; ?>">
									<span class="list-title-author"><?php echo $article_list['author']['title']; ?></span>
								</a>
							</li>
<?php } ?>
						</ul>
					</li>
<?php } ?>
				</ul>
				<footer class="more-list-small">
				</footer>
			</section>
<?php } else if ( (isset($target_article_list)) && (!empty($target_article_list)) ) { ?>
			<section class="section-target-article-list-small">
				<p class="article-addressing">
<?php echo "ta发表的其他文章"; ?>
					<a href="browser.php" class="list-more-small">更多</a>
				</p>
				<ul class="ul-target-article-list-small">
<?php foreach ($target_article_list as $target_article) { ?>
					<li>
						<p>
							<a href="<?php echo $home.$target_article['detail']['url']; ?>">
								<span class="list-title-article"><?php echo $target_article['detail']['title']; ?></span>
							</a>
						</p>
					</li>
<?php } ?>
				</ul>
				<footer class="more-list-small">
				</footer>
			</section>
<?php } ?>