<?php
	ignore_user_abort(TRUE); //如果客户端断开连接，不会引起脚本abort.
	set_time_limit(0);//取消脚本执行延时上限
	$home = '../../';
	include_once ($home.'core.php');

	$auth = Authority::get_auth_arr();
	$links = $_SGLOBAL['links'];
$bm = new Timer();
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @free_order:ipn</h1>');
	}

		$args = array(
				  'user_email'	=>	'',
				  'user_pid'		=>	'',
				  'event_eid'		=>	'',
				  'ticket_allowance'	=>	'',
				  'num_cart_items'	=>	'',
				  'items'	=>	'',
				  );

		//Process data
		foreach ($args as $key => $val)
		{
			if ((isset($_GET[$key])) && ($_GET[$key] != "")) 
			{
				$args[$key] = $_GET[$key];
			}
		}

		$info_list = EventDAO::get_info_list($args['user_pid'], $args['event_eid']);
		$large_logo = EventDAO::get_event_logo($args['user_pid'], $args['event_eid']);
		$large_logo_url = $large_logo['image'];
		if ( !file_exists($home.$large_logo_url) )
		{
			$large_logo_url = "theme/images/logo_blue.jpg";
		}

		$transaction_id		=	EventDAO::generate_order_num();
		$num_cart_items		=	$args['num_cart_items'];
		$items_temp = $args['items'];

		$items_arr 		=	explode("uni_lg", $items_temp);
		$items_individual_type		=	"";
		$items_individual_quantity	=	"";

		$item_name_arr 		=	array();
		$quantity_arr		=	array();

	    foreach ($items_arr as $key => $value)
	    {
	    	if ( $key < $num_cart_items )
	    	{
	    		$items_individual_arr	=	explode("uni_sm", $value);
				$item_name	=	$items_individual_arr[0];
				array_push($item_name_arr, $item_name);

				$quantity =	$items_individual_arr[1];
				array_push($quantity_arr, $quantity);

				if ( $key < ($num_cart_items-1) )
				{
					$items .= $item_name.",".$quantity."|";
				}
				else
				{
					$items .= $item_name.",".$quantity;
				}
	    	}
	    }

	    $item_number		=	00000;
		$payment_status		=	"Completed";
		$payment_gross		=	0;
		$payment_fee		=	0;
		$payment_currency	=	"USD";
		$txn_id				=	$transaction_id;
		$receiver_email		=	"lifeloverxg@gmail.com";
		$payer_email		=	$args['user_email'];
		$custom				=	$args['user_pid']."nycuni".$args['event_eid']."nycuni".$info_list['title'];
		
		//payer information
		$address_city		=	"here";
		$address_country	=	"USA";
		$address_name		=	"GO";
		$address_street		=	"hereeere";
		$address_state		=	"NJ";
		$address_zip		=	"07089";
		$first_name			=	"";

		$person_info		=	PeopleDAO::get_people_basic_pid($args['user_pid']);
		$last_name			=	$person_info['title'];

		$buyer_info	= $first_name.",".$last_name."|".$address_country.",".$address_state.",".$address_street.",".$address_name;

		$pieces		=	explode("nycuni", $custom);
		$pid		=	$pieces[0];
		$eid		=	$pieces[1];
		$e_title	=	$pieces[2];
		$net		=	$payment_gross - $payment_fee;

		$order	=	array(
							'transaction_id'	=>		$txn_id,
							'pid'				=>		$pid,
							'eid'				=>		$eid,
							'payer_email'		=>		$payer_email,
							'items'				=>		$items,
							'net'				=>		$payment_gross,
							'payer_status'		=>		$payment_status,
							'buyer_info'		=>		$buyer_info,
							);

		$event_time	=	$info_list['活动时间'];
		$etime_arr	=	explode(" - ", $event_time);
		$start_time_x1	=	$etime_arr[0];
		$start_time_x2 =	strtotime($start_time_x1);
		$start_time	=	date('D, M d g:i a', $start_time_x2);
		$end_time_x1	=	$etime_arr[1];
		$end_time_x2 =	strtotime($end_time_x1);
		$end_time	=	date('D, M d g:i a', $end_time_x2);
		$event_street	=	$info_list['活动地址']['street'];
		$event_city		=	$info_list['活动地址']['city'];
		$event_state	=	$info_list['活动地址']['state'];

		$to = $payer_email;
		$to_self = "lifeloverxg@gmail.com";
		$to_self_1 = "jiangsuliufeng@gmail.com";
		// $to_self_1 = "yijunxiao88@gmail.com";
		$subject = "Your Order For ".$info_list['title'];
		$subject_self = "Order Notification For ".$info_list['title'];

		$body = '<html lang="utf-8">'
.'	<head>'
.'		<meta charset="utf-8" />'
.'   	<meta name="keywords" content="纽约有你, 在线社交活动网站, 纽约学生活动平台, 发布参加活动群组, nycuni, nyc, uni, social, socialplatform, event, group, club">'
.'   	<meta name="description" content="纽约有你，纽约年轻华人社交活动网站，发布/参加线下活动，创建/参与交流群组，发布/游览丰富富咨讯，享受NYC Uni与合作商家优惠，满足社交、资讯、娱乐和生活多方面需求。">'
.'      <title>支付 - NBRC - 纽约新蜂跑团</title>'
.'	</head>'
.'	<body>'
.'		<section>'
.'			<div style="background:#f7f7f7">'
.'				<div style="width:600px;margin:0 auto;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:12px;color:#666;line-height:1.4em">'
.'					<table border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;background:#f7f7f7;width:600px">'
.'			    		<tbody>'
.'			    			<tr>'
.'			        			<td width="70%" valign="middle" style="text-align:right;padding:20px 10px 10px 0">'
.'					            	<a href="http://nycuni.com" target="_blank">'
.'					                	<img src="http://nycuni.com/theme/images/logo_blue.png" width="78" height="72" border="0" alt="NYCuni" style="width:116px;min-height:35px">'
.'					            	</a>'
.'			        			</td>'
.'			        			<td width="66%" valign="middle" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;padding-top:12px;vertical-align:middle">'
.'			            			<span>'
.'										<a style="text-decoration:none;color:rgba(0, 118, 166, 0.75);font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;font-size:13px;font-weight:500;color:rgba(0, 118, 166, 1);text-decoration:none;padding-right:30px" href="http://nycuni.com" target="_blank">'
.'										    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NYCuni</br>'
.'										    纽约新蜂跑团</a>'
.'									</span>'
.'			       				</td>'
.'			    			</tr>'					    
.'						    <tr>'
.'						        <td colspan="2">'
.'						            <table border="0" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:10px;width:100%">'
.'						                <tbody>'
.'						                	<tr>'
.'							                    <td style="font-family:"Helvetica Neue",Helvetica,Arial,sans-serif">'
.'							                    </td>'
.'						                	</tr>'
.'						                	<tr>'
.'										        <td style="font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;padding:32px 40px;background-color:#fff;border-radius:0;border-radius:6px 6px 0 0">'
.'												<h2 style="color:#404040;font-size:23px;font-weight:500;line-height:1.25;margin:0 0 12px 0;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif">'
.'													Dear&nbsp'.$last_name.', this is your order confirmation for</br>'
.'													<a style="text-align: center; text-decoration:none;color:#1090ba;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;font-weight:normal" href="http://nycuni.com/event?eid='.$eid.'" target="_blank">&nbsp;'.$e_title.'</a>'
.'												</h2>'
.'												<p style="line-height:1.667;color:#999;margin:0;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;font-size:16px">' 
.'													<a href="http://nycuni.com" style="color:#999" target="_blank">NYCuni 纽约有你</a>'
.'												</p>'
.'												</td>'
.'											</tr>'
.'											<tr>'
.'											    <td style="padding:0 40px">'
.'													<table cellspacing="0" cellpadding="0" width="100%">'
.'														<tbody>'
.'															<tr>'
.'																<td style="background-color:#e1e1e1;width:100%;font-size:1px;height:1px;line-height:1px">&nbsp;'
.'																</td>'
.'															</tr>'
.'														</tbody>'
.'													</table>'
.'											    </td>'
.'											</tr>'
.'											<tr>'
.'												<td style="padding:0 40px">'
.'													<table cellspacing="0" cellpadding="0" width="100%">'
.'														<tbody>'
.'															<tr>'
.'																<td style="background-color:#e1e1e1;width:100%;font-size:1px;height:1px;line-height:1px">&nbsp;'
.'																</td>'
.'															</tr>'
.'														</tbody>'
.'													</table>'
.'												</td>'
.'											</tr>'
.'										    <tr>'
.'										        <td style="font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;padding:32px 40px;background-color:#fff;border-radius:0">' 
.'													<h2 style="color:#404040;font-size:23px;font-weight:500;line-height:1.25;margin:0 0 12px 0;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif">'
.'												        Questions about this event?'
.'												    </h2>'    
.'													<table width="100%" cellspacing="0" cellpadding="0">'
.'										    			<tbody>'
.'										    				<tr width="100%">'
.'										        				<td width="100%" style="font-size:13px">'
.'																	Contact the organizer at <a href="mailto:customer@nycuni.com" style="text-decoration:none;color:#1090ba;font-weight:normal" target="_blank">customer@nycuni.com</a>'
.'										        				</td>'
.'										    				</tr>'
.'														</tbody>'
.'													</table>'
.'										        </td>'
.'										    </tr>'
.'			    							<tr>'
.'			    								<td>'
.'			    									<img src="http://nycuni.com:8541/ZUS_Chipotle/theme/images/mail_saleborder.jpg" alt="NYCuni" height="7" style="min-height:7px;border:none;display:block" border="0">'
.'												</td>'
.'											</tr>'
.'											<tr>'
.'												<td style="font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;padding:32px 40px;background-color:#ededed">'
.'			        								<table cellpadding="0" cellspacing="0" border="0" style="width:100%;margin-bottom:12px">'
.'			            								<tbody>'
.'			            									<tr>'
.'												                <td style="border-bottom:1px dashed #d3d3d3">'
.'												                    <h2 style="color:#404040;font-size:23px;font-weight:500;line-height:1.25;margin:0 0 12px 0">Order Summary</h2>'
.'												                </td>'
.'												                <td colspan="2" style="text-align:right;font-weight:600;border-bottom:1px dashed #d3d3d3">'.date("M d Y").'</td>'
.'			            									</tr>'
.'			            									<tr>'
.'			                									<td colspan="3">'
.'												                    <p style="margin-bottom:18px">Order #: '.$txn_id.'</p>'
.'												                    <table cellpadding="0" cellspacing="0" border="0" style="width:100%">'
.'												                        <thead>'
.'												                            <tr>'
.'												                                <th style="border-bottom:1px dashed #d3d3d3;text-align:left;padding-bottom:12px;padding-right:12px">Name</th>'
.'												                                <th style="border-bottom:1px dashed #d3d3d3;text-align:left;padding-bottom:12px;padding-right:12px">Type</th>'
.'												                                <th style="border-bottom:1px dashed #d3d3d3;text-align:right;padding-bottom:12px;padding-right:0">Quantity</th>'
.'												                            </tr>'
.'												                        </thead>'
.'												                        <tbody>';

for ( $i = 1; $i <= $num_cart_items; $i++ ) {
$body .= '<tr>'
.'												                                <td style="padding:12px 0;padding-right:3px">'.$first_name.' '.$last_name.'</td>'            
.'												                                <td style="padding:12px 0;padding-right:3px">'.$item_name_arr[$i-1].'</td>'
.'												                                <td style="text-align:right;padding:12px 0">'.$quantity_arr[$i-1].'</td>'
.'												                            </tr>';
} 
$body .= '</tbody>'
.'												                    </table>'
.'												                </td>'
.'												            </tr>'
.'												        </tbody>'
.'												    </table>'
.'			    								</td>'
.'			    							</tr>'
.'										    <tr>'
.'										    	<td>'
.'												    <img src="http://nycuni.com:8541/ZUS_Chipotle/theme/images/mail_saleborder_2.jpg" alt="nycuni" height="7" style="min-height:7px;border:none;display:block" border="0">'
.'												</td>'
.'											</tr>'
.'										    <tr>'
.'										        <td style="font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;padding:32px 40px;background-color:#fff;border-radius:0;border-radius:0 0 6px 6px">'
.'													<table cellpadding="0" cellspacing="0" border="0" align="left" style="width:260px;line-height:1.67;font-size:13px">'
.'													    <tbody>'
.'													    	<tr>'
.'													        	<td>'
.'																	<h2 style="color:#404040;font-size:23px;font-weight:500;line-height:1.25;margin:0 0 12px 0;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif">'
.'																		活动信息</h2>'
.'																	<table cellspacing="0" cellpadding="0" width="100%" align="">'
.'																		<tbody>'
.'																			<tr>'    
.'																				<td width="20" height="" style="vertical-align:top;padding-right:10px" align="">'
.'																					<img src="http://nycuni.com/theme/Flat-UI-Pro-1.2.5/images/icons/clocks.svg" title="date" alt="date" style="width:20px;min-height:20px;vertical-align:-2px" border="0" width="20" height="20">'
.'																				</td>'
.'																				<td width="" height="" style="padding-bottom:10px" align="">'.$start_time.'&nbsp;&nbsp;-</br>'.$end_time.'</td>'
.'																			</tr>'	            
.'																			<tr>'
.'																				<td width="20" height="" style="vertical-align:top;padding-right:10px" align="">'
.'																					<img src="http://nycuni.com/theme/Flat-UI-Pro-1.2.5/images/icons/compas.svg" title="date" alt="date" style="width:20px;min-height:20px;vertical-align:-4px" border="0" width="20" height="20">'
.'																				</td>'
.'																				<td width="" height="" style="padding-bottom:10px" align="">'.$event_street.'<br>'.$event_city.'<br>'.$event_state.'</td>'
.'																			</tr>'
.'																		</tbody>'
.'																	</table>'
.'																</td>'
.'														    </tr>'
.'														</tbody>'
.'													</table>'
.'													<table cellpadding="0" cellspacing="0" border="0" align="right" style="width:240px;text-align:center;margin-top:16px">'
.'													    <tbody>'
.'													    	<tr>'
.'													        	<td>'
.'																	<a style="text-decoration:none;color:#1090ba;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif" href="http://maps.google.com/maps?q='.$event_street."+".$event_city."+".$event_state.'" target="_blank">'          
.'																		<img src="http://maps.googleapis.com/maps/api/staticmap?size=240x160&amp;sensor=true&amp;center='.$event_street.$event_city.$event_state.'&amp;markers=label%3AA%7C621+'.$event_street."+".$event_city."+".$event_state.'&amp;zoom=13" title="map" alt="map" style="width:240px;min-height:160px" border="0" width="240" height="160">'
.'																	</a>'
.'													        	</td>'
.'													    	</tr>'
.'														</tbody>'
.'													</table>'
.'												</td>'
.'											</tr>'
.'											<tr>'
.'											    <td style="padding:0 40px">'        
.'													<table cellspacing="0" cellpadding="0" width="100%">'
.'														<tbody>'
.'															<tr>'
.'																<td style="background-color:#e1e1e1;width:100%;font-size:1px;height:1px;line-height:1px">&nbsp;</td>'
.'															</tr>'
.'														</tbody>'
.'													</table>'
.'											    </td>'
.'											</tr>' 
.'			            				</tbody>'
.'			            			</table>'
.'			        			</td>'
.'			    			</tr>'
.'						</tbody>'
.'					</table>'		
.'					<table style="width:600px">'
.'					    <tbody>'
.'					    	<tr>'
.'					        	<td>'
.'									<table cellpadding="0" cellspacing="0" border="0" align="left" style="color:#999;line-height:1.3em;font-size:12px;font-family:Helvetica,Arial,sans-serif;margin-bottom:5px;width:47%">'
.'									    <tbody>'
.'									    	<tr>'
.'									        	<td>'
.'													<table style="width: 600px; margin:0 auto;border-top:1px solid #ccc;border-bottom:1px solid #ccc;padding-top:5px;padding-bottom:5px">'
.'									        			<tbody>'
.'									        				<tr>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://nycuni.com/about" style="text-decoration:none;color:#666" target="_blank">'
.'													                    about</a>'
.'													            </td>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://nycuni.com/contact" style="text-decoration:none;color:#666" target="_blank">'
.'													                    Contact</a>'
.'													            </td>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://nycuni.com/privacy" style="text-decoration:none;color:#666" target="_blank">'
.'													                    Privacy</a>'
.'													            </td>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://nycuni.com/terms" style="text-decoration:none;color:#666" target="_blank">'
.'													                    Terms</a>'
.'													            </td>'
.'													             <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase;background-image:none">'
.'													                <a href="http://nycuni.com/team" style="text-decoration:none;color:#666" target="_blank">'
.'													                    Team</a>'
.'													            </td>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://www.facebook.com/nycuni" style="display:inline" target="_blank">'
.'													                    <img src="http://nycuni.com/theme/images/facebook_share_samll.png" alt="Facebook" title="Facebook" border="0" style="padding-top:2px">'
.'													                </a>'
.'													            </td>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://weibo.com/u/5065310473" style="display:inline" target="_blank">'
.'													                    <img src="http://nycuni.com/theme/images/sina.png" alt="Sina" title="Sina" border="0" style="padding-top:2px">'
.'													                </a>'
.'													            </td>'
.'									        				</tr>'	
.'									    				</tbody>'
.'									    			</table>'
.'									        	</td>'
.'									    	</tr>'
.'									    	<tr>'
.'									        	<td>'
.'									            	<table style="width:100%;color:#999;margin-top:18px;line-height:21px;font-family:Helvetica,Arial,sans-serif;font-size:12px">'
.'									                	<tbody>'
.'									                		<tr>'
.'											                    <td style="padding:0 60px;text-align:center">'
.'											                        This email was sent to <a href="mailto:'.$payer_email.'" style="color:#0f90ba;text-decoration:none;font-weight:600" target="_blank">'.$payer_email.'</a>'
.'											                    </td>'
.'									                		</tr>'
.'									               			<tr>'
.'											                    <td style="padding:0 60px;text-align:center">'
.'											                        <span style="padding:0 3px"> <span class="il">ZUS Network LLC</span> </span> |<span style="padding:0 3px"> 20 River Ct </span> |<span style="padding:0 3px"> Jersey City, NJ 07310 </span>'
.'											                    </td>'
.'											                    <td style="float:left;overflow:hidden;font-size:0;max-height:0;height:0;text-align:center;margin-top:2px!important">'
.'											                        <span class="il">ZUS Network LLC</span><br>'
.'											                        20 River Ct<br>'
.'											                        Jersey City, NJ 07310</td>'
.'									                		</tr>'
.'									               			<tr>'
.'											                    <td style="padding:0 60px;text-align:center">'
.'											                        Copyright©2014 <span class="il">ZUS Network LLC</span>. All rights reserved.</td>'
.'									                		</tr>'
.'											                <tr>'
.'											                    <td align="center" style="padding-top:6px">'
.'											                        <a href="http://www.nycuni.com" target="_blank">'
.'											                            <img src="http://nycuni.com/theme/images/logo_uni.png" width="38" height="38" alt="nycuni" border="0" style="width:38px;min-height:38px;margin:0 0 25px 0">'
.'											                        </a>'
.'											                    </td>'
.'											                </tr>'
.'									            		</tbody>'
.'									            	</table>'
.'									        	</td>'
.'									    	</tr>'
.'										</tbody>'
.'									</table>'
.'								</td>'
.'							</tr>'
.'						</tbody>'
.'					</table>'
.'				</div>'
.'			</div>'
.'		</section>'
.'	</body>'
.'</html>';

$body_self = '<html lang="utf-8">'
.'	<head>'
.'		<meta charset="utf-8" />'
.'   	<meta name="keywords" content="纽约有你, 在线社交活动网站, 纽约学生活动平台, 发布参加活动群组, nycuni, nyc, uni, social, socialplatform, event, group, club">'
.'   	<meta name="description" content="纽约有你，纽约年轻华人社交活动网站，发布/参加线下活动，创建/参与交流群组，发布/游览丰富富咨讯，享受NYC Uni与合作商家优惠，满足社交、资讯、娱乐和生活多方面需求。">'
.'      <title>支付 - NBRC - 纽约新蜂跑团</title>'
.'	</head>'
.'	<body>'
.'		<section>'
.'			<div style="background:#f7f7f7">'
.'				<div style="width:600px;margin:0 auto;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:12px;color:#666;line-height:1.4em">'
.'					<table border="0" cellpadding="0" cellspacing="0" style="margin-bottom:10px;background:#f7f7f7;width:600px">'
.'			    		<tbody>'
.'			    			<tr>'
.'			        			<td width="70%" valign="middle" style="text-align:right;padding:20px 10px 10px 0">'
.'					            	<a href="http://nycuni.com" target="_blank">'
.'					                	<img src="http://nycuni.com/theme/images/logo_blue.png" width="78" height="72" border="0" alt="NYCuni" style="width:116px;min-height:35px">'
.'					            	</a>'
.'			        			</td>'
.'			        			<td width="66%" valign="middle" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;padding-top:12px;vertical-align:middle">'
.'			            			<span>'
.'										<a style="text-decoration:none;color:rgba(0, 118, 166, 0.75);font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;font-size:13px;font-weight:500;color:rgba(0, 118, 166, 1);text-decoration:none;padding-right:30px" href="http://nycuni.com" target="_blank">'
.'										    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NYCuni</br>'
.'										    纽约新蜂跑团</a>'
.'									</span>'
.'			       				</td>'
.'			    			</tr>'					    
.'						    <tr>'
.'						        <td colspan="2">'
.'						            <table border="0" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:10px;width:100%">'
.'						                <tbody>'
.'						                	<tr>'
.'							                    <td style="font-family:"Helvetica Neue",Helvetica,Arial,sans-serif">'
.'							                    </td>'
.'						                	</tr>'
.'						                	<tr>'
.'										        <td style="font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;padding:32px 40px;background-color:#fff;border-radius:0;border-radius:6px 6px 0 0">'
.'												<h2 style="color:#404040;font-size:23px;font-weight:500;line-height:1.25;margin:0 0 12px 0;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif">'
.'													Dear&nbsp;'.'nycuni'.', here is an new order for</br>'
.'													<a style="text-align: center; text-decoration:none;color:#1090ba;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;font-weight:normal" href="http://nycuni.com/event?eid='.$eid.'" target="_blank">&nbsp;'.$e_title.'</a>'
.'												</h2>'
.'												<p style="line-height:1.667;color:#999;margin:0;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;font-size:16px">' 
.'													<a href="http://nycuni.com" style="color:#999" target="_blank">NYCuni 纽约有你</a>'
.'												</p>'
.'												</td>'
.'											</tr>'
.'											<tr>'
.'											    <td style="padding:0 40px">'
.'													<table cellspacing="0" cellpadding="0" width="100%">'
.'														<tbody>'
.'															<tr>'
.'																<td style="background-color:#e1e1e1;width:100%;font-size:1px;height:1px;line-height:1px">&nbsp;'
.'																</td>'
.'															</tr>'
.'														</tbody>'
.'													</table>'
.'											    </td>'
.'											</tr>'
.'											<tr>'
.'												<td style="padding:0 40px">'
.'													<table cellspacing="0" cellpadding="0" width="100%">'
.'														<tbody>'
.'															<tr>'
.'																<td style="background-color:#e1e1e1;width:100%;font-size:1px;height:1px;line-height:1px">&nbsp;'
.'																</td>'
.'															</tr>'
.'														</tbody>'
.'													</table>'
.'												</td>'
.'											</tr>'
.'										    <tr>'
.'										        <td style="font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;padding:32px 40px;background-color:#fff;border-radius:0">' 
.'													<h5 style="color:#404040;font-size:16px;font-weight:500;line-height:1.25;margin:0 0 12px 0;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif">'.$first_name.'&nbsp;'.$last_name.'</h5>'    
.'													<table width="100%" cellspacing="0" cellpadding="0">'
.'										    			<tbody>'
.'										    				<tr width="100%">'
.'										        				<td width="100%" style="font-size:13px">'
.'																	<a href="mailto:'.$payer_email.'" style="text-decoration:none;color:#1090ba;font-weight:normal" target="_blank">'.$payer_email.'</a>'
.'										        				</td>'
.'										    				</tr>'
.'															<tr width="100%">'
.'										        				<td width="100%" style="font-size:13px">'
.'																	</br><p style="text-decoration:none;color:#ddd;font-weight:normal" target="_blank">Order #: '.$txn_id.'</p>'
.'										        				</td>'
.'										    				</tr>'
.'														</tbody>'
.'													</table>'
.'										        </td>'
.'										    </tr>'
.'			    							<tr>'
.'			    								<td>'
.'			    									<img src="http://nycuni.com:8541/ZUS_Chipotle/theme/images/mail_saleborder.jpg" alt="NYCuni" height="7" style="min-height:7px;border:none;display:block" border="0">'
.'												</td>'
.'											</tr>'
.'											<tr>'
.'												<td style="font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;padding:32px 40px;background-color:#ededed">'
.'			        								<table cellpadding="0" cellspacing="0" border="0" style="width:100%;margin-bottom:12px">'
.'			            								<tbody>'
.'			            									<tr>'
.'												                <td style="border-bottom:1px dashed #d3d3d3">'
.'												                    <h2 style="color:#404040;font-size:23px;font-weight:500;line-height:1.25;margin:0 0 12px 0">Order Summary</h2>'
.'												                </td>'
.'												                <td colspan="2" style="text-align:right;font-weight:600;border-bottom:1px dashed #d3d3d3">'.date("M d Y").'</td>'
.'			            									</tr>'
.'			            									<tr>'
.'			                									<td colspan="3">'
.'												                    <p style="margin-bottom:18px">Order #: '.$txn_id.'</p>'
.'												                    <table cellpadding="0" cellspacing="0" border="0" style="width:100%">'
.'												                        <thead>'
.'												                            <tr>'
.'												                                <th style="border-bottom:1px dashed #d3d3d3;text-align:left;padding-bottom:12px;padding-right:12px">Name</th>'
.'												                                <th style="border-bottom:1px dashed #d3d3d3;text-align:left;padding-bottom:12px;padding-right:12px">Type</th>'
.'												                                <th style="border-bottom:1px dashed #d3d3d3;text-align:right;padding-bottom:12px;padding-right:0">Quantity</th>'
.'												                            </tr>'
.'												                        </thead>'
.'												                        <tbody>';

for ( $i = 1; $i <= $num_cart_items; $i++ ) {
$body_self .= '<tr>'
.'												                                <td style="padding:12px 0;padding-right:3px">'.$first_name.' '.$last_name.'</td>'            
.'												                                <td style="padding:12px 0;padding-right:3px">'.$item_name_arr[$i-1].'</td>'
.'												                                <td style="text-align:right;padding:12px 0">'.$quantity_arr[$i-1].'</td>'
.'												                            </tr>';
} 
$body_self .= '</tbody>'
.'												                    </table>'
.'												                </td>'
.'												            </tr>'
.'												        </tbody>'
.'												    </table>'
.'			    								</td>'
.'			    							</tr>'
.'										    <tr>'
.'										    	<td>'
.'												    <img src="http://nycuni.com:8541/ZUS_Chipotle/theme/images/mail_saleborder_2.jpg" alt="nycuni" height="7" style="min-height:7px;border:none;display:block" border="0">'
.'												</td>'
.'											</tr>'
.'										    <tr>'
.'										        <td style="font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif;padding:32px 40px;background-color:#fff;border-radius:0;border-radius:0 0 6px 6px">'
.'													<table cellpadding="0" cellspacing="0" border="0" align="left" style="width:260px;line-height:1.67;font-size:13px">'
.'													    <tbody>'
.'													    	<tr>'
.'													        	<td>'
.'																	<h2 style="color:#404040;font-size:23px;font-weight:500;line-height:1.25;margin:0 0 12px 0;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif">'
.'																		活动信息</h2>'
.'																	<table cellspacing="0" cellpadding="0" width="100%" align="">'
.'																		<tbody>'
.'																			<tr>'    
.'																				<td width="20" height="" style="vertical-align:top;padding-right:10px" align="">'
.'																					<img src="http://nycuni.com/theme/Flat-UI-Pro-1.2.5/images/icons/clocks.svg" title="date" alt="date" style="width:20px;min-height:20px;vertical-align:-2px" border="0" width="20" height="20">'
.'																				</td>'
.'																				<td width="" height="" style="padding-bottom:10px" align="">'.$start_time.'&nbsp;&nbsp;-</br>'.$end_time.'</td>'
.'																			</tr>'	            
.'																			<tr>'
.'																				<td width="20" height="" style="vertical-align:top;padding-right:10px" align="">'
.'																					<img src="http://nycuni.com/theme/Flat-UI-Pro-1.2.5/images/icons/compas.svg" title="date" alt="date" style="width:20px;min-height:20px;vertical-align:-4px" border="0" width="20" height="20">'
.'																				</td>'
.'																				<td width="" height="" style="padding-bottom:10px" align="">'.$event_street.'<br>'.$event_city.'<br>'.$event_state.'</td>'
.'																			</tr>'
.'																		</tbody>'
.'																	</table>'
.'																</td>'
.'														    </tr>'
.'														</tbody>'
.'													</table>'
.'													<table cellpadding="0" cellspacing="0" border="0" align="right" style="width:240px;text-align:center;margin-top:16px">'
.'													    <tbody>'
.'													    	<tr>'
.'													        	<td>'
.'																	<a style="text-decoration:none;color:#1090ba;font-family:&quot;Helvetica neue&quot;,Helvetica,arial,sans-serif" href="http://maps.google.com/maps?q='.$event_street."+".$event_city."+".$event_state.'" target="_blank">'          
.'																		<img src="http://maps.googleapis.com/maps/api/staticmap?size=240x160&amp;sensor=true&amp;center='.$event_street.$event_city.$event_state.'&amp;markers=label%3AA%7C621+'.$event_street."+".$event_city."+".$event_state.'&amp;zoom=13" title="map" alt="map" style="width:240px;min-height:160px" border="0" width="240" height="160">'
.'																	</a>'
.'													        	</td>'
.'													    	</tr>'
.'														</tbody>'
.'													</table>'
.'												</td>'
.'											</tr>'
.'											<tr>'
.'											    <td style="padding:0 40px">'        
.'													<table cellspacing="0" cellpadding="0" width="100%">'
.'														<tbody>'
.'															<tr>'
.'																<td style="background-color:#e1e1e1;width:100%;font-size:1px;height:1px;line-height:1px">&nbsp;</td>'
.'															</tr>'
.'														</tbody>'
.'													</table>'
.'											    </td>'
.'											</tr>' 
.'			            				</tbody>'
.'			            			</table>'
.'			        			</td>'
.'			    			</tr>'
.'						</tbody>'
.'					</table>'		
.'					<table style="width:600px">'
.'					    <tbody>'
.'					    	<tr>'
.'					        	<td>'
.'									<table cellpadding="0" cellspacing="0" border="0" align="left" style="color:#999;line-height:1.3em;font-size:12px;font-family:Helvetica,Arial,sans-serif;margin-bottom:5px;width:47%">'
.'									    <tbody>'
.'									    	<tr>'
.'									        	<td>'
.'													<table style="width: 600px; margin:0 auto;border-top:1px solid #ccc;border-bottom:1px solid #ccc;padding-top:5px;padding-bottom:5px">'
.'									        			<tbody>'
.'									        				<tr>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://nycuni.com/about" style="text-decoration:none;color:#666" target="_blank">'
.'													                    about</a>'
.'													            </td>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://nycuni.com/contact" style="text-decoration:none;color:#666" target="_blank">'
.'													                    Contact</a>'
.'													            </td>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://nycuni.com/privacy" style="text-decoration:none;color:#666" target="_blank">'
.'													                    Privacy</a>'
.'													            </td>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://nycuni.com/terms" style="text-decoration:none;color:#666" target="_blank">'
.'													                    Terms</a>'
.'													            </td>'
.'													             <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase;background-image:none">'
.'													                <a href="http://nycuni.com/team" style="text-decoration:none;color:#666" target="_blank">'
.'													                    Team</a>'
.'													            </td>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://www.facebook.com/nycuni" style="display:inline" target="_blank">'
.'													                    <img src="http://nycuni.com/theme/images/facebook_share_samll.png" alt="Facebook" title="Facebook" border="0" style="padding-top:2px">'
.'													                </a>'
.'													            </td>'
.'													            <td style="padding:2px 7px 1px 14px;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#666;text-transform:uppercase">'
.'													                <a href="http://weibo.com/u/5065310473" style="display:inline" target="_blank">'
.'													                    <img src="http://nycuni.com/theme/images/sina.png" alt="Sina" title="Sina" border="0" style="padding-top:2px">'
.'													                </a>'
.'													            </td>'
.'									        				</tr>'	
.'									    				</tbody>'
.'									    			</table>'
.'									        	</td>'
.'									    	</tr>'
.'									    	<tr>'
.'									        	<td>'
.'									            	<table style="width:100%;color:#999;margin-top:18px;line-height:21px;font-family:Helvetica,Arial,sans-serif;font-size:12px">'
.'									                	<tbody>'
.'									                		<tr>'
.'											                    <td style="padding:0 60px;text-align:center">'
.'											                        This email was sent to <a href="mailto:'.$payer_email.'" style="color:#0f90ba;text-decoration:none;font-weight:600" target="_blank">'.$payer_email.'</a>'
.'											                    </td>'
.'									                		</tr>'
.'									               			<tr>'
.'											                    <td style="padding:0 60px;text-align:center">'
.'											                        <span style="padding:0 3px"> <span class="il">ZUS Network LLC</span> </span> |<span style="padding:0 3px"> 20 River Ct </span> |<span style="padding:0 3px"> Jersey City, NJ 07310 </span>'
.'											                    </td>'
.'											                    <td style="float:left;overflow:hidden;font-size:0;max-height:0;height:0;text-align:center;margin-top:2px!important">'
.'											                        <span class="il">ZUS Network LLC</span><br>'
.'											                        20 River Ct<br>'
.'											                        Jersey City, NJ 07310</td>'
.'									                		</tr>'
.'									               			<tr>'
.'											                    <td style="padding:0 60px;text-align:center">'
.'											                        Copyright©2014 <span class="il">ZUS Network LLC</span>. All rights reserved.</td>'
.'									                		</tr>'
.'											                <tr>'
.'											                    <td align="center" style="padding-top:6px">'
.'											                        <a href="http://www.nycuni.com" target="_blank">'
.'											                            <img src="http://nycuni.com/theme/images/logo_uni.png" width="38" height="38" alt="nycuni" border="0" style="width:38px;min-height:38px;margin:0 0 25px 0">'
.'											                        </a>'
.'											                    </td>'
.'											                </tr>'
.'									            		</tbody>'
.'									            	</table>'
.'									        	</td>'
.'									    	</tr>'
.'										</tbody>'
.'									</table>'
.'								</td>'
.'							</tr>'
.'						</tbody>'
.'					</table>'
.'				</div>'
.'			</div>'
.'		</section>'
.'	</body>'
.'</html>';


// Include the main TCPDF library (search for installation path).

require_once($home.'external/tcpdf/examples/config/tcpdf_config_alt.php');
require_once($home.'external/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sean Yi');
$pdf->SetTitle('Junxiao Yi\'s test');
$pdf->SetSubject('nycuni ticket');
$pdf->SetKeywords('nycuni, ticket, event, group, community');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 2);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$qr = QRCodeDAO::get_qr_code_event($eid);

// set some language-dependent strings (optional)
// if (@file_exists($home.'external/tcpdf/examples/lang/eng.php'))
// {
// 	require_once($home.'external/tcpdf/examples/lang/eng.php');
// 	$pdf->setLanguageArray($l);
// }
if (@file_exists($home.'external/tcpdf/examples/lang/chi.php'))
{
	require_once($home.'external/tcpdf/examples/lang/chi.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
// $pdf->SetFont('dejavusans', '', 10);
// $pdf->SetFont('stsongstdlight', '', 10);
$pdf->SetFont('droidsansfallback', '', 12);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// add a page
$pdf->AddPage();

// create some HTML content
// $subtable = '<table border="1" cellspacing="6" cellpadding="4"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';
$subtable = '<table class="subtable" border="0" cellspacing="6" cellpadding="4">
				<tr>
					<td style="border-top: 1px solid #ddd; border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-right: 0px solid #ddd; color: #ADD0E0">item</td>
					<td style="border-top: 1px solid #ddd; border-left: 0px solid #ddd; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; color: #ADD0E0">quantity</td>
				</tr>';
for ( $i = 1; $i <= $num_cart_items; $i++ )
{
	$subtable .= '<tr><td>'.$item_name_arr[$i-1].'</td><td>'.$quantity_arr[$i-1].'</td></tr>';
}
$subtable .= '</table>';

$subelement = 'Order Detail:&nbsp;';
for ( $i = 1; $i <= $num_cart_items; $i++ )
{
	$subelement .= '('.$item_name_arr[$i-1].',&nbsp;'.$quantity_arr[$i-1].'张);&nbsp;';
}

$html = '<div align="center" width="150" bgcolor="#ADD0E0" color="0074A8">This is your ticket for nycuni.com event <br>Please print and bring this ticket with you</div>
		<img width="20" src="'.$home.'theme/images/arrow_down.jpg"/>';

$pdf->writeHTMLCell(150, 0, 35, '', $html, '', 1, 0, true, 'C', true);

// $html = '<div style="border-bottom: 2px dashed #ddd;"></div>';
// $pdf->writeHTMLCell('', '', '', '', $html, '', 1, 0, true, 'C', true);


$html = '
<!-- CSS STYLE -->
<style>
	td
	{
		background-color: white;
	}
	.subtable
	{
		border: 0px solid white;
	}
	.lowercase {
		text-transform: lowercase;
	}
	.uppercase {
		text-transform: uppercase;
	}
	.capitalize {
		text-transform: capitalize;
	}
</style>

<table border="0" cellspacing="3" cellpadding="4">
	<tr>
		<td rowspan="2" style="border-top: 5px solid #ddd; border-left: 5px solid #ddd; border-bottom: 5px solid #ddd; border-right: 5px solid #ddd;">
			<br/><sup style="color: #aaa;">活动海报</sup><br/>
			<img src="'.$home.$large_logo_url.'" width="100" style="text-align: center;"/>
		</td>
		<td colspan="4" style="border-top: 5px solid #ddd; border-left: 0px solid #ddd; border-bottom: 5px solid #ddd; border-right: 5px solid #ddd;">
			<br/><sup style="color: #aaa;">活动名称</sup><br/>
			<span style="text-align:center; font-size: 12px;">'.$e_title.'</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" rowspan="1" style="border-top: 0px solid #ddd; border-left: 0px solid #ddd; border-bottom: 5px solid #ddd; border-right: 5px solid #ddd;">
			<br/><sup style="color: #aaa;">活动时间</sup><br/>
			<span style="text-align:center; font-size: 12px;">Start Time: '.$start_time.'</span><br/>
			<span style="text-align:center; font-size: 12px;">End Time: '.$end_time.'</span>
		</td>
		<td colspan="2" rowspan="1" style="border-top: 0px solid #ddd; border-left: 0px solid #ddd; border-bottom: 5px solid #ddd; border-right: 5px solid #ddd;">
			<br/><sup style="color: #aaa;">活动地点</sup><br/>
			<span style="text-align:center; font-size: 12px;">'.$event_street.'</span><br/>
			<span style="text-align:center; font-size: 12px;">'.$event_city.',</span>
			<span style="text-align:center; font-size: 12px;">'.$event_state.'</span>
		</td>
	</tr>
	<tr>
		<td colspan="4" rowspan="1" style="border-top: 0px solid #ddd; border-left: 5px solid #ddd; border-bottom: 5px solid #ddd; border-right: 5px solid #ddd;">
			<br/><sup style="color: #aaa;">票务信息</sup><br/>
			<span style="text-align:center; font-size: 12px;">Order #'.$transaction_id.';&nbsp;</span>
			<span style="text-align:center; font-size: 12px;">Issued to: '.$last_name.'&nbsp;'.$first_name.';</span>
			<span style="text-align:center; font-size: 12px;">Issued on: '.date("Y-m-d").'</span><br/>
			<span style="text-align:center; font-size: 12px;">'.$subelement.'</span>
		</td>
		<td align="center" colspan="1" rowspan="1" style="border-top: 0px solid #ddd; border-left: 0px solid #ddd; border-bottom: 5px solid #ddd; border-right: 5px solid #ddd;">
			<img src="'.$qr.'"/ width="50" style="text-align: center;"/>
		</td>
	</tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// $html = '<div style="border-top: 2px dashed #ddd;"></div>';
// $pdf->writeHTMLCell('', '', '', '', $html, '', 1, 0, true, 'C', true);

$html = <<<EOF
 <table style="width:100%;color:#999;margin-top:18px;line-height:21px;font-family:Helvetica,Arial,sans-serif;font-size:12px">
    <tbody>
        <tr>
            <td style="padding:0 60px;text-align:center">
                This ticket was created for event on&nbsp;<a href="http://nycuni.com" style="color:#0f90ba;text-decoration:none;font-weight:600" target="_blank">nycuni.com</a>.
            </td>
        </tr>
        <tr>
            <td style="padding:0 60px;text-align:center">
                <span style="padding:0 3px"> <span class="il">ZUS Network LLC</span> </span> |
                <span style="padding:0 3px"> 20 River Ct </span> |
                <span style="padding:0 3px"> Jersey City, NJ 07310 </span>
            </td>
            <td style="float:left;overflow:hidden;font-size:0;max-height:0;height:0;text-align:center;margin-top:2px!important">
                <span class="il">ZUS Network LLC</span><br>
                20 River Ct<br>
                Jersey City, NJ 07310
            </td>
        </tr>
        <tr>
            <td style="padding:0 60px;text-align:center">
                Copyright 
                ©
                 2014 <span class="il">ZUS Network LLC</span>. All rights reserved.
            </td>
        </tr>
        <tr>
            <td align="center" style="padding-top:6px">
                <a href="http://www.nycuni.com" target="_blank">
                    <img src="http://nycuni.com/theme/images/logo_uni.png" width="38" height="38" alt="nycuni" border="0" style="width:38px;min-height:38px;margin:0 0 25px 0">
                </a>
            </td>
        </tr>
    </tbody>
</table>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document

$ticket_dir = 'upload/ticket/'.$eid.'/'.$pid.'/';

// $file .= '/'. round(microtime(true));
if (!file_exists($home.$ticket_dir))
{
	mkdir($home.$ticket_dir, 0777, true);
}

$ticket_url = $home.$ticket_dir.'ticket_111'.$pid.'111'.$eid.$transaction_id.'.pdf';

$pdf->Output($ticket_url, 'f');
		
		$paypal 		=	EventDAO::ipn_handle($order);

		$sale2paypal 	=	EventDAO::update_sale2paypal_remain_order($order);

		EventDAO::join_event($args['user_pid'], $args['event_eid']);
		MailDAO::sendmail_event_paypalsale($to, $subject, $body, $ticket_url);
		MailDAO::sendmail_event_paypalsale($to_self, $subject_self, $body_self, $ticket_url);
		MailDAO::sendmail_event_paypalsale($to_self_1, $subject_self, $body_self, $ticket_url);
?>