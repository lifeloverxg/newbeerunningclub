<?php
	if(!defined('IN_ZUS')) {
		exit('<h1>403:Forbidden @util:auth.php</h1>');
	}

	// Authority class for user sign_in, sign_up, sign_out etc. 
	class Authority {
		// check if the email address existed
		public static function exist_email($email) 
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT 1 FROM login WHERE email=? LIMIT 1;');
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->fetch_array(MYSQLI_ASSOC)) {
				$stmt->close();
				return true;
			}
			$stmt->close();
			return false;
		}

		public static function isEmail($email)
		{
			if ( preg_match("/^[a-z0-9]+([.a-z0-9_-]+)*@[a-z0-9]+(.[a-z0-9]+)*.[a-z]+$/i", $email) )
			//if ( preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i",$email) ) 
			{
	    		return true;
	        }
	        else
	        {
				return false;
			}
		}

		public static function like_exist_email($email) 
		{
			$param = "%".$email."%";
			$uid = 0;

			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT uid FROM login WHERE email like ? LIMIT 1;');
			$stmt->bind_param('s', $param);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$uid = $row['uid'];
				$stmt->close();
				return $uid;
			}
			$stmt->close();
			return $uid;
		}
		
		// check if the user name existed
		public static function exist_user($user) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT 1 FROM login WHERE user=? LIMIT 1;');
			$stmt->bind_param('s', $user);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->fetch_array(MYSQLI_ASSOC)) {
				$stmt->close();
				return true;
			}
			$stmt->close();
			return false;
		}
		
		// check if the invite code is available and consume it
		public static function consume_code($code, $consume=false) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			if ($consume) {
				$stmt->prepare('DELETE FROM invitation WHERE code=? ;');
				$stmt->bind_param('s', $code);
				$stmt->execute();
				$result = $mysqli->affected_rows;
			}
			else {
				$stmt->prepare('SELECT 1 FROM invitation WHERE code=? ;');
				$stmt->bind_param('s', $code);
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
			$stmt->close();
			return $result;
		}

		// try to sign in with email and password
		public static function sign_in($email, $pass)
		{
			if (empty($email))
			{
				return 2;
			}
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			if (strpos($email, '@') !== false)
			{
				$stmt->prepare('SELECT uid, email, user FROM login WHERE email=? AND pass=PASSWORD(?);');
			}
			else
			{
				$stmt->prepare('SELECT uid, email, user FROM login WHERE user=? AND pass=PASSWORD(?);');				
			}
			$stmt->bind_param('ss', $email, $pass);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$uid   = $row['uid'];
				$email = $row['email'];
				$user  = strip_tags($row['user']);

				session_regenerate_id(true);
				$_SESSION['auth'] = PeopleDAO::get_people_basic_pid($uid);
				$_SESSION['auth']['email'] = $email;
				$_SESSION['auth']['uid']   = $uid;
				if (!empty($_SESSION['auth']['title']))
				{
					$_SESSION['auth']['user'] = $_SESSION['auth']['title'];
				}
				else
				{
					if (!empty($user))
					{
						$_SESSION['auth']['user'] = $user;
					}
					else
					{
						$_SESSION['auth']['user'] = 'User'.$uid;
					}
				}
				$stmt->close();
				return 0;
			}
			$stmt->close();
			return 1;
		}
		
		// refresh session
		public static function refresh_session() {
			$pid = self::get_uid();
			if ($pid <= 0) {
				return true;
			}
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT user, email FROM login WHERE uid=? limit 1;');
			$stmt->bind_param('i', $pid);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$email = $row['email'];
				$user  = strip_tags($row['user']);
				// session_regenerate_id(true);

				$_SESSION['auth'] = PeopleDAO::get_people_basic_pid($pid);
				$_SESSION['auth']['email'] = $email;
				$_SESSION['auth']['uid']   = $pid;
				if (!empty($_SESSION['auth']['title'])) {
					$_SESSION['auth']['user'] = $_SESSION['auth']['title'];
				}
				else {
					$_SESSION['auth']['user'] = 'User'.$pid;
				}
				$stmt->close();
				return true;
			}
			$stmt->close();
			return false;
		}
		
		// try to sign up with email and password
		public static function sign_up($email, $pass, $code, $user='', $consume = false) 
		{
			if (self::exist_email($email)) {
				return 1;
			}
			if (!empty($user)) {
				if (self::exist_user($user)) {
					return 2;
				}
			}
			
			if (!self::consume_code($code, $consume)) {
				return 3;
			}
			
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO login (email, pass, user) VALUES (?, PASSWORD(?), ?);');
			$stmt->bind_param('sss', $email, $pass, $user);
			$stmt->execute();
			$pid = $mysqli->insert_id;

			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO people (pid, name, avatar, privacy, credit) VALUES (?, ?, ?, 0, 0);');
			$avatar = DefaultImage::People;
			$stmt->bind_param('iss', $pid, $user, $avatar);
			$stmt->execute();
			$stmt->close();
			
			return self::sign_in($email, $pass);
		}
		
		// try to sign out
		public static function sign_out() {
			unset($_SESSION['auth']);
			session_unset();
			session_destroy();
			return 0;
		}
		
		// get uid
		public static function get_uid() {
			if (isset($_SESSION['auth'])) {
				return $_SESSION['auth']['uid'];
			}
			return 0;
		}

		// get email
		public static function get_email() {
			if (isset($_SESSION['auth'])) {
				return $_SESSION['auth']['email'];
			}
			return '';
		}
		
		// get auth class as array
		public static function get_auth_arr() {
			if (isset($_SESSION['auth'])) {
				$auth = $_SESSION['auth'];
				return $auth;
			}
			return array(
						 'uid'   => 0,
						 'user'  => 'Guest',
						 'email' => '',
						 'title' => '游客',
						 'alt'   => '游客',
						 'url'   => '',
						 'image' => 'upload/0/pudding_small.jpg'
			);
		}
	}
?>