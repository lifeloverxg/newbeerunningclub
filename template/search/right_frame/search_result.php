	<section class="section-search-result-list-large">
		<div class="search-right-result-list-large">
			<ul class="ul-search-result-list-large">
<?php if ( isset($search_result_list) && (!empty($search_result_list)) ) { ?>
<?php foreach ($search_result_list as $result) { ?>
				<li class='li-search-result-list-large'>
					<a href='<?php echo $home.$result['url']; ?>'>
						<div class='search-result-left-area'>
							<img class='logo-small' src="<?php echo $home.$result['image_large']; ?>" alt="<?php echo $result['alt']; ?>" title="<?php echo $result['title']; ?>">
						</div>
						<div class='search-result-right-area'>
							<span class='search-result-list-title'><?php echo $result['title']; ?></span>
							<!--这里是每一个搜索结果的tag-->
<?php if ( isset($result['tag']) ) { ?>
							<ul class="ul-search-filter-list">
<?php foreach ($result['tag'] as $filter) { ?>
								<li>
									<span class="search-filter-list search-filter-list-filter-on" href="javascript:"><?php echo $filter; ?></span>
								</li>
<?php } ?>
							</ul>
<?php } ?>
						</div>
					</a>
<?php if ($result['head']) { ?>
					<div class="search-result-head-area">
						<?php echo $result['head']; ?>						
					</div>
<?php } ?>
					<div class="friend-right">
<?php if (!empty($result['button'])) { ?>
<?php   foreach ($result['button'] as $f_button) { ?>
      					<button class="search-button <?php echo $f_button['class']; ?>" onclick="<?php echo $f_button['action']; ?>"><?php echo $f_button['title']; ?></button>
<?php   } ?>
<?php } ?>
		    		</div>
				</li>
<?php }  } ?>
			</ul>
		</div>
	</section>