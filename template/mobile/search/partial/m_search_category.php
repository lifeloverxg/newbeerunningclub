	<section class="section-m-search-category">
		<ul class="ul-search-category-list">
<?php foreach ($catalog_list as $catalog) { ?>
			<li>
				<span class="search-category-list search-category-list-<?php echo $catalog['class']; ?>" href="javascript:" onclick="<?php echo $catalog['action']; ?>"><?php echo $catalog['title']; ?></span>
			</li>
<?php } ?>
		</ul>
	</section>