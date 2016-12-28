<?php
	$home = '../../';
	include_once ($home.'core.php');
$bm = new Timer();

	$title = "发送邮件 - NBRC - 纽约新蜂跑团";
    $to = "lifeloverxg@gmail.com";
    $subject = "test for email Junxiao";

    $email = "lifeloverxg@gmail.com";
    
    $url = MailDAO::get_mail_url($email);
    
    $content = "您的链接是:".$url;

    var_dump($content);

    $test = explode("code=", $url);

    var_dump($test);

    $test2 = $test[1];	
  	
    $test3 = base64_decode($test2);

    $test_arr = explode("|", $test3);

    $test5 = $test_arr[2];
    var_dump($test5);

    $res = MailDAO::sendmail($to, $subject, $content);

    var_dump($res);

?>