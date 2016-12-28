			<section class="section-feed-list-large">
				<header class="tag-tabs">
					<ul class="ul-tag-list">
<?php foreach ($tag_list as $tag) { ?>
						<li>
							<a class="tag-tabs-list" href="javascript:" onclick="<?php echo $tag['action']; ?>"><?php echo $tag['title']; ?></a>
						</li>
<?php } ?>
<?php if (isset($feed_list["add_feed"])) { ?>
						<li>
							<a class="tag-tabs-list-new-feed" id="tag-tabs-list-new-feed" href="javascript:" onclick="update_feed_tag(10, <?php echo '$auth["uid"]'; ?>, <?php echo '$type'; ?>)"><?php echo $feed_list['add_feed']['title']; ?></a>
						</li>
					</ul>
<?php } ?>
					<!-- reply area -->
					<div class="ul-feed-list-reply">
						<a href="<?php echo $home.$auth['url']; ?>">
							<img class="self-logo-small" src="<?php echo $home.$auth['image']; ?>" alt="<?php echo $auth['alt']; ?>" title="<?php echo $auth['title']; ?>">
						</a>
						<div>
							<textarea class="comment-textarea" id="comment-textarea-<?php echo $feed['id']; ?>" placeholder="写评论" title="写评论..." value="写评论..."></textarea>
							<button class="button-reply" onclick="<?php echo $feed['func']['reply']; ?>">评论</button>
						</div>
					</div>
			</section>
