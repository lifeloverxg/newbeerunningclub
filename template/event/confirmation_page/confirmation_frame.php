<?php
// HTML header
include $home . "template/common/header.php"; 
?>

<section class="section-confirmation-page">
	恭喜您，已经加入活动, 点击<a href='<?php echo $back; ?>'>返回</a>到活动页面</p>
	<div style="width:295px; text-align:center; margin: 0px auto;" ><iframe  src="https://www.eventbrite.com/countdown-widget?eid=12034135423" frameborder="0" height="586" width="195" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="true"></iframe></div>
</section>
<?php
// $test = $_GET['https://www.eventbrite.com/xml/event_list_attendees?app_key=V7DWJXIVE4MCEZADXC&id=11737187243&user_key=139543901294252847805'];
// $curl = curl_init();

// curl_setopt($curl, CURLOPT_URL, 'https://www.eventbrite.com/xml/event_list_attendees?app_key=V7DWJXIVE4MCEZADXC&id=11737187243&user_key=139543901294252847805&only_display=email');

// // 设置header
// curl_setopt($curl, CURLOPT_HEADER, 1);

// // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

// // 运行cURL，请求网页
// $data = curl_exec($curl);

// // 关闭URL请求
// curl_close($curl);

// // 显示获得的数据
// // var_dump($data);

// $test_1 = simplexml_load_file('https://www.eventbrite.com/xml/event_list_attendees?app_key=V7DWJXIVE4MCEZADXC&id=11737187243&user_key=139543901294252847805&only_display=email,order_id');
// var_dump($test_1);
// echo "</br>";
// echo "</br>";
// $test_2 = json_encode($test_1, TRUE);
// var_dump($test_2);
// echo "</br>";
// echo "</br>";
// $test_3 = json_decode($test_2, TRUE);
// var_dump($test_3);
// echo "</br>";
// echo "</br>";

// foreach 
// $array = json_decode(json_encode(simplexml_load_string($data)),TRUE);
// var_dump($array);
// $str='<xml><node><![CDATA[content]]></node></xml>';
// $res = @simplexml_load_string($str,NULL,LIBXML_NOCDATA);
// $res = json_decode(json_encode($res),true);
// print_r($res);
?>
<?php
// HTML footer
include $home . "template/common/footer.php"; 
?>