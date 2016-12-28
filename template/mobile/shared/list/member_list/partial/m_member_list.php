<section class="section-friend-list-large">
	<div class="friend-list-large">
		<div class="event-detail-title" style="text-aline: center;"><?php echo $member_list['title']; ?>成员列表</div>
		<div class="friend-list-table">
			<ul>
<?php foreach ($member_list['member'] as $member) { ?>
				<li>
					 <div class="friend-left">
				        <a href="<?php echo $home.$member['url'] ; ?>">
				          <img class="logo-small" src="<?php echo $home.$member['image']; ?>" alt="<?php echo $member['alt']; ?>" title="<?php echo $member['title']; ?>">
				        </a>
		    		</div>
					<div class="friend-middle">
					  <a href="<?php echo $home.$member['url']; ?>">
						<span><?php echo $member['title']; ?></span>
					  </a>
					</div>
		   			<div class="friend-right">
<?php if (!empty($member['button'])) { ?>
<?php   foreach ($member['button'] as $f_button) { ?>
		      			<button class="<?php echo $f_button['class']; ?>" onclick="<?php echo $f_button['action']; ?>"><?php echo $f_button['title']; ?></button>
<?php   } ?>
<?php } ?>
		    		</div>
				</li>
<?php } ?>
			</ul>
		</div>
	</div>
</section>