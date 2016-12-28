			<div class="div-recommend-list">
				<div class="recommend-list">
					<ul>
<?php foreach ($recommend_list as $value) { ?>
						<li>
							<a href="<?php echo $home.$value['url']; ?>">
								<img class="logo-medium" src="<?php echo $home.$value['image']; ?>" alt="<?php echo $value['alt']; ?>" title="<?php echo $value['title']; ?>">
							</a>
							<a href="<?php echo $home.$value['url']; ?>">
								<span class="list-title-recommend"><?php echo $value['title']; ?></span>
							</a>
						</li>
<?php } ?>
					</ul>
				</div>
			</div>
