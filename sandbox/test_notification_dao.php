<?php
	$home = '../';
	include_once ($home.'core.php');

	$pid = 1;
	$icon = "http://nycuni.com/upload/1/1391671205_small.jpg";
	$message = "Oyster Generated Testing: <a href=\"./test_notificagion_dao.php\">One More...</a>";
	$category = 1;
	$edt = new DateTime();
	$expire = $edt->format('Y-m-d H:i:s');
	
	echo "<br />== Adding Default Notification ==<br />";
	NotificationDAO::add_notification($pid, 'Default MSG: '.$message, $icon);
	
	echo "<br />== Adding Customize Notification ==<br />";
	NotificationDAO::add_notification($pid, 'Full MSG: '.$message, $icon, $category, $expire);
	
	echo "<br />== Get Default Notifications ==<br />";
	$result = NotificationDAO::get_notifications(1);
	print_r($result);
	echo "<br /><br /><br />";

	echo "<br />== Mark Customize Notifications " . $result[0]['nid'] . " as Read ==<br />";
	NotificationDAO::mark_as_read($result[0]['nid']);
	echo "<br /><br /><br />";
	
	echo "<br />== Get Customize Notifications ==<br />";
	$result = NotificationDAO::get_notifications(1, false, 1, -1);
	print_r($result);

	echo "<br />== Done ==<br />";
	
	?>
