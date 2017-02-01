<?php
/*~ NBRC RUNDAO
.---------------------------------------------------------------------------.
|  function: Search - PHP class                                             |
|   Version: 0.0.1                                                          |
|      Site: http://newbeerunningclub.org                                   |
| ------------------------------------------------------------------------- |
|     Admin: Sean Yi                              						    |
|   Authors: Sean Yi                                                        |
'---------------------------------------------------------------------------'
*/
?>
<?php
	if(!defined('IN_NBRC'))
	{
		exit('<h1>403:Forbidden @util:runnewbee.php</h1>');
	}

	class RunDAO 
	{
			/*
			 --------------------------------
			   Core API
			 --------------------------------
			 */

		/* (0) get  */

		public static function get_run_nav_tab_list($pid)
		{
			$nav_tabs = array();

			$tab = "按天数排名";
			array_push($nav_tabs, $tab);

			$tab = "按距离排名";
			array_push($nav_tabs, $tab);

			$tab = "打卡";
			array_push($nav_tabs, $tab);

			return $nav_tabs;
		}

		public static function get_curMorningrun_eid()
		{
			//return 155;	// January
			return 162;	// Febuary
		}

		public static function get_rcid_list_people($mode = 0, $pid = 0, $limit = 5)
		{
			if ( $pid != 0 )
			{
				$running_cards = array();
				$mysqli = MysqlInterface::get_connection();
				$stmt = $mysqli->stmt_init();
				$stmt->prepare('SELECT rcid, pid, privacy FROM people2running WHERE $pid = ? privacy <'. Privacy::NonExist .' AND date_format(rctime, "%Y%m") = date_format(curdate(), "%Y%m") ORDER BY rctime DESC LIMIT 1000;');
				$stmt->bind_param('i', $pid);
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$card = array();
					$card['rcid'] = $row['rcid'];
					$card['owner'] = $row['pid']; 
					array_push($running_cards, $card);
				}
				$stmt->close();

				return $running_cards;
			}
			// pid = 0, Mode = 0 : 默认查询所有人当月卡, limit 限制显示数量
			$running_cards = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			// * 上月数据: 
			//$stmt->prepare('SELECT rcid, pid, privacy FROM people2running WHERE privacy <'. Privacy::NonExist .' AND date_format(rctime, "%Y%m") = date_format(DATE_SUB(curdate(), INTERVAL 1 MONTH), "%Y%m") ORDER BY rctime DESC LIMIT 1000;');
			
			// * 当月数据
			$stmt->prepare('SELECT rcid, pid, privacy FROM people2running WHERE privacy <'. Privacy::NonExist .' AND date_format(rctime, "%Y%m") = date_format(curdate(), "%Y%m") ORDER BY rctime DESC LIMIT 1000;');
			//$stmt->bind_param('ii', $pid, $role);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$card = array();
				$card['rcid'] = $row['rcid'];
				$card['owner'] = $row['pid']; 
				array_push($running_cards, $card);
			}
			$stmt->close();

			return $running_cards;
		}

		public static function get_running_rcid($rcid, $mode = 0)
		{
			$running_cards = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT owner, distance, image, rctime FROM runningcard WHERE rcid = ? AND privacy <'. Privacy::NonExist .' LIMIT 1;');
			$stmt->bind_param('i', $rcid);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$card = array();
				$card['owner'] = $row['owner'];
				$card['distance'] = $row['distance'];
				$card['day'] = date('d', strtotime($row[rctime]));
				if (!empty($row['image'])) {
					$card['image'] = $row['image'].'_large.jpg';
				}
				else {
					$card['image'] = DefaultImage::Runcard.'.jpg';
				}
				$running_cards = $card;
			}
			$stmt->close();

			return $running_cards;
		}

		public static function getcurmonthdays($pid)
		{
			if ( $pid < 0 )
			{
				return -1;
			}
			$day = 0;
			$rank_list = self::get_rank_list();
			foreach( $rank_list as $key => $value )
			{
				if ( $value['owner'] == $pid )
				{
					$day = $value['days'];
					break;
				}
			}

			return $day;
		}
		/*= (0) get =*/

		/* + (1) Calculate + */
		public static function get_rank_list($mode = 0)	/*default current month ranking*/
		{
			$countsss = 1;
			$rank_list = array();			
			$card_list_people = self::get_rcid_list_people($mode);
			$cards_detail = array();

			foreach ($card_list_people as $card) 
			{
				$card_info = self::get_running_rcid($card['rcid']);
				
				array_push($cards_detail, $card_info);
			}

			$rank_test_list = array();

			foreach ( $cards_detail as $cards )
			{
				$rankcount = 1;	// if not added;

				$rank_test_list = $rank_list;

				foreach( $rank_list as $key => $ranks )
				{
					if ( $ranks['owner']  == $cards['owner'] )	// adds already 
					{
						$addday = 1;

						foreach( $ranks['daylist'] as $rankday )
						{
							if ( $rankday == $cards['day'] ) //	already has this day
							{
								$addday = 0;				// no adding days;
								break;
							}
						}

						if ( $addday == 1 )
						{
							$rank_test_list[$key]['days'] += 1;
							array_push($rank_test_list[$key]['daylist'], $cards['day']);
						}

						$rank_test_list[$key]['distance']  = $rank_test_list[$key]['distance'] + $cards['distance'];
						$rankcount = 0;				//already added;
						break;
					}
				}

				if ( $rankcount == 1 )	// no adding before
				{
					$rank_new = array();
					$rank_new['owner'] = $cards['owner'];
					$rank_new['ownerinfo'] = array();
					$rank_new['ownerinfo'] = PeopleDAO::get_people_basic_pid($cards['owner']);
					$rank_new['distance'] = $cards['distance'];
					$rank_new['daylist'] = array();
					array_push($rank_new['daylist'], $cards['day']);
					$rank_new['days'] = 1;
					array_push($rank_list, $rank_new);
				}

				if ( $rankcount == 0 )
				{
					$rank_list = $rank_test_list;
				}
				
				$countsss += 1;
			}

			return $rank_list;
		}

		public static function get_sorted_rank_list($mode = 0, $sortfunc = 0)
		{
			$unsorted_list = self::get_rank_list($mode);
			
			$len = count($unsorted_list);

			for ( $i = 0; $i < $len - 1; $i++ )
			{
				$tmpkey = $i;
				for ( $j = $i + 1; $j < $len; $j++ )
				{
					if ( $sortfunc == 0 )
					{
						if ( $unsorted_list[$j]['days'] > $unsorted_list[$tmpkey]['days'] )
						{
							$tmpkey = $j;
						}
						else if ( $unsorted_list[$j]['days'] == $unsorted_list[$tmpkey]['days'] )
						{
							if ( $unsorted_list[$j]['distance'] > $unsorted_list[$tmpkey]['distance'] )
							{
								$tmpkey = $j;
							}
						}
					}
					else if ( $sortfunc == 1 )
					{
						if ( $unsorted_list[$j]['distance'] > $unsorted_list[$tmpkey]['distance'] )
						{
							$tmpkey = $j;
						}
						else if ( $unsorted_list[$j]['distance'] == $unsorted_list[$tmpkey]['distance'] )
						{
							if ( $unsorted_list[$j]['days'] > $unsorted_list[$tmpkey]['days'] )
							{
								$tmpkey = $j;
							}
						}
					}
				}
				if ( $tmpkey != $i )
				{
					$tmp = $unsorted_list[$tmpkey];
					$unsorted_list[$tmpkey] = $unsorted_list[$i];
					$unsorted_list[$i] = $tmp;
				}
			}

			return $unsorted_list;
		}

		public static function get_raunTotal_list()
		{
			$rundata = RunDAO::get_sorted_rank_list();
			$runTotal = array();
			$runTotal['days'] = 0;
			$runTotal['distance'] = 0.0;
			foreach ( $rundata as $key => $runvalue )
			{
				$runTotal['days'] = $runTotal['days'] + $runvalue['days'];
				$runTotal['distance'] = $runTotal['distance'] + $runvalue['distance'];
			}

			return $runTotal;
		}

		/* = (1) Calculate = */

		/* + (2) Create + */
		public static function create_runcard($pid, $card) 
		{	
			if ($pid <= 0) {
				return 0;
			}
			$mysqli = MysqlInterface::get_connection();
			
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO runningcard (owner, eowner, distance, image, description) VALUES (?, ?, ?, ?, ?);');
			$stmt->bind_param('iidss', $pid, $card['eowner'], $card['distance'], $card['image'], $card['description']);
			$stmt->execute();
			
			// get auto generated id
			$rcid = $mysqli->insert_id;
			
			$stmt->close();
			
			// insert to people2running and event2running table

			if ( $rcid > 0 )
			{
				self:: updaterctime($rcid);
				$rctime = self::getrctime($rcid);
				self::insertpeoplerun($pid, $rcid, $rctime);
				self::inserteventrun($card['eowner'], $rcid, $rctime);
			}
			
			return $rcid;
		}

		public static function updaterctime($rcid)
		{
			$mysqli = MysqlInterface::get_connection();
			
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE runningcard SET rctime = updatetime where rcid = ?;');
			$stmt->bind_param('i', $rcid);
			$stmt->execute();
			$stmt->close();
		}

		public static function getrctime($rcid)
		{
			$rctime = '';
			$mysqli = MysqlInterface::get_connection();
			
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT rctime from runningcard where rcid = ? LIMIT 1;');
			$stmt->bind_param('i', $rcid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$rctime = $row['rctime'];
			}

			$stmt->close();

			return $rctime;
		}

		public static function insertpeoplerun($pid, $rcid, $rctime)
		{
			$mysqli = MysqlInterface::get_connection();
			
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO people2running (pid, rcid, rctime) VALUES (?, ?, ?);');
			$stmt->bind_param('iis', $pid, $rcid, $rctime);
			$stmt->execute();
			
			$stmt->close();
		}

		public static function inserteventrun($eowner, $rcid, $rctime)
		{
			$mysqli = MysqlInterface::get_connection();
			
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO event2running (eid, rcid, rctime) VALUES (?, ?, ?);');
			$stmt->bind_param('iis', $eowner, $rcid, $rctime);
			$stmt->execute();
			
			$stmt->close();
		}

		// set group logo by id
		public static function set_runcard_image_rcid($rcid, $image)
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE runningcard SET image=? WHERE rcid=?;');
			$stmt->bind_param('si', $image, $rcid);
			$stmt->execute();
			$stmt->close();
			return 0;
		}

		/* = (3) Create = */

		/*++++++++++++++++++++++++++++++ (0) PHP time functions ++++++++++++++++++++++++++++++*/
		/*
		Sql语句: 查询数据
		当日: select * from `article` where to_days(`add_time`) = to_days(now());
		昨日：select * from `article` where to_days(now()) – to_days(`add_time`) <= 1;
		近7天: select * from `article` where date_sub(curdate(), INTERVAL 7 DAY) <= date(`add_time`);
		近30天: select * from `article` where date_sub(curdate(), INTERVAL 30 DAY) <= date(`add_time`);
		本月: select * from `article` where date_format(`add_time`, ‘%Y%m') = date_format(curdate() , ‘%Y%m');
		上月: select * from `article` where period_diff(date_format(now() , ‘%Y%m') , date_format(`add_time`, ‘%Y%m')) =1;
		*/
		public static function getthemonth($date)
		{   
		    $firstday = date('Y-m-01', strtotime($date));
		    $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
		    return array($firstday,$lastday);
		} 


		public static function getCurMonthFirstDay($date)
		{
	   		return date('Y-m-01', strtotime($date));
		}

		public static function getCurMonthLastDay($date)
		{
	    	return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month -1 day'));
		}

		public static function getLastMonthLastDay($date)
		{
	    	return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' -0 month -1 day'));
		}

		public static function getNextMonthFirstDay($date)
		{
	    	return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month'));
		}

		public static function getNextMonthLastDay($date)
		{
		    return date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +2 month -1 day'));
		}

		public static function get_time_function()
		{
			date_default_timezone_set('America/New_York');
			$twoyearlater = date("Y-m-d H:i:s", strtotime(" +2 year"));
			$twomonthlater = date("Y-m-d H:i:s", strtotime(" +2 month"));
			$twoweeklater = date("Y-m-d H:i:s", strtotime(" +2 week"));
			$twodaylater = date("Y-m-d H:i:s", strtotime(" +2 day"));
			$twohoudlater = date("Y-m-d H:i:s", strtotime(" +2 hour"));
			$twominutelater = date("Y-m-d H:i:s", strtotime(" +2 minute"));
			$twosecondlater = date("Y-m-d H:i:s", strtotime(" +2 second"));
			$now = date("Ymd",strtotime("now"));
			echo date("Ymd",strtotime("-1 week Monday")), "n<br>";
			echo date("Ymd",strtotime("-1 week Sunday")), "n<br>";
			echo date("Ymd",strtotime("+0 week Monday")), "n<br>";
			echo date("Ymd",strtotime("+0 week Sunday")), "n<br>";
			echo "<br>*********第几个月:";
			echo date('n');
			echo "<br>*********本周周几:";
			echo date("w");
			echo "<br>*********本月天数:";
			echo date("t");
			echo "<br>*********";
			echo '<br>今天:<br>';
			echo date("Y-m-d H:i:s",mktime(0, 0, 0, date("m"), date("d"), date("Y"))),"n";
			echo date("Y-m-d H:i:s",mktime(23,59,59, date("m"), date("d"), date("Y"))),"n";
			echo '<br>上周:<br>';
			echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"))),"n";
			echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y"))),"n";
			echo '<br>本周:<br>';
			echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"))),"n";
			echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))),"n";
			echo '<br>上月:<br>';
			echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m")-1,1,date("Y"))),"n";
			echo date("Y-m-d H:i:s",mktime(23,59,59,date("m") ,0,date("Y"))),"n";
			echo '<br>本月:<br>';
			echo date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y"))),"n";
			echo date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y"))),"n";
			$season = ceil((date('n'))/3);//当月是第几季度
			echo '<br>本季度:<br>';
			echo date('Y-m-d H:i:s', mktime(0, 0, 0,$season*3-3+1,1,date('Y'))),"n";
			echo date('Y-m-d H:i:s', mktime(23,59,59,$season*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y"))),date('Y'))),"n";
			$season = ceil((date('n'))/3)-1;//上季度是第几季度
			echo '<br>上季度:<br>';
			echo date('Y-m-d H:i:s', mktime(0, 0, 0,$season*3-3+1,1,date('Y'))),"n";
			echo date('Y-m-d H:i:s', mktime(23,59,59,$season*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y"))),date('Y'))),"n";

			$x = date("Y-m-d H:i:s", strtotime(" +2 minute"));
			$y = date("Y-m-d H:i:s", strtotime("now"));
			$m = strtotime(" +2 minute");
			$n = strtotime("now");
			echo "<br>x: ", $x, " y: ", $y, "<br>";
			if ( x < y )
			{
				echo "Hello World!";
			}

			$now = time();
			$nowdate = date("Y-m-d", $now);
			$test = RunDAO::getcurMonthFirstDay($nowdate);
			echo $test;
			echo strtotime("now"), "\n";
			echo strtotime("10 September 2000"), "\n";
			echo strtotime("+1 day"), "\n";
			echo strtotime("+1 week"), "\n";
			echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n";
			echo strtotime("next Thursday"), "\n";
			echo strtotime("last Monday"), "\n";
		}

		/*============================== (0) PHP time functions ==============================*/

	}
?>