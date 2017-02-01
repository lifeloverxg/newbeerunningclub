<?php if ( !empty($newrun) ) { ?>
	<div class="alert alert-error" style = "text-align: center;">
            <button type="button" class="close fui-cross" data-dismiss="alert"></button>
            	Your latest Run was <a href="" onclick = "">already uploaded</a>. You ran <?php echo number_format($newrun['distance'],2); ?> km; This is your Day <?php echo $curdays; ?><br>
          		<img src="<?php echo $home. $newrun['image']; ?>" style="width: 100%; height: auto;"/>
          </div>
<?php } ?>

			<article class="">
                <ul class="nav nav-tabs ul-button-list-small-large-button" style = "margin-bottom: 0px !important;">
<?php 
		$tab_acitve_id = 0;
		foreach ($manage_tabs as $tab_id => $tabs) { ?>
                    <li <?php if ($tab_id == $tab_active_id ) { echo "class='active'"; }?>>
                        <a href="#tab<?php echo ($tab_id+1); ?>" style = "margin-bottom: 0px !important;">
                            <p style = "margin: 0px;"><?php echo $tabs; ?></p>
                        </a>
                    </li>
<?php } ?>                  
                </ul>
            </article>

<div class="tab-content" style = "border: 0px !important; padding: 0px;">
	
	<div class="tab-pane <?php if ($tab_active_id == 0) { echo "active"; } ?>" id="tab1">
		<div class="demo-row">
			<div class="demo-title pbm">
				<!-- <div class="demo-panel-title">Just Go Running</div> -->
			</div>
			<div class="demo-content-wide ptl" style = "padding-top: 0px !important;">
				<div class="table-responsive">
					<table class="table table-striped">
						<tr>
							<th>Rank</th>
							<th>Name</th>
							<th>Days</th>
							<th>Distance(km)</th>
							<th>Finished</th>
						</tr>
<?php
			foreach ( $rundata as $key => $runvalue )
			{
		?>
						<tr>
							<td>
								<?php echo $key + 1; ?>
								<a href="<?php echo $home.$runvalue['ownerinfo']['url']; ?>">
									<img src="<?php echo $home.$runvalue['ownerinfo']['image']; ?>"/>
								</a>
							</td>
							<td>
								<a class= "link-runner-title" href="<?php echo $home.$runvalue['ownerinfo']['url']; ?>">
									<?php echo $runvalue['ownerinfo']['title']; ?>
								</a>
							</td>
							<td><?php echo $runvalue['days']; ?></td>
							<td><?php echo number_format($runvalue['distance'],2); ?></td>
<?php if ( $key == 0 ) { ?>
							<td>
								<img src="<?php echo $home."theme/Flat-UI-Pro-1.2.5/images/icons/medal.svg"; ?>" alt="medal" style = "height: 30px !important; line-height: 30px !important; vertical-align: middle;">
							</td>
<?php } else { ?>
							<td><span class="fui-<?php if ($runvalue['days'] >= 8) echo "check"; else echo "cross"; ?>-inverted text-primary"></span></td>
<?php } ?>
						</tr>
<?php } ?>
						<tr>
							<td>
							</td>
							<th>Total</th>
							<th><?php echo $runtotal['days']; ?> (runs)</th>
							<th><?php echo number_format($runtotal['distance'],2); ?> (km)</th>
							<td></td>
						</tr>
					</table>
				</div>          
			</div>
		</div>
	</div>
	<div class="tab-pane <?php if ($tab_active_id == 1) { echo "active"; }?>" id="tab2">
		<div class="demo-row">
			<div class="demo-title pbm">
				<!-- <div class="demo-panel-title">Just Go Running</div> -->
			</div>
			<div class="demo-content-wide ptl" style = "padding-top: 0px !important;">
				<div class="table-responsive">
					<table class="table table-striped">
						<tr>
							<th>Rank</th>
							<th>Name</th>
							<th>Distance(km)</th>
							<th>Days</th>
							<th>Finished</th>
						</tr>
		<?php
			foreach ( $rundata_dis as $key => $runvalue )
			{
		?>
						<tr>
							<td>
								<?php echo $key + 1; ?>
								<a href="<?php echo $home.$runvalue['ownerinfo']['url']; ?>">
									<img src="<?php echo $home.$runvalue['ownerinfo']['image']; ?>"/>
								</a>
							</td>
							<td>
								<a class= "link-runner-title" href="<?php echo $home.$runvalue['ownerinfo']['url']; ?>">
									<?php echo $runvalue['ownerinfo']['title']; ?>
								</a>
							</td>
							<td><?php echo number_format($runvalue['distance'],2); ?></td>
							<td><?php echo $runvalue['days']; ?></td>
<?php if ( $key == 0 ) { ?>
							<td>
								<img src="<?php echo $home."theme/Flat-UI-Pro-1.2.5/images/icons/medal.svg"; ?>" alt="medal" style = "height: 30px !important; line-height: 30px !important; vertical-align: middle;">
							</td>
<?php } else { ?>
							<td><span class="fui-<?php if ($runvalue['days'] >= 8) echo "check"; else echo "cross"; ?>-inverted text-primary"></span></td>
<?php } ?>
						</tr>
		<?php
			}
		?>
						<tr>
							<td>
							</td>
							<th>Total</th>
							<th><?php echo number_format($runtotal['distance'],2); ?> (km)</th>
							<th><?php echo $runtotal['days']; ?> (runs)</th>
							<td></td>
						</tr>
					</table>
				</div>          
			</div>
		</div>
	</div>

	<div class="tab-pane <?php if ($tab_active_id == 2) { echo "active"; }?>" id="tab3">
		<div class="g-cell g-cell-1-1 g-cell-md-7-12 l-block-2 l-align-center-sm">
				<!-- <span class="text-heading-epic main-heading" data-automation="event-name-display" style = "font-size: 10px;">
					Step by Step
				</span> -->
<?php 
				if ( $auth['uid'] <= 0 ) {
?>
				<a href="#fakelink" onclick = "show_login_panel()" class="btn btn-hg btn-primary btn-block">点我登录后才能打卡<span class="fui-arrow-right pull-right"></span></a>
<?php } ?>
				<!-- <div class="text-body-medium text-body--faint l-block-1">
					Monday, October 13, 2014 from 7:00 PM to 10:00 PM (PDT)
				</div> -->
			</div>
			<section class="section-create" id="create-event">
				<article class="create-form create-event-form">
					<form id="runcardform" name="runcardform" method="post" action="<?php echo $home . "cgi/formActions/run_form_action.php"; ?>" enctype="multipart/form-data" onSubmit="return run_card_check(this)">										
						<!-- <div id="event_details_header" class="g-group">
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
						</div> -->
						<hr>

						<div class="margin-bottom">
						</div>

						<div id="run-card-title">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									奔跑距离<默认mile, 右侧修改unit>
									<span class="required">*</span>
								</label>
							</div>
							<div class="g-cell">
								<input type="text" name="card_distance" class="form-control input-sm type-input run-input" style="text-align:right;" placeholder="....."/>
							<div class="unit-wrapper">
								<div id = "unit-switch" class="switch has-switch">
										 <div id = "switch-unit-in" class="switch-off switch-animate">
										 <span class="switch-left">km</span>
										 <label for="card-unit">&nbsp;</label>
										 <span class="switch-right">mile</span>
										 </div>
									 </div>
								 </div>

								 <input type="hidden" name="cardunit" id="cardunit" value="0"/>

								 <script type = "text/javascript">
								  $("#unit-switch").click(function(){
									$("#switch-unit-in").removeAttr("style");
								    if ( $("#switch-unit-in").hasClass("switch-on") )
								    {
								      $("#switch-unit-in").removeClass("switch-on").addClass("switch-off");
								      $("#switch-unit-in").addClass("switch-animate");
								      $("input[name='cardunit']").val(0);
								    }
								    else
								    {
								       $("#switch-unit-in").removeClass("switch-off").addClass("switch-on");
								       $("#switch-unit-in").addClass("switch-animate");
								       $("input[name='cardunit']").val(1);
								    }
								    $("#switch-unit-in").removeAttr("style");
								  });
								  </script>
								<div class="carderror inputtext errors">
									<div class="event-create-errors">
										<ul class="errorlist" id="ul-errorlist-1"></ul>
									</div>
								</div>
							</div>
						</div>

						<div id="event_details_time" class="margin-top event-details-float">
							<div class="g-cell">
								<label class="responsive-form__label--primary">
									奔跑时间暂时在这里并不那么的重要
									<span class="required">*</span>
								</label>
							</div>
						</div>

						<div id="run-card-image" class="margin-top event-details-float">
							<div class="g-cell">
								<label class="responsive-form__label--primary" for="id_group-details-name">
									奔跑App截图/靓照
									<span class="required">*</span>
								</label>
							</div>
							<div class="g-cell">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="div-fui-fileinput">
										<div id="fui-fileinput-imageUpload" class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 160px; max-height: 150px; border: 4px dashed #dedede;">
											<img src="<?php echo $home."theme/images/default_upload_logo.jpg"; ?>" style="width: 160px; height: 150px;"/>
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
								<textarea name="runningcard_description" class="event_description form-control" placeholder="...晨跑打卡 day x..." title="活动描述..." value="..." style="font-size: 13px; padding: 6px 10px;"></textarea>
								<div class="inputtext errors">
									<div class="event-create-errors">
										<ul class="errorlist" id="ul-errorlist-5"></ul>
									</div>
								</div>
							</div>
						</div>

						<div class="add-event-btn">
                            <a href="javascript: " onclick="create_runningcard_btn()">
                                <div class="tagsinput-add"> 提交跑步 </div>
                            </a>
                        </div>
                        <!--++++++++++hidden values++++++++++-->
						<input type="hidden" name="nbrcpid" id="nbrcpid" value="<?php echo $auth['uid']; ?>">
						<input type="hidden" name="curMoreid" id="curMoreid" value="<?php echo $curMorningruneid; ?>">
						<!-- hidden anchor -->
							<a href="#go-set-sale-href-id-1" id="trigger-go-set-sale-href-id-1" class="uni-switch-off"></a>
							<a href="#go-set-sale-href-id-2" id="trigger-go-set-sale-href-id-2" class="uni-switch-off"></a>
						<!-- hidden anchor -->
						<!--==========hidden values==========-->
						<input type="submit" style="display:none;" name="runcard_submit" id="runcard-create-submit" value="创建活动" />
					</form>
				</article>
			</section>
	</div>
</div>