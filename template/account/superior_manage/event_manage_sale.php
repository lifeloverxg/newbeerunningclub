    <section class="manage-sale" id="manage-sale-alex">
        <header>
            <h5>修改活动信息-Alex专用</h5>
        </header>

            <article class="edit-event-form">
                <ul class="nav nav-tabs ul-button-list-small-large-button">
<?php foreach ($manage_tabs as $tab_id => $tabs) { ?>
                    <li <?php if ($tab_id == 0) { echo "class='active'"; }?>>
                        <a href="#tab<?php echo ($tab_id+1); ?>">
                            <p><?php echo $tabs; ?></p>
                        </a>
                    </li>
<?php } ?>                  
                </ul>
            </article>

            <div class="tab-content">
<?php if ( $isPaypal ) { ?>
                <div class="tab-pane active" id="tab1">
                    <article class="sale-form sale-form-on" id="modify-sale-form">
                        <form class="saleForm" name="modifySaleForm" action="<?php echo $home . "cgi/formActions/uni_sale.php"; ?>" method="post" enctype="multipart/form-data" onSubmit="return chk_ModifysaleForm(this)">              
                            <div id="TicketReg" class="panel_body">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ticket_table" id="ticket_table">
                                    <tbody>
                                        <tr class="ticket_table_head">
                                            <td width="35%" nowrap="nowrap">Ticket Type</td>
                                            <!-- <td>Sales End</td> -->
                                            <td width="10%" nowrap="nowrap">Price</td>
                                            <!-- <td>Tax</td> -->
                                            <td width="10%" nowrap="nowrap">Quantity</td>
                                            <td width="10%" nowrap="nowrap">Remain</td>
                                            <td width="10%" nowrap="nowrap">Tlimit</td>
                                            <td width="25%" nowrap="nowrap">Description</td>
                                            <td width="5%" nowrap="nowrap"><img src="<?php echo $home . "theme/images/remove_2.png"; ?>"/></td>
                                        </tr>   

                                        <div class="ticket_info_detail">
<?php foreach ($ticket_all as $ticket_id => $ticket_row) { ?>
                                            <tr class="ticket_row" id="tic_info_row_<?php echo ($ticket_id+1); ?>">
                                                <td class="ticket_type_name">
                                                    <input type="text" class="form-control input-sm type-input" name="type_<?php echo ($ticket_id+1); ?>" id="type-<?php echo ($ticket_id+1); ?>" placeholder="Example: Early Bird..." value="<?php echo $ticket_row['type']; ?>">
                                                </td>
                                                
                                                <td nowrap="nowrap" class="price_td">
                                                    <input type="text" class="form-control input-sm" name="price_<?php echo ($ticket_id+1); ?>" id="price-<?php echo ($ticket_id+1); ?>" placeholder="No '$'" value="<?php echo $ticket_row['price']; ?>">
                                                </td>
                                                
                                                <td width="15%" nowrap="nowrap">
                                                    <!-- <input type="number" class="form-control input-sm" min="1" name="volume_<?php echo ($ticket_id+1); ?>" id="quantity-<?php echo ($ticket_id+1); ?>" placeholder="票的数量" value="<?php echo $ticket_row['volume']; ?>"> -->
                                                    <span class="ui-spinner ui-widget ui-widget-content ui-corner-all">
                                                        <input type="text" name="volume_<?php echo ($ticket_id+1); ?>" id="spinner-01" placeholder="" value="<?php echo ($ticket_row['volume']); ?>" class="form-control spinner ui-spinner-input volume-input" aria-valuemin="0" aria-valuemax="99" aria-valuenow="<?php echo $ticket_row['volume']; ?>" autocomplete="off" role="spinbutton">
                                                    </span>
                                                </td>

                                                <td width="15%" nowrap="nowrap">
                                                    <input type="number" class="form-control input-sm" name="remain_<?php echo ($ticket_id+1); ?>" id="remain-<?php echo ($ticket_id+1); ?>" value="<?php echo $ticket_row['remain']; ?>">
                                                </td>

                                                <td width="15%" nowrap="nowrap">
                                                    <input type="number" min="0" class="form-control input-sm" name="tlimit_<?php echo ($ticket_id+1); ?>" id="tlimit-<?php echo ($ticket_id+1); ?>" placeholder="limit..." value="<?php echo $ticket_row['tlimit']; ?>">
                                                </td>

                                                <td width="15%" nowrap="nowrap">
                                                    <input type="text" class="form-control input-sm" name="description_<?php echo ($ticket_id+1); ?>" id="description-<?php echo ($ticket_id+1); ?>" placeholder="description..." value="<?php echo $ticket_row['description']; ?>">
                                                    <!-- <textarea name="alex_description_1" class="alex_description_1" id="alex-ticket-description" placeholder="票的描述" title="票的描述..." value="票的描述..."></textarea> -->
                                                </td>
                                                <td width="5%" nowrap="nowrap">
                                                    <a href="javascript: " onclick="delTicketType(<?php echo ($ticket_id+1); ?>, 1)">
                                                        <img src="<?php echo $home . "theme/images/remove_1.png"; ?>"/>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- +++ticket_id; hidden; for delete use and update use+++ -->
                                            <input type="hidden" class="form-control input-sm" name="ticket_id_<?php echo ($ticket_id+1); ?>" id="ticket-id-<?php echo ($ticket_id+1); ?>" value="<?php echo $ticket_row['id']; ?>">
                                            <!-- ===ticket_id; hidden; for delete use=== -->
<?php } ?>
                                        </div>
                                            <tr class="ticket_row">
                                                <td colspan="6">
                                                    <div class="add-ticket-type">
                                                        <a href="javascript: " onclick="addTicketType('<?php echo $home; ?>')">
                                                            <div class="tagsinput-add"> Add Ticket Type </div>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="ticket_foot">
                                                <td colspan="6">
                                                    <!-- <input type="submit" name="uni_sale_submit" value="确定"> -->
                                                    <input type="submit" class="form-control input-sm" name="uni_sale_modify_submit" value="保存修改">
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--++++++++++hidden values++++++++++-->
                            <input type="hidden" class="form-control input-sm" name="ticket_type_nums" id="ticket-type-nums" value="<?php echo sizeof($ticket_all); ?>">
                            <input type="hidden" name="unisaleid" id="unisaleid" value="<?php echo $eid; ?>">
                            <input type="hidden" name="unisalepid" id="unisalepid" value="<?php echo $auth['uid']; ?>">
                            <input type="hidden" name="unisalemode" id="unisalemode" value="modify">
                            <input type="hidden" name="unisalecount" id="unisalecount" value="<?php echo sizeof($ticket_all); ?>">
                            <!--==========hidden values==========-->
                      </form>
                    </article>
                </div>
<?php } else { ?>
                <div class="tab-pane active" id="tab1">
                    <article class="sale-form sale-form-on" id="sale-form-1">
                        <form class="saleForm" name="setSaleForm" action="<?php echo $home . "cgi/formActions/uni_sale.php"; ?>" method="post" enctype="multipart/form-data" onSubmit="return chk_saleForm(this)">              
                            <div id="TicketReg" class="panel_body">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ticket_table" id="ticket_table">
                                    <tbody>
                                        <tr class="ticket_table_head">
                                            <td width="35%" nowrap="nowrap">Ticket Type</td>
                                            <!-- <td>Sales End</td> -->
                                            <td width="10%" nowrap="nowrap">Price</td>
                                            <!-- <td>Tax</td> -->
                                            <td width="10%" nowrap="nowrap">Quantity</td>
                                            <td width="10%" nowrap="nowrap">Tlimit</td>
                                            <td width="25%" nowrap="nowrap">Description</td>
                                            <td width="5%" nowrap="nowrap"><img src="<?php echo $home . "theme/images/remove_2.png"; ?>"/></td>
                                        </tr>   

                                        <div class="ticket_info_detail">
                                            <tr class="ticket_row" id="tic_info_row_1">
                                                <td class="ticket_type_name">
                                                    <input type="text" class="form-control input-sm type-input" name="type_1" id="type-1" placeholder="Example: Early Bird..." value="">
                                                </td>
                                                
                                                <td nowrap="nowrap" class="price_td">
                                                    <input type="text" class="form-control input-sm" name="price_1" id="price-1" placeholder="No '$'" value="">
                                                </td>
                                                
                                                <td width="15%" nowrap="nowrap">
                                                    <!-- <input type="number" class="form-control input-sm" min="1" name="volume_1" id="quantity-1" placeholder="票的数量" value=""> -->
                                                    <span class="ui-spinner ui-widget ui-widget-content ui-corner-all">
                                                        <input type="text" name="volume_1" id="spinner-01" placeholder="" value="0" class="form-control spinner ui-spinner-input volume-input" aria-valuemin="0" aria-valuemax="99" aria-valuenow="0" autocomplete="off" role="spinbutton">
                                                    </span>
                                                    <input type="hidden" name="remain_1" id="remain-1" value="">
                                                </td>

                                                <td width="15%" nowrap="nowrap">
                                                    <input type="number" min="0" class="form-control input-sm" name="tlimit_1" id="tlimit-1" placeholder="limit..." value="">
                                                </td>

                                                <td width="15%" nowrap="nowrap">
                                                    <input type="text" class="form-control input-sm" name="description_1" id="description-1" placeholder="description..." value="">
                                                    <!-- <textarea name="alex_description_1" class="alex_description_1" id="alex-ticket-description" placeholder="票的描述" title="票的描述..." value="票的描述..."></textarea> -->
                                                </td>
                                                <td width="5%" nowrap="nowrap">
                                                    <a href="javascript: " onclick="delTicketType(1, 0)">
                                                        <img src="<?php echo $home . "theme/images/remove_1.png"; ?>"/>
                                                    </a>
                                                </td>
                                            </tr>
                                        </div>
                                        <tr class="ticket_row">
                                            <td colspan="6">
                                                <div class="add-ticket-type">
                                                    <a href="javascript: " onclick="addTicketType('<?php echo $home; ?>')">
                                                        <div class="tagsinput-add"> Add Ticket Type </div>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="ticket_foot">
                                            <td colspan="6">
                                                <!-- <input type="submit" name="uni_sale_submit" value="确定"> -->
                                                <input type="submit" class="form-control input-sm" name="uni_sale_submit" value="售票">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--++++++++++hidden values++++++++++-->
                            <input type="hidden" class="form-control input-sm" name="ticket_type_nums" id="ticket-type-nums" value="1">
                            <input type="hidden" name="unisaleid" id="unisaleid" value="<?php echo $eid; ?>">
                            <input type="hidden" name="unisalepid" id="unisalepid" value="<?php echo $auth['uid']; ?>">
                            <input type="hidden" name="unisalemode" id="unisalemode" value="new">
                            <input type="hidden" name="unisalecount" id="unisalecount" value="1">
                            <!--==========hidden values==========-->
                      </form>
                    </article>
                </div>
<?php } ?>

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
                <div class="tab-pane" id="tab4">
                        <div class="div-manage-mail">
<?php if ( isset($mail_list) && !empty($mail_list) ) { ?>
                        <a class="fui-mail" href="<?php echo $file_mail_list; ?>" style="text-decoration:none;color:#1090ba;font-weight:normal" target="_self">
                            <img src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/images/icons/storage.svg"; ?>">
                            &nbsp;mail_list地址请点击我
                        </a></br></br>
<?php foreach ($mail_list as $mail_key => $mail_email) { ?>
<?php $mail_all .= "&bcc=".$mail_email['email']; ?>
<?php } ?>
                        <a class="fui-mail" href="<?php echo $mail_all; ?>" style="text-decoration:none;color:#1090ba;font-weight:normal" target="_self">&nbsp;发送给所有人</a></br></br>
                        <p>单独发送: </p>
<?php foreach ($mail_list as $mail_key => $mail_email) { ?>
                        <a class="fui-mail" href="mailto:<?php echo $mail_email['email']; ?>" style="text-decoration:none;color:#1090ba;font-weight:normal" target="_self">&nbsp;<?php echo $mail_email['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</a>
<?php } ?>
<?php } ?>
                    </div>
                </div>

                <!-- /tabs -->
                <div class="tab-pane" id="tab5">
                    <a class="fui-star-2" href="<?php echo $sale_info_download_list; ?>" style="text-decoration:none;color:#1090ba;font-weight:normal" target="_self">
                        &nbsp;所有购票成员信息请点击我
                    </a></br></br>
                    <span class="fui-star-2">Total Sale: <?php echo "$".$sale_info_list['total_sale']; ?></span>
                    <article class="buyer-form buyer-form-on" id="buyer-form">            
                        <div id="buyer-form-body" class="panel_body">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ticket_table" id="ticket_table">
                                <tbody>
                                    <tr class="ticket_table_head">
                                        <td width="5%" nowrap="nowrap">pid</td>
                                        <td width="10%" nowrap="nowrap">name</td>
                                        <td width="25%" nowrap="nowrap">ordeID</td>
                                        <td width="25%" nowrap="nowrap">product</td>
                                        <td width="25%" nowrap="nowrap">quantity</td>
                                        <td width="15%" nowrap="nowrap">Net</td>
                                        <td width="10%" nowrap="nowrap">email</td>
                                    </tr>   

                                    <div class="ticket_info_detail">
<?php if ( isset($sale_info_list) && !empty($sale_info_list) ) { ?>
<?php foreach ($sale_info_list['info'] as $sale_info_list_key => $sale_info_list_value) { ?>
                                        <tr class="ticket_row" id="tic_info_row_1">
                                            <td width="10%" nowrap="nowrap">
                                                <p><?php echo $sale_info_list_value['pid']; ?></p>
                                            </td>
                                            
                                            <td width="10%" nowrap="nowrap">
                                                <p><?php echo $sale_info_list_value['name']; ?></p>
                                            </td>
                                            
                                            <td width="10%" nowrap="nowrap">
                                                <p><?php echo $sale_info_list_value['id']; ?></p>
                                            </td>

                                            <td width="25%" nowrap="nowrap">
                                                <p><?php echo $sale_info_list_value['type']; ?></p>
                                            </td>
                                           
                                            <td width="25%" nowrap="nowrap">
                                                <p><?php echo $sale_info_list_value['quantity']; ?></p>
                                            </td>
                                            
                                            <td width="15%" nowrap="nowrap">
                                                <p><?php echo $sale_info_list_value['net']; ?></p>
                                            </td>

                                            <td width="10%" nowrap="nowrap">
                                                <!-- <p><?php echo $sale_info_list_value['email']; ?></p> -->
                                                <a class="fui-mail" href="mailto:<?php echo $sale_info_list_value['email']; ?>" style="text-decoration:none;color:#1090ba;font-weight:normal" target="_self"><?php echo $sale_info_list_value['email']; ?></a>
                                            </td>
                                        </tr>
<?php } ?>
<?php } ?>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </article>
                </div>
            </div> <!-- /End tab-content -->
	</section>
