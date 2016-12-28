<section class="section-friend-list-large">
	<div class="friend-list-large">
		<header class="tag-tabs">
			<ul class="ul-tag-list">
	<?php foreach ($friend_list as $friend_category) { ?>
				<li>
					<a class="tag-tabs-list tag-tabs-list-<?php echo $friend_category['class']; ?>" href="javascript:" onclick="<?php echo $friend_category['action']; ?>"><?php echo $friend_category['title']; ?></a>
				</li>
	<?php } ?>
			</ul>
		</header>
		<div class="friend-list-table">
			<ul>
		<?php foreach ($friend_list[$category]['member'] as $friend) { ?>
				<li>
					 <div class="friend-left">
		        <a href="<?php echo $home.$friend['url'] ; ?>">
		          <img class="logo-small" src="<?php echo $home.$friend['image']; ?>" alt="<?php echo $friend['alt']; ?>" title="<?php echo $friend['title']; ?>">
		        </a>
		    </div>
			<div class="friend-middle">
			  <a href="<?php echo $home.$friend['url']; ?>">
				<span><?php echo $friend['title']; ?></span>
			  </a>
			</div>
		    <div class="friend-right">
		<?php if (!empty($friend['button'])) { ?>
		<?php foreach ($friend['button'] as $f_button) { ?>
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