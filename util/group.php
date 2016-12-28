<?php
	if(!defined('IN_ZUS')) {
		exit('<h1>403:Forbidden @util:group.php</h1>');
	}
	
	class GroupDAO {
		/*
		 --------------------------------
		   Core API
		 --------------------------------
		 */
		// #Browser
		// !!! [B0] get group list large for browser
		public static function get_group_list_large($pid, $category = 0, $limit = 24, $start = 0) {
			// #1 default value
			$group_list_large = array(
									  'group_list' => array(),
									  'next' => ''
									  );
			
			// #2 get groups
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$limit_plus = $limit+1;
			if ($category > 0) {
				$stmt->prepare('SELECT gid, logo, title, owner, privacy FROM community WHERE category=? AND privacy<'. Privacy::NonExist .' ORDER BY gid DESC LIMIT ?,?;');
				$stmt->bind_param('iii', $category, $start, $limit_plus);
			}
			else {
				$stmt->prepare('SELECT gid, logo, title, owner, privacy FROM community WHERE privacy<'. Privacy::NonExist .' ORDER BY gid DESC LIMIT ?,?;');
				$stmt->bind_param('ii', $start, $limit_plus);
			}
			$stmt->execute();
			$result = $stmt->get_result();
			$count = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$gid = $row['gid'];
				$role = PeopleDAO::get_group_role_pid($pid, $gid);
				if ($role != Role::Invited && $role < $row['privacy']) {
					continue;
				}

				$count ++;
				if ($count > $limit) {
					$group_list_large['next'] = $start + $limit;
					break;
				}
				$group = array();
				
				// #2.1 basic fields
				$group['next_event'] = self::get_group_next_event($gid);
				$group['info'] = self::get_info_list($pid, $gid);
				$group['url']   = 'group?gid='.$gid;
				if (!empty($row['logo'])) {
					$group['image'] = $row['logo'].'_large.jpg';
				}
				else {
					$group['image'] = DefaultImage::Group.'_large.jpg';
				}
				$group['alt']   = strip_tags($row['title']);
				$group['title'] = strip_tags($row['title']);
				
				switch ($role) {
					case Role::None:
						$privacy = PeopleDAO::get_people_privacy_pid($pid);
						if ($privacy == Privacy::NonExist) {
							$group['action'] = array(
													 'func'  => 'show_login_panel()',
													 'class' => 'guest',
													 'name'  => '未登录'
													 );
							break;
						}
					case Role::Invited:
						$group['action'] = array(
												 'func' => 'group_oper('.$pid.','.$gid.',\'join\')',
												 'class' => 'join',
												 'name' => '参加群组'
												 );
						break;
					case Role::Pending:
						$group['action'] = array(
												 'func' => '',
												 'class' => 'pending',
												 'name' => '等待通过'
												 );
						break;
					case Role::Member:
						$group['action'] = array(
												 'func' => 'visit(\'group?gid='.$gid.'\')',
												 'class' => 'member',
												 'name' => '已参加'
												 );
						break;
					case Role::Admin:
						$group['action'] = array(
												 'func' => 'visit(\'group?gid='.$gid.'\')',
												 'class' => 'admin',
												 'name' => '管理群组'
												 );
						break;
					case Role::Owner:
						$group['action'] = array(
												 'func' => 'visit(\'group?gid='.$gid.'\')',
												 'class' => 'owner',
												 'name' => '我的群组'
												 );
						break;
				}
				
				// #2.2 get interset of current user's friend list and group member list, including owner
				$member_ids = PeopleDAO::get_member_id_list_group($gid);
				$friend_ids = PeopleDAO::get_friend_id_list_people($pid);
				$show_ids = array_intersect($member_ids, $friend_ids);
				//* 现在网站的逻辑要求是把参与人总数拿出来，我们取好友参加数做什么
				// $group['member_count'] = sizeof($show_ids);
				//*好吧，我重新改下名
				$group['member_count'] = sizeof($member_ids);			//取群组参加人数
				$group['friend_member_count'] = sizeof($show_ids);		//取好友参与人数

				$show_ids = array_slice($show_ids, 0, 8);

				$group['owner'] = PeopleDAO::get_people_basic_pid($row['owner']);

				// #2.3 show owner then interset people
				$members = array();
				foreach ($show_ids as $tpid) {
					array_push($members, PeopleDAO::get_people_basic_pid($tpid));
				}
				$group['members'] = $members;
				array_push($group_list_large['group_list'], $group);
			}
			$stmt->close();
			return $group_list_large;
		}
		
		// #ContentLeft
		// !!! [CL1] get group logo for group page
		public static function get_group_logo($pid, $gid) {
			// #1 default value
			$group_logo = array(
								'image'   => DefaultImage::Group.'_large.jpg',
								'alt'     => '',
								'title'   => '',
								'qr_code' => DefaultImage::QR,
								'edit'    => '',
								'url'     => ''
			);

			// #2 get logo
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT logo, title FROM community WHERE gid=? LIMIT 1;');
			$stmt->bind_param('i', $gid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (!empty($row['logo'])) {
					$group_logo['image'] = $row['logo'].'_large.jpg';
				}
				$group_logo['alt']     = strip_tags($row['title']);
				$group_logo['title']   = strip_tags($row['title']);
				$group_logo['qr_code'] = QRCodeDAO::get_qr_code_group($gid);
				$event_logo['url']     = QRCodeDAO::get_url_group($gid);
			}
			$stmt->close();
			
			// #3 check edit
			$role = PeopleDAO::get_group_role_pid($pid, $gid);
			if ($role >= Role::Admin)
			{
				if ( Mobile_Detect::deviceType() == 'phone' )
				{
					$group_logo['edit'] = 'window.location=\'logo_original.php?id='.$gid.'\'';
				}
				else
				{
					$group_logo['edit'] = 'window.location=\'logo.php?gid='.$gid.'\'';
				}
			}
			return $group_logo;
		}

		// !!! [CL2] get group operation buttons for group page
		public static function get_group_oper_button_list($pid, $gid) {
			// #1 default value
			$oper_button = array(
								 'large' => array(),
								 'small' => array()
								 );
			// #2 get action
			$role = PeopleDAO::get_group_role_pid($pid, $gid);
			if (self::get_group_privacy_gid($gid) == Privacy::NonExist) {
				$main_oper = array(
								   'action' => '',
								   'class'  => 'ghost_group',
								   'title'  => '不存在'
								   );
				array_push($oper_button['large'], $main_oper);
				return $oper_button;
			}
			switch ($role) {
				case Role::None:
					$privacy = PeopleDAO::get_people_privacy_pid($pid);
					if ($privacy == Privacy::NonExist) {
						$main_oper = array(
										   'action' => 'show_login_panel()',
										   'class'  => 'login',
										   'title' => '请先登录'
										   );
						array_push($oper_button['large'], $main_oper);
						break;
					}
				case Role::Invited:
					if ( $gid != 1 )
					{
						$main_oper = array(
									   'action' => 'group_oper('.$pid.','.$gid.',\'join\')',
									   'class'  => 'join_group',
									   'title'  => '加入群组'
									   );
						array_push($oper_button['large'], $main_oper);
					}
					break;
				case Role::Pending:
					$main_oper = array(
									   'action' => '',
									   'class'  => 'pending',
									   'title'  => '等待通过'
									   );
					array_push($oper_button['large'], $main_oper);
					break;
				case Role::Member:
					$main_oper = array(
									   'action' => 'group_oper('.$pid.','.$gid.',\'leave\')',
									   'class'  => 'leave_group',
									   'title'  => '退出群组'
									   );
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'post_article('.$pid.','.$gid.',\'group\')',
									   'class'  => 'post_article',
									   'title'  => '发表文章'
									   );
					array_push($oper_button['large'], $main_oper);
					break;
				case Role::Admin:
					if ( Mobile_Detect::deviceType() == "phone" )
					{
						$main_oper = array(
									   'action' => 'window.location=\'logo_original.php?id='.$gid.'\'',
									   'class'  => 'edit_logo',
									   'title'  => '修改图标'
									   );
					}
					else
					{
						$main_oper = array(
									   'action' => 'window.location=\'logo.php?gid='.$gid.'\'',
									   'class'  => 'edit_logo',
									   'title'  => '修改图标'
									   );
					}
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'edit_info('.$pid.','.$gid.',\'group\')',
									   'class'  => 'edit_info',
									   'title'  => '修改信息'
									   );
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'group_oper('.$pid.','.$gid.',\'leave\')',
									   'class'  => 'leave_group',
									   'title'  => '退出群组'
									   );
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'post_article('.$pid.','.$gid.',\'group\')',
									   'class'  => 'post_article',
									   'title'  => '发表文章'
									   );
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'window.location=\'manage_member.php?gid='.$gid.'\'',
									   'class'  => 'manage_member',
									   'title'  => '管理群组'
									   );
					array_push($oper_button['large'], $main_oper);
					break;
				case Role::Owner:
					if ( Mobile_Detect::deviceType() == "phone" )
					{
						$main_oper = array(
									   'action' => 'window.location=\'logo_original.php?id='.$gid.'\'',
									   'class'  => 'edit_logo',
									   'title'  => '修改图标'
									   );
					}
					else
					{
						$main_oper = array(
									   'action' => 'window.location=\'logo.php?gid='.$gid.'\'',
									   'class'  => 'edit_logo',
									   'title'  => '修改图标'
									   );
					}
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'edit_info('.$pid.','.$gid.',\'group\')',
									   'class'  => 'edit_info',
									   'title'  => '修改信息'
									   );
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'post_article('.$pid.','.$gid.',\'group\')',
									   'class'  => 'post_article',
									   'title'  => '发表文章'
									   );
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'window.location=\'manage_member.php?gid='.$gid.'\'',
									   'class'  => 'manage_member',
									   'title'  => '管理群组'
									   );
					array_push($oper_button['large'], $main_oper);
//					$main_oper = array(
//									   'action' => 'group_oper('.$pid.','.$gid.',\'delete\')',
//									   'class'  => 'delete_group',
//									   'title'  => '解散群组'
//									   );
//					array_push($oper_button['large'], $main_oper);
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

		// !!! [CL3] get group member list for group page
		public static function get_group_member_list($pid, $gid, $limit = 12, $start = 0) 
		{
			// #1 default value
			$member_list = array(
								 'admins' => array(),
								 'members' => array()
			);
			
			// #2 fill admins
			$member_id_list = array();
			$pid_list = PeopleDAO::get_pid_list_group($gid, Role::Owner);
			$member_id_list = array_merge($member_id_list, $pid_list);
			$pid_list = PeopleDAO::get_pid_list_group($gid, Role::Admin);
			$member_id_list = array_merge($member_id_list, $pid_list);
			$role = PeopleDAO::get_group_role_pid($pid, $gid);
			foreach ($member_id_list as $tpid) {
				$admin = PeopleDAO::get_people_basic_pid($tpid);
				$admin['action'] = array();
				$trole = PeopleDAO::get_group_role_pid($tpid, $gid);
				if ($role == Role::Owner && $trole == Role::Admin) {
					$admin['action'][0] = array(
												'title' => '取消管理员',
												'class' => 'degrade',
												'action' => 'gmember_oper('.$pid.','.$tpid.','.$gid.',\'degrade\')'
												);
					$admin['action'][1] = array(
												'title' => '删除成员',
												'class' => 'delete',
												'action' => 'gmember_oper('.$pid.','.$tpid.','.$gid.',\'delete\')'
												);
				}
				array_push($member_list['admins'], $admin);
			}
			
			// #3 fill members
			$member_id_list = PeopleDAO::get_pid_list_group($gid, Role::Member);
			if ($limit > 0) {
				$member_id_list = array_slice($member_id_list, $start, $limit);
			}
			foreach ($member_id_list as $tpid) {
				$member = PeopleDAO::get_people_basic_pid($tpid);
				$member['action'] = array();
				$trole = PeopleDAO::get_group_role_pid($tpid, $gid);
				if ($role == Role::Owner && $trole == Role::Member) {
					$member['action'][0] = array(
												'title' => '升级管理员',
												 'class' => 'upgrade',
												'action' => 'gmember_oper('.$pid.','.$tpid.','.$gid.',\'upgrade\')'
												);
					$member['action'][1] = array(
												'title' => '删除成员',
												 'class' => 'delete',
												'action' => 'gmember_oper('.$pid.','.$tpid.','.$gid.',\'delete\')'
												);
				}
				if ($role == Role::Admin && $trole == Role::Member) {
					$member['action'][0] = array(
												'title' => '删除成员',
												 'class' => 'delete',
												'action' => 'gmember_oper('.$pid.','.$tpid.','.$gid.',\'delete\')'
												);
				}
				array_push($member_list['members'], $member);
			}
			return $member_list;
		}

		//群组成员 更多
		public static function get_group_member_list_relation($pid, $gid, $limit = 12, $start = 0) 
		{
			// #1 default value
			$member_list = array(
								 'admins' => array(),
								 'members' => array()
			);
			
			// #2 fill admins
			$member_id_list = array();
			$pid_list = PeopleDAO::get_pid_list_group($gid, Role::Owner);
			$member_id_list = array_merge($member_id_list, $pid_list);
			$pid_list = PeopleDAO::get_pid_list_group($gid, Role::Admin);
			$member_id_list = array_merge($member_id_list, $pid_list);
			
			foreach ($member_id_list as $tpid) {
				$admin = PeopleDAO::get_people_basic_pid($tpid);
				$admin['action'] = PeopleDAO::get_friend_action_list($pid, $tpid);
				array_push($member_list['admins'], $admin);
			}
			
			// #3 fill members
			$member_id_list = PeopleDAO::get_pid_list_group($gid, Role::Member);
			if ($limit > 0) {
				$member_id_list = array_slice($member_id_list, $start, $limit);
			}
			foreach ($member_id_list as $tpid) {
				$member = PeopleDAO::get_people_basic_pid($tpid);
				$member['action'] = PeopleDAO::get_friend_action_list($pid, $tpid);
				array_push($member_list['members'], $member);
			}
			return $member_list;
		}
//获得群组成员并按性别分类
		public static function get_group_member_gender_list($pid, $gid, $limit = 12, $start = 0) 
		{
			// #1 default value
			$member_list = array(
								 'admins' => array(),
								 'members' => array(
								 					'female' => array(),
								 					'male' => array()
								 					)
			);
			
			// #2 fill admins
			$member_id_list = array();
			$pid_list = PeopleDAO::get_pid_list_gender_group($gid, Role::Owner);
			$member_id_list = array_merge($member_id_list, $pid_list);
			$pid_list = PeopleDAO::get_pid_list_gender_group($gid, Role::Admin);
			$member_id_list = array_merge($member_id_list, $pid_list);
			$role = PeopleDAO::get_group_role_pid($pid, $gid);
			foreach ($member_id_list as $tpid) 
			{
				$admin = PeopleDAO::get_people_basic_pid($tpid);
				$admin['action'] = array();
				$trole = PeopleDAO::get_group_role_pid($tpid, $gid);
				if ($role == Role::Owner && $trole == Role::Admin) {
					$admin['action'][0] = array(
												'title' => '取消管理员',
												'class' => 'degrade',
												'action' => 'gmember_oper('.$pid.','.$tpid.','.$gid.',\'degrade\')'
												);
					$admin['action'][1] = array(
												'title' => '删除成员',
												'class' => 'delete',
												'action' => 'gmember_oper('.$pid.','.$tpid.','.$gid.',\'delete\')'
												);
				}
				array_push($member_list['admins'], $admin);
			}
			
			// #3 fill members
			$member_id_list = PeopleDAO::get_pid_list_gender_group($gid, Role::Member);
			if ($limit > 0) 
			{
				$member_id_list['female'] = array_slice($member_id_list['female'], $start, $limit);
				$member_id_list['male'] = array_slice($member_id_list['male'], $start, $limit);
			}

			foreach ($member_id_list as $gender => $gender_id_list)
			{
				foreach ($gender_id_list as $tpid) 
				{
					$member = PeopleDAO::get_people_basic_pid($tpid);
					$member['action'] = array();
					$trole = PeopleDAO::get_group_role_pid($tpid, $gid);
					
					if ($role == Role::Owner && $trole == Role::Member) 
					{
						$member['action'][0] = array(
													'title' => '升级管理员',
													 'class' => 'upgrade',
													'action' => 'gmember_oper('.$pid.','.$tpid.','.$gid.',\'upgrade\')'
													);
						$member['action'][1] = array(
													'title' => '删除成员',
													 'class' => 'delete',
													'action' => 'gmember_oper('.$pid.','.$tpid.','.$gid.',\'delete\')'
													);
					}

					if ($role == Role::Admin && $trole == Role::Member) 
					{
						$member['action'][0] = array(
													'title' => '删除成员',
													 'class' => 'delete',
													'action' => 'gmember_oper('.$pid.','.$tpid.','.$gid.',\'delete\')'
													);
					}

					if( $gender == 'female' )
					{
						array_push($member_list['members']['female'], $member);
					}
					else
					{
						array_push($member_list['members']['male'], $member);
					}
				}
			}
			
			return $member_list;
		}

		/*get all the members*/
		public static function get_group_member_list_all($pid, $gid, $limit = 1000, $start = 0)
		{
			// #1 default value
			$member_list = array(
								'title'	=> '',
								'member' => array()
								 );
			// #2 fill title
			$basic = GroupDAO::get_group_basic_gid($gid);
			$member_list['title'] = $basic['title'];
			// #3 fill members
			$member_id_list = PeopleDAO::get_pid_list_group($gid, Role::Member);
			
			if ($limit > 0)
			{
				$member_id_list = array_slice($member_id_list, $start, $limit);
			}
			foreach ($member_id_list as $tpid)
			{
				$member = PeopleDAO::get_people_basic_pid($tpid);
				$button_action = PeopleDAO::get_friend_action_list($pid, $tpid);
				$member['button'] = $button_action;
				array_push($member_list['member'], $member);
			}
			
			return $member_list;
		}
		
		// !!! [CL4] get event list for group page
		public static function get_group_event_list($pid, $gid, $limit = 5, $start = 0) {
			// #1 default value
			$event_list = array();
			
			// #2 fill events
			$event_id_list = EventDAO::get_eid_list_group($gid);
			if ($limit > 0) {
				$event_id_list = array_slice($event_id_list, $start, $limit);
			}
			foreach ($event_id_list as $teid) {
				$event = EventDAO::get_event_detail_eid($teid);
				$event['action'] = array();
				array_push($event_list, $event);
			}
			return $event_list;
		}

		// !!! [CL5] get recommend group list for group page
		public static function get_group_recommend_list($pid, $eid, $limit = 6, $start = 0) {
			// TODO generate recommend group list
			return array();
		}

		// #ContentRight
		// !!! [CR1] get group info list for group page
		public static function get_info_list($pid, $gid) 
		{
			// #1 get role
			$role = PeopleDAO::get_group_role_pid($pid, $gid);
			
			// #2 default value
			$info_list = array(
							   'title'		=> 		'（暂无）',
							   '群组类型' 	=> 		' (待定) ',
							   '规模'		=>		' (待定) ',
							   '人数规模' 	=> 		'（待定）',
							   '群组描述' 	=> 		'（待定）',
							   '群组公告' 	=> 		'（暂无）',
							   '标签内容' 	=> 		'',
							   '群组标签' 	=> 		''
							   );
			
			$tag_array = array();

			// #3 get info list
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT title, ctime, description, category, size, tag, announcement, isnew FROM community WHERE gid=? LIMIT 1;');
			$stmt->bind_param('i', $gid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				if (!empty($row['title'])) 
				{
					$info_list['title'] = strip_tags($row['title']);
				}
				if (!empty($row['ctime'])) 
				{
					$info_list['成立时间'] = substr($row['ctime'], 0, 10);
				}
				if (!empty($row['category'])) 
				{
					$const_array = GroupCategory::get_const_array();
					$info_list['群组类型'] = $const_array[$row['category']];
				}
				if ( !empty($row['isnew']) && ($row['isnew'] == '1') )
				{
					$info_list['群组类型'] = "新生群组";
				}
				if (!empty($row['size'])) 
				{
					$member = PeopleDAO::get_member_id_list_group($gid);
					$info_list['规模'] = $row['size'];
					$info_list['人数规模'] = sizeof($member).'/'.$row['size'];
				}
				if ( $row['tag'] != "" ) 
				{
					$tag_temp = strip_tags($row['tag']);
					$info_list['群组标签'] = $tag_temp;
					$tag_temp_array = explode(",", $tag_temp);
					$tag_const_array = GroupFilter::get_const_array();
					foreach ( $tag_temp_array as $tags )
					{
						$tag = $tag_const_array[$tags];
						array_push($tag_array, $tag);
					}
					$tag_temp = implode(", ", $tag_array);
					$info_list['标签内容'] = $tag_temp;
				}
				if (!empty($row['description'])) {
					$info_list['群组描述'] = strip_tags($row['description']);
				}
				//Community announcement
				if (!empty($row['announcement'])) 
				{
					$info_list['群组公告'] = strip_tags($row['announcement']);
				}
			}
			return $info_list;
		}

		// !!! [CR2] get album cover list for group page
		public static function get_album_cover_list($pid, $gid, $limit = 4, $start = 0) {
			// #1 default value
			$album_cover_list = array('previous' => '',
									  'next' => '',
									  'action' => 'show_album_group('.$gid.',',
									  'albums' => array()
									 );
			// #2 get album id list
			$album_id_list = AlbumDAO::get_album_id_list_group($gid);
			if(count($album_id_list) > $limit && $start < count($album_id_list)-1) {
				$s = $start + $limit;
				$album_cover_list['next'] = 'showMoreAlbum_group('.$gid.', '.$s.')';
			}
			if($start >= $limit) {
				$s = $start - $limit;
				$album_cover_list['previous'] = 'showMoreAlbum_group('.$gid.', '.$s.')';
			}
			$album_id_list = array_slice($album_id_list, $start, $limit);
			
			// #3 get values
			foreach ($album_id_list as $album_id) {
				$album_cover = AlbumDAO::get_album_cover_aid($album_id);
				array_push($album_cover_list['albums'], $album_cover);
			}
			return $album_cover_list;
		}
		
		// !!! [CR3] get feed list for group page
		public static function get_feed_list($pid, $gid, $tag_id = 0,$bd_start = 0, $bd_limit = 20, $cm_start = 0, $cm_limit = 3) {
			return BoardDAO::get_feed_list($pid, 'group', $gid, $tag_id, $bd_start, $bd_limit, $cm_start, $cm_limit);
		}

		// #ContentFunction
		// !!! [CF1] join group
		public static function join_group($pid, $gid) {
			$role = PeopleDAO::get_group_role_pid($pid, $gid);
			$privacy = self::get_group_privacy_gid($gid);
			if ($privacy == Privacy::NonExist) {
				return false;
			}
			switch ($role) {
				case Role::None:
					if ($privacy >= Role::Member) {
						PeopleDAO::set_group_role_pid($pid, $gid, Role::Pending);
					}
					else {
						PeopleDAO::set_group_role_pid($pid, $gid, Role::Member);						
					}
					return true;
				case Role::Invited:
					PeopleDAO::set_group_role_pid($pid, $gid, Role::Member);
					return true;
			}
			return false;
		}

		// !!! [CF2] leave group
		public static function leave_group($pid, $gid) {
			$role = PeopleDAO::get_group_role_pid($pid, $gid);
			switch ($role) {
				case Role::Member:
				case Role::Admin:
					PeopleDAO::set_group_role_pid($pid, $gid, Role::None);
					return true;
			}
			return false;
		}

		// !!! [CF3] delete group
		public static function delete_group($pid, $gid) {
			$role = PeopleDAO::get_group_role_pid($pid, $gid);
			switch ($role) {
				case Role::Owner:
					self::set_group_privacy($gid, Privacy::NonExist);
					PeopleDAO::set_group_role_all($gid, Role::None);
					return true;
			}
			return false;
		}

		// !!! [CF4] upgrade admin
		public static function upgrade_admin($pid, $tpid, $gid) {
			if (PeopleDAO::get_group_role_pid($pid, $gid) != Role::Owner) {
				return false;
			}
			$role = PeopleDAO::get_group_role_pid($tpid, $gid);
			switch ($role) {
				case Role::Member:
					PeopleDAO::set_group_role_pid($tpid, $gid, Role::Admin);
					return true;
			}
			return false;
		}

		// !!! [CF5] degrade admin
		public static function degrade_admin($pid, $tpid, $gid) {
			if (PeopleDAO::get_group_role_pid($pid, $gid) != Role::Owner) {
				return false;
			}
			$role = PeopleDAO::get_group_role_pid($tpid, $gid);
			switch ($role) {
				case Role::Admin:
					PeopleDAO::set_group_role_pid($tpid, $gid, Role::Member);
					return true;
			}
			return false;
		}

		// !!! [CF6] delete member
		public static function delete_member($pid, $tpid, $gid) {
			if (PeopleDAO::get_group_role_pid($pid, $gid) < Role::Admin) {
				return false;
			}
			$role = PeopleDAO::get_group_role_pid($tpid, $gid);
			switch ($role) {
				case Role::Invited:
				case Role::Pending:
				case Role::Member:
					PeopleDAO::set_group_role_pid($tpid, $gid, Role::None);
					return true;
			}
			return false;
		}

		// !!! [CF7] create group
		public static function create_group($pid, $group) {
			$mysqli = MysqlInterface::get_connection();
			
			// insert event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO community (title, owner, logo, description, category, size, tag) VALUES (?, ?, ?, ?, ?, ?, ?);');
			$stmt->bind_param('sissiis', $group['title'], $group['owner'], $group['logo'], $group['description'], $group['category'], $group['size'], $group['tag']);
			$stmt->execute();
			
			// get auto generated id
			$gid = $mysqli->insert_id;
			
			$stmt->close();
			
			// grant user host role
			PeopleDAO::set_group_role_pid($pid, $gid, Role::Owner);
			return $gid;
		}
		
		// !!! [CF8] edit group
		public static function edit_info($pid, $gid, $group) {
			$role = PeopleDAO::get_group_role_pid($pid, $gid);
			
			if ($role < Role::Admin) {
				return false;
			}
			
			$mysqli = MysqlInterface::get_connection();
			
			// edit group
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE community SET title=?, description=?, announcement=?, category=?, size=?, tag=? WHERE gid=?;');
			$stmt->bind_param('sssiisi', $group['title'], $group['description'], $group['announcement'], $group['category'], $group['size'], $group['tag'], $gid);
			$stmt->execute();
			return true;
		}

		//create group2album
		public static function create_group_album($gid, $aid) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO group2album VALUES (?, ?);');
			$stmt->bind_param('ii', $gid, $aid);
			$stmt->execute();
			$stmt->close();
			return 0;
		}
		
		/*
		 --------------------------------
		   Getters by id
		 --------------------------------
		 */
		// get group basic info by gid: url, image(small), alt, title
		public static function get_group_basic_gid($gid) {
			// #1 default value
			$group = array(
							'url' => '',
							'image' => DefaultImage::Group.'_small.jpg',  
						    'image_large' => DefaultImage::Group.'_large.jpg',  
							'alt' => '', 
							'title' => ''
							);
			
			// #2 get person basic info
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT logo, title FROM community WHERE gid=? LIMIT 1;');
			$stmt->bind_param('i', $gid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$group['url'] = 'group?gid='.$gid;
				if (!empty($row['logo'])) {
					$group['image'] = $row['logo'].'_small.jpg';
					$group['image_large'] = $row['logo'].'_large.jpg';
				}
				$group['alt']   = strip_tags($row['title']);
				$group['title'] = strip_tags($row['title']);
			}
			$stmt->close();
			return $group;
		}

		// get group's role in event
		public static function get_event_role_gid($gid, $eid) {
			$role = Role::None;
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT role FROM group2event WHERE gid=? AND eid=? LIMIT 1;');
			$stmt->bind_param('ii', $gid, $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$role = $row['role'];
			}
			$stmt->close();
			return $role;
		}

		// get group's privacy
		public static function get_group_privacy_gid($gid) {
			// #1 default value
			$privacy = Privacy::NonExist;
			
			// #2 get group basic info
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT privacy FROM community WHERE gid=? LIMIT 1;');
			$stmt->bind_param('i', $gid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$privacy = $row['privacy'];
			}
			$stmt->close();
			return $privacy;
		}
		
		// get group's next event
		public static function get_group_next_event($gid) {
			// #1 default value
			$event = array();
			
			// #2 get event list
			$event_id_list = EventDAO::get_eid_list_group($gid);
			
			// #3 set the latest one
			$now = time();
			$latest_next_id = 0;
			$latest_next_time = 0;
			foreach ($event_id_list as $eid) {
				$event_time = EventDAO::get_event_time_eid($eid);
				$start_time = strtotime($event_time['start_time']);
				if ($start_time > $now && ($latest_next_id == 0 || $start_time < $latest_next_time)) {
					$latest_next_id = $eid;
					$latest_next_time = $start_time;
				}
			}
			
			// #4 get event basic by id
			if ($latest_next_id > 0) {
				$event = EventDAO::get_event_basic_eid($latest_next_id);
			}
			return $event;
		}
		
		/*
		 --------------------------------
		   Setters
		 --------------------------------
		 */
		public static function set_group_privacy($gid, $privacy) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE community SET privacy=? WHERE gid=?;');
			$stmt->bind_param('ii', $privacy, $gid);
			$stmt->execute();
			$stmt->close();
			return true;
		}

		// set group logo by id
		public static function set_group_logo_gid($gid, $logo) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE community SET logo=? WHERE gid=?;');
			$stmt->bind_param('si', $logo, $gid);
			$stmt->execute();
			$stmt->close();
			return 0;
		}
		

		/*
		 --------------------------------
		   Get id list by foreign key
		 --------------------------------
		 */
		// get group id list of a person(whose role >= member)
		public static function get_gid_list_people($pid) {
			$group_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			// $stmt->prepare('SELECT gid FROM people2group WHERE pid=? AND role>=? ORDER BY mtime DESC LIMIT 1000;');
			$stmt->prepare('SELECT gid, privacy FROM people2group WHERE pid=? AND role>=? AND privacy<'. Privacy::NonExist .' ORDER BY mtime DESC LIMIT 1000;');
			$role = Role::Member;
			$stmt->bind_param('ii', $pid, $role);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($group_ids, $row['gid']);
			}
			$stmt->close();
			return $group_ids;
		}
		//get group id list of a person(whose role > member)
		public static function get_gid_list_people_admin($pid) {
			$group_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT gid FROM people2group WHERE pid=? AND role>=? ORDER BY mtime DESC LIMIT 1000;');
			$role = Role::Admin;
			$stmt->bind_param('ii', $pid, $role);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($group_ids, $row['gid']);
			}
			$stmt->close();
			return $group_ids;
		}

		/*+++++++++++++++热门群组+++++++++++++++*/
		public static function get_hot_group_list($pid, $start = 0, $limit = 5)
		{
			$hot_group_list_unsorted = array();
			$hot_group_list_sorted = array();
			$limit_plus = 1000;
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT gid, logo, title, privacy FROM community WHERE privacy<'. Privacy::NonExist .' ORDER BY ctime DESC LIMIT ?,?;');
			$stmt->bind_param('ii', $start, $limit_plus);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$gid = $row['gid'];
				$group['url'] = 'group?gid='.$gid;
				$role = PeopleDAO::get_group_role_pid($pid, $gid);
				if ($role != Role::Invited && $role < $row['privacy']) 
				{
					continue;
				}
				$member_ids = PeopleDAO::get_member_id_list_group($gid);
				$group['title'] = $row['title'];
				$group['size'] = sizeof($member_ids);
				if (!empty($row['logo'])) 
				{
					$group['image'] = $row['logo'].'_small.jpg';
				}
				else 
				{
					$group['image'] = DefaultImage::Group.'_small.jpg';
				}
				array_push($hot_group_list_unsorted, $group);
			}
			$stmt->close();

			usort($hot_group_list_unsorted, "GroupDAO::hot_cmp");

			$hot_group_list_sorted = array_slice($hot_group_list_unsorted, $start, $limit);

			return $hot_group_list_sorted;
		}

		protected static function hot_cmp($a, $b)
		{
			if ($a['size'] < $b['size'])
			{
				return 1;
			}
			else if ($a['size'] = $b['size'])
			{
				return 0;
			}
			else if ($a['size'] > $b['size'])
			{
				return -1;
			}
			
		}
		/*===============热门活动===============*/

		/*+++++++++++++++最新群组+++++++++++++++*/
		public static function get_newest_group_list($pid, $start = 0, $limit = 5)
		{
			$newest_group_list_unsorted = array();
			$newest_group_list_sorted = array();
			$limit_plus = 1000;
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT gid, logo, title, privacy, ctime FROM community WHERE privacy<'. Privacy::NonExist .' ORDER BY ctime DESC LIMIT ?,?;');
			$stmt->bind_param('ii', $start, $limit_plus);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$gid = $row['gid'];
				$role = PeopleDAO::get_group_role_pid($pid, $gid);
				if ($role != Role::Invited && $role < $row['privacy']) 
				{
					continue;
				}
				$group['title'] = $row['title'];
				if (!empty($row['logo'])) 
				{
					$group['image'] = $row['logo'].'_small.jpg';
				}
				else 
				{
					$group['image'] = DefaultImage::Group.'_small.jpg';
				}
				$group['ctime'] = $row['ctime'];

				array_push($newest_group_list_unsorted, $group);
			}
			$stmt->close();

			$newest_group_list_sorted = array_slice($newest_group_list_unsorted, $start, $limit);

			return $newest_group_list_sorted;
		}
		/*===============最新群组===============*/

		/*++++++++++++++++++++++++++++++++++++++++ 新生群组 ++++++++++++++++++++++++++++++++++++++++*/
		public static function get_newcome_group_list_large($pid, $category = 0, $limit = 24, $start = 0)
		{
			$newcome_group_list_large = array();
			$group = array();

			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT gid, logo, title, privacy FROM community WHERE isnew>0 AND privacy<'. Privacy::NonExist .' ORDER BY ctime LIMIT ?,?;');
			$stmt->bind_param('ii', $start, $limit);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$gid = $row['gid'];
				$group['url'] = 'group?gid='.$gid;
				$role = PeopleDAO::get_group_role_pid($pid, $gid);
				if ($role != Role::Invited && $role < $row['privacy']) 
				{
					continue;
				}
				$member_ids = PeopleDAO::get_member_id_list_group($gid);
				$group['title'] = $row['title'];
				$group['size'] = sizeof($member_ids);
				if (!empty($row['logo'])) 
				{
					$group['image'] = $row['logo'].'_large.jpg';
				}
				else 
				{
					$group['image'] = DefaultImage::Group.'_large.jpg';
				}
				array_push($newcome_group_list_large, $group);
			}
			$stmt->close();

			return $newcome_group_list_large;
		}

		//<--end of GroupDAO-->
	}
	/*======================================== 新生群组 ========================================*/
?>