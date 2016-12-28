<?php
	if(!defined('IN_NBRC')) {
		exit('<h1>403:Forbidden @util:board.php</h1>');
	}
	
	class BoardDAO {
		/*
		 --------------------------------
		   Core API
		 --------------------------------
		 */
		// !!! get feed list for any type
		public static function get_feed_list($pid, $page_type, $page_id, $tag_id = 0, $bd_start = 0, $bd_limit = 20, $cm_start = 0, $cm_limit = 3) {
			switch ($page_type) {
				case 'people':
					if ($pid == $page_id) {
						return self::get_feed_list_self($pid, $tag_id, $bd_start, $bd_limit, $cm_start, $cm_limit);
					}
					else {
						return self::get_feed_list_friend($pid, $page_id, $tag_id, $bd_start, $bd_limit, $cm_start, $cm_limit);
					}
				case 'group':
					return self::get_feed_list_group($pid, $page_id, $tag_id, $bd_start, $bd_limit, $cm_start, $cm_limit);
				case 'event':
					return self::get_feed_list_event($pid, $page_id, $tag_id, $bd_start, $bd_limit, $cm_start, $cm_limit);
				default:
					return;
			}
		}
		

		// !!! create a new feed by people
		public static function create_feed_people($pid, $feed, $target_group_id_list=array(), $target_event_id_list=array()) {

			if ($pid <= 0) {
				return 0;
			}
			
			// #1 create board
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO board (owner, content, image) VALUES (?, ?, ?)');
			$stmt->bind_param('iss', $pid, $feed['content'], $feed['image']);
			$stmt->execute();
			// get auto generated id
			$bid = $mysqli->insert_id;
			$stmt->close();

			// #2 post to owner's board
			$source = Role::Owner;
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO people2board (pid, bid, source) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE source=?;');
			$stmt->bind_param('iiii', $pid, $bid, $source, $source);
			$stmt->execute();
			$stmt->close();

			// #3 post to group's board
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO group2board (gid, bid, source) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE source=?;');
			foreach ($target_group_id_list as $tgid) {
				$source = PeopleDAO::get_group_role_pid($pid, $tgid);
				if ($source >= Role::Member) {
					$stmt->bind_param('iiii', $tgid, $bid, $source, $source);
				}
			}			
			$stmt->execute();
			$stmt->close();

			// #4 post to event's board
			$stmt = $mysqli->stmt_init(); 
			$stmt->prepare('INSERT INTO event2board (eid, bid, source) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE source=?;');
			foreach ($target_event_id_list as $teid) {
				$source = PeopleDAO::get_event_role_pid($pid, $teid);
				if ($source >= Role::Member) {
					$stmt->bind_param('iiii', $teid, $bid, $source, $source);
				}
			}
			$stmt->execute();
			$stmt->close();
			return $bid;
		}
		
		// !!! add a new comment to a feed
		public static function add_comment_people($bid, $pid, $comment, $gid = 0) {
			
			if ($pid <= 0 || strlen($comment) < 1) {
				return -1;
			}
			
			// #1 check permission
			if ($gid > 0 && PeopleDAO::get_group_role_pid($pid, $gid) < Role::Admin) {
				$gid = 0;
			}

			// #2 add comment
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO comment (bid, owner, gowner, text) VALUES (?, ?, ?, ?);');
			$stmt->bind_param('iiis', $bid, $pid, $gid, $comment);
			$stmt->execute();

			$cid = $mysqli->insert_id;
			$stmt->close();

			return $cid;
		}
		
		/*
		 --------------------------------
		   Getters by id
		 --------------------------------
		 */
		
		// get comment by cid
		public static function get_comment_cid($pid, $cid) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT owner, gowner, ctime, text FROM comment WHERE cid=? LIMIT 1;');
			$stmt->bind_param('i', $cid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$comment = array();
				if (isset($row['gowner']) && $row['gowner'] > 0 && PeopleDAO::get_group_role_pid($row['owner'], $row['gowner']) > Role::Admin) {
					$comment['owner'] = GroupDAO::get_group_basic_gid($row['gowner']);
				}
				else {
					$comment['owner'] = PeopleDAO::get_people_basic_pid($row['owner']);
				}
				$comment['content'] = strip_tags($row['text']);
				$comment['timestamp'] = $row['ctime'];
				return $comment;
			}
			return '';
		}
		
		// get comment list by bid
		public static function get_comment_list_bid($pid, $bid, $limit = 3, $start = 0) {
			
			// #1 default value
			$comments = array(
							  'comment' => array(), 
							  'func'    => array(
												 'reply' => 'reply_to('.$pid.','.$bid.')',
												 'more'  => ''
												 )
							  );

			if ($pid <= 0) {
				$comments['func']['reply'] = '';
			}
			

			// #2 get comment list
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT cid, owner, gowner, ctime, text FROM comment WHERE bid=? ORDER BY cid DESC LIMIT ?,?;');
			$limit_plus = $limit + 1;
			$stmt->bind_param('iii', $bid, $start, $limit_plus);
			$stmt->execute();
			$result = $stmt->get_result();
			$count = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$count ++;
				if ($count > $limit) {
					$next = $start + $limit;
					$comments['func']['more'] = 'showMoreComment('.$bid.',6,'.$next.')';
					break;
				}
				$comment = array();
				if (isset($row['gowner']) && $row['gowner'] > 0 && PeopleDAO::get_group_role_pid($row['owner'], $row['gowner']) > Role::Admin) {
					$comment['owner'] = GroupDAO::get_group_basic_gid($row['gowner']);
				}
				else {
					$comment['owner'] = PeopleDAO::get_people_basic_pid($row['owner']);
				}
				$comment['content'] = strip_tags($row['text']);
				$comment['timestamp'] = $row['ctime'];
				array_push($comments['comment'], $comment);
			}
			$comments['comment'] = array_reverse($comments['comment']);
			return $comments;
		}
		
		// get one feed by bid
		public static function get_feed_bid($pid, $bid, $cm_limit = 3, $cm_start = 0) {
			
			// #1 default value
			$board = array(
						   'id'        => $bid,
						   'owner'     => array(),
						   'comments'  => array(),
						   'score'     => '',
						   'content'   => '',
						   'image'     => array(
												'url'   => '',
												'alt'   => '',
												'title' => ''
												),
						   'timestamp' => '',
						   'func'      => array(
												'reply' => '',
												'more'  => ''
												),
						   'isarticle' => false
						   );
			
			// #2 get feed details
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT owner, gowner, content, ctime, image, privacy, isarticle FROM board WHERE bid=? LIMIT 1;');
			$stmt->bind_param('i', $bid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (isset($row['gowner']) && $row['gowner'] > 0) {
					$gid = $row['gowner'];
					$role = PeopleDAO::get_group_role_pid($pid, $gid);
					if ($role < $row['privacy']) {
						$stmt->close();
						return $board;
					}
					$p_role = PeopleDAO::get_group_role_pid($row['owner'], $gid);
					if ($p_role >= Role::Admin) {
						$board['owner'] = GroupDAO::get_group_basic_gid($row['gowner']);
					}
					else {
						$board['owner'] = PeopleDAO::get_people_basic_pid($row['owner']);
					}
				}
				else {
					$tpid = $row['owner'];
					$role = PeopleDAO::get_people_role_pid($pid, $tpid);
					if ($role < $row['privacy']) {
						$stmt->close();
						return $board;
					}
					$board['owner'] = PeopleDAO::get_people_basic_pid($row['owner']);
				}
				$board['comments'] = self::get_comment_list_bid($pid, $bid, $cm_limit, $cm_start);
				$board['content']  = strip_tags($row['content']);
				if (empty($board['content'])) {
					$board['content'] = '无题';
				}
				if ($row['isarticle']) {
					$board['isarticle'] = true;
					// $board['content']  = '发表了文章'.'<a herf="#" onclick="update_feed_tag(0,'.$bid.',\'article\')">《'.$board['content'].'》</a>';
					$board['content']  = '发表了文章'.'<a href="../information/detail.php?arid='. $bid .'">《'.$board['content'].'》</a>';
				}
				if (!empty($row['image'])) {
					$board['image']['url'] = $row['image'].'_large.jpg';
				}
				$board['timestamp'] = strip_tags($row['ctime']);
				$board['func'] = $board['comments']['func'];
			}
			$stmt->close();
			return $board;
		}
		
		public static function get_board_gowner_id($bid) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT gowner FROM board WHERE bid=? LIMIT 1;');
			$stmt->bind_param('i', $bid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				return $row['gowner'];
			}
			return 0;
		}
		
		/*
		 --------------------------------
  		   Setters
		 --------------------------------
		 */
		
		/*
		 --------------------------------
		   Get id list by foreign key
		 --------------------------------
		 */
		// get bid list for people
		public static function get_bid_list_people($pid, $limit = 1000) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			//$stmt->prepare('SELECT bid FROM people2board WHERE pid=? ORDER BY bid DESC LIMIT ?');
			$stmt->prepare('SELECT bid, privacy FROM people2board WHERE privacy<'. Privacy::NonExist .' AND pid=? ORDER BY bid DESC LIMIT ?');
			$stmt->bind_param('ii', $pid, $limit);
			$stmt->execute();
			$result = $stmt->get_result();
			$board_ids = array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($board_ids, $row['bid']);
			}
			return $board_ids;
		}
		
		// get bid list for group
		public static function get_bid_list_group($gid, $role = -1, $limit = 1000) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			if ($role >= 0) {
				$stmt->prepare('SELECT bid FROM group2board WHERE gid=? AND source=? ORDER BY bid DESC LIMIT ?;');
				$stmt->bind_param('iii', $gid, $role, $limit);
			}
			else {
				$stmt->prepare('SELECT bid FROM group2board WHERE gid=? ORDER BY bid DESC LIMIT ?;');
				$stmt->bind_param('ii', $gid, $limit);
			}
			$stmt->execute();
			$result = $stmt->get_result();
			$board_ids = array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($board_ids, $row['bid']);
			}
			return $board_ids;
		}
		
		// get bid list for event
		public static function get_bid_list_event($eid, $role = -1, $limit = 1000) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			if ($role >= 0) {
				$stmt->prepare('SELECT bid FROM event2board WHERE eid=? AND source=? ORDER BY bid DESC LIMIT ?;');
				$stmt->bind_param('iii', $eid, $role, $limit);
			}
			else {
				$stmt->prepare('SELECT bid FROM event2board WHERE eid=? ORDER BY bid DESC LIMIT ?;');
				$stmt->bind_param('ii', $eid, $limit);
			}
			$stmt->execute();
			$result = $stmt->get_result();
			$board_ids = array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($board_ids, $row['bid']);
			}
			return $board_ids;
		}
		
		/*
		 --------------------------------
		   Non-Public Functions
		 --------------------------------
		 */
		// get feed list for self page
		protected static function get_feed_list_self($pid, $tag_id = 0, $bd_start = 0, $bd_limit = 20, $cm_start = 0, $cm_limit = 3) {
			$people_feed = array();
			
			// #1 generate tag_list
			$people_feed['add_feed'] = array(
											 'action' => 'add_feed('.$pid.','.$pid.',\'people\')',
											 'class'  => 'add_feed',
											 'title'  => '发表新鲜事'
			);
			$people_feed['tag_list'] = array();
			$people_feed['tag_list'][0] = array(
												'class'  => 'off',
												'title'  => '全部',
												'action' => 'update_feed_tag(0,'.$pid.',\'people\')'
												);
			
			$people_feed['tag_list'][1] = array(
												'class'  => 'off',
												'title'  => '好友',
												'action' => 'update_feed_tag(1,'.$pid.',\'people\')'
												);
			
			$people_feed['tag_list'][2] = array(
												'class'  => 'off',
												'title'  => '群组',
												'action' => 'update_feed_tag(2,'.$pid.',\'people\')'
												);
			$people_feed['tag_list'][3] = array(
												'class'  => 'off',
												'title'  => '活动',
												'action' => 'update_feed_tag(3,'.$pid.',\'people\')'
												);
			
			$people_feed['tag_list'][4] = array(
												'class'  => 'off',
												'title'  => '个人',
												'action' => 'update_feed_tag(4,'.$pid.',\'people\')'
												);
			$people_feed['tag_list'][$tag_id]['class'] = 'on';
			// #2 generate feed board id list
			$feed_id_list = array();
			if ($tag_id == 0 || $tag_id == 1) {
				$friend_ids = PeopleDAO::get_friend_id_list_people($pid);
				foreach ($friend_ids as $fid) {
					$board_ids = BoardDAO::get_bid_list_people($fid, $bd_limit);
					$feed_id_list = array_merge($feed_id_list, $board_ids);
				}
			}
			if ($tag_id == 0 || $tag_id == 2) {
				$group_ids = GroupDAO::get_gid_list_people($pid);
				foreach ($group_ids as $gid) {
					$board_ids = BoardDAO::get_bid_list_group($gid, $bd_limit);
					$feed_id_list = array_merge($feed_id_list, $board_ids);
				}
			}
			if ($tag_id == 0 || $tag_id == 3) {
				$event_ids = EventDAO::get_eid_list_people($pid);
				foreach ($event_ids as $eid) {
					$board_ids = BoardDAO::get_bid_list_event($eid, $bd_limit);
					$feed_id_list = array_merge($feed_id_list, $board_ids);
				}
			}
			if ($tag_id == 0 || $tag_id == 4) {
				$board_ids = BoardDAO::get_bid_list_people($pid, $bd_limit);
				$feed_id_list = array_merge($feed_id_list, $board_ids);
			}
			arsort($feed_id_list);
			$people_feed['next'] = '';
			if (sizeof($feed_id_list) > $bd_start+$bd_limit) {
				$people_feed['next'] = $bd_start+$bd_limit;				
			}
			$feed_id_list = array_slice($feed_id_list, $bd_start, $bd_limit);
			
			// #3 fill entity with feed ids
			$feed = array();
			foreach ($feed_id_list as $feed_id) {
				$board = BoardDAO::get_feed_bid($pid, $feed_id, $cm_limit, $cm_start);
				array_push($feed, $board);
			}
			
			$people_feed['feed_list_large'] = $feed;
			return $people_feed;
		}
		
		// get feed list for friend's page
		public static function get_feed_list_friend($pid, $page_id, $tag_id = 0, $bd_start = 0, $bd_limit = 20, $cm_start = 0, $cm_limit = 3) {
			$people_feed = array();

			/*+++++在好友页面留言!!+++++*/
			$people_feed['add_feed'] = array(
											 'action' => 'add_feed('.$pid.','.$page_id.',\'people\')',
											 'class'  => 'add_feed',
											 'title'  => '发表留言'
			);
			/*=====在好友页面留言!!=====*/
			
			// #1 generate tag_list
			$people_feed['tag_list'] = array();
			$people_feed['tag_list'][0] = array(
												'class'  => 'off',
												'title'  => '全部',
												'action' => 'update_feed_tag(0,'.$page_id.',\'people\')'
												);
			$people_feed['tag_list'][1] = array(
												'class'  => 'off',
												'title'  => '好友',
												'action' => 'update_feed_tag(1,'.$page_id.',\'people\')'
												);
			$people_feed['tag_list'][$tag_id]['class'] = 'on';			
			// #2 generate feed board id list
			$feed_id_list = array();
			if ($tag_id == 0 || $tag_id == 1) {
				$board_ids = BoardDAO::get_bid_list_people($page_id);
				$feed_id_list = array_merge($feed_id_list, $board_ids);
			}
			arsort($feed_id_list);
			$people_feed['next'] = '';
			if (sizeof($feed_id_list) > $bd_start+$bd_limit) {
				$people_feed['next'] = $bd_start+$bd_limit;				
			}
			$feed_id_list = array_slice($feed_id_list, $bd_start, $bd_limit);
			
			// #3 fill entity with feed ids
			$feed = array();
			foreach ($feed_id_list as $feed_id) {
				$board = BoardDAO::get_feed_bid($pid, $feed_id, $cm_limit, $cm_start);
				array_push($feed, $board);
			}
			
			$people_feed['feed_list_large'] = $feed;
			return $people_feed;
		}
		
		// get feed list for group page
		protected static function get_feed_list_group($pid, $page_id, $tag_id = 0, $bd_start = 0, $bd_limit = 20, $cm_start = 0, $cm_limit = 3) {
			$group_feed = array();
			
			// #1 generate tag_list
			$role = PeopleDAO::get_group_role_pid($pid, $page_id);
			if ($role >= Role::Member) {
			$group_feed['add_feed'] = array(
											 'action' => 'add_feed('.$pid.','.$page_id.',\'group\')',
											 'class'  => 'add_feed',
											 'title'  => '发表新鲜事'
											 );
			}
			
			$group_feed['tag_list'] = array();
			$group_feed['tag_list'][0] = array(
												'class'  => 'off',
												'title'  => '全部',
												'action' => 'update_feed_tag(0,'.$page_id.',\'group\')'
												);
			$group_feed['tag_list'][1] = array(
												'class'  => 'off',
												'title'  => '群公告',
												'action' => 'update_feed_tag(1,'.$page_id.',\'group\')'
												);
			
			$group_feed['tag_list'][2] = array(
												'class'  => 'off',
												'title'  => '成员分享',
												'action' => 'update_feed_tag(2,'.$page_id.',\'group\')'
												);
			$group_feed['tag_list'][3] = array(
											   'class'  => 'off',
											   'title'  => '文章列表',
											   'action' => 'update_feed_tag(3,'.$page_id.',\'group\')'
											   );
			$group_feed['tag_list'][$tag_id]['class'] = 'on';
			
			// #2 generate feed board id list
			$feed_id_list = array();
			if ($tag_id == 0 || $tag_id == 1 || $tag_id == 3) {
				$role = Role::Owner;
				$board_ids = BoardDAO::get_bid_list_group($page_id, $role);
				$feed_id_list = array_merge($feed_id_list, $board_ids);
				$role = Role::Admin;
				$board_ids = BoardDAO::get_bid_list_group($page_id, $role);
				$feed_id_list = array_merge($feed_id_list, $board_ids);
			}
			if ($tag_id == 0 || $tag_id == 2|| $tag_id == 3) {
				$role = Role::Member;
				$board_ids = BoardDAO::get_bid_list_group($page_id, $role);
				$feed_id_list = array_merge($feed_id_list, $board_ids);
			}
			arsort($feed_id_list);
			$group_feed['next'] = '';
			if (sizeof($feed_id_list) > $bd_start+$bd_limit) {
				$group_feed['next'] = $bd_start+$bd_limit;				
			}
			$feed_id_list = array_slice($feed_id_list, $bd_start, $bd_limit);
			
			// #3 fill entity with feed ids
			$feed = array();
			foreach ($feed_id_list as $feed_id) {
				$board = BoardDAO::get_feed_bid($pid, $feed_id, $cm_limit, $cm_start);
				if ($tag_id != 3 || $board['isarticle']) {
					array_push($feed, $board);
				}
			}
			
			$group_feed['feed_list_large'] = $feed;
			return $group_feed;
		}
		
		// get feed list for event page
		protected static function get_feed_list_event($pid, $page_id, $tag_id = 0, $bd_start = 0, $bd_limit = 20, $cm_start = 0, $cm_limit = 3) {
			$event_feed = array();
			
			// #1 generate tag_list
			$role = PeopleDAO::get_event_role_pid($pid, $page_id);
			if ($role >= Role::Member) {
				$event_feed['add_feed'] = array(
												 'action' => 'add_feed('.$pid.','.$page_id.',\'event\')',
												 'class'  => 'add_feed',
												 'title'  => '发表新鲜事'
												 );
			}
			
			$event_feed['tag_list'] = array();
			$event_feed['tag_list'][0] = array(
											   'class'  => 'off',
											   'title'  => '全部',
											   'action' => 'update_feed_tag(0,'.$page_id.',\'event\')'
											   );
			$event_feed['tag_list'][1] = array(
											   'class'  => 'off',
											   'title'  => '活动公告',
											   'action' => 'update_feed_tag(1,'.$page_id.',\'event\')'
											   );
			$event_feed['tag_list'][2] = array(
											   'class'  => 'off',
											   'title'  => '成员分享',
											   'action' => 'update_feed_tag(2,'.$page_id.',\'event\')'
											   );			
			$event_feed['tag_list'][$tag_id]['class'] = 'on';
			$event_feed['db_tag_id'] = $tag_id;
			// #2 generate feed board id list
			$feed_id_list = array();
			if ($tag_id == 0 || $tag_id == 1) 
			{
				$role = Role::Owner;
				$board_ids = BoardDAO::get_bid_list_event($page_id, $role);
				$feed_id_list = array_merge($feed_id_list, $board_ids);
				$role = Role::Admin;
				$board_ids = BoardDAO::get_bid_list_event($page_id, $role);
				$feed_id_list = array_merge($feed_id_list, $board_ids);
			}
			if ($tag_id == 0 || $tag_id == 2) 
			{
				$role = Role::Member;
				$board_ids = BoardDAO::get_bid_list_event($page_id, $role);
				$feed_id_list = array_merge($feed_id_list, $board_ids);
			}
			arsort($feed_id_list);
			$event_feed['next'] = '';
			if (sizeof($feed_id_list) > $bd_start+$bd_limit) {
				$event_feed['next'] = $bd_start+$bd_limit;				
			}
			$feed_id_list = array_slice($feed_id_list, $bd_start, $bd_limit);
			
			// #3 fill entity with feed ids
			$feed = array();
			foreach ($feed_id_list as $feed_id) {
				$board = BoardDAO::get_feed_bid($pid, $feed_id, $cm_limit, $cm_start);
				array_push($feed, $board);
			}
			
			$event_feed['feed_list_large'] = $feed;
			return $event_feed;
		}
		
	}	
	?>
