<?php
	$home = '../../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @cgi:formActions</h1>');
	}

	$auth = Authority::get_auth_arr();

	/*++++++++++++++++++++++++++++++uni_sale++++++++++++++++++++++++++++++*/
	if ( isset( $_POST['uni_sale_submit'] ) )
	{
		$eid = $_POST['unisaleid'];
		$pid = $_POST['unisalepid'];

		$ticket_info	=	array();
		$ticket_ids		=	array();
		$ticket_count	=	$_POST["ticket_type_nums"];
		$salecount		=	$_POST['unisalecount'];

		for ( $i = 1; $i <= $salecount; $i++ )
		{
			$ticket['eid']			=	$eid;
			$ticket['type']			=	$_POST["type_".$i];
			$ticket['price']		=	$_POST["price_".$i];
			$ticket['volume']		=	$_POST["volume_".$i];
			$ticket['remain']		=	$_POST["volume_".$i];
			$ticket['tlimit']		=	$_POST["tlimit_".$i];
			$ticket['description']	=	$_POST["description_".$i];

			array_push($ticket_info, $ticket);

			$ticket_id = EventDAO::set_uni_ticket($pid, $eid, $ticket);
			array_push($ticket_ids, $ticket_id);
		}

		// print_r($ticket_ids);

		header('Location: '.$home.'account/superior_manage.php?eid='.$eid);
	}

	if ( isset( $_POST['uni_sale_modify_submit'] ) )
	{
		$eid = $_POST['unisaleid'];
		$pid = $_POST['unisalepid'];

		$ticket_info	=	array();
		$ticket_ids		=	array();
		$ticket_count	=	$_POST["ticket_type_nums"];
		$salecount		=	$_POST['unisalecount'];

		for ( $i = 1; $i <= $salecount; $i++ )
		{
			$ticket['eid']			=	$eid;
			$ticket['type']			=	$_POST["type_".$i];
			$ticket['price']		=	$_POST["price_".$i];
			$ticket['volume']		=	$_POST["volume_".$i];
			$ticket['remain']		=	$_POST["remain_".$i];
			$ticket['tlimit']		=	$_POST["tlimit_".$i];
			$ticket['description']	=	$_POST["description_".$i];

			if ( isset($_POST['ticket_id_'.$i]) && (!empty($_POST['ticket_id_'.$i])) )
			{
				$ticket['ticket_id'] = $_POST['ticket_id_'.$i];

				array_push($ticket_info, $ticket);

				$ticket_id = EventDAO::edit_uni_ticket($pid, $eid, $ticket);
				array_push($ticket_ids, $ticket_id);
			}
			else
			{
				array_push($ticket_info, $ticket);

				$ticket_id = EventDAO::set_uni_ticket($pid, $eid, $ticket);
				array_push($ticket_ids, $ticket_id);
			}
		}

		// print_r($ticket_ids);
		header('Location: '.$home.'account/superior_manage.php?eid='.$eid);
	}


	/*test*/
	// $pid = 10;
	// $ticket['eid']			=	12;
	// $ticket['type']			=	'Early bird';
	// $ticket['price']		=	10;
	// $ticket['volume']		=	100;
	// $ticket['remain']		=	50;
	// $ticket['tlimit']		=	'';
	// $ticket['description']	=	'hello world';
	// $test = EventDAO::set_uni_ticket($pid, $ticket);
	// var_dump($test);

	if ( isset($_POST['paypal_free_order_submit']) )
	{
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
			if ((isset($_POST[$key])) && ($_POST[$key] != "")) 
			{
				$args[$key] = $_POST[$key];
			}
		}

		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		if ( $_SERVER['HTTP_HOST'] == 'localhost' )
		{
			$url = 'http://'.$_SERVER['HTTP_HOST']."/~lifeloverxg/github/ZUS_Apollo/cgi/formActions/fsockopen_uni_sale.php?user_email=".$args['user_email']."&user_pid=".$args['user_pid']."&event_eid=".$args['event_eid']."&num_cart_items=".$args['num_cart_items']."&items=".$args['items'];
		}
		else
		{
			$url = 'http://'.$_SERVER['HTTP_HOST']."/cgi/formActions/fsockopen_uni_sale.php?user_email=".$args['user_email']."&user_pid=".$args['user_pid']."&event_eid=".$args['event_eid']."&num_cart_items=".$args['num_cart_items']."&items=".$args['items'];
		}
		// var_dump($url);

	    $post_data = array(
	                        'test_1' => 'test1',
	                        'test_2' =>  'test2',
	                        'test_3' => 'test3'
	                        );
	    $cookie_array = array();

	    AccountDAO::triggerRequest($url, $post_data, $cookie);

		EventDAO::join_event($args['user_pid'], $args['event_eid']);
		// MailDAO::sendmail_event_paypalsale($to, $subject, $body, $ticket_url);
		// MailDAO::sendmail_event_paypalsale($to_self, $subject_self, $body_self, $ticket_url);
		// MailDAO::sendmail_event_paypalsale($to_self_1, $subject_self, $body_self, $ticket_url);


		// echo "</br></br></br> hello world!";
		echo "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'>";
		echo "<script type='text/javascript'>alert('您的订单确认信已经发到您的邮箱，请稍后查收');</script>";
		echo "<script type='text/javascript'>window.location.href='".$home."event/detail.php?eid=".$args['event_eid']."&isconfirmation=1'</script>";
	}
	/*==============================uni_sale==============================*/
?>