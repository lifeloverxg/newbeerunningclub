		<section class="payment-gateway-paypal">
			<!-- <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" target= "_blank" method="post" style="margin: 0px;"> -->
			<form action="https://www.paypal.com/cgi-bin/webscr" onSubmit="return chk_ticketSale('<?php echo $home; ?>', '<?php echo $deviceType; ?>', <?php echo $ticket_list['allowance']; ?>)" target= "_blank" method="post" style="margin: 0px;">
				<input type="hidden" name="cmd" value="_cart">
				<input type="hidden" name="upload" value="1">
				<!-- <input type="hidden" name="business" value="testsale@nycuni.com"> -->
				<input type="hidden" name="business" value="event@nycuni.com">
				<input type="hidden" name="rm" value="2"/>
				<input type="hidden" name="redirect_cmd" value="_xclick"/>
				
				<div class="l-block-stack">
					<div class="panel_head2 l-block-3" id="ticketInfo">
						<!-- <h5><?php echo $info_list['title']; ?></br>Ticket Information</h5> -->
						<h5>Ticket Information</h5>
					</div>
				</div> 
				
				<div id="TicketReg" class="panel_body">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="ticket_table" id="ticket_table">
						<tbody>
							<tr class="ticket_table_head">
								<td width="35%" nowrap="nowrap">Ticket Type</td>
								<!-- <td>Sales End</td> -->
								<td>Price</td>
								<!-- <td>Tax</td> -->
								<td width="35%" nowrap="nowrap">Quantity</td>
							</tr>   


<?php foreach ($ticket_all as $ticket => $ticket_row) { ?>
<?php if ($ticket == 0) { ?>
<input type="hidden" name="ticket_0_type" id="ticket_0_type_id" value="<?php echo $ticket_row['type']; ?>">
<input type="hidden" name="ticket_0_price" id="ticket_0_price_id" value="<?php echo $ticket_row['price']; ?>">
<?php } ?>
							<tr class="ticket_row">
								<td class="ticket_type_name"><?php echo $ticket_row['type']; ?></td>
								
								<!-- <td nowrap="nowrap"><?php echo $ticket_row['end']; ?></td> --> 
								
								<td nowrap="nowrap" class="price_td">
									<input type="hidden" name="cost_26721449_None" id="price_<?php echo ($ticket+1); ?>" value="<?php echo $ticket_row['price']; ?>">
									<?php echo "$".$ticket_row['price']; ?>
								</td>
								
								<!-- <td nowrap="nowrap" class="fee_td"><?php echo $ticket_row['tax']; ?></td> -->
								
								<td width="35%" nowrap="nowrap">
<?php if ( $ticket_row['remain'] == 0 ) { ?>
									<p>Sold Out</p>
<?php } else { ?>
									<select class="select-block mbl" style="display: none;" name="num_<?php echo ($ticket+1); ?>" id="quantity_<?php echo ($ticket+1); ?>">
<?php for ( $i = 0; $i <= $ticket_row['tlimit']; $i++ ) { ?>
											<option value="<?php echo $i; ?>">
												<?php echo $i; ?>&nbsp;
											</option>
<?php } ?>
									</select>
									<select class="select-block mbl" name="small" id="flat-ui_quantity_<?php echo ($ticket+1); ?>" onchange="updateCheckout(<?php echo ($ticket+1); ?>, '<?php echo $ticket_row['type']; ?>', <?php echo $ticket_row['price']; ?>, <?php echo $ticket_list['allowance']; ?>)">
<?php for ( $i = 0; $i <= $ticket_row['tlimit']; $i++ ) { ?>
											<option value="<?php echo $i; ?>">
												<?php echo $i; ?>&nbsp;
											</option>
<?php } ?>
									</select>
<?php } ?>
								</td>
							</tr>
							<div class="paypal-ticket-info" id="paypal-ticket-info-id-<?php echo ($ticket+1); ?>">
							</div>
<?php } ?>
							<input type="hidden" name="nozero_flag_quantity" id="nozero-flag-quantity" value="-1">
							<input type="hidden" name="tax_cart" id="paypal-ticket-tax-all-id" value="0.99">
							<input type="hidden" name="ticket_count_all" id="ticket-count-all" value="<?php echo sizeof($ticket_all); ?>">
						</tbody>
					</table>
				</div><!-- end panel_body -->

<!-- ++++++++++++++++++++++++spec use only ++++++++++++++++++++++++-->
<?php if ( ($eid == 31) || ($eid == 73) ) { ?>
				<div id="TicketReg" class="panel_body" style="display: block; margin: 0px auto; text-align: center;">
					注: Table: Bottle Deal是在网站RSVP时交$100刀押金, On Site时补余款
				</div>
<?php } ?>
<?php if ( $eid == 84 ) { ?>
				<div id="TicketReg" class="panel_body" style="display: block; margin: 0px auto; text-align: center;">
					注: 买票后可作为通票, 可以选择任意一家rooftop</br>
					Hotel on Rivington: 107 Rivington Street: New York, New York 10002</br>
					或者 Gansevoort Park: Rooftop 420 Park Ave S,Manhattan, NY 10016
				</div>
<?php } ?>

				<div id="OrderReg" class="panel_footer" style="text-align: center;  padding: 10px; margin-top: 10px; width: 120%;">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="invoice" value="<?php $order_num = EventDAO::generate_order_num(); echo $order_num; ?>">
					<input type="hidden" name="custom" value="<?php echo $auth['uid']."nycuni".$eid."nycuni".$info_list['title']; ?>">
					<input type="hidden" name="cancel_return" value="<?php echo "http://nycuni.com/event/payment.php?eid=".$eid; ?>">    
					<!-- <input type="hidden" name="notify_url" value="<?php echo "http://nycuni.com:8541/ZUS_Chipotle/event/ipn.php"; ?>"> -->
					<input type="hidden" name="notify_url" value="<?php echo "http://nycuni.com/event/ipn.php"; ?>">
					<input type="hidden" name="lc" value="US">
					<input type="hidden" name="return" value="<?php echo "http://nycuni.com/event/detail.php?eid=".$eid."&ipn_finish=TRUE&ipn_pid=".$auth['uid']; ?>">
					<!-- <input type="hidden" name="return" value="<?php echo "http://nycuni.com/event/paypalConfirmation.php?eid=".$eid."&ipn_finish=TRUE&ipn_pid=".$auth['uid']; ?>"> -->
					<input type="image" src="<?php echo $home . "theme/images/credit-card-logos.jpg"; ?>" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" >
					<input type="submit" class="btn btn-lg btn-block btn-info" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" value="Process to Checkout">
				</div>		<!-- end paidButton -->
				<!-- end hide_order -->
				<div class="clearfloat">

				</div><!-- end panel_footer -->

			</form>
		</section>