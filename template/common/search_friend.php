<section class="section-friend-list-large">
	<div class="friend-list-large">
		<div class="info-title_center" style="text-aline: center;">搜索&nbsp;<?php echo $keyword; ?>&nbsp;</div>
		<div class="friend-list-table">
			<ul>
		<?php foreach ($search_result as $search) { ?>
				<li>
					 <div class="friend-left">
		        <a href="<?php echo $home.$search['url'] ; ?>">
		          <img class="logo-small" src="<?php echo $home.$search['image']; ?>" alt="<?php echo $search['alt']; ?>" title="<?php echo $search['title']; ?>">
		        </a>
		    </div>
			<div class="friend-middle">
			  <a href="<?php echo $home.$search['url']; ?>">
				<span><?php echo $search['title']; ?></span>
			  </a>
			</div>
		    <div class="friend-right">
		<?php if (!empty($search['button'])) { ?>
		<?php   foreach ($search['button'] as $f_button) { ?>
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