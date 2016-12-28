			<div class="div-popup" id="create-event">
				<a href="javascript:" class="popup-close"><span class="glyphicon glyphicon-remove"></span></a>
				<section class="popup-main">
					<header>
						<h1>创建活动</h1>
					</header>
					<article class="create-form create-event-form">
						<form id="eventForm" name="eventForm" method="post" action="<?php echo $home . "cgi/formActions/uni_form_common.php"; ?>" enctype="multipart/form-data" onSubmit="return event_create_check(this)">
							<input type="text" name="event_title" class="form-control input-sm type-input event_title create-event-input" placeholder="活动名称" required/>

							<div class="div-event-create-category">
								<input type="hidden" name="event_category" value="0" class="select-input-substitute">
								<select class="select-block mbl" name="small" id="flat-ui-event-category" onchange="update_form_select(2, 0)">
									<option value="全部" disabled selected>活动类型</option>
<?php foreach ($create_catalog_list as $catalog_id => $catalog_name) { ?>
									<option value="<?php echo $catalog_id; ?>"><?php echo $catalog_name; ?></option>
<?php } ?>
								</select>
							</div>

							<textarea name="event_description" class="event_description form-control" placeholder="活动描述" title="活动描述..." value="活动描述..."></textarea>

							<div class="event-time">
								<!-- ++++++ Start Time ++++++ -->
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn" type="button"><span class="fui-calendar"></span></button>
									</span>
									<input type="text" class="event-time-date form-control" placeholder="开始日期" id="datepicker-01" onchange="update_form_select(3, 10)">
								</div>
								<select class="event_time_start_hh" style="display:none;" id="event-time-start-hh">
									<option value="00" disabled selected>时</option>
<?php foreach ($hour_array as $hour_array_key => $hour_array_value) { ?>
									<option value="<?php echo $hour_array_value; ?>" <?php if ($hour_array_key == '00') {echo 'selected';} ?>><?php echo $hour_array_key; ?></option>
<?php } ?>
								</select>
								<div class="input-time input-time-hh">
									<select class="select-block mbl" name="large" id="flat-ui-event-time-start-hh" onchange="update_form_select(3, 1)">
										<option value="00" disabled selected>时</option>
<?php foreach ($hour_array as $hour_array_key => $hour_array_value) { ?>

										<option value="<?php echo $hour_array_key; ?>"><?php echo $hour_array_value; ?></option>
<?php } ?>
									</select>
								</div>
								<div class="input-time input-time-mm">
									<select style="display:none" name="event_time_start_mm" id="event-time-start-mm">
										<option value="00" disabled selected>分</option>
<?php foreach ($minute_array as $minute_array_key => $minute_array_value) { ?>
										<option value="<?php echo $minute_array_value; ?>" <?php if ($minute_array_key == '00') {echo 'selected';} ?>><?php echo $minute_array_key; ?></option>
<?php } ?>
									</select>
									<select class="select-block mbl" name="large" id="flat-ui-event-time-start-mm" onchange="update_form_select(3, 2)">
										<option value="00" disabled selected>分</option>
<?php foreach ($minute_array as $minute_array_key => $minute_array_value) { ?>
										<option value="<?php echo $minute_array_key; ?>"><?php echo $minute_array_value; ?></option>
<?php } ?>
									</select>
								</div>
								<!-- <div class="input-time input-time-updown">
									<input type="text" class="form-control" value="AM">
								</div> -->
								<!-- ====== Start Time ====== -->
								<!-- ++++++ End Time ++++++ -->
								<div class="input-group">
									<span class="input-group-btn">
										<button class="btn" type="button"><span class="fui-calendar"></span></button>
									</span>
									<!-- <input type="text" class="form-control" value="<?php echo $showtime=date("d M,Y");?>" id="datepicker-02"> -->
									<input type="text" name="event_end_time_date" class="event-time-date form-control" placeholder="结束日期" id="datepicker-02" onchange="update_form_select(3, 11)">
								</div>
								<div class="input-time input-time-hh">
									<select class="event_time_end_hh" style="display:none;" id="event-time-end-hh">
										<option value="00" disabled selected>时</option>
<?php foreach ($hour_array as $hour_array_key => $hour_array_value) { ?>
										<option value="<?php echo $hour_array_value; ?>" <?php if ($hour_array_key == '00') {echo 'selected';} ?>><?php echo $hour_array_key; ?></option>
<?php } ?>
									</select>
									<select class="select-block mbl" name="large" id="flat-ui-event-time-end-hh" onchange="update_form_select(3, 3)">
										<option value="00" disabled selected>时</option>
<?php foreach ($hour_array as $hour_array_key => $hour_array_value) { ?>
										<option value="<?php echo $hour_array_key; ?>"><?php echo $hour_array_value; ?></option>
<?php } ?>
									</select>
								</div>
								<div class="input-time input-time-mm">
									<select class="event_time_end_mm" style="display:none;" id="event-time-end-mm">
										<option value="00" disabled selected>分</option>
<?php foreach ($minute_array as $minute_array_key => $minute_array_value) { ?>
										<option value="<?php echo $minute_array_value; ?>" <?php if ($minute_array_key == '00') {echo 'selected';} ?>><?php echo $minute_array_key; ?></option>
<?php } ?>
									</select>
									<select class="select-block mbl" name="large" id="flat-ui-event-time-end-mm" onchange="update_form_select(3, 4)">
										<option value="00" disabled selected>分</option>
<?php foreach ($minute_array as $minute_array_key => $minute_array_value) { ?>
										<option value="<?php echo $minute_array_key; ?>"><?php echo $minute_array_value; ?></option>
<?php } ?>
									</select>
								</div>
								<!-- ====== End Time ====== -->
							</div>

							<input type="hidden" name="event_start_time" value="<?php echo $showtime=date("Y-m-d H:i:s");?>" placeholder="start_time">
							<input type="hidden" name="event_end_time" value="<?php echo $showtime=date("Y-m-d H:i:s");?>" placeholder="end_time">
							<input type="hidden" name="test_time" value="<?php echo $showtime=date("Y-m-d H:i:s");?>" placeholder="test">

							<!-- <div class="event-time">
								<input type="text" name="event_start_time" id="datetimepicker-start" class="event-time-start create-event-input" placeholder="活动开始时间" required/>
								<div class="add-end-time-wrap">
									<a href="javascript:" id="add-end-time">添加结束时间</a>
								</div>
								<input type="text" name="event_end_time" id="datetimepicker-end" class="event-time-end create-event-input" placeholder="活动结束时间" />
								<div class="cancel-end-time-wrap">
									<a href="javascript:" id="cancel-end-time">取消添加结束时间</a>
								</div>	
							</div> -->

							<div class="event-location">
								<p>添加地点:</p>
								<input type="text" name="event_location_locale" class="form-control input-sm type-input" placeholder="活动地点, example: My Home" required/>
								<input type="text" name="event_location_street" class="event_location_street form-control input-sm" id="event_location_street" placeholder="门牌号,街道名..." required/></br>
								<input type="text" name="event_location_city" class="event_location_city form-control input-sm" id="event_location_city" placeholder="city..." required/>
								<input type="hidden" name="event_location_state" class="form-control input-sm" id="event-location-state" value="NY" required/>
								<div class="event_location_state">
									<!-- <select class="event_location_state" style="display:none;" id="event-location-state">
										<option value="New York" disabled selected>State</option>
<?php $states = state_city_list::getStatesList(); ?>
<?php foreach ($states as $state_id => $state_name) { ?>
										<option value="<?php echo $state_id; ?>" <?php if ( $state_id == 'NY' ) {echo "selected";} ?>><?php echo $state_name; ?></option>
<?php } ?>
									</select> -->
									<select class="select-block mbl" name="small" id="flat-ui-event-location-state" onchange="update_form_select(4, 0)">
										<option value="New York" disabled selected>State...</option>
<?php $states = state_city_list::getStatesList(); ?>
<?php foreach ($states as $state_id => $state_name) { ?>
										<option value="<?php echo $state_id; ?>"><?php echo $state_name; ?></option>
<?php } ?>
									</select>
								</div>
							</div>

							<div class="event_tag">
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
							<!-- <input type="text" name="event_title" class="form-control input-sm type-input event_title create-event-input" placeholder="活动名称" required/> -->
							<input type="number" name="event_size" class="form-control input-sm event-input-margin event-size" placeholder="人数规模" min="1" max="2000" required/>
							<input type="text" name="event_price" class="form-control input-sm event-input-margin event-price" placeholder="活动收费"/>
							
							<!-- <input name="event_price" type="checkbox" checked data-toggle="switch" /> -->

							<div class="div-event-create-option">						
								<input type="hidden" name="create_option" value="self" class="select-input-substitute">
								<select class="select-block mbl" name="small" id="flat-ui-event-option" onchange="update_form_select(1, 0)">
									<option value="self" disabled selected>创建活动身份</option>
<?php foreach ($create_event_option as $create_id => $create_name) { ?>
<?php if ($create_id == 'self') { ?>
									<option value="<?php echo $create_id; ?>"><?php echo $create_name; ?></option>
<?php } else { ?>
<?php foreach ($create_name as $group_name) { ?>
									<option value="<?php echo $group_name['gid']; ?>"><?php echo $group_name['title']; ?></option>
<?php } } } ?>
								</select>
							</div>

							<div class="add-event-btn">
                                <a href="javascript: " onclick="create_event_btn()">
                                    <div class="tagsinput-add"> 创建活动 </div>
                                </a>
                            </div>
                            <input type="hidden" name="pid_hidden" value="<?php echo $auth['uid']; ?>">
							<input type="submit" style="display:none;" name="event_submit" id="event-create-submit" value="创建活动" />
						</form>
					</article>
				</section>
			</div>
