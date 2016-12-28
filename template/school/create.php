			<div class="div-popup" id="create-event">
				<section class="popup-main">
					<header>
						<h2 style="margin:0"> 创建活动 </h2>
			            <hr style="border:1px solid #0e0e0e; margin-top: 10px;" />
					</header>
					<article class="create-event-form">
						<form id="eventForm" name="eventForm" method="post" action="" enctype="multipart/form-data" onSubmit="return event_check(this)">
							<select name="create_option" class="create-event-input">
								<option id="catalog-event-create-option" value="个人" disabled selected>创建活动身份</option>
<?php foreach ($create_event_option as $create_id => $create_name) { ?>
<?php if ($create_id == 'self') { ?>
								<option class="catalog-event-option-class" id="option-event-catalog-list-<?php echo $create_id; ?>" value="<?php echo $create_id; ?>"><?php echo $create_name; ?></option>
<?php } else { ?>
<?php foreach ($create_name as $group_name) { ?>
								<option class="catalog-event-option-class" id="option-event-catalog-list-<?php echo $create_id; ?>" value="<?php echo $group_name['gid']; ?>"><?php echo $group_name['title']; ?></option>
<?php } } } ?>
							<input type="text" name="event_title" class="event_title create-event-input" placeholder="活动名称" required/>
							<select name="event_category" class="create-event-input">
								<option id="option-catalog-list-all" value="全部" disabled selected>活动类型</option>
<?php foreach ($create_catalog_list as $catalog_id => $catalog_name) { ?>
								<option class="catalog-event-option-class" id="option-event-catalog-list-<?php echo $catalog_id; ?>" value="<?php echo $catalog_id; ?>"><?php echo $catalog_name; ?></option>
<?php } ?>
							</select>
							<div class="event-time">
								<input type="text" name="event_start_time"  class="event-time-start create-event-input" placeholder="Start time （format: 2012-06-30 07:00）" required/>
								<input type="text" name="event_end_time"  class="event-time-end create-event-input" placeholder="If any end time" />
							</div>
							<div class="event-location">
								<!--			
									<input type="text" name="event_location" class="event_location create-event-input" placeholder="活动地点" required/>
								-->
								<input type="text" name="event_location_street" class="event_location_street create-event-input" id="event_location_street" placeholder="门牌号,街道名..." required/>
								<input type="text" name="event_location_city" class="event_location_city create-event-input" id="event_location_city" placeholder="city..." required/>
								<input type="text" name="event_location_state" class="event_location_state create-event-input" id="event_location_state" placeholder="state..." required/>
							</div>
							<!--
							<div class="event-location-map">							
<?php include $home . "template/common/map_form.php"; ?>
							</div>
							-->
							<div class="event_tag">
<!--
								<input type="text" readonly name="event_tag-test" class="event_tag create-event-input" placeholder="活动标签, 您的输入今后将成为搜索您的活动的关键, 请在下方选择" required/>
<?php foreach ($event_filter_list as $filter_id => $filter_name) { ?>
<?php if ($filter_name != '全部') { ?>
								<div class="div-filter-option">
									<?php echo $filter_name; ?>
									<label>								
										<input type="checkbox" name="event_tag[]" id="event_tag-<?php echo $filter_id; ?>" class="event-tag" value="<?php echo $filter_id; ?>"/>
									</label>
								</div>
<?php } else { ?>
								<input type="checkbox" name="event_tag[]" id="event_tag-<?php echo $filter_id; ?>" class="event-tag event-tag-all" value="<?php echo $filter_id; ?>"/>
<?php } ?>
<?php } ?>
-->
								<p style="margin: 5px 0;">添加标签:</p>
								<input type="text" name="event_tag" class="tag-value none_class" value="0"/>
								<div class="search-right-filter">
									<ul class="ul-search-filter-list">
<?php foreach ($event_filter_list as $filter_id => $filter) { ?>
										<li>
											<span id="search-filter-list-<?php echo $filter_id; ?>" class="search-filter-list search-filter-list-<?php echo $filter['class']; ?> <?php if ($filter['title'] == '全部') {echo 'none_class';}?>" href="javascript:" onclick="<?php echo $filter['action']; ?>"><?php echo $filter['title']; ?></span>
										</li>
<?php } ?>
									</ul>
								</div>
							</div>
							<input type="number" name="event_size" class="event_size create-event-input" placeholder="人数规模" min="1" max="2000" required/>
							<input type="text" name="event_price" class="event_price create-event-input" placeholder="活动收费"/>
							<textarea name="event_description" class="event_description" placeholder="活动描述" title="活动描述..." value="活动描述..."></textarea>
							<input type="submit" name="event_submit" id="event_submit" value="创建活动" /></td>
						</form>
					</article>
				</section>
			</div>
