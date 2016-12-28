			<section class="section-member-list-large">
				<ul class="ul-member-list-large">
<?php foreach ($member_list_large as $member) { ?>
					<li>
						<a href="<?php echo $home.$member['url']; ?>">
							<img class="logo-medium" src="<?php echo $home.$member['image']; ?>" alt="<?php echo $member['alt']; ?>" title="<?php echo $member['title']; ?>">
						</a>
						<a href="<?php echo $home.$member['url']; ?>">
							<span class="list-title-member"><?php echo $member['title']; ?></span>
						</a>
						<ul class="ul-member-list-large-button-list">
<?php foreach ($member['action'] as $value) { ?>
							<li>
								<a href="javascript:" onclick="<?php echo $value['func']; ?>"><?php echo $value['title']; ?></a>
							</li>
<?php } ?>
						</ul>
					</li>
<?php } ?>
				</ul>
			</section>