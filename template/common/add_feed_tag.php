			<section class="ul-feed-list-large">
				<div class="feed-left-area">
					<a href="<?php echo $home.$auth['url']; ?>">
						<img class="logo-medium" src="<?php echo $home.$auth['image']; ?>" alt="<?php echo $auth['alt']; ?>" title="<?php echo $auth['title']; ?>">
					</a>
				</div>
				<!-- right area-->
				<div class="feed-right-area">
					<!-- board area -->
					<div class="div-feed-list-feed">
						<a href="<?php echo $home.$auth['url']; ?>"
							<span class="list-title-member"><?php echo $auth['title']?></span>
						</a>
						<div>
							<textarea class="comment-textarea" id="comment-textarea-<?php echo $feed['id']; ?>" placeholder="写新鲜事..." title="写新鲜事..." value="写新鲜事..." style="height: 200px; width: 600px; max-width: 600px; '幼圆', '宋体', Arial, sans-serif; font-size: 25px;"></textarea>
							<button class="button-reply" onclick="<?php echo $feed_list['add_feed']['action']; ?>" style="float:right;"><?php echo $feed_list['add_feed']['title']; ?></button>
						</div>
					</div>
				</div>
			</section>
