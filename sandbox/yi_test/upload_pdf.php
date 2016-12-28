<?php
	$home = '../../';
	include_once ($home.'core.php');

	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @sandbox:yi_test</h1>');
	}

	$auth = Authority::get_auth_arr();
	
	$pid = Authority::get_uid();

	$title = $info_list['title'] . ' - 测试 - NBRC - 纽约新蜂跑团';
	
	$stylesheet = array();
	$javascript = array();
	
	$links = $_SGLOBAL['links'];

?>

<html>
<body>

<form action="upload_file.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>