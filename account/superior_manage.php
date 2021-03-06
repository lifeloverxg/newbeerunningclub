<?php

	$home = '../';
	include_once ($home.'core.php');
	
$bm = new Timer();
	
	if(!defined('IN_NBRC'))
	{
		exit('<h1>503:Service Unavailable @account:manage</h1>');
	}

	$auth = Authority::get_auth_arr();

	if ( !AccountDAO::define_superior_member($auth['uid']) )
	{
		header('Location: '.$home);
	}

	// if ( ( $auth['uid'] != 2 ) && ( $auth['uid'] != 99 ) )
	// {
	// 	header('Location: '.$home);
	// }

	if (isset($_GET['eid']))
	{
		$eid = $_GET['eid'];
	}
	else
	{
		header('Location: '.$home);
	}

	$links = $_SGLOBAL['links'];

	$deviceType = Mobile_Detect::deviceType();

	$info_list = EventDAO::get_info_list($auth['uid'], $eid);
	
	$title = '管理页面 - NBRC - 纽约新蜂跑团';
	
	$stylesheet = array(
						'theme/zus/event_css/detail_page.css',
						'theme/zus/event_css/payment.css',
						'theme/zus/people_css/edit_profile.css',
						);
	$m_stylesheet = array(			
						);
	$javascript = array(
						'js/zus/jquery.datetimepicker.js',
						'js/zus/map/route.js'
						);
	$m_javascript = array('js/zus/common.js',
						  'js/mobile/m_common.js');

	$manage_tabs = EventDAO::get_alex_manage_nav_tab_list($auth['uid'], $eid);

	$isPaypal = EventDAO::is_Paypal_Sale($eid);

	$sale_info_list = EventDAO::get_sale_info_list($eid);

	if ( $isPaypal )
	{
		$ticket_list = EventDAO::get_ticket_info_eid($eid);
		$ticket_all = $ticket_list['ticket'];

		$mail_list = MailDAO::get_paypalsale_mail_list_eid($eid);
		//保存mail_list_csv
		$folder_mail_list = 'upload/'."attendee_csv/".$eid."/";
		$file_mail_list = $home.$folder_mail_list."array2csv_whole.csv";
		$sale_info_download_list = $home.$folder_mail_list."saleinfo.csv";
		xmlToCsv::array2CSV($home, $mail_list, $eid);
		xmlToCsv::array2CSV($home, $sale_info_list['info'], $eid, "saleinfo");
		$mail_all = "mailto:event@nycuni.com?bcc=jiangsuliufeng@gmail.com&bcc=yijunxiao@nycuni.com";
	}

$bm->mark();
	

	if ( ($deviceType == "phone") ) 
	{
		// include S_ROOT."template/mobile/event/m_detail_frame.php";
		include S_ROOT."template/account/superior_manage/manage_frame.php";
	}
	else if ( ($_SCONFIG['version'] == 'debug_tablet') || ($deviceType == "tablet") )
	{
		include S_ROOT."template/account/superior_manage/manage_frame.php";
	}
	else 
	{
		include S_ROOT."template/account/superior_manage/manage_frame.php";
	}
$bm->mark();
echo '<!-- '.$bm->report().'-->';
