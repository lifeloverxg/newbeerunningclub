			<div class="g-cell g-cell-1-1 g-cell-md-7-12 l-block-2 l-align-center-sm">
				<span class="text-heading-epic main-heading" data-automation="event-name-display">
					创建活动
				</span>
				<span id="event-status-badge" class="badge badge-alert">draft</span>
				<!-- <div class="text-body-medium text-body--faint l-block-1">
					Monday, October 13, 2014 from 7:00 PM to 10:00 PM (PDT)
				</div> -->
			</div>
			<section class="section-create" id="create-event">
				<!-- <header>
					<h5>创建活动</h5>
				</header> -->
				<article class="create-form create-event-form">
					<form id="eventForm" name="eventForm" method="post" action="<?php echo $home . "cgi/formActions/uni_form_common.php"; ?>" enctype="multipart/form-data" onSubmit="return event_create_check(this)">										
						<div id="event_details_header" class="g-group">
							<div class="l-block-3">
								<div class="g-cell">
									<div class="l-media-v-center">
										<div class="l-media-v-center__row">
											<span class="ico-box ico--small ico--color-teal ico--color-brand-white">1</span>
											<span class="text-heading-primary l-padded-h-1">
												基本信息
											</span>
										</div>
									</div>
								</div>
								<div class="g-cell l-align-right header-tip">
									<span class="tip">
										<a href="#event_details_tips" class="js-d-modal">
											Tips
										</a>
									</span>
								</div>
							</div>
						</div>
						<hr>

						<div class="margin-bottom">
						</div>

						<div id="event_details_title">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									活动名称
									<span class="required">*</span>
								</label>
							</div>
							<div class="g-cell">
								<input type="text" name="event_title" class="form-control input-sm type-input event_title create-event-input" placeholder="好的活动名称可以帮助您吸引更多用户..."/>
								<div class="inputtext errors">
									<div class="event-create-errors">
										<ul class="errorlist" id="ul-errorlist-1"></ul>
									</div>
								</div>
							</div>
						</div>

						<div id="event_details_location" class="margin-top event-details-float">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									活动地点
									<span class="required">*</span>
								</label>
							</div>
							<div class="g-cell">
								<div class="event-location">
									<!-- <p>添加地点:</p> -->
									<input type="text" name="event_location_locale" class="form-control input-sm type-input" placeholder="活动地点, example: My Home"/>
									<input type="text" name="event_location_street" class="event_location_street form-control input-sm" id="event_location_street" placeholder="门牌号,街道名..."/></br>
									<input type="text" name="event_location_city" class="event_location_city form-control input-sm" id="event_location_city" placeholder="city..."/>
									<input type="hidden" name="event_location_state" class="form-control input-sm" id="event-location-state" value="NY"/>
									<div class="event_location_state">
										<select class="select-block mbl" name="small" id="flat-ui-event-location-state" onchange="update_form_select(4, 0)">
											<option value="New York" disabled selected>New York</option>
<?php $states = state_city_list::getStatesList(); ?>
<?php foreach ($states as $state_id => $state_name) { ?>
											<option value="<?php echo $state_id; ?>"><?php echo $state_name; ?></option>
<?php } ?>
										</select>
									</div>
								</div>
								<div class="inputtext errors">
									<div class="event-create-errors">
										<ul class="errorlist" id="ul-errorlist-2"></ul>
									</div>
								</div>
							</div>
						</div>

						<div id="event_details_time" class="margin-top event-details-float">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									活动时间
									<span class="required">*</span>
								</label>
							</div>
							<div class="g-cell">
								<div class="event-time">
									<!-- ++++++ Start Time ++++++ -->
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn" type="button"><span class="fui-calendar"></span></button>
										</span>
										<input type="text" class="event-time-date form-control" placeholder="开始日期" id="datepicker-01" onchange="update_form_select(3, 10)">
									</div>
									<input type="hidden" id="event-time-start-hh" class="event_time_start_hh" value="00">
									<div class="input-time input-time-hh input-time-start-hh">
										<select class="select-block mbl" name="large" id="flat-ui-event-time-start-hh" onchange="update_form_select(3, 1)">
											<option value="00" disabled selected>时</option>
<?php foreach ($hour_array as $hour_array_key => $hour_array_value) { ?>

											<option value="<?php echo $hour_array_key; ?>"><?php echo $hour_array_value; ?></option>
<?php } ?>
										</select>
									</div>
									<div class="input-time input-time-mm input-time-start-mm">
										<input type="hidden" id="event-time-start-mm" class="event_time_start_mm" value="00">
										<select class="select-block mbl" name="large" id="flat-ui-event-time-start-mm" onchange="update_form_select(3, 2)">
											<option value="00" disabled selected>分</option>
<?php foreach ($minute_array as $minute_array_key => $minute_array_value) { ?>
											<option value="<?php echo $minute_array_key; ?>"><?php echo $minute_array_value; ?></option>
<?php } ?>
										</select>
									</div>
									<!-- ====== Start Time ====== -->
									<!-- ++++++ End Time ++++++ -->
									<div class="input-group">
										<span class="input-group-btn">
											<button class="btn" type="button"><span class="fui-calendar"></span></button>
										</span>
										<!-- <input type="text" class="form-control" value="<?php echo $showtime=date("d M,Y");?>" id="datepicker-02"> -->
										<input type="text" name="event_end_time_date" class="event-time-date form-control" placeholder="结束日期" id="datepicker-02" onchange="update_form_select(3, 11)">
									</div>
									<div class="input-time input-time-hh input-time-end-hh">
										<input type="hidden" class="event_time_end_hh" id="event-time-end-hh" value="00">
										<select class="select-block mbl" name="large" id="flat-ui-event-time-end-hh" onchange="update_form_select(3, 3)">
											<option value="00" disabled selected>时</option>
<?php foreach ($hour_array as $hour_array_key => $hour_array_value) { ?>
											<option value="<?php echo $hour_array_key; ?>"><?php echo $hour_array_value; ?></option>
<?php } ?>
										</select>
									</div>
									<div class="input-time input-time-mm input-time-end-mm">
										<input type="hidden" class="event_time_end_mm" id="event-time-end-mm" value="00">
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

								<div class="inputtext errors">
									<div class="event-create-errors">
										<ul class="errorlist" id="ul-errorlist-3"></ul>
									</div>
								</div>
							</div>
						</div>

						<div id="go-set-sale-href-id-1"></div>

						<div id="event_details_logo" class="margin-top event-details-float">
							<div class="g-cell">
								<label class="responsive-form__label--primary" for="id_group-details-name">
									活动海报
									<span class="required">*</span>
								</label>
							</div>
							<div class="g-cell">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="div-fui-fileinput">
										<div id="fui-fileinput-imageUpload" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 180px; height: 120px; max-height: 120px; border: 4px dashed #dedede;">
											<img src="<?php echo $home."theme/images/default_upload_logo.jpg"; ?>" style="width: 150px; height: 100px;"/>
											<!-- <img data-src="holder.js/240x160" alt="..."> -->
										</div>
									</div>
									<div class="fui-fileinput-btns-upload" id="select-image-fileinput">
										<span class="btn btn-primary btn-embossed btn-file">	
											<span class="fileinput-new"><span class="fui-image"></span>&nbsp;&nbsp;Select image</span>
											
											<span class="fileinput-exists"><span class="fui-gear"></span>&nbsp;&nbsp;Change</span>
											
											<input type="file" name="file" id="logo-file-id"/>
											<input type="hidden" id="fui-fileinput-imageUpload-home" value="<?php echo $home; ?>"/>
											<input type="hidden" id="fui-fileinput-imageUpload-iscreate" value="<?php echo 1; ?>"/>
											<!-- <input type="hidden" name="hidden_eid" value="<?php echo $eid; ?>"/> -->
										</span>
										<a href="#" class="btn btn-primary btn-embossed fileinput-exists" data-dismiss="fileinput">
											<span class="fui-trash"></span>&nbsp;&nbsp;Remove
										</a>
									</div>
								</div>


								<div class="inputtext errors">
									<div class="event-create-errors">
										<ul class="errorlist" id="ul-errorlist-4"></ul>
									</div>
								</div>
							</div>
						</div>

						<div id="event_details_description" class="margin-top event-details-float">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									活动描述
									<span class="required">*</span>
								</label>
							</div>
							<div class="g-cell">
								<textarea name="event_description" class="event_description form-control" placeholder="活动描述" title="活动描述..." value="活动描述..."></textarea>
								<div class="inputtext errors">
									<div class="event-create-errors">
										<ul class="errorlist" id="ul-errorlist-5"></ul>
									</div>
								</div>
							</div>
						</div>

						<div id="event_details_header" class="g-group margin-top">
							<div class="l-block-3">
								<div class="g-cell">
									<div class="l-media-v-center">
										<div class="l-media-v-center__row">
											<span class="ico-box ico--small ico--color-teal ico--color-brand-white">2</span>
											<span class="text-heading-primary l-padded-h-1">
												售票信息
											</span>
										</div>
									</div>
								</div>
								<div class="g-cell l-align-right header-tip">
									<span class="tip">
										<a href="#event_details_tips" class="js-d-modal">
											Tips
										</a>
									</span>
								</div>
							</div>
						</div>
						<hr>

						<div id="go-set-sale-href-id-2"></div>

						<div class="margin-bottom"></div>

						<div class="uni-salenot">
							<div class="g-cell g-cell-v3">
								<label class="responsive-form__label--primary">
									<span class="uni-hint-r">请选择您的活动是否需要售票</span>
									<span class="required">*</span>
								</label>
							</div>
							<div class="g-cell">
								<input type="checkbox" name="uni_sale_checknot" id="uni-sale-checknot" data-toggle="switch" onchange="uniSalechecknot()"/>
							</div>
						</div>

						<div id="event_details_sale" class="uni-switch-off">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									加入uni售票
									<span class="required">*</span>
								</label>
							</div>
							<div class="g-cell">
								<div class="event-details-sale-cover">
									<p class="text-body-large">What type of ticket would you like to start with?</p>
									<div class="event-details-sale-cover-adds">
										<a class="tagsInput-a" href="javascript:" id="sale-cover-adds-free" onclick="eventCreateSale(1, '<?php echo $home; ?>', <?php echo $auth['uid']; ?>)">
											<div class="tagsinput-add"> Free ticket </div>
										</a>
										<a class="tagsInput-a" href="javascript:" id="sale-cover-adds-paid" onclick="eventCreateSale(2, '<?php echo $home; ?>', <?php echo $auth['uid']; ?>)">
											<div class="tagsinput-add"> Paid ticket </div>
										</a>
									</div>
								</div>

								<article class="sale-form" id="sale-form-1" style="display: none;">
									<div class="ticket-table-head">
										<div class="ticket-table-sale-type ticket-table-head-indi">Ticket Type</div>
										<div class="ticket-table-sale-quantity ticket-table-head-indi">Quantity</div>
										<div class="ticket-table-sale-price ticket-table-head-indi">Price</div>
										<div class="ticket-table-sale-actions ticket-table-head-indi">Actions</div>
									</div> 
									<div class="ticket-table-detail"></div>  
									
									<div class="sale-ticket-foot">
										<div class="add-ticket-type">
											<!-- <a href="javascript: " onclick="addTicketType('<?php echo $home; ?>')">
												<div class="tagsinput-add"> Add Ticket Type </div>
											</a> -->
											<a class="tagsInput-a" href="javascript:" id="sale-cover-adds-free" onclick="addTicketType('<?php echo $home; ?>', 'free', <?php echo $auth['uid']; ?>)">
												<div class="tagsinput-add"> Free ticket </div>
											</a>
											<a class="tagsInput-a" href="javascript:" id="sale-cover-adds-paid" onclick="addTicketType('<?php echo $home; ?>', 'paid', <?php echo $auth['uid']; ?>)">
												<div class="tagsinput-add"> Paid ticket </div>
											</a>
										</div>
									</div>

									<!--++++++++++hidden values++++++++++-->
									<input type="hidden" class="form-control input-sm" name="ticket_type_nums" id="ticket-type-nums" value="0">
									<input type="hidden" name="unisaleid" id="unisaleid" value="<?php echo $eid; ?>">
									<input type="hidden" name="unisalepid" id="unisalepid" value="<?php echo $auth['uid']; ?>">
									<input type="hidden" name="unisalemode" id="unisalemode" value="create_new">
									<input type="hidden" name="unisalecount" id="unisalecount" value="0">
									<input type="hidden" name="uni_sale_checknot_hidden" id="uni-sale-checknot-hidden" value="0"/>
									<!--==========hidden values==========-->
									<!-- </form> -->
								</article>

								<div class="event-create-errors">
									<ul class="errorlist" id="ul-errorlist-6"></ul>
								</div>
							</div>
						</div>

						<div id="event_details_numbers" class="margin-top event-details-float uni-switch-on">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									活动人数
									<span class="required">*</span>
								</label>
							</div>
							<div class="g-cell g-cell-v2">
								<input type="number" name="event_size" class="form-control input-sm event-size" placeholder="人数规模" min="1" max="30000"/>
								<div class="inputtext errors">
									<div class="event-create-errors event-create-errors-l">
										<ul class="errorlist" id="ul-errorlist-9">
											<li class="errorlist-hint">
												若不售票, 请填写活动允许参与人数.
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div id="event_details_header" class="g-group margin-top">
							<div class="l-block-3">
								<div class="g-cell">
									<div class="l-media-v-center">
										<div class="l-media-v-center__row">
											<span class="ico-box ico--small ico--color-teal ico--color-brand-white">3</span>
											<span class="text-heading-primary l-padded-h-1">
												其他设置
											</span>
										</div>
									</div>
								</div>
								<div class="g-cell l-align-right header-tip">
									<span class="tip">
										<a href="#event_details_tips" class="js-d-modal">
											Tips
										</a>
									</span>
								</div>
							</div>
						</div>
						<hr>

						<div class="margin-bottom"></div>

						<div id="event_details_category">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									活动类型
									<!-- <span class="required">*</span> -->
								</label>
							</div>
							<div class="g-cell">
								<div class="div-event-create-category">
									<input type="hidden" name="event_category" value="1" class="select-input-substitute">
									<select class="select-block mbl" name="small" id="flat-ui-event-category" onchange="update_form_select(2, 0)">
										<option value="全部" disabled selected>活动类型</option>
<?php foreach ($create_catalog_list as $catalog_id => $catalog_name) { ?>
										<option value="<?php echo $catalog_id; ?>"><?php echo $catalog_name; ?></option>
<?php } ?>
									</select>
								</div>

								<div class="inputtext errors">
									<div class="event-create-errors event-create-errors-l">
										<ul class="errorlist" id="ul-errorlist-7"></ul>
									</div>
								</div>
							</div>
						</div>

						<div id="event_details_option" class="margin-top" style="display: block; float: left;">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									创建活动身份
									<!-- <span class="required">*</span> -->
								</label>
							</div>
							<div class="g-cell g-cell-v2">
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

								<div class="inputtext errors">
									<div class="event-create-errors event-create-errors-l">
										<ul class="errorlist" id="ul-errorlist-8"></ul>
									</div>
								</div>
							</div>
						</div>

						<div id="event_details_tag" class="margin-top event-details-float">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									活动标签
									<!-- <span class="required">*</span> -->
								</label>
							</div>
							<div class="g-cell">			
								<div class="event_tag">
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

								<div class="inputtext errors">
									<div class="event-create-errors event-create-errors-l">
										<ul class="errorlist">
											<!-- <li class="errorlist-hint">
												请添加活动标签.
											</li> -->
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="add-event-btn">
                            <a href="javascript: " onclick="create_event_btn()">
                                <div class="tagsinput-add"> 创建活动 </div>
                            </a>
                        </div>
						<input type="submit" style="display:none;" name="event_submit" id="event-create-submit" value="创建活动" />
					</form>
				</article>
			</section>

			<!-- hidden anchor -->
				<a href="#go-set-sale-href-id-1" id="trigger-go-set-sale-href-id-1" class="uni-switch-off"></a>
				<a href="#go-set-sale-href-id-2" id="trigger-go-set-sale-href-id-2" class="uni-switch-off"></a>
			<!-- hidden anchor -->
