			<section class="section-admin-list-small">
				<ul class="ul-admin-list-small">
					<p class="addressing">管理员</p>
					<div class="admin-list-scroll">
<?php foreach ($admin_list_small as $admin) { ?>
						<li>
							<a href="<?php echo $home.$admin['url']; ?>">
								<img class="logo-medium" src="<?php echo $home.$admin['image']; ?>" alt="<?php echo $admin['alt']; ?>" title="<?php echo $admin['title']; ?>">
							</a>
							<span class="list-icon-admin"><?php // echo $admin['icon']; ?></span>
							<br>
							<a href="<?php echo $home.$admin['url']; ?>">
								<span class="list-title-admin"><?php echo $admin['title']; ?></span>
							</a>
						</li>
<?php } ?>
					</div>
				</ul>
				<footer class="more-list-small">
				</footer>
			</section>
