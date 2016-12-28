<div class="information-browser-wrap">
	<div class="information-locate-bar">
		<button class="locate-first locate-button" onclick="scrollToAnchor(1)">人在纽约</button>
		<button class="locate-second locate-button" onclick="scrollToAnchor(2)">衣食住行</button>
		<button class="locate-third locate-button" onclick="scrollToAnchor(3)">茶余饭后</button>
	</div>
	<div class="information-1">
		<a name="informationFocus1"></a>
		<div class="information-1-left">
			<div class="article-category-title"><?php echo $category_list[ArticleCategory::a]; ?></div>
			<ul>
<?php foreach ($article_category[ArticleCategory::a] as $article) { ?>
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
		</div>		
		<div class="information-1-middle">
			<div class="article-category-title"><?php echo $category_list[ArticleCategory::b]; ?></div>
			<ul>
<?php foreach ($article_category[ArticleCategory::b] as $article) { ?>
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
		</div>
		<div class="information-1-right">
			<div class="article-category-title"><?php echo $category_list[ArticleCategory::c]; ?></div>
			<ul>
<?php foreach ($article_category[ArticleCategory::c] as $article) { ?>
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
		</div>
	</div>
	<div class="information-2">
		<a name="informationFocus2"></a>
		<div class="information-2-left">
			<div class="article-category-title"><?php echo $category_list[ArticleCategory::d]; ?></div>
			<ul>
<?php foreach ($article_category[ArticleCategory::d] as $article) { ?>
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
		</div>
		<div class="information-2-right">
			<div class="article-category-title"><?php echo $category_list[ArticleCategory::e]; ?></div>
			<ul>
<?php foreach ($article_category[ArticleCategory::e] as $article) { ?>
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
		</div>
	</div>
	<div class="information-3">
		<a name="informationFocus3"></a>
		<div class="article-category-title">茶余饭后</div>
		<input type="text" id="information-3-index" style="display: none;" value="2" />
		<div class="information-3-viewleft" id="information-3-viewleft" onclick="information_3_viewleft()">
			<span class="glyphicon glyphicon-chevron-left"></span>
		</div>
		<div class="information-3-viewright" id="information-3-viewright" onclick="information_3_viewright()">
			<span class="glyphicon glyphicon-chevron-right"></span>
		</div>
		<div class="information-3-left">
			<div class="tucao-title" id="tucao-title-1"><?php echo $category_list[ArticleCategory::f1]; ?></div>
			<?php include $home . "cgi/tucao_6.php"; ?>
		</div>
		<div class="information-3-middle">
			<div class="tucao-title" id="tucao-title-2"><?php echo $category_list[ArticleCategory::f2]; ?></div>
			<?php include $home . "cgi/tucao_7.php"; ?>
		</div>
		<div class="information-3-right">
			<div class="tucao-title" id="tucao-title-3"><?php echo $category_list[ArticleCategory::f3]; ?></div>
			<?php include $home . "cgi/tucao_8.php"; ?>
		</div>
	</div>
</div>