<?php
	if(!defined('IN_ZUS')) {
		exit('<h1>403:Forbidden @util:trends.php</h1>');
	}
	
	class TrendsDAO {
		/*
		 --------------------------------
		   Core API
		 --------------------------------
		 */
		// !!! get trends list for people
		public static function get_trend_feed($pid, $page_id, $limit = 6)
		{
			$trend_feed = array();
			
			$feed_list = BoardDAO::get_feed_list_friend($pid, $page_id, 1, 0, $limit);

			$feed_list_trends = $feed_list["feed_list_large"];

			$n = sizeof($feed_list_trends);
			$i = 0;

			
			foreach ($feed_list_trends as $feed)
			{
				$trend_feed[$i]['title'] = '发表了新鲜事';
				$trend_feed[$i]['content'] = $feed['content'];
				$trend_feed[$i]['timestamp'] = $feed['timestamp'];

				$i++;
			}

			return $trend_feed;
		}


		public static function get_trend_event($pid, $tpid, $limit = 6, $start = 0)
		{
			$event_list = array();
			$event_id_list = EventDAO:: get_eid_list_people($tpid);
			$trend_event = array();

			$mysqli = MysqlInterface::get_connection();
			
			$n = sizeof($event_id_list);
			$i = 0;

			foreach($event_id_list as $eid)
			{
				$event = EventDAO::get_event_basic_eid($eid);

				$stmt = $mysqli->stmt_init();
				$stmt->prepare('SELECT mtime FROM people2event WHERE pid=? AND eid=? AND role>=? ORDER BY mtime DESC LIMIT 1000;');
				$role = Role::Member;
				$stmt->bind_param('iii', $tpid, $eid, $role);
				$stmt->execute();
				$result = $stmt->get_result();
				
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
				{
					$trend_event[$i]['title'] = '参加了活动';
					$trend_event[$i]['content'] = $event;
					$trend_event[$i]['timestamp'] = $row['mtime']; 
					
					$i++;
				}

				$stmt->close();
			}
			
			return $trend_event;
		}

		public static function get_trend_group($pid, $tpid, $limit = 6, $start = 0)
		{
			$group_list = array();
			$group_id_list = GroupDAO:: get_gid_list_people($tpid);
			$trend_group = array();

			$mysqli = MysqlInterface::get_connection();
			
			$n = sizeof($group_id_list);
			$i = 0;

			foreach($group_id_list as $gid)
			{
				$stmt = $mysqli->stmt_init();
				$group = GroupDAO::get_group_basic_gid($gid);

				$stmt->prepare('SELECT mtime FROM people2group WHERE pid=? AND gid=? AND role>=? ORDER BY mtime DESC LIMIT 1000;');
				$role = Role::Member;
				$stmt->bind_param('iii', $tpid, $gid, $role);
				$stmt->execute();
				$result = $stmt->get_result();
				
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
				{
					$trend_group[$i]['title'] = '参加了群组';
					$trend_group[$i]['content'] = $group;
					$trend_group[$i]['timestamp'] = $row['mtime']; 
					
					$i++;
				}

				$stmt->close();
			}

			return $trend_group;
		}

		public static function get_trend_relation($pid, $tpid, $limit = 6, $start = 0)
		{
			$trend_relation = array();

			$mutual_ids = self::get_mutual_friend_id_list($tpid);

			$n = sizeof($mutual_ids);
			$i = 0;

			foreach ($mutual_ids as $mutuals)
			{
				$people = PeopleDAO::get_people_basic_pid($mutuals['id']);
				
				$trend_relation[$i]['title'] = '成为了好友';
				$trend_relation[$i]['content'] = $people;
				$trend_relation[$i]['timestamp'] = $mutuals['timestamp'];

				$i++;
			}

			return $trend_relation;
		}

		public static function get_mutual_friend_id_list($pid, $limit = 6, $start = 0) 
		{
			//#0 default value
			$people_ids = array();
			$i = 0;
			$mutual = Relation::Friend;

			//#1 get people_ids and mtime
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pid2, mtime FROM people2people WHERE pid1=? AND relation=? ORDER BY mtime DESC LIMIT 1000;');
			$stmt->bind_param('ii', $pid, $mutual);
			$stmt->execute();
			$result = $stmt->get_result();			
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$people_ids[$i]['id'] = $row['pid2'];
				$people_ids[$i]['timestamp'] = $row['mtime'];

				$i++;
			}
			$stmt->close();

			return $people_ids;
		}

		public static function cmp($a, $b)
		{
			return strcmp($b["timestamp"], $a["timestamp"]);
		}


		public static function get_trend_sorted($pid, $tpid, $limit = 6)
		{
			$i = 0;
			$trend_unsorted = array();
			$trend_sorted = array();

			$trend_people_feed = self::get_trend_feed($pid, $tpid, $limit);
			$trend_people_event = self::get_trend_event($pid, $tpid, $limit);
			$trend_people_group = self::get_trend_group($pid, $tpid, $limit);
			$trend_people_relation = self::get_trend_relation($pid, $tpid, $limit);

			$trend_unsorted = array_merge($trend_unsorted, $trend_people_feed, $trend_people_event, $trend_people_group, $trend_people_relation);

			usort($trend_unsorted, "TrendsDAO::cmp");

			$trend_sorted = array_slice($trend_unsorted, 0, $limit);

			return $trend_sorted;
		}
		
	}	
?>
