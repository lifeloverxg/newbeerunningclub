			<header class="top">
				<div class="event-group-search-wrap">
				<div class="div-search">
					<!-- <input class="search-input" id="event-group-search-input" type="text" placeholder="搜索" x-webkit-speech="x-webkit-speech" value="<?php echo $search['keyword']; ?>" onkeyup="if(event.which != 13){<?php echo $search['func']['assist']; ?>}else{<?php echo $search['func']['search']; ?>}" /> -->
					<input class="search-input" id="event-group-search-input" type="text" placeholder="搜索" x-webkit-speech lang="zh-CN" x-webkit-grammar="bUIltin:translate" onwebkitspeechchange="<?php echo $search['func']['assist']; ?>" value="<?php echo $search['keyword']; ?>" onkeyup="if(event.which != 13){<?php echo $search['func']['assist']; ?>}else{<?php echo $search['func']['search']; ?>}" />
					<ul id="ul-assist-list"></ul>
					<div class="div-search-catalog">
						<div class="div-search-catalog-div"></div>
						<select id="search-type" onchange="<?php echo $search['func']['assist']; ?>">
<?php foreach ($catalog_list as $catalog_id => $catalog_name) {
				if ($catalog_id == $search['catalog']){
?>
							<option class="option-catalog-list" value="<?php echo $catalog_id; ?>" selected><?php echo $catalog_name; ?></option>
<?php		} else { ?>
							<option class="option-catalog-list" value="<?php echo $catalog_id; ?>"><?php echo $catalog_name; ?></option>
<?php		}
	}
?>
						</select>
						
					</div>
					<button class="btn btn-default button-search" onclick="<?php echo $search['func']['search']; ?>">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</div>
				<div class="event-group-search-result" id="event-group-search-result" style="display: none;">
					<div class="event-group-search-result-title"></div>
					<ul class="ul-search-result-event-group">
					</ul>
					<div class="event-group-search-result-more"></div>
				</div>
			</div>
				<div class="div-button-list-large">
					<ul class="ul-button-list-large">
<?php foreach ($button_list_large as $button) { ?>
						<li><a href="javascript:" onclick="<?php echo $button['action']; ?>" class="button-create"><?php echo $button['title']; ?></a></li>
<?php } ?>
					</ul>
				</div>
			</header>
			
