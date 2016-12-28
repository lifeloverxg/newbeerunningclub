<?php
	if(!defined('IN_NBRC')) {
		exit('<h1>403:Forbidden @util:account.php</h1>');
	}
	
	class AccountDAO 
	{		
		// modify pwd
		public static function modify_pwd($uid, $pwd) 
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE login SET pass=PASSWORD(?) WHERE uid=?;');
			$stmt->bind_param('si', $pwd, $uid);
			$stmt->execute();
			$stmt->close();
			return 0;
		}

		public static function check_pwd($uid, $pwd) 
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT 1 FROM login WHERE uid=? AND pass=PASSWORD(?) LIMIT 1;');
			$stmt->bind_param('is', $uid, $pwd);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$stmt->close();
				return 1;					
			}
			else {
				$stmt->close();
				return 0;
			}
		}

		public static function ResetPwd($email, $pass)
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE login SET pass=PASSWORD(?) WHERE email = ?;');
			$stmt->bind_param('ss', $pass, $email);
			$stmt->execute();
			$stmt->close;
			return true;
		}

		public static function isMobile()
		{
			//强制用parameter转换为mobile/desktop的方式访问
			if(isset ($_GET['mode'])) {
				if ($_GET['mode'] == "mobile") {
					return true;
				} else if ($_GET['mode'] == "desktop") {
					return fasle;
				}
			}
		    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
		    {
		        return true;
		    }
		    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		    if (isset ($_SERVER['HTTP_VIA']))
		    {
		        // 找不到为flase,否则为true
		        if (stristr($_SERVER['HTTP_VIA'], "wap")) {
		        	return true;
		        }
		    }
		    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
		    if (isset ($_SERVER['HTTP_USER_AGENT']))
		    {
		        $clientkeywords = array ('nokia',
		            'sony',
		            'ericsson',
		            'mot',
		            'samsung',
		            'htc',
		            'sgh',
		            'lg',
		            'sharp',
		            'sie-',
		            'philips',
		            'panasonic',
		            'alcatel',
		            'lenovo',
		            'iphone',
		            'ipod',
		            'blackberry',
		            'meizu',
		            'android',
		            'netfront',
		            'symbian',
		            'ucweb',
		            'windowsce',
		            'palm',
		            'operamini',
		            'operamobi',
		            'openwave',
		            'nexusone',
		            'cldc',
		            'midp',
		            'wap',
		            'mobile'
		            );
		        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
		        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
		        {
		            return true;
		        }
		    }
		    // 协议法，因为有可能不准确，放到最后判断
		    if (isset ($_SERVER['HTTP_ACCEPT']))
		    {
		        // 如果只支持wml并且不支持html那一定是移动设备
		        // 如果支持wml和html但是wml在html之前则是移动设备
		        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
		        {
		            return true;
		        }
		    }
		    return false;
		}

		public static function user_error()
		{
			$uid_list			= 		array();
			$pid1_list 			= 		array();
			$pid2_list			=		array();
			$people_list		= 		array();
			$people2board_list	= 		array();
			$album_list			=		array();

			$intersect_friend = array();

			$mysqli = MysqlInterface::get_connection();

			/*++++++++++login 表++++++++++*/
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT uid FROM login LIMIT 1000;');
			// $stmt->bind_param('is', $uid, $pwd);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				array_push($uid_list, $row['uid']);				
			}
			/*==========login 表==========*/
			
			/*++++++++++people2people 表++++++++++*/
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pid1 FROM people2people LIMIT 1000;');
			// $stmt->bind_param('is', $uid, $pwd);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				array_push($pid1_list, $row['pid1']);				
			}

			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pid2 FROM people2people LIMIT 1000;');
			// $stmt->bind_param('is', $uid, $pwd);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				array_push($pid2_list, $row['pid2']);				
			}

			$intersect_friend = array_intersect($pid1_list, $pid2_list);

			$intersect_diff_friend = array_diff($intersect_friend, $uid_list);

			sort($intersect_diff_friend);
			/*==========people2people 表==========*/

			/*++++++++++people 表++++++++++*/
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pid FROM people LIMIT 1000;');
			// $stmt->bind_param('is', $uid, $pwd);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				array_push($people_list, $row['pid']);				
			}

			$intersect_diff_people = array_diff($people_list, $uid_list);

			sort($intersect_diff_people);
			/*==========people 表==========*/

			/*++++++++++people2board 表++++++++++*/
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pid FROM people2board LIMIT 1000;');
			// $stmt->bind_param('is', $uid, $pwd);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				array_push($people2board_list, $row['pid']);				
			}

			$intersect_diff_people2board = array_diff($people2board_list, $uid_list);

			sort($intersect_diff_people2board);
			/*==========people2board 表==========*/

			/*==========people 表==========*/

			/*++++++++++album 表++++++++++*/
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT owner FROM album LIMIT 1000;');
			// $stmt->bind_param('is', $uid, $pwd);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				array_push($album_list, $row['owner']);				
			}

			$intersect_diff_album = array_diff($album_list, $uid_list);

			sort($intersect_diff_album);
			/*==========people2board 表==========*/

			return $intersect_diff_album;
		}

		public static function access_Eventbrite($param = '')
		{
			$file_url = 'https://www.eventbrite.com/xml/event_list_attendees?app_key=V7DWJXIVE4MCEZADXC&id=11847073917&user_key=1400251351101612885877'.$param;
			$attendee_xml = simplexml_load_file($file_url);
			$attendee_json = json_encode($attendee_xml, TRUE);
			//#2 json 	=> php array
			$attendee_array = json_decode($attendee_json, TRUE);

			return $attendee_array;
		}

		protected static function get_superior_member($pid)
		{
			$superior_member = array();
			if ( $pid > 0 )
			{
				$pid = 2;
				array_push($superior_member, $pid);

				$pid = 99;
				array_push($superior_member, $pid);

				$pid = 244;
				array_push($superior_member, $pid);

				$pid = 1529;
				array_push($superior_member, $pid);
			}
			
			return $superior_member;
		}

		public static function define_superior_member($pid)
		{
			$superior_member = AccountDAO::get_superior_member($pid);
			foreach ($superior_member as $key => $value)
			{
				if ( $pid == $value )
				{
					return true;
				}
			}

			return false;
		}

		public static function triggerRequest($url, $post_data = array(), $cookie = array())
    	{
	        $method = "GET";  //可以通过POST或者GET传递一些参数给要触发的脚本
	        $url_array = parse_url($url); //获取URL信息，以便平凑HTTP HEADER
	        $port = isset($url_array['port'])? $url_array['port'] : 80;
	      
	        $fp = fsockopen($url_array['host'], $port, $errno, $errstr, 30); 
	        if (!$fp)
	        {
	            echo "hello";
	            return FALSE;
	        }
	        $getPath = $url_array['path'] ."?". $url_array['query'];
	        if(!empty($post_data))
	        {
	            $method = "POST";
	        }
	        $header = $method . " " . $getPath;
	        $header .= " HTTP/1.1\r\n";
	        $header .= "Host: ". $url_array['host'] . "\r\n "; //HTTP 1.1 Host域不能省略
	        /**//*以下头信息域可以省略
	        $header .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13 \r\n";
	        $header .= "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,q=0.5 \r\n";
	        $header .= "Accept-Language: en-us,en;q=0.5 ";
	        $header .= "Accept-Encoding: gzip,deflate\r\n";
	         */

	        // $header .= "Connection:Close\r\n";
	        $header .= "Connection:Close\r\n\r\n";
	        if(!empty($cookie))
	        {
	            $_cookie = strval(NULL);
	            foreach($cookie as $k => $v)
	            {
	                $_cookie .= $k."=".$v."; ";
	            }
	            $cookie_str =  "Cookie: " . base64_encode($_cookie) ." \r\n";//传递Cookie
	            $header .= $cookie_str;
	        }
	        if(!empty($post_data))
	        {
	            $_post = strval(NULL);
	            foreach($post_data as $k => $v)
	            {
	                // $_post .= $k."=".$v."&";
	                $value = urlencode(stripslashes($v)); 
	                $_post .= "&$k=$v"; 
	            }

	            $post_str  = "Content-Type: application/x-www-form-urlencoded\r\n";//POST数据
	            $post_str .= "Content-Length: ". strlen($_post) ." \r\n";//POST数据的长度
	            $post_str .= $_post."\r\n\r\n "; //传递POST数据
	            $header .= $post_str;
	        }
	        // var_dump($header);
	        fwrite($fp, $header);

	        // echo fread($fp, 1024); //我们不关心服务器返回
	        fclose($fp);
	        return true;
	    }
	}

	class xmlToCsv
	{
		public static function xml2CSV($home)
		{
			$xml = simplexml_load_file('https://www.eventbrite.com/xml/event_list_attendees?app_key=V7DWJXIVE4MCEZADXC&id=11737187243&user_key=139543901294252847805&only_display=email,first_name,last_name');
			$folder = 'upload/'."attendee_csv/";
			if ( !file_exists($home.$folder) )
			{
				mkdir($home.$folder, 0777, true);
			}
			$file = $home.$folder."test.csv";
			// $f = fopen('cars.csv', 'w');
			$f = fopen($file, 'w');
			foreach ($xml as $car) 
			{
				fputcsv($f, get_object_vars($car),',','"');
			}
			fclose($f);

			return 1;
		}

		public static function array2CSV($home, $array, $eid = 0, $address = "")
		{
			$folder = 'upload/'."attendee_csv/";
			if ( $eid > 0 )
			{
				$folder = 'upload/'."attendee_csv/".$eid."/";
			}	
			if ( !file_exists($home.$folder) )
			{
				mkdir($home.$folder, 0777, true);
			}
			if ( $address != "" )
			{
				$file = $home.$folder.$address.".csv";
			}
			else
			{
				$file = $home.$folder."array2csv_whole.csv";
			}
			// $f = fopen('cars.csv', 'w');
			$f = fopen($file, 'w');

			foreach($array as $val) 
			{ 
				foreach ($val as $key => $val2) 
				{ 
				 	$val[$key] = iconv('utf-8', 'gbk', $val2);// CSV的Excel支持GBK编码，一定要转换，否则乱码 
				} 
				fputcsv($f, $val); 
			} 
			fclose($f);

        	return 1; 
		}
	}

	class spec_use
	{
		public static function get_title_type($server_url)
		{
			$title_type = "unknown";
			if ( preg_match("/\/event/i", $server_url) > 0 )
			{
				$title_type = "event";
			}
			else if ( preg_match("/\/group/i", $server_url) > 0 )
			{
				$title_type = "group";
			}
			else if ( preg_match("/\/people/i", $server_url) > 0 )
			{
				$title_type = "people";
			}
			else if ( preg_match("/\/information/i", $server_url) > 0 )
			{
				$title_type = "information";
			}

			return $title_type;
		}

		protected static function create_email_verify_step_1()
		{
			$uid_array = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT uid from login LIMIT 2000;');
			// $stmt->bind_param('si', $pwd, $uid);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				array_push($uid_array, $row['uid']);
			}
			$stmt->close();
			return $uid_array;
		}

		public static function create_email_verify_step_2()
		{
			$uid_array = self::create_email_verify_step_1();
			$e_verify = 1;

			$mysqli = MysqlInterface::get_connection();

			foreach ($uid_array as $key => $value)
			{
				$stmt = $mysqli->stmt_init();
				$stmt->prepare('INSERT INTO verify (uid, e_verify) VALUES (?, ?);');
				$stmt->bind_param('ii', $value, $e_verify);
				$stmt->execute();				
				
				$stmt->close();
			}
		}

		public static function newVarDump($varVal, $isExit = FALSE)
		{
			ob_start();
			var_dump($varVal);
			$varVal = ob_get_clean();
			$varVal = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $varVal);
			echo '<pre>'.$varVal.'</pre>';
			$isExit && exit();
		}
	}
?>
