<?php	
	class QRCodeDAO {
		public static function get_qr_code_people($pid) {
			global $_SCONFIG;
			
			return 'http://chart.apis.google.com/chart?cht=qr&chs=350x350&chl=http%3A//'.$_SCONFIG['host'].'/people%3Fpid%3D'.$pid.'&chld=H|0';
		}

		public static function get_qr_code_group($gid) {
			global $_SCONFIG;
			
			return 'http://chart.apis.google.com/chart?cht=qr&chs=350x350&chl=http%3A//'.$_SCONFIG['host'].'/group%3Fgid%3D'.$gid.'&chld=H|0';
		}

		public static function get_qr_code_event($eid) {
			global $_SCONFIG;
			
			return 'http://chart.apis.google.com/chart?cht=qr&chs=350x350&chl=http%3A//'.$_SCONFIG['host'].'/event%3Feid%3D'.$eid.'&chld=H|0';
		}
		
		public static function get_url_people($pid) {
			global $_SCONFIG;
			return 'http://'.$_SCONFIG['host'].'/people?pid='.$pid;
		}

		public static function get_url_group($gid) {
			global $_SCONFIG;
			return 'http://'.$_SCONFIG['host'].'/group?gid='.$gid;
		}

		public static function get_url_event($eid) {
			global $_SCONFIG;
			return 'http://'.$_SCONFIG['host'].'/event?eid='.$eid;
		}
	}

	$transaction_id     =   "1111111";
    $num_cart_items     =   1;

    $item_name_arr      =   array();
    $quantity_arr       =   array();
    for ( $i = 1; $i <= $num_cart_items; $i++ )
    {
        $item_name  =   "early_bird_".$i;
        array_push($item_name_arr, $item_name);

        $quantity   =   "quantity_".$i;
        array_push($quantity_arr, $quantity);

        if ( $i < $num_cart_items )
        {
            $items .= $item_name.",".$quantity."|";
        }
        else
        {
            $items .= $item_name.",".$quantity;
        }
    }

    $item_number        =   12345;
    $payment_status     =   "Completed";
    $payment_gross      =   12345;
    $payment_fee        =   1234;
    $payment_currency   =   "USD";
    $txn_id             =   1111111111111;
    $receiver_email     =   "lifeloverxg@gmail.com";
    $payer_email        =   "lifeloverxg@gmail.com";
    $custom             =   "2nycuni31nycuni亲爱的小孩好好学习天天向上有饭吃长大了是开银行还是掏大粪";
    
    //payer information
    $address_city       =   "here";
    $address_country    =   "USA";
    $address_name       =   "GO";
    $address_street     =   "hereeere";
    $address_state      =   "NJ";
    $address_zip        =   "07089";
    $first_name         =   "Edward";
    $last_name          =   "Yijunxiao";

    $buyer_info = $first_name.",".$last_name."|".$address_country.",".$address_state.",".$address_street.",".$address_name;

    $pieces     =   explode("nycuni", $custom);
    $pid        =   $pieces[0];
    $eid        =   $pieces[1];
    $e_title    =   $pieces[2];
    $net        =   $payment_gross - $payment_fee;
    $info_list  =   array(
                            '活动时间' => '2014-07-26 00:00:00 - 2014-07-26 00:00:00',
                            '活动地址' => array(
                                                'street' => 'new st',
                                                'city' => 'harrison',
                                                'state' => 'NJ',
                                                ),
                            );
    $event_time =   $info_list['活动时间'];
    $etime_arr  =   explode(" - ", $event_time);
    $start_time_x1  =   "2014-07-26 12:00:00";
    // $start_time_x2 = strtotime($start_time_x1);
    $start_time =   date('D, M d g:i a', $start_time_x1);
    $end_time_x1    =   "2014-07-27 06:00:00";
    // $end_time_x2 =   strtotime($end_time_x1);
    $end_time   =   date('D, M d g:i a', $end_time_x1);
    $event_street   =   $info_list['活动地址']['street'];
    $event_city     =   $info_list['活动地址']['city'];
    $event_state    =   $info_list['活动地址']['state'];

    $qr = QRCodeDAO::get_qr_code_event($eid);
?>
<?php
//============================================================+
// File name   : Sean_yi.php
// Begin       : 2014-08-09
// Last Update : 2014-08-12
//
// Description : Create pdf files for nycuni ticket use
//
//
// Author: Sean Yi
//
// (c) Copyright:
//               Sean Yi
//               nycuni.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sean Yi');
$pdf->SetTitle('Junxiao Yi\'s test');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
// $pdf->SetFont('dejavusans', '', 10);
$pdf->SetFont('stsongstdlight', '', 10);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// add a page
$pdf->AddPage();

// create some HTML content
// $subtable = '<table border="1" cellspacing="6" cellpadding="4"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';
$subtable = '<table class="subtable" border="0" cellspacing="6" cellpadding="4">
				<tr>
					<td style="border-top: 1px solid #eee; border-left: 1px solid #eee; border-bottom: 1px solid #eee; border-right: 0px solid #eee; color: #ADD0E0">item</td>
					<td style="border-top: 1px solid #eee; border-left: 0px solid #eee; border-bottom: 1px solid #eee; border-right: 1px solid #eee; color: #ADD0E0">quantity</td>
				</tr>';
for ( $i = 1; $i <= $num_cart_items; $i++ )
{
	$subtable .= '<tr><td>'.$item_name_arr[$i-1].'</td><td>'.$quantity_arr[$i-1].'</td></tr>';
}
$subtable .= '</table>';

$subelement = '';
for ( $i = 1; $i <= $num_cart_items; $i++ )
{
	$subelement .= '('.$item_name_arr[$i-1].',&nbsp;'.$quantity_arr[$i-1].'张);&nbsp;';
}

$html = '<div align="center" width="150" bgcolor="#ADD0E0" color="0074A8">This is your ticket for nycuni.com event <br>Please print and bring this ticket with you</div>
		<img width="20" src="images/arrow_down.jpg"/>';

$pdf->writeHTMLCell(150, 0, 35, '', $html, '', 1, 0, true, 'C', true);

// $html = '<div style="border-bottom: 2px dashed #eee;"></div>';
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
		<td rowspan="2" style="border-top: 5px solid #eee; border-left: 5px solid #eee; border-bottom: 5px solid #eee; border-right: 5px solid #eee;">
			<br/><sup style="color: #aaa;">活动海报</sup><br/>
			<img src="images/xunyicao.jpg" width="100" style="text-align: center;"/>
		</td>
		<td colspan="4" style="border-top: 5px solid #eee; border-left: 0px solid #eee; border-bottom: 5px solid #eee; border-right: 5px solid #eee;">
			<br/><sup style="color: #aaa;">活动名称</sup><br/>
			<span style="text-align:center; font-size: 12px;">'.$e_title.'</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" rowspan="1" style="border-top: 0px solid #eee; border-left: 0px solid #eee; border-bottom: 5px solid #eee; border-right: 5px solid #eee;">
			<br/><sup style="color: #aaa;">活动时间</sup><br/>
			<span style="text-align:center; font-size: 12px;">Start Time: '.$start_time.'</span><br/>
			<span style="text-align:center; font-size: 12px;">End Time: '.$end_time.'</span>
		</td>
		<td colspan="2" rowspan="1" style="border-top: 0px solid #eee; border-left: 0px solid #eee; border-bottom: 5px solid #eee; border-right: 5px solid #eee;">
			<br/><sup style="color: #aaa;">活动地点</sup><br/>
			<span style="text-align:center; font-size: 12px;">'.$event_street.'</span><br/>
			<span style="text-align:center; font-size: 12px;">'.$event_city.',</span>
			<span style="text-align:center; font-size: 12px;">'.$event_state.'</span>
		</td>
	</tr>
	<tr>
		<td colspan="4" rowspan="1" style="border-top: 0px solid #eee; border-left: 5px solid #eee; border-bottom: 5px solid #eee; border-right: 5px solid #eee;">
			<br/><sup style="color: #aaa;">票务信息</sup><br/>
			<span style="text-align:center; font-size: 12px;">Order #'.$transaction_id.';&nbsp;</span>
			<span style="text-align:center; font-size: 12px;">Issued to: '.$last_name.'&nbsp;'.$first_name.';</span>
			<span style="text-align:center; font-size: 12px;">Issued on: '.date("Y-m-d").'</span><br/>
			<span style="text-align:center; font-size: 12px;">'.$subelement.'</span>
		</td>
		<td align="center" colspan="1" rowspan="1" style="border-top: 0px solid #eee; border-left: 0px solid #eee; border-bottom: 5px solid #eee; border-right: 5px solid #eee;">
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

// $html = '<div style="border-top: 2px dashed #eee;"></div>';
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
$pdf->Output('new_folder/Sean_y.pdf', 'f');

//============================================================+
// END OF FILE
//============================================================+
