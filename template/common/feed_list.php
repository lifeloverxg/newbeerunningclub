			<section class="section-feed-list-large">
<?php if ( $deviceType != "phone" ) { ?>
				<header class="tag-tabs">
					<ul class="ul-tag-list">
<?php foreach ($tag_list as $tag) { ?>
						<li>
							<div class="tag-tabs-list tag-tabs-list-<?php echo $tag['class']; ?>" onclick="<?php echo $tag['action']; ?>"><?php echo $tag['title']; ?></div>
						</li>
<?php } ?>
					</ul>
				</header>
<?php } ?>
				<div class="feed-list-content">
					<article>
<?php if (isset($feed_list['add_feed'])){ ?>
						<div id="ul-feed-list-large-newfeed">
							<div class="feed-left-area">
								<a href="<?php echo $home.$auth['url']; ?>">
									<img class="logo-medium" src="<?php echo $home.$auth['image_large']; ?>" alt="<?php echo $auth['alt']; ?>" title="<?php echo $auth['title']; ?>">
								</a>
							</div>
							<!-- right area-->
							<div class="feed-right-area">
								<!-- board area -->
								<div class="div-feed-list-feed">
									<a href="<?php echo $home.$auth['url']; ?>">
										<span class="list-title-member"><?php echo $auth['title']?></span>
									</a>
									<div>
										<textarea class="comment-textarea" id="newfeed-textarea-id" placeholder="<?php echo $feed_list['add_feed']['title']; ?>" title="<?php echo $feed_list['add_feed']['title']; ?>" value="<?php echo $feed_list['add_feed']['title']; ?>"></textarea>
										<button class="button-reply" onclick="<?php echo $feed_list['add_feed']['action']; ?>"><?php echo $feed_list['add_feed']['title']; ?></button>
									</div>
								</div>
							</div>
						</div>
<?php }?>
						<!-- 底下是feedlist,上面是发表新鲜事 -->
						<ul class="ul-feed-list-large">
<?php foreach ($feed_list_large as $feed) { ?>
							<li class="li-feed-list-large">
								<!-- left area: poster -->
								<div class="feed-left-area">
									<a href="<?php echo $home.$feed['owner']['url']; ?>">
										<img class="logo-medium" src="<?php echo $home.$feed['owner']['image_large']; ?>" alt="<?php echo $feed['owner']['alt']; ?>" title="<?php echo $feed['owner']['title']; ?>">
									</a>
								</div>
								<!-- right area-->
								<div class="feed-right-area">
									<!-- board area -->
									<div class="div-feed-list-feed">
<?php 		if (isset($feed['score']) && $feed['score'] != "") { ?>
											<!-- review score area appears only if there is a score -->
											<div class="div-feed-list-feed-score">
												<div class="div-rating-small">
													<div class="rating-small-stars"></div>
													<div class="rating-small-score"><span></span></div>
												</div>
											</div>
<?php 		} ?>
										<!-- board content -->
										<a href="<?php echo $home.$feed['owner']['url']; ?>">
											<span class="list-title-member"><?php echo $feed['owner']['title']?></span>
										</a>
										<p><?php echo $feed['content']; ?></p>
<?php 		if (isset($feed['image']) && $feed['image']['url'] != "") { ?>
										<!-- board image area appears only if there is an image -->
											<div class="div-feed-list-feed-image">
												<img class="image-large" src="<?php echo $home.$feed['image']['url']; ?>" alt="<?php echo $feed['image']['alt']; ?>" title="<?php echo $feed['image']['title']; ?>">
											</div>
<?php 		} ?>
										<!-- board timestamp -->
										<span class="time-feed"><?php echo $feed['timestamp']; ?></span>
									</div>
									<!-- comments area -->
									<div class="div-feed-list-comment-list">
										<div class="div-feed-list-more-comment" id="div-feed-list-more-comment-<?php echo $feed['id']; ?>">
<?php 		if (isset($feed['func']['more']) && $feed['func']['more'] != "") { ?>
											<a href="javascript:" onclick="<?php echo $feed['func']['more']; ?>">查看更多评论</a>
<?php 		} ?>
										</div>
										<!-- comment list -->
										<ul class="ul-feed-list-comment-list" id="ul-feed-list-comment-list-<?php echo $feed['id']; ?>">
<?php if ( isset($feed['comments']['comment']) && !empty($feed['comments']['comment']) ) { ?>
<?php foreach ($feed['comments']['comment'] as $comment) { ?>
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
<?php } } ?>
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
											<textarea class="comment-textarea" id="comment-textarea-<?php echo $feed['id']; ?>" placeholder="发表评论" title="发表评论" value="发表评论"></textarea>
											<button class="button-reply" onclick="<?php echo $feed['func']['reply']; ?>">评论</button>
										</div>
									</div>
									<!-- 结束回复板块 -->
<?php 		} ?>
								</div>
							</li>
<?php } ?>
						</ul>
					</article>
					<footer class="more-list-large">
<?php if (isset($next) && $next != "") { ?>
					<a href="javascript:" onclick="showMoreFeed(<?php echo $tag_id; ?>, <?php echo $page_id; ?>, '<?php echo $page_type; ?>', 20, <?php echo $next; ?>);">可以查看更多哦</a>
<?php } ?>
					</footer>
				</div>
			</section>
