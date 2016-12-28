<section class="section-detail-article-content">
	<!-- <p class="addressing">
		<?php echo "正文"; ?>
	</p> -->
	<div class="content-head">
<?php if ( isset($recommend_button) && !empty($recommend_button) ) { ?>
		<button onclick="<?php echo $recommend_button['action']; ?>" class="button-recommend-<?php echo $recommend_button['class']; ?>"><?php echo $recommend_button['title']; ?></button>
<?php } ?>
		<div class="article-title">
			<button class="before-title-semicircle"></button><?php echo $article_detail['title']; ?>
		</div>
		<span class="post-timestamp"><?php echo "(发表于: ".$article_detail['ctime'].")"; ?></span>
	</div>
	<div class="article_tag_category">
		<div class="article-tag">
			<p>
				<?php echo "标签: "; ?><?php echo $article_detail['tag']; ?>
			</p>
		</div>
		<div class="article-category">
			<p>
				<?php echo "分类: "; ?><?php echo $article_catalog_list[$article_detail['category']]; ?>
			</p>
		</div>
	</div>
	<div class="article-content">
		<?php echo $article_detail['content']; ?>
	</div>
</section>

<style type="text/css">
 
.article-content>img
{
	max-width: 100%;
}

</style>