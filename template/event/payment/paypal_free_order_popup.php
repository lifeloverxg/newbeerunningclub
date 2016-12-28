			<div class="div-popup-normal" id="<?php echo "show-free-order"; ?>">
				<section class="popup-normal" style="text-align: center;">
					<form id="paypalfreeorderForm" name="paypalfreeorderForm" method="post" action="<?php echo $home . "cgi/formActions/uni_sale.php"; ?>" enctype="multipart/form-data" onSubmit="return chk_paypal_free_order(this)">	
						<div class="modal-content">
			        		<div class="modal-header">
								<button type="button" onclick="hidePopup('#<?php echo "show-free-order"; ?>')" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title"><span style="color: red"><?php echo "Free RSVP"." - ".$info_list['title']; ?></span></h4>
							</div>
							<div class="modal-body">
								<p><?php echo "您的订单为Free Order, 点击确定后您会收到系统发到您的nycuni注册邮箱(".$auth['email'].")的邮件, 请确保您注册时使用的是有效邮箱"; ?></p>
								<p><span id="chkmsg" style="display:none;">正在提交中, 请稍等<img src='<?php echo $home . "theme/images/account/ellipsis.gif"; ?>'/></span></p>
							</div>
							<div class="modal-footer">
								<a href="javascript: " onclick="hidePopup('#<?php echo "show-free-order"; ?>')" class="btn btn-default btn-wide"><?php echo "取消"; ?></a>
								<a href="javascript: " onclick="free_order_btn()" class="btn btn-wide btn-primary"><?php echo "确定"; ?></a>
							</div>
			        	</div>
			        	<input type="hidden" name="user_email" value="<?php echo $auth['email']; ?>">
			        	<input type="hidden" name="ticket_allowance" id="paypal-free-order-allowance" value="<?php echo $ticket_list['allowance']; ?>">
			        	<input type="hidden" name="num_cart_items" id="free-order-num-cart-items" value="">
			        	<input type="hidden" name="items" id="free-order-items" value="">
			        	<input type="hidden" name="user_pid" value="<?php echo $auth['uid']; ?>">
			        	<input type="hidden" name="event_eid" value="<?php echo $eid; ?>">
			        	<input type="submit" style="display:none;" name="paypal_free_order_submit" id="paypal-free-order-submit" value="生成订单" />
			        </form>
        		</section>
    		</div>