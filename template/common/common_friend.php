<?php if ( !empty($common_friend_small) ){ ?>
			<section class="section-common-friend-small">
				<p class="addressing">共同好友</p>
				<ul class="ul-common-friend-small">
<?php foreach ($common_friend_small as $common) { ?>
					<li>
						<a href="<?php echo $home.$common['url']; ?>">
							<img class="logo-medium" src="<?php echo $home.$common['image']; ?>" alt="<?php echo $common['alt']; ?>" title="<?php echo $common['title']; ?>">
						</a>
						<span class="list-icon-common"><?php // echo $common['icon']; ?></span>
						<br>
						<a href="<?php echo $home.$common['url']; ?>">
							<span class="list-title-common"><?php echo $common['title']; ?></span>
						</a>
					</li>
<?php } ?>
				</ul>
				<footer class="more-list-small">
				</footer>
			</section>
<?php } ?>
