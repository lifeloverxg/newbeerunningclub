	<section class="section-search-top-nav">
		<div class="info-title">
			<div class="search-keyword-col">
				<div class="search-item">
					<div class="search-form-label">
						搜索关键词:
					</div>
					<div class="search-input-container">
						<input type="text" class="search-input" id="search-form-search-input" placeholder="..." value="<?php echo $keyword; ?>" onkeyup="if(event.which == 13) {<?php echo $search['func']['search'];?>}"/>
					</div>
					<div class="search-input-button">
						<button href="javascript:" onclick="<?php echo $search['func']['search']; ?>">
							<img src="<?php echo $home . "theme/images/search/searchPage_smallSearch.png"?>">
						</button>
					</div>
				</div>
			</div>
		</div>

	</section>