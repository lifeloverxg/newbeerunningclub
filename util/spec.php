<?php
	if(!defined('IN_NBRC'))
	{
		exit('<h1>403:Forbidden @util:spec.php</h1>');
	}

	class NycOne
	{
		public static function get_feed_list()
		{
			$feed_list = array();
			$id = 1;

			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT user, event, groupname, feed, ctime FROM nycone ORDER BY ctime DESC LIMIT 1000;');
//			$stmt->bind_param('i', $id);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$feed['user'] = $row['user'];
				$feed['event'] = $row['event'];
				$feed['group'] = $row['groupname'];
				$feed['feed'] = $row['feed'];
				$feed['ctime'] = $row['ctime'];

				array_push($feed_list, $feed);
			}

			$stmt->close();

			return $feed_list;
		}

		public static function insert_feed_list($feed)
		{
			$mysqli = MysqlInterface::get_connection();
			
			// insert event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO nycone (user, event, groupname, feed) VALUES (?, ?, ?, ?);');
			$stmt->bind_param('ssss', $feed['username'], $feed['event'], $feed['group'], $feed['feed']);
			$stmt->execute();
			
			// get auto generated id
			$id = $mysqli->insert_id;
			
			return $id;
			$stmt->close();
		}
	}
?>