	<section class="section-search-left-frame">
		<div class="search-left-category">
			<ul class="ul-search-category-list">
<?php foreach ($catalog_list as $catalog) { ?>
				<li>
					<span class="search-category-list search-category-list-<?php echo $catalog['class']; ?>" href="javascript:" onclick="<?php echo $catalog['action']; ?>"><?php echo $catalog['title']; ?></span>
				</li>
<?php } ?>
			</ul>
		</div>
		<div class="search-keyword-col">
			<div class="search-item">
				<div class="search-form-label">
					搜索关键词
				</div>
				<div class="search-input-container">
					<input type="text" class="search-input" id="search-form-search-input" placeholder="搜索..." value="<?php echo $keyword; ?>" onkeyup="if(event.which == 13) {<?php echo $search['func']['search'];?>}"/>
				</div>
			</div>
		</div>
	</section>