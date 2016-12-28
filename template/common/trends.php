<section class="section-trends">
	<div class="info-title">
		动态
	</div>
	<article class="info-list">
<?php if ( (isset($trend_sorted)) && (!empty($trend_sorted)) ) { ?>
		<div id="trend-wrap">
			<div id="trend-content">
			<div id="trend-top"> 
			<ul class="ul-trends">
<?php foreach ($trend_sorted as $trend) { ?>
				<li class="li-trends">
<?php switch ($trend['title']) { ?>
<?php case "参加了活动": ?>
					<p class="news-tag"><?php echo $info_list['title']; ?><?php echo $trend['title']; ?></p>
					<p class="trends-content"><?php echo $trend['content']['title']; ?></p>
					<span class="trends-time"><?php echo $trend['timestamp']; ?></span>
<?php break;?>
<?php case "参加了群组": ?>
					<p class="news-tag"><?php echo $info_list['title']; ?><?php echo $trend['title']; ?></p>
					<p class="trends-content"><?php echo $trend['content']['title']; ?></p>
					<span class="trends-time"><?php echo $trend['timestamp']; ?></span>
<?php break; ?>
<?php case "发表了新鲜事": ?>
					<p class="news-tag"><?php echo $info_list['title']; ?><?php echo $trend['title']; ?></p>
					<p class="trends-content"><?php echo $trend['content']; ?></p>
					<span class="trends-time"><?php echo $trend['timestamp']; ?></span>
<?php break; ?>	
<?php case "成为了好友": ?>
					<p class="news-tag"><?php echo $info_list['title']; ?>与<a href="<?php echo $home.$trend['content']['url']; ?>"><?php echo $trend['content']['title']; ?></a><?php echo $trend['title']; ?></p>
					<span class="trends-time"><?php echo $trend['timestamp']; ?></span>
<?php break; ?>					
<?php } ?>
				</li>
<?php } ?>
			</ul>
			</div>
			<div id="trend-bottom"></div>
			</div>			
			<div id="trend-foot"></div>
		</div>
<?php } ?>
	</article>
</section>