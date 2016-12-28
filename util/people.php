<?php
	if(!defined('IN_ZUS')) {
		exit('<h1>403:Forbidden @util:people.php</h1>');
	}
	
	class PeopleDAO {
		/*
		 --------------------------------
		   Core API
		 --------------------------------
		 */
		// #ContentLeft
		// !!! [CL1] get people logo for people page
		public static function get_people_logo($pid, $tpid) {
			// #1 default value
			$people_logo = array(
								'image'   => DefaultImage::People.'_large.jpg',
								'alt'     => '',
								'title'   => '',
								'qr_code' => DefaultImage::QR,
								'edit'    => '',
								'url'     => ''
								);
			
			// #2 get logo
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT avatar, name FROM people WHERE pid=? LIMIT 1;');
			$stmt->bind_param('i', $tpid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (!empty($row['avatar'])) {
					$people_logo['image'] = $row['avatar'].'_large.jpg';
				}
				$people_logo['alt']     = strip_tags($row['name']);
				$people_logo['title']   = strip_tags($row['name']);
				$people_logo['qr_code'] = QRCodeDAO::get_qr_code_people($tpid);
				$people_logo['url']     = QRCodeDAO::get_url_people($tpid);
			}
			$stmt->close();
			
			// #3 check edit
			if ($pid == $tpid)
			{
				if ( Mobile_Detect::deviceType() == 'phone' )
				{
					$people_logo['edit'] = 'window.location=\'logo_original.php?id='.$tpid.'\'';
				}
				else
				{
					// $people_logo['edit'] = 'window.location=\'logo.php?pid='.$tpid.'\'';
					$people_logo['edit'] = 'window.location=\'logo_original.php?id='.$tpid.'\'';
				}
			}
			return $people_logo;
		}
		
		// !!! [CL2] get people operation buttons for people page
		public static function get_people_oper_button_list($pid, $tpid) {
			// #1 default value
			$oper_button = array(
								 'large' => array(),
								 'small' => array()
								 );
			
			// #2 get action
			$relation = PeopleDAO::get_people_role_pid($pid, $tpid);
			$exist = PeopleDAO::get_people_privacy_pid($pid);
			if ($exist == Privacy::NonExist) {
				return $oper_button;
			}
			switch ($relation) {
				case Relation::None:
				case Relation::Follower:
					$main_oper = array(
									   'action' => 'friend_oper('.$pid.','.$tpid.',\'add\')',
									   'class'  => 'add_friend',
									   'title'  => '加为好友'
									   );
					array_push($oper_button['large'], $main_oper);
					break;
				case Relation::Following:
					$main_oper = array(
									   'action' => 'friend_oper('.$pid.','.$tpid.',\'delete\')',
									   'class'  => 'delete_friend',
									   'title'  => '取消关注'
									   );
					array_push($oper_button['large'], $main_oper);
					break;
				case Relation::Friend:
					$main_oper = array(
									   'action' => 'friend_oper('.$pid.','.$tpid.',\'delete\')',
									   'class'  => 'delete_friend',
									   'title'  => '取消关注'
									   );
					array_push($oper_button['large'], $main_oper);
					break;
				case Relation::Self:
					if ( Mobile_Detect::deviceType() == "phone" )
					{
						$main_oper = array(
									   'action' => 'window.location=\'logo_original.php?id='.$pid.'\'',
									   'class'  => 'edit_logo',
									   'title'  => '修改头像'
									   );
					}
					else
					{
						$main_oper = array(
									   // 'action' => 'window.location=\'logo.php?pid='.$pid.'\'',
										'action' => 'window.location=\'logo_original.php?id='.$pid.'\'',
										'class'  => 'edit_logo',
										'title'  => '修改头像'
									   );
					}
					array_push($oper_button['large'], $main_oper);
					
					if ( Mobile_Detect::deviceType() != "phone" )
					{
						$main_oper = array(
									   'action' => 'edit_info('.$pid.','.$pid.',\'people\')',
									   'class'  => 'edit_info',
									   'title'  => '修改信息'
									   );
						array_push($oper_button['large'], $main_oper);
					}
								
					
					$main_oper = array(
									   'action' => 'window.location=\'friend_list.php\'',
									   'class'  => 'edit_info',
									   'title'  => '管理好友'
									   );					
					array_push($oper_button['large'], $main_oper);
					break;
			}
			/* 
			 $oper_button['small'] = array(
			 array(
			 'action', 'class', 'title'
			 )
			 );
			 */
			return $oper_button;
		}

		// !!! [CL3] get people friend list for people page
		public static function get_people_friend_list($pid, $tpid, $limit = 12, $start = 0) {
			// #1 default value
			$friend_list = array(
								 'common_list' => array(),
								 'friend_list' => array()
								 );
			
			// #2 fill common list
			if ($pid != $tpid) {
				$pid_list = PeopleDAO::get_friend_id_list_people($pid);
				$tpid_list = PeopleDAO::get_friend_id_list_people($tpid);
				$friend_id_list = array_intersect($pid_list, $tpid_list);
				foreach ($friend_id_list as $cfid) {
					$friend = PeopleDAO::get_people_basic_pid($cfid);
					$friend['action'] = PeopleDAO::get_friend_action_list($pid, $tpid);
					array_push($friend_list['common_list'], $friend);
				}
			}
			
			// #3 fill friend list
			$friend_id_list = PeopleDAO::get_friend_id_list_people($tpid);
			if ($limit > 0) {
				$friend_id_list = array_slice($friend_id_list, $start, $limit);
			}
			foreach ($friend_id_list as $fid) {
				$friend = PeopleDAO::get_people_basic_pid($fid);
				$friend['action'] = PeopleDAO::get_friend_action_list($pid, $tpid);
				array_push($friend_list['friend_list'], $friend);
			}
			
			// #4 recommend friend list
			// TODO
			
			return $friend_list;
		}

		// !!! [CL4] get people group list for people page
		public static function get_people_group_list($pid, $tpid, $limit = 6, $start = 0) 
		{
			// #1 default value
			$group_list = array();

			// #2 fill group list
			$group_id_list = GroupDAO::get_gid_list_people($tpid);
			if ($limit > 0) {
				$group_id_list = array_slice($group_id_list, $start, $limit);
			}
			foreach ($group_id_list as $gid) {
				$group = GroupDAO::get_group_basic_gid($gid);
				array_push($group_list, $group);
			}
			return $group_list;
		}

		public static function get_self_group_list_admin($pid, $limit = 1000, $start = 0)
		{
			// #1 default value
			$group_list = array();

			// #2 fill group list
			$group_id_list = GroupDAO::get_gid_list_people_admin($pid);
			if ($limit > 0) {
				$group_id_list = array_slice($group_id_list, $start, $limit);
			}
			foreach ($group_id_list as $gid) {
				$group = GroupDAO::get_group_basic_gid($gid);
				$group['gid'] = $gid;
				array_push($group_list, $group);
			}
			return $group_list;
		}
		
		// !!! [CL5] get people event list for people page
		public static function get_people_event_list($pid, $tpid, $limit = 6, $start = 0) {
			// #1 default value
			$event_list = array();
			
			// #2 fill event list
			$event_id_list = EventDAO::get_eid_list_people($tpid);
			if ($limit > 0) {
				$event_id_list = array_slice($event_id_list, $start, $limit);
			}
			foreach ($event_id_list as $eid) {
				$event = EventDAO::get_event_basic_eid($eid);
				array_push($event_list, $event);
			}
			return $event_list;
		}
		
		// #ContentRight
		// !!! [CR1] get people info list for people page
		public static function get_info_list($pid, $tpid) {
			// #1 default value
			$info_list = array(
							   'title'  => '（未知）',
							   '个人签名' => '（暂无）'
			);

			$nature_array = array();
			
			// #2 get info list
			$role = self::get_people_role_pid($pid, $tpid);
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT name, signature, birth, gender, nature, education, hometown, marriage, phone, email, address, hobby, privacy FROM people WHERE pid=? LIMIT 1;');
			$stmt->bind_param('i', $tpid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (!empty($row['name'])) {
					$info_list['title'] = strip_tags($row['name']);
				}
				if (!empty($row['signature'])) {
					$info_list['个人签名'] = strip_tags($row['signature']);
				}
				if (!empty($row['gender'])) 
				{
					$gender_array = Gender::get_const_array();
					$info_list['性别'] = $gender_array[$row['gender']];
				}
				if ($row['nature'] != "")
				{
					$nature_temp = strip_tags($row['nature']);
					$info_list['nature'] = $nature_temp;
					$nature_temp_array = explode(",", $nature_temp);
					$nature_const_array = oysterGender::get_const_array();
					foreach ( $nature_temp_array as $natures )
					{
						$nature = $nature_const_array[$natures];
						array_push($nature_array, $nature);
					}
					$nature_temp = implode(", ", $nature_array);
					$info_list['属性'] = $nature_temp;
				}
				if (!empty($row['education'])) 
				{
					$info_list['学校'] = strip_tags($row['education']);
				}
				if (!empty($row['hometown'])) 
				{
					$info_list['家乡'] = strip_tags($row['hometown']);
				}
				if (!empty($row['hobby'])) 
				{
					$info_list['爱好'] = strip_tags($row['hobby']);
				}
				if ($role >= $row['privacy']) 
				{
					if (!empty($row['birth']) && substr($row['birth'], 0, 4) != '0000') 
					{
						$info_list['生日'] = strip_tags(substr($row['birth'], 0, 10));
					}
					if (!empty($row['marriage'])) 
					{
						$info_list['婚姻状况'] = strip_tags($row['marriage']);
					}
					if (!empty($row['phone'])) 
					{
						$info_list['电话'] = strip_tags($row['phone']);
					}
					if (!empty($row['email'])) 
					{
						$info_list['邮箱'] = strip_tags($row['email']);
					}
					if (!empty($row['address'])) 
					{
						$info_list['地址'] = strip_tags($row['address']);
					}
					if (!empty($row['privacy'])) 
					{
						$role_array = Role::get_const_array();
						$info_list['可见范围'] = $role_array[$row['privacy']];
					}
				}
			}

			return $info_list;
		}

		// !!! [CR2] get album cover list for people detail page
		public static function get_album_cover_list($pid, $limit = 4, $start = 0) {
			// #1 default value
			$album_cover_list = array('previous' => '',
									  'next' => '',
									  'action' => 'show_album_people('.$pid.',',
									  'albums' => array()
									 );
			// #2 get album id list
			$album_id_list = AlbumDAO::get_album_id_list_people($pid);
			if(count($album_id_list) > $limit && $start < count($album_id_list)-1) {
				$s = $start + $limit;
				$album_cover_list['next'] = 'showMoreAlbum_people('.$pid.', '.$s.')';
			}
			if($start >= $limit) {
				$s = $start - $limit;
				$album_cover_list['previous'] = 'showMoreAlbum_people('.$pid.', '.$s.')';
			}
			$album_id_list = array_slice($album_id_list, $start, $limit);
			
			// #3 get values
			foreach ($album_id_list as $album_id) {
				$album_cover = AlbumDAO::get_album_cover_aid($album_id);
				array_push($album_cover_list['albums'], $album_cover);
			}
			return $album_cover_list;
		}
		
		// !!! [CR2] get feed list for people page
		public static function get_feed_list($pid, $tpid, $tag_id = 0,$bd_start = 0, $bd_limit = 20, $cm_start = 0, $cm_limit = 3) 
		{
			return BoardDAO::get_feed_list($pid, 'people', $tpid, $tag_id, $bd_start, $bd_limit, $cm_start, $cm_limit);
		}

		// #ContentFunction
		// !!! [CF1] edit people
		public static function edit_info($pid, $people) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE people SET name=?, signature=?, birth=?, gender=?, nature=?, education=?, hometown=?, marriage=?, phone=?, email=?, address=?, hobby=?, privacy=? WHERE pid=?');
			$stmt->bind_param('sssissssssssii', $people['name'], $people['signature'], $people['birth'], $people['gender'], $people['nature'], $people['education'], $people['hometown'], $people['marriage'], $people['phone'], $people['email'], $people['address'], $people['hobby'], $people['privacy'], $pid);
			$stmt->execute();
			return true;
		}
		
		// !!! [CF2] add friend
		public static function add_friend($pid, $tpid) 
		{
			$relation = self::get_people_role_pid($pid, $tpid);
			switch ($relation) 
			{
				case Relation::None:
					self::set_people_role_pid($pid, $tpid, Relation::Following);
					self::set_people_role_pid($tpid, $pid, Relation::Follower);
					break;
				case Relation::Friend:
				case Relation::Self:
				case Relation::Following:
					break;
				case Relation::Follower:
					self::set_people_role_pid($pid, $tpid, Relation::Friend);
					self::set_people_role_pid($tpid, $pid, Relation::Friend);
					break;
			}
			return 0;
		}
		
		// !!! [CF3] delete friend
		public static function delete_friend($pid, $tpid) {
			$relation = self::get_people_role_pid($pid, $tpid);
			switch ($relation) {
				case Relation::None:
				case Relation::Follower:
				case Relation::Self:
					return false;
				case Relation::Following:
					self::set_people_role_pid($pid, $tpid, Relation::None);
					self::set_people_role_pid($tpid, $pid, Relation::None);
					return true;
				case Relation::Friend:
					self::set_people_role_pid($pid, $tpid, Relation::Follower);
					self::set_people_role_pid($tpid, $pid, Relation::Following);
					return true;
			}
		}
		
		
		// !!! [CF4] get friend list large
		public static function get_friend_list_large($pid, $category) {
			$friend_list = array(
								 'following' => array('class'  => 'off', 
								 					  'title' => '关注中', 
								 					  'action' => 'update_friend_list_large(\'following\')', 
								 					  'member' => array()
								 					  ),
								 'follower'  => array('class'  => 'off', 
								 					  'title' => '粉丝', 
								 					  'action' => 'update_friend_list_large(\'follower\')', 
								 					  'member' => array()
								 					  ),
								 'recommend' => array('class'  => 'off', 
								 					  'title' => '推荐好友', 
								 					  'action' => 'update_friend_list_large(\'recommend\')', 
								 					  'member' => array()
								 					  )
			);

			$friend_list[$category]['class'] = 'on';
			
			$id_list = PeopleDAO::get_people_id_list_relation($pid, $category);
			foreach ($id_list as $f_id) {
				$f_relation = PeopleDAO::get_people_basic_pid($f_id);
				$f_relation['button'] = PeopleDAO::get_friend_action_list($pid, $f_id);
				array_push($friend_list[$category]['member'], $f_relation);
			}
			return $friend_list;
		}
		
		/*
		 --------------------------------
		   Getters by id
		 --------------------------------
		 */
		// get person basic info by pid: url, image(small), alt, title
		public static function get_people_basic_pid($pid) {
			// #1 default value
			$person = array(
							'url' => '',
							'image' => DefaultImage::People.'_small.jpg',  
							'image_large' => DefaultImage::People.'_large.jpg',  
							'alt' => '', 
							'title' => ''
			);
			
			// #2 get person basic info
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT avatar, name FROM people WHERE pid=? LIMIT 1;');
			$stmt->bind_param('i', $pid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$person['url'] = 'people?pid='.$pid;
				if (!empty($row['avatar'])) {
					$person['image'] = $row['avatar'].'_small.jpg';
					$person['image_large'] = $row['avatar'].'_large.jpg';
				}
				$person['alt']   = strip_tags($row['name']);
				$person['title'] = strip_tags($row['name']);
			}
			$stmt->close();
			return $person;
		}

		// get person's role in people (none, friend, self)
		public static function get_people_role_pid($pid, $tpid) {
			if ($pid == $tpid) {
				return Relation::Self;
			}
			$relation = Relation::None;
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT relation FROM people2people WHERE pid1=? AND pid2=? ORDER BY mtime DESC LIMIT 1;');
			$stmt->bind_param('ii', $pid, $tpid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$relation = $row['relation'];
			}
			$stmt->close();
			return $relation;
		}

		// get person's role in group
		public static function get_group_role_pid($pid, $gid)
		{
			/*+++++Alex管理+++++*/
			// if ( ($pid == 2) || ($pid == 99) || ($pid == 1234) )
			// {
			// 	return Role::Owner;
			// }
			if ( AccountDAO::define_superior_member($pid) )
			{
				return Role::Owner;
			}
			/*=====Alex管理=====*/
			
			$role = Role::None;
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT role FROM people2group WHERE pid=? AND gid=? LIMIT 1;');
			$stmt->bind_param('ii', $pid, $gid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$role = $row['role'];
			}
			$stmt->close();
			return $role;
		}
		
		// get person's role in event
		public static function get_event_role_pid($pid, $eid)
		{
			/*+++++Alex管理+++++*/
			// if ( ($pid == 2) || ($pid == 99) || ($pid == 1234) )
			// {
			// 	return Role::Owner;
			// }
			if ( AccountDAO::define_superior_member($pid) )
			{
				return Role::Owner;
			}
			/*=====Alex管理=====*/
			$role = Role::None;
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT role FROM people2event WHERE pid=? AND eid=? LIMIT 1;');
			$stmt->bind_param('ii', $pid, $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$role = $row['role'];
			}
			$stmt->close();
			return $role;			
		}

		// get person's privacy
		public static function get_people_privacy_pid($pid) {
			// #1 default value
			$privacy = Privacy::NonExist;
			
			// #2 get group basic info
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT privacy FROM people WHERE pid=? LIMIT 1;');
			$stmt->bind_param('i', $pid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$privacy = $row['privacy'];
			}
			$stmt->close();
			return $privacy;
		}
		
		// get friend action list
		public static function get_friend_action_list($pid, $tpid) {
			$action_list = array();
			if (PeopleDAO::get_people_privacy_pid($pid) == Privacy::NonExist) {
				return $action_list;
			}
			if (PeopleDAO::get_people_privacy_pid($tpid) == Privacy::NonExist) {
				return $action_list;
			}
			$relation = PeopleDAO::get_people_role_pid($pid, $tpid);
			switch ($relation) {
				case Relation::None:
					if (PeopleDAO::get_people_role_pid($tpid, $pid) == Relation::Banned) {
						break;
					}
				case Relation::Follower:
					$action = array(
									'action' => 'friend_oper('.$pid.','.$tpid.',\'add\')',
									'class'  => 'add_friend',
 									'title'  => '关注此人'
					);
					array_push($action_list, $action);
					break;
				case Relation::Following:
				case Relation::Friend:
					$action = array(
									   'action' => 'friend_oper('.$pid.','.$tpid.',\'delete\')',
									   'class'  => 'delete_friend',
									   'title'  => '取消关注'
									   );
					array_push($action_list, $action);
					break;
				case Relation::Self:
					break;
			}
			return $action_list;
		}


		/*
		 --------------------------------
		   Setters
		 --------------------------------
		 */
		// set people role with pid
		public static function set_people_role_pid($pid, $tpid, $role) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO people2people (pid1, pid2, relation) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE relation=?;');
			$stmt->bind_param('iiii', $pid, $tpid, $role, $role);
			$stmt->execute();
			$stmt->close();
			return 0;
		}

		// set group role with pid
		public static function set_group_role_pid($pid, $gid, $role) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO people2group (pid, gid, role) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE role=?;');
			$stmt->bind_param('iiii', $pid, $gid, $role, $role);
			$stmt->execute();
			$stmt->close();
			return 0;
		}
		
		// set event role with pid
		public static function set_event_role_pid($pid, $eid, $role) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO people2event (pid, eid, role) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE role=?;');
			$stmt->bind_param('iiii', $pid, $eid, $role, $role);
			$stmt->execute();
			$stmt->close();
			return 0;
		}

		// set group role all
		public static function set_group_role_all($gid, $role) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE people2group SET role=? WHERE gid=?;');
			$stmt->bind_param('ii', $role, $gid);
			$stmt->execute();
			$stmt->close();
			return 0;
		}
		
		// set event role all
		public static function set_event_role_all($eid, $role) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE people2event SET role=? WHERE eid=?;');
			$stmt->bind_param('ii', $role, $eid);
			$stmt->execute();
			$stmt->close();
			return 0;
		}
		
		// set people name by id
		public static function set_people_name_pid($pid, $name) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE people SET name=? WHERE pid=?;');
			$stmt->bind_param('si', $name, $pid);
			$stmt->execute();
			$stmt->close();
			return 0;
		}

		// set people avatar by id
		public static function set_people_avatar_pid($pid, $avatar) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE people SET avatar=? WHERE pid=?;');
			$stmt->bind_param('si', $avatar, $pid);
			$stmt->execute();
			$stmt->close();
			return 0;
		}
		
		/*
		 --------------------------------
		   Get id list by foreign key
		 --------------------------------
		 */

		// get group member id list with role
		public static function get_pid_list_group($gid, $role = -1) 
		{
			$member_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			if ($role >= 0) 
			{
				$stmt->prepare('SELECT pid FROM people2group WHERE gid=? AND role=? ORDER BY mtime DESC LIMIT 1000;');
				$stmt->bind_param('ii', $gid, $role);
			}
			else 
			{
				$stmt->prepare('SELECT pid FROM people2group WHERE gid=? LIMIT 1000;');
				$stmt->bind_param('i', $gid);
			}
			$stmt->execute();
			$result = $stmt->get_result();
			$member_ids = array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				array_push($member_ids, $row['pid']);
			}
			$stmt->close();
			return $member_ids;
		}
		//get group member id list by gender with role
		public static function get_pid_list_gender_group($gid, $role = -1) 
		{
			//#1 default value
			$gender_male = 1;
			$gender_female = 0;
			$member_ids = array();
			$all_member_ids = array();
			$male_member_ids = array();
			$female_member_ids = array();

			//#2 get pid_list_group
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			if ($role >= 0) {
				$stmt->prepare('SELECT pid FROM people2group WHERE gid=? AND role=? LIMIT 1000;');
				$stmt->bind_param('ii', $gid, $role);
			}
			else {
				$stmt->prepare('SELECT pid FROM people2group WHERE gid=? LIMIT 1000;');
				$stmt->bind_param('i', $gid);
			}
			$stmt->execute();
			$result = $stmt->get_result();

			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($member_ids, $row['pid']);
			}
			
			$stmt->close();
			
			if ($role > 3)
			{
				return $member_ids;
			}
			else
			{
				//get id_list_male/female
				foreach($member_ids as $pids)
				{
					$stmt = $mysqli->stmt_init();
					$stmt->prepare('SELECT pid, gender FROM people WHERE pid=? LIMIT 1;');
					$stmt->bind_param('i', $pids);
					$stmt->execute();
					$result = $stmt->get_result();

					while ($row = $result->fetch_array(MYSQLI_ASSOC))
					{
						if( $row['gender'] == $gender_female )
						{
							array_push($female_member_ids, $row['pid']);
						}
						else
						{
							array_push($male_member_ids, $row['pid']);
						}
					}
					$stmt->close();
				}
				
				$all_member_ids['female'] = $female_member_ids;
				$all_member_ids['male'] = $male_member_ids;

				return $all_member_ids;
			}
		}

		// get event member id list with role without considering gender
		public static function get_pid_list_event_nogender($eid, $role = -1) 
		{
			//#1 default value
			$member_ids = array();

			//#2 get pid_list_event
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			if ($role >= 0)
			{
				$stmt->prepare('SELECT pid FROM people2event WHERE eid=? AND role=? ORDER BY mtime DESC LIMIT 1000;');
				$stmt->bind_param('ii', $eid, $role);
			}
			else
			{
				/*这里取的时候把已退出活动的人给取出来是要闹哪样
					$stmt->prepare('SELECT pid FROM people2event WHERE eid=? LIMIT 1000;');
				*/
				//role > 2以后需要替换成role >= Role::Member
				$stmt->prepare('SELECT pid FROM people2event WHERE eid=? AND role > 2 ORDER BY mtime DESC LIMIT 1000;');
				$stmt->bind_param('i', $eid);
			}
			$stmt->execute();
			$result = $stmt->get_result();

			while ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				array_push($member_ids, $row['pid']);
			}
			$stmt->close();
			
			return $member_ids;
		}

		// get event member id list as gender with role
		public static function get_pid_list_event($eid, $role = -1) {
			//#1 default value
			$gender_male = 1;
			$gender_female = 0;
			$member_ids = array();
			$all_member_ids = array();
			$male_member_ids = array();
			$female_member_ids = array();

			//#2 get pid_list_event
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			if ($role >= 0) {
				$stmt->prepare('SELECT pid FROM people2event WHERE eid=? AND role=? LIMIT 1000;');
				$stmt->bind_param('ii', $eid, $role);
			}
			else {
				$stmt->prepare('SELECT pid FROM people2event WHERE eid=? LIMIT 1000;');
				$stmt->bind_param('i', $eid);
			}
			$stmt->execute();
			$result = $stmt->get_result();

			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($member_ids, $row['pid']);
			}
			$stmt->close();

			if ( $role > 3)
			{
				return $member_ids;
			}
			else
			{
				//get id_list_male/female
				foreach($member_ids as $pids)
				{
					$stmt = $mysqli->stmt_init();
					$stmt->prepare('SELECT pid, gender FROM people WHERE pid=? LIMIT 1;');
					$stmt->bind_param('i', $pids);
					$stmt->execute();
					$result = $stmt->get_result();

					while ($row = $result->fetch_array(MYSQLI_ASSOC))
					{
						if( $row['gender'] == $gender_female )
						{
							array_push($female_member_ids, $row['pid']);
						}
						else
						{
							array_push($male_member_ids, $row['pid']);
						}
					}
					$stmt->close();
				}
				
				$all_member_ids['female'] = $female_member_ids;
				$all_member_ids['male'] = $male_member_ids;

				return $all_member_ids;
			}
		}

		// get person friend id list (whose relation >= Following)
		public static function get_friend_id_list_people($pid) {
			$friend_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pid2 FROM people2people WHERE pid1=? AND relation>=? ORDER BY mtime DESC LIMIT 1000;');
			$relation = Relation::Following;
			$stmt->bind_param('ii', $pid, $relation);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($row['pid2'] != $pid) {
					array_push($friend_ids, $row['pid2']);
				}
			}
			$friend_ids = array_unique($friend_ids);
			$stmt->close();
			return $friend_ids;
		}

		// get id list classified by relations(0: following, 1: follower, 2: friend, 3: recommend)
		public static function get_people_id_list_relation($pid, $category) 
		{
			$people_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pid2, relation FROM people2people WHERE pid1=? ORDER BY mtime DESC LIMIT 1000;');

			$stmt->bind_param('i', $pid);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				switch ($category) 
				{
					case "following":
						if ($row['relation'] == Relation::Friend || $row['relation'] == Relation::Following) 
						{
							array_push($people_ids, $row['pid2']);
						}						
						break;
					case "follower":
						if ($row['relation'] == Relation::Friend || $row['relation'] == Relation::Follower) 
						{
							array_push($people_ids, $row['pid2']);
						}						
						break;
					case "friend":
						if ( $row['relation'] == Relation::Friend )
						{
							array_push($people_ids, $row['pid2']);
						}
					case "recommend":
						break;
				}
			
			}
			$stmt->close();
			return $people_ids;
		}
		
		// get group member id list (whose role >= member)
		public static function get_member_id_list_group($gid) {
			$member_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pid, role FROM people2group WHERE gid=? AND role>=? ORDER BY role DESC LIMIT 1000;');
			$role = Role::Member;
			$stmt->bind_param('ii', $gid, $role);
			$stmt->execute();
			$result = $stmt->get_result();
			$member_ids = array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($member_ids, $row['pid']);
			}
			$stmt->close();
			return $member_ids;
		}

		// get event member id list (whose role >= member)
		public static function get_member_id_list_event($eid) {
			$member_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pid, role FROM people2event WHERE eid=? AND role>=? ORDER BY role DESC LIMIT 1000;');
			$role = Role::Member;
			$stmt->bind_param('ii', $eid, $role);
			$stmt->execute();
			$result = $stmt->get_result();
			$member_ids = array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($member_ids, $row['pid']);
			}
			$stmt->close();
			return $member_ids;
		}
	}
?>