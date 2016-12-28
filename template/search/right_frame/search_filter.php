	<section class="section-search-filter-list">
<?php if ( isset($filter_list) && !empty($filter_list) ) { ?>
		<div class="search-right-filter">
			<span style="display: block; float: left; color: white; margin-right: 10px; background: #0076a6; border: 1px solid #eee; line-height: 30px; width: 50px; text-align: center; border-radius: 5px;">Filter: </span>
			<input name="search_filter_tag" class="search-tag-value none_class" value="0" />
			<ul class="ul-search-filter-list">
<?php foreach ($filter_list as $filter_id => $filter) { ?>
				<li>
					<span id="search-filter-list-<?php echo $filter_id; ?>" class="search-filter-list search-filter-list-<?php echo $filter['class']; ?> <?php if ( ($filter['title'] == '全部') || ($filter['title'] == '未知') ) {echo 'none_class';}?>" href="javascript:" onclick="<?php echo $filter['action']; ?>"><?php echo $filter['title']; ?></span>
				</li>
<?php } ?>
			</ul>
		</div>
<?php } ?>
	</section>