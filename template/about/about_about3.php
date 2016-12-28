<ul>
	<?php foreach ($member_list['admins'] as $admin) { ?>
		<li>
			<a href="<?php echo $home . $admin['url']; ?>">
				<img class="about-people-img" src="<?php echo $home . $admin['image_large']; ?>" alt="<?php echo $admin['alt']; ?>" title="<?php echo $admin['title']; ?>">
				<h3><?php echo $admin['title']; ?></h3>
			</a>
			<p>add description here</p>
		</li>
	<?php } ?>
	<?php foreach ($member_list['members'] as $member) { ?>
		<li>
			<a href="<?php echo $home . $member['url']; ?>">
				<img class="about-people-img" src="<?php echo $home . $member['image_large']; ?>" alt="<?php echo $member['alt']; ?>" title="<?php echo $member['title']; ?>">
				<h3><?php echo $member['title']; ?></h3>
			</a>
			<p>add description here</p>
		</li>
	<?php } ?>
</ul>