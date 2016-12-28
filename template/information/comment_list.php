<section class="article-comment-list">
	<!-- comments area -->
	<div class="div-feed-list-comment-list">
		<div class="div-feed-list-more-comment" id="div-feed-list-more-comment-<?php echo $arid; ?>">
<?php 		if (isset($comment_list['func']['more']) && $comment_list['func']['more'] != "") { ?>
			<a href="javascript:" onclick="<?php echo $comment_list['func']['more']; ?>">查看更多评论</a>
<?php 		} ?>
		</div>
		<!-- comment list -->
		<ul class="ul-feed-list-comment-list" id="ul-feed-list-comment-list-<?php echo $arid; ?>">
<?php 		foreach ($comment_list['comment'] as $comment) { ?>
			<li>
				<a href="<?php echo $home.$comment['owner']['url']; ?>">
					<img class="logo-small" src="<?php echo $home.$comment['owner']['image']; ?>" alt="<?php echo $comment['owner']['alt']; ?>" title="<?php echo $comment['owner']['title']; ?>">
				</a>
				<div class="comment-right-area">
					<!-- replyer name -->
					<a class="replyer-title" href="<?php echo $home.$comment['owner']['url']; ?>"><?php echo $comment['owner']['title']; ?></a>
					<p><?php echo $comment['content']; ?></p>
					<span class="comment-time-feed"><?php echo $comment['timestamp']; ?></span>
				</div>
			</li>
<?php 		} ?>
		</ul>
	</div>
<?php 		if($auth['uid'] > 0) { ?>
	<!-- reply area -->
	<!--如果是游客则不显示回复窗口-->
	<div class="ul-feed-list-reply">
		<a href="<?php echo $home.$auth['url']; ?>">
			<img class="self-logo-small" src="<?php echo $home.$auth['image']; ?>" alt="<?php echo $auth['alt']; ?>" title="<?php echo $auth['title']; ?>">
		</a>
		<div>
			<textarea class="comment-textarea" id="comment-textarea-<?php echo $arid; ?>" placeholder="发表评论" title="发表评论" value="发表评论"></textarea>
			<button class="button-reply" onclick="<?php echo $comment_list['func']['reply']; ?>">评论</button>
		</div>
	</div>
	<!-- 结束回复板块 -->
<?php 		} ?>
</section>