<section class="section-manage-member">
	<div class="manage-member">
		<p class="member-type">管理员</p>
		<ul>
	<?php foreach ($member_list['admins'] as $admin) { ?>
			<li>
				<div class="member-left">
					<a href="<?php echo $home.$admin['url'] ; ?>">
						<img class="logo-small" src="<?php echo $home.$admin['image']; ?>" alt="<?php echo $admin['alt']; ?>" title="<?php echo $admin['title']; ?>">
					</a>
				</div>
				<div class="member-middle">
					<a href="<?php echo $home.$admin['url']; ?>">
						<span><?php echo $admin['title']; ?></span>
					</a>
				</div>
				<div class="member-right">
				<?php if (!empty($admin['action'])) { ?>
				<?php   foreach ($admin['action'] as $button) { ?>
					<button class="<?php echo $button['class']; ?>" onclick="<?php echo $button['action']; ?>"><?php echo $button['title']; ?></button>
				<?php   } ?>
				<?php } ?>
				</div>
			</li>
	<?php } ?>
		</ul>

		<p class="member-type">成员</p>
		<ul>
	<?php foreach ($member_list['members'] as $member) { ?>
			<li>
				<div class="member-left">
					<a href="<?php echo $home.$member['url'] ; ?>">
						<img class="logo-small" src="<?php echo $home.$member['image']; ?>" alt="<?php echo $member['alt']; ?>" title="<?php echo $member['title']; ?>">
					</a>
				</div>
				<div class="member-middle">
					<a href="<?php echo $home.$member['url']; ?>">
						<span><?php echo $member['title']; ?></span>
					</a>
				</div>
				<div class="member-right">
				<?php if (!empty($member['action'])) { ?>
				<?php   foreach ($member['action'] as $button) { ?>
					<button class="<?php echo $button['class']; ?>" onclick="<?php echo $button['action']; ?>"><?php echo $button['title']; ?></button>
				<?php   } ?>
				<?php } ?>
				</div>
			</li>
	<?php } ?>
		</ul>
	</div>
</section>