<?php
	if(!defined('IN_ZUS')) {
		exit('<h1>403:Forbidden @util:mysql.php</h1>');
	}

	// Mysql Interface, for connect to database
	class MysqlInterface {
		protected static $_connection;
		
		// get connection
		public static function get_connection() {
			if (empty(self::$_connection)) {
				global $_SCONFIG;
				self::$_connection = new mysqli($_SCONFIG['mysql_host'], $_SCONFIG['mysql_user'], $_SCONFIG['mysql_pass'], $_SCONFIG['mysql_database']);
				$error = self::$_connection->connect_errno;
				while ($error) {
					time_nanosleep(0, 10000000); // 1/100 second
					self::$_connection = new mysqli($_SCONFIG['mysql_host'], $_SCONFIG['mysql_user'], $_SCONFIG['mysql_pass'], $_SCONFIG['mysql_database']);
					$error = self::$_connection->connect_errno;
				}
				self::$_connection->set_charset($_SCONFIG['mysql_charset']);
			}
			return self::$_connection;
		}
	}
?>