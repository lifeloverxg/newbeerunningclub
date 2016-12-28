<?php
// HTML header
include $home . "template/common/header.php";

// <-- HTML body
include $home . "template/common/navigation/navi_event_payment.php";
include $home . "template/event/payment/paypal.php";

include $home . "template/event/payment/paypal_free_order_popup.php";

// spec_popup::spec_popup_common("show-free-order", "Free RSVP"." - ".$info_list['title'], "您的订单为Free Order, 点击确定后您会收到系统发到您的nycuni注册邮箱(".$auth['email'].")的邮件, 请确保您注册时使用的是有效邮箱", "paypal_free_order('".$home."', ".$auth['uid'].", ".$eid.", '".$auth['email']."', ".$ticket_list['allowance'].")", "取消", "确定");
// spec_popup::spec_popup_common_v2("show-free-order", $home, $auth['email'], "Free RSVP"." - ".$info_list['title'], "您的订单为Free Order, 点击确定后您会收到系统发到您的nycuni注册邮箱(".$auth['email'].")的邮件, 请确保您注册时使用的是有效邮箱", "free_order_btn()", "取消", "确定");

// HTML footer
include $home . "template/common/footer_noInformation.php";