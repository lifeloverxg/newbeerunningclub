			<header class="top">
				<div class="top-search-wrap">
					<div class="top-search-wrap-tabs">
						<div class="page-title">
							活动
						</div>
						<div class="search-tabs">
							<ul class="nav nav-tabs">
	<?php foreach ($search_tabs as $tab_id => $tabs) { ?>
		                    <li <?php if ($tab_id == 0) { echo "class='active'"; }?>>
		                        <a href="#tab<?php echo ($tab_id+1); ?>">
		                            <p><?php echo $tabs; ?></p>
		                        </a>
		                    </li>
		                    <div class="search-tab-border-right">
		                    </div>
	<?php } ?>                  
		                	</ul>
		                </div>
		            </div>
		            <div class="search-detail-dropdown-list">
						<div class="div-sddlist">
							<input type="hidden" name="search_event_time" value="0" class="select-input-substitute">
							<select class="select-block mbl" name="small" id="flat-ui-event-timeOption" onchange="update_form_select(5, 1)">
								<option value="全部" disabled selected>时间/all times</option>
<?php foreach ($search_event_time_tabs as $catalog_id => $catalog_name) { ?>
								<option value="<?php echo $catalog_id; ?>"><?php echo $catalog_name; ?></option>
<?php } ?>
							</select>
						</div>
						
						<div class="div-sddlist">
							<input type="hidden" name="search_event_category" value="0" class="select-input-substitute">
							<select class="select-block mbl" name="small" id="flat-ui-event-typeOption" onchange="update_form_select(5, 2)">
								<option value="全部" disabled selected>类型/all kinds</option>
<?php foreach ($create_catalog_list as $catalog_id => $catalog_name) { ?>
								<option value="<?php echo $catalog_id; ?>"><?php echo $catalog_name; ?></option>
<?php } ?>
							</select>
						</div>

						<div class="top-form-search">
							<!-- <div class="input-group input-group-lg"> -->
								<input class="form-control" id="appendedInputButton-02" type="search" placeholder="输入活动关键词...">
								<!-- <span class="input-group-btn">
									<button class="btn btn-default" type="button">
										<span class="fui-search">找活动</span>
									</button>
								</span>  -->
								<button class="top-search-button button-search" type="button" onclick="<?php echo $search['func']['search']; ?>">
									找活动<!-- <span class="fui-search"></span> -->
								</button>
							<!-- </div> -->
						</div>
		            </div>
				</div>
				

				<div class="top-create-btn shake shake-slow">
					<div class="span-create-btn">
						玩儿得不够high?<!-- <img src="<?php echo $home . "theme/images/event_create_span.png"; ?>"/> -->
					</div>
					<!-- <ul class="ul-button-list-large">
<?php foreach ($button_list_large as $button) { ?>
						<li>
							<button onclick="<?php echo $button['action']; ?>" class="create-btn"><?php echo $button['title']; ?></button>
						</li>
<?php } ?>
					</ul> -->
<?php
					if ( $auth['uid'] > 0 )
					{
?>
					<a href="<?php echo $home."event/create.php"; ?>">
						<button class="create-btn">创建活动</button>
					</a>
<?php
					}
					else
					{
?>
					<a href="javascript: show_login_panel()">
						<button class="create-btn">创建活动</button>
					</a>
<?php
					}
?>
				</div>
			</header>

			<!-- <div class="shake">Hello world</div>
			<div class="shake shake-hard">Hello world</div>
			<div class="shake shake-slow">Hello world</div>
			<div class="shake shake-little">Hello world</div>
			<div class="shake shake-horizontal">Hello world</div>
			<div class="shake shake.vertical">Hello world</div>
			<div class="shake shake-rotate">Hello world</div>
			<div class="shake shake-opacity">Hello world</div>
			<div class="shake shake-crazy">Hello world</div> -->
			
