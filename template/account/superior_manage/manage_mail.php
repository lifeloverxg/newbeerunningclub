    <section class="manage-sale" id="manage-sale-alex">
        <header>
            <h5>Super_manage-mail</h5>
        </header>

            <article class="edit-event-form">
                <ul class="nav nav-tabs ul-button-list-small-large-button">
<?php foreach ($manage_tabs as $tab_id => $tabs) { ?>
                    <li <?php if ($tab_id == 3) { echo "class='active'"; }?>>
                        <a href="#tab<?php echo ($tab_id+1); ?>">
                            <p><?php echo $tabs; ?></p>
                        </a>
                    </li>
<?php } ?>                  
                </ul>
            </article>

            <div class="tab-content">
            	<div class="tab-pane" id="tab1">
            	</div>

                <!-- /tabs -->
                <div class="tab-pane" id="tab2">
                    <article class="edit-event-form sale-form-on" id="sale-form-2">
                        <form class="modifyForm" name="modifyForm" method="post" action="" enctype="multipart/form-data" onSubmit="return chk_modify(this)">              
                            <p>活动名称: </p>
                            <input name="edit_title" type="text" class="modify_form_class" placeholder="活动名称" disabled=disabled value="<?php echo $info_list['title'];?>" maxlength="20"/>

                            <p>卖票地址: </p>
                            <input name="edit_eventbrite_sale_address" type="text" class="modify_form_class" placeholder="eventbrite的卖票地址" value="" maxlength="200"/>

                            <input type="button" name="manage_sale_submit" class="edit_button" onclick="event_oper(<?php echo $auth['uid']; ?>, <?php echo $eid; ?>, 'other_sale')" value="确定售票" />
                        </form>
                    </article>
                </div>

            <!-- /tabs -->
                <div class="tab-pane" id="tab3">
                    <a href="#fakelink" onclick="showPopup('#show-del-error')" class="btn btn-lg btn-block btn-danger"><?php echo '取消活动'; ?></a>
                </div>

            <!-- /tabs -->
                <div class="tab-pane active" id="tab4">
                    <div class="div-manage-mail">
<?php if ( isset($mail_list) && !empty($mail_list) ) { ?>
<?php foreach ($mail_list as $mail_key => $mail_email) { ?>
<?php $mail_all .= "&bcc=".$mail_email['email']; ?>
<?php } ?>
                    	<a class="fui-mail" href="<?php echo $mail_all; ?>" style="text-decoration:none;color:#1090ba;font-weight:normal" target="_self">&nbsp;发送给所有人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(共<?php echo sizeof($mail_list); ?>个有效邮箱)</a></br></br>
                    	<p>单独发送: </p>
<?php foreach ($mail_list as $mail_key => $mail_email) { ?>
                    	<a class="fui-mail" href="mailto:<?php echo $mail_email['email']; ?>" style="text-decoration:none;color:#1090ba;font-weight:normal" target="_self">&nbsp;<?php echo $mail_email['user']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</a>
<?php } ?>
<?php } ?>
                	</div>
            	</div>

                <!-- /tabs -->
                <div class="tab-pane" id="tab5">
                </div>
            </div> <!-- /End tab-content -->
	</section>
