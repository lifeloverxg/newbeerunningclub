<?php

	$item_name = "hello test";
	$dbh=mysql_connect("162.243.244.117", "zus_robot", "B0to(^_^)oZus") or die ('Cannot   connect   to   the   database   because:   '   .   mysql_error());
	mysql_select_db("stagezus",$dbh);
	$sql = "INSERT INTO paypal(item_name) VALUES ('".$item_name."')";
	$result = mysql_query($sql,$dbh);

	$req = 'cmd=_notify-validate&' . http_build_query($_POST, NULL, '&');

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

	curl_setopt($ch, CURLOPT_URL, 'https://wwww.sandbox.paypal.com/cgi-bin/webscr');

	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

	$response = curl_exec($ch);

	curl_close($ch);

	mail('lifeloverxg@gmail.com', "IPN Test Result", $response);

	// mail('lifeloverxg@gmail.com', $response, $response);

	if ( $response == "VERIFIED" )
	{
		$item_name = "hello world";
		$dbh = mysql_connect("162.243.244.117", "zus_robot", "B0to(^_^)oZus") or die ('Cannot   connect   to   the   database   because:   '   .   mysql_error());
		mysql_select_db("stagezus",$dbh);
		$sql = "INSERT INTO paypal(item_name) VALUES ('".$item_name."')";
		$result = mysql_query($sql,$dbh);
	}
	else if ( $response == "INVALID" )
	{
		$item_name = "hello world22";
		$dbh = mysql_connect("162.243.244.117", "zus_robot", "B0to(^_^)oZus") or die ('Cannot   connect   to   the   database   because:   '   .   mysql_error());
		mysql_select_db("stagezus",$dbh);
		$sql = "INSERT INTO paypal(item_name) VALUES ('".$item_name."')";
		$result = mysql_query($sql,$dbh);
	}
	else
	{
		$item_name = "hello world33";
		$dbh = mysql_connect("162.243.244.117", "zus_robot", "B0to(^_^)oZus") or die ('Cannot   connect   to   the   database   because:   '   .   mysql_error());
		mysql_select_db("stagezus",$dbh);
		$sql = "INSERT INTO paypal(item_name) VALUES ('".$item_name."')";
		$result = mysql_query($sql,$dbh);
	}
?>