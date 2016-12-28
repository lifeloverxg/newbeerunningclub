			<section class="section-member-list-small">
<?php if ( isset($eid) ) { ?>
				<p class="addressing">
					<span>成员</span>
					<a href="member_list.php?eid=<?php echo $eid; ?>" class="list-more-small">更多</a>
				</p>
<?php } else if ( isset($gid) ) { ?>
				<p class="addressing">
					<span>成员列表</span>
					<a href="manage_member.php?gid=<?php echo $gid; ?>&more=true" class="list-more-small">更多</a>
				</p>
<?php } else{ ?>
				<p class="addressing">
					<span>好友列表</span>
<?php if ($auth['uid'] == $tpid) { ?>
                <a href="friend_list.php" class="list-more-small">更多</a>
<?php } ?>
				</p>
<?php } ?>
<?php if ( isset($member_list_small) && !empty($member_list_small) ) { ?>
				<ul class="ul-member-list-small">
<?php foreach ($member_list_small as $member) { ?>
					<li>
						<a href="<?php echo $home.$member['url']; ?>">
							<img class="logo-medium" src="<?php echo $home.$member['image']; ?>" alt="<?php echo $member['alt']; ?>" title="<?php echo $member['title']; ?>">
						</a>
						<span class="list-icon-member"><?php // echo $member['icon']; ?></span>
						<br>
						<a href="<?php echo $home.$member['url']; ?>">
							<span class="list-title-member"><?php echo $member['title']; ?></span>
						</a>
					</li>
<?php } ?>
				</ul>
<?php } else { ?>
<?php if ( isset($member_list_small_gender) && !empty($member_list_small_gender) ) { ?>
					<div class="member-list-icon">
<?php foreach ($member_list_small_gender as $gender => $member_list) { ?>
	<?php if ($gender == 'female') { ?>
						<div class="member-list-icon-female">
							<img src="../theme/images/female.png">
						</div>
	<?php } else { ?>
						<div class="member-list-icon-male">
							<img src="../theme/images/male.png">
						</div>
	<?php } ?>
<?php } ?>
					</div>
					<div class="member-list-scroll">
<?php foreach ($member_list_small_gender as $gender => $member_list) { ?>
						<div class="member-list-small-<?php echo $gender; ?>">
							<ul class="ul-member-list-small">
<?php foreach ($member_list as $member) { ?>
								<li>
									<a href="<?php echo $home.$member['url']; ?>">
										<img class="logo-medium" src="<?php echo $home.$member['image']; ?>" alt="<?php echo $member['alt']; ?>" title="<?php echo $member['title']; ?>">
									</a>
									<span class="list-icon-member"><?php // echo $member['icon']; ?></span>
									<br>
									<a href="<?php echo $home.$member['url']; ?>">
										<span class="list-title-member"><?php echo $member['title']; ?></span>
									</a>
								</li>
<?php } ?>
							</ul>
						</div>
<?php } ?>
					</div>
<?php } } ?>
				<footer class="more-list-small">
				</footer>
			</section>
