<?php
	if(!defined('IN_NBRC')) {
		exit('<h1>403:Forbidden @util:event.php</h1>');
	}
	
	class EventDAO {
		/*
		 --------------------------------
		   Core API
		 --------------------------------
		 */
		// #Browser
		// !!! [B0] get event list large for browser
		public static function get_event_list_large($pid, $gowner = 0, $category = 0, $limit = 24, $start = 0) 
		{
			// #1 default value
			$event_list_large = array(
									  'event_list' => array(),
									  'next' => ''
			);

			// #2 get events
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$limit_plus = $limit;
			$start_plus = $start;


			$tt=date('Y-m-d H:i:s');
			// $result=mysql_query("SELECT * FROM mysf order by kfsj>'$tt' desc, abs(UNIX_TIMESTAMP(kfsj)-UNIX_TIMESTAMP('$tt'))");

			// SELECT * FROM dbzus.event order by start_time>@tt desc, if(start_time>@tt,start_time-@tt, @tt-start_time)

			if ( $start > 0 )
			{
				$start_plus = $start+1;
			}

			if ($category > 0)
			{
				// $stmt->prepare('SELECT eid, logo, title, owner, gowner, start_time, location, issale, privacy FROM event WHERE gowner=? AND category=? AND privacy<'. Privacy::NonExist .' ORDER BY ctime DESC LIMIT ?,?;');
				$stmt->prepare('SELECT eid, logo, title, owner, gowner, start_time, location, issale, privacy FROM event WHERE gowner=? AND category=? AND privacy<'. Privacy::NonExist .' order by start_time>? desc, abs(UNIX_TIMESTAMP(start_time)-UNIX_TIMESTAMP(?)) DESC LIMIT ?,?;');
				$stmt->bind_param('iiiiii', $gowner, $category, $tt, $tt, $start_plus, $limit_plus);
			}
			else
			{
				// $stmt->prepare('SELECT eid, logo, title, owner, gowner, start_time, location, issale, privacy FROM event WHERE gowner=? AND privacy<'. Privacy::NonExist .' ORDER BY ctime DESC LIMIT ?,?;');
				// $stmt->bind_param('iii', $gowner, $start_plus, $limit_plus);
				if ( $gowner > 0 )
				{
					$stmt->prepare('SELECT eid, logo, title, owner, gowner, start_time, location, issale, privacy FROM event WHERE gowner=? AND privacy<'. Privacy::NonExist .' ORDER BY start_time>? DESC, abs(UNIX_TIMESTAMP(start_time)-UNIX_TIMESTAMP(?)) DESC LIMIT ?,?;');
					// $stmt->prepare('SELECT eid, logo, title, owner, gowner, start_time, location, issale, privacy FROM event WHERE gowner=? AND privacy<'. Privacy::NonExist .' order by start_time>? DESC, if(start_time>?,start_time-?, ?-start_time) DESC LIMIT ?,?;');
					$stmt->bind_param('iiiii', $gowner, $tt, $tt, $start_plus, $limit_plus);
				}
				else
				{
					$stmt->prepare('SELECT eid, logo, title, owner, gowner, start_time, location, issale, privacy FROM event WHERE gowner>=? AND privacy<'. Privacy::NonExist .' ORDER BY start_time>? DESC, abs(UNIX_TIMESTAMP(start_time)-UNIX_TIMESTAMP(?)) DESC LIMIT ?,?;');
					$stmt->bind_param('iiiii', $gowner, $tt, $tt, $start_plus, $limit_plus);
				}	
			}
			$stmt->execute();
			$result = $stmt->get_result();
			$count = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$eid = $row['eid'];
				$role = PeopleDAO::get_event_role_pid($pid, $eid);
				if ($role != Role::Invited && $role < $row['privacy']) {
					continue;
				}
				// if ( $role < $row['privacy'])
				// {
				// 	continue;
				// }
				
				/*++++++加上官方售票字段++++++*/
				$issale = $row['issale'];
				/*======加上官方售票字段======*/
				$count ++;
				// print_r($count);
				// print_r("</br>");
				// if ($count > $limit)
				// {
				$event_list_large['next'] = $start + $limit;
				// break;
				// }
				$event = array();
				
				// #2.1 basic fields
				$event['info'] = self::get_info_list($pid, $eid);
				$event['url']   = 'event?eid='.$eid;
				if (!empty($row['logo'])) {
					$event['image'] = $row['logo'].'_large.jpg';
				}
				else {
					$event['image'] = DefaultImage::Event.'_large.jpg';
				}
				$event['alt']   = strip_tags($row['title']);
				$event['title'] = strip_tags($row['title']);
				if (!empty($row['start_time']) && substr($row['start_time'], 0, 4) != "0000") 
				{
					$event['start_time'] = substr($row['start_time'], 0, 16);
				}
				if (!empty($row['location'])) 
				{
					$location_temp = strip_tags($row['location']);
					$location_array_temp = explode('|', $location_temp);
					$location_real = implode(', ', $location_array_temp);
					$event['location'] = $location_real;
				}
				
				global $_SCONFIG;
				switch ($role) 
				{
					case Role::None:
						$privacy = PeopleDAO::get_people_privacy_pid($pid);
						if ($privacy == Privacy::NonExist) 
						{
							if ($issale == 0)
							{
								if ( ($_SCONFIG['version'] == 'debug') || (AccountDAO::isMobile()) )
								{
									$event['action'] = array(
														'func' => 'visit(\'\')',	
														'class'  => 'login',
														'name' => '未登录'
													 );
									
								}
								else
								{
									$event['action'] = array(
													 // 'action' => 'visit(\'spec/nyc_only_you\')',
														'func' => 'show_login_panel()',	
														'class'  => 'login',
														'name' => '未登录'
													 );
								}
							}
							else
							{
								// $event['action'] = array(
								// 					 // 'func'  => 'visit(\'spec/nyc_only_you\')',
								// 					 'func'  => 'show_login_panel()',
								// 					 // 'func' => 'visit(\'\')',
								// 					 'class' => 'guest',
								// 					 'name'  => '我要参加'
								// 					 );
								if ( ($_SCONFIG['version'] == 'debug') || (AccountDAO::isMobile()) )
								{
									$event['action'] = array(
														'func' => 'visit(\'\')',	
														'class'  => 'login',
														'name' => '我要参加'
													 );
									
								}
								else
								{
									$event['action'] = array(
													 // 'action' => 'visit(\'spec/nyc_only_you\')',
														'func' => 'show_login_panel()',	
														'class'  => 'login',
														'name' => '我要参加'
													 );
								}
							}							
							break;
						}
						
					case Role::Invited:
						if ($issale == 0)
						{
							$event['action'] = array(
												 'func'  => 'event_oper('.$pid.','.$eid.',\'join\')',
												 'class' => 'join',
												 'name'  => '参加活动'
												 );
						}						
						/*++++++加上官方售票字段++++++*/
						else
						{
							$event['action'] = array(
												 'func'  => 'event_oper('.$pid.','.$eid.',\'buy\')',
												 'class' => 'join',
												 'name'  => '购票'
												 );
						}
						/*======加上官方售票字段======*/
						break;
					case Role::Pending:
						$event['action'] = array(
												 'func'  => '',
												 'class' => 'pending',
												 'name'  => '等待通过'
												 );
						break;
					case Role::Member:
						/*++++++官方售票++++++*/
						if ( $issale == 1 )
						{
							$event['action'] = array(
											   'func' => 'visit(\'event?eid='.$eid.'\')',
											   'class'  => 'member',
											   'name'  => '已购票'
												);
						}
						/*======官方售票======*/
						else
						{
							$event['action'] = array(
												 'func'  => 'visit(\'event?eid='.$eid.'\')',
												 'class' => 'member',
												 'name'  => '已参加'
												 );
						}				
						break;
					case Role::Admin:
						$event['action'] = array(
												 'func'  => 'visit(\'event?eid='.$eid.'\')',
												 'class' => 'admin',
												 'name'  => '管理活动'
												 );
						break;
					case Role::Owner:
						$event['action'] = array(
												 'func'  => 'visit(\'event?eid='.$eid.'\')',
												 'class' => 'owner',
												 'name'  => '我的活动'
												 );
						break;
				}
				
				// #2.2 get interset of current user's friend list and event member list, including owner
				$member_ids = PeopleDAO::get_member_id_list_event($eid);
				// $friend_ids = PeopleDAO::get_friend_id_list_people($pid);
				// $show_ids = array_intersect($member_ids, $friend_ids);
				$show_ids = $member_ids;
				$event['member_count'] = sizeof($show_ids);
				$show_ids = array_slice($show_ids, 0, 8);

				if (!empty($row['gowner'])) {
					$event['owner'] = GroupDAO::get_group_basic_gid($row['gowner']);
				}
				else {
					$event['owner'] = PeopleDAO::get_people_basic_pid($row['owner']);
				}

				// #2.3 show owner then interset people
				$members = array();
				foreach ($show_ids as $tpid) {
					array_push($members, PeopleDAO::get_people_basic_pid($tpid));
				}
				$event['members'] = $members;
				array_push($event_list_large['event_list'], $event);
			}
			$stmt->close();
			return $event_list_large;
		}
		
		// #ContentLeft
		// !!! [CL1] get event logo for event page
		public static function get_event_logo($pid, $eid) {
			// #1 default value
			$event_logo = array(
								'image'   => DefaultImage::Event.'_large.jpg',
								'alt'     => '',
								'title'   => '',
								'qr_code' => DefaultImage::QR,
								'edit'    => '',
								'url'     => ''
								);
			
			// #2 get logo
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT logo, title FROM event WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (!empty($row['logo'])) {
					$event_logo['image'] = $row['logo'].'_large.jpg';
				}
				$event_logo['alt']     = strip_tags($row['title']);
				$event_logo['title']   = strip_tags($row['title']);
				$event_logo['qr_code'] = QRCodeDAO::get_qr_code_event($eid);
				$event_logo['url']     = QRCodeDAO::get_url_event($eid);
			}
			$stmt->close();
			
			// #3 check edit
			$role = PeopleDAO::get_event_role_pid($pid, $eid);
			if ($role >= Role::Admin)
			{
				if ( Mobile_Detect::deviceType() == 'phone' )
				{
					$event_logo['edit'] = 'window.location=\'logo_original.php?id='.$eid.'\'';
				}
				else
				{
					$event_logo['edit'] = 'window.location=\'logo.php?eid='.$eid.'\'';
				}
			}
			return $event_logo;
		}
		
		/*++++++++++增加issale字段++++++++++*/
		public static function get_event_issale($eid)
		{
			$issale = 0;

			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT issale FROM event WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$issale = $row['issale'];
			}

			$stmt->close();

			return $issale;
		}
		/*==========增加issale字段==========*/


		// !!! [CL2] get event operation buttons for event page
		public static function get_event_oper_button_list($pid, $eid) 
		{
			// #1 default value
			$oper_button = array(
								 'large' => array(),
								 'small' => array()
								 );
			if (self::get_event_privacy_eid($eid) == Privacy::NonExist) {
				$main_oper = array(
								   'action' => '',
								   'class'  => 'ghost_event',
								   'title'  => '不存在'
								   );
				array_push($oper_button['large'], $main_oper);
				return $oper_button;
			}

			// #2 get large
			$role = PeopleDAO::get_event_role_pid($pid, $eid);
			$issale = self::get_event_issale($eid);

			switch ($role) {
				case Role::None:
					$privacy = PeopleDAO::get_people_privacy_pid($pid);
					if ($privacy == Privacy::NonExist) 
					{
						if ($issale == 1)
						{
							// $main_oper = array(
							// 					 // 'action' => 'visit(\'spec/nyc_only_you\')',
							// 						// 'action' => 'visit(\'\')',	
							// 						'action' => 'show_login_panel()',
							// 						'class'  => 'login',
							// 						'title' => '我要参加'
							// 					 );
							if ( ($_SCONFIG['version'] == 'debug') || (AccountDAO::isMobile()) )
							{
								$main_oper = array(
												 // 'action' => 'visit(\'spec/nyc_only_you\')',
													'action' => 'visit(\'\')',	
													'class'  => 'login',
													'title' => '我要参加'
												 );
								
							}
							else
							{
								$main_oper = array(
												 // 'action' => 'visit(\'spec/nyc_only_you\')',
													'action' => 'show_login_panel()',	
													'class'  => 'login',
													'title' => '我要参加'
												 );
							}		
						}
						else
						{

							$main_oper = array(
												 // 'action' => 'visit(\'\')',
												 'action' => 'show_login_panel()',	
												 'class'  => 'login',
												 'title' => '请先登录'
												 );	
						}

						array_push($oper_button['large'], $main_oper);
						break;
					}
				case Role::Invited:
					/*++++++官方售票++++++*/
					if ( $issale == 1 )
					{
						$main_oper = array(
										   'action' => 'event_oper('.$pid.','.$eid.',\'buy\')',
										   'class'  => 'join_event',
										   'title'  => '购票'
											);
					}
					/*======官方售票======*/
					else
					{
						$main_oper = array(
										   'action' => 'event_oper('.$pid.','.$eid.',\'join\')',
										   'class'  => 'join_event',
										   'title'  => '参加活动'
											);
					}
					array_push($oper_button['large'], $main_oper);
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
					/*++++++官方售票++++++*/
					if ( $issale == 1 )
					{
						$main_oper = array(
										   'action' => '',
										   'class'  => 'join_event',
										   'title'  => '已购票'
											);
						$main_oper_add = array(
											   'action' => 'event_oper('.$pid.','.$eid.',\'buy\')',
											   'class'  => 'join_event',
											   'title'  => '购买更多'
												);
						array_push($oper_button['large'], $main_oper_add);
					}
					/*======官方售票======*/
					else
					{
						$main_oper = array(
									   'action' => 'event_oper('.$pid.','.$eid.',\'leave\')',
									   'class'  => 'leave_event',
									   'title'  => '退出活动'
									   );
					}					
					array_push($oper_button['large'], $main_oper);
					break;

				case Role::Admin:
					if ( Mobile_Detect::deviceType() == "phone" )
					{
						$main_oper = array(
									   'action' => 'window.location=\'logo_original.php?id='.$eid.'\'',
									   'class'  => 'edit_logo',
									   'title'  => '修改图标'
									   );
					}
					else
					{
						$main_oper = array(
									   'action' => 'window.location=\'logo.php?eid='.$eid.'\'',
									   'class'  => 'edit_logo',
									   'title'  => '修改图标'
									   );
					}
					
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'edit_info('.$pid.','.$eid.',\'event\')',
									   'class'  => 'edit_info',
									   'title'  => '修改信息'
									   );
					array_push($oper_button['large'], $main_oper);
					/*++++++官方售票++++++*/
					if ( $issale == 1 )
					{
						$main_oper = array(
										   'action' => '',
										   'class'  => 'join_event',
										   'title'  => '已购票'
											);
					}
					/*======官方售票======*/
					else
					{
						$main_oper = array(
									   'action' => 'event_oper('.$pid.','.$eid.',\'leave\')',
									   'class'  => 'leave_event',
									   'title'  => '退出活动'
									   );
					}			
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'window.location=\'manage_member.php?eid='.$eid.'\'',
									   'class'  => 'manage_member',
									   'title'  => '管理活动'
									   );
					array_push($oper_button['large'], $main_oper);
					break;

				case Role::Owner:
					if ( Mobile_Detect::deviceType() == "phone" )
					{
						$main_oper = array(
									   'action' => 'window.location=\'logo_original.php?id='.$eid.'\'',
									   'class'  => 'edit_logo',
									   'title'  => '修改图标'
									   );
					}
					else
					{
						$main_oper = array(
									   'action' => 'window.location=\'logo.php?eid='.$eid.'\'',
									   'class'  => 'edit_logo',
									   'title'  => '修改图标'
									   );
					}
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'edit_info('.$pid.','.$eid.',\'event\')',
									   'class'  => 'edit_info',
									   'title'  => '修改信息'
									   );
					array_push($oper_button['large'], $main_oper);
					$main_oper = array(
									   'action' => 'window.location=\'manage_member.php?eid='.$eid.'\'',
									   'class'  => 'manage_member',
									   'title'  => '管理活动'
									   );
					array_push($oper_button['large'], $main_oper);
//					$main_oper = array(
//									   'action' => 'event_oper('.$pid.','.$eid.',\'delete\')',
//									   'class'  => 'delete_event',
//									   'title'  => '取消活动'
//									   );
//					array_push($oper_button['large'], $main_oper);
					break;
			}
			
			// #3 get small list
			/* 
			 $oper_button['small'] = array(
			 array(
			 'action', 'class', 'title'
			 )
			 );
			 */

			/*+++++给Alex加售票权限+++++*/
			if ( AccountDAO::define_superior_member($pid) )
			{
				$main_oper = array(
							   // 'action' => 'event_manage_sale('.$pid.','.$eid.')',
								'action' => 'window.location=\'../account/superior_manage.php?eid='.$eid.'\'',
								'class'  => 'manage_sale',
								'title'  => 'Alex管理'
							   );
				array_push($oper_button['large'], $main_oper);
			}
			/*=====给Alex加售票权限=====*/

			/*+++++给Alex加售票权限+++++*/
			// if ( ($pid == 2) || ($pid == 99) || ($pid == 1234) )
			// {
			// 	$main_oper = array(
			// 				   // 'action' => 'event_manage_sale('.$pid.','.$eid.')',
			// 					'action' => 'window.location=\'../account/superior_manage_mail.php?eid='.$eid.'\'',
			// 					'class'  => 'manage_sale',
			// 					'title'  => '邮件管理'
			// 				   );
			// 	array_push($oper_button['large'], $main_oper);
			// }
			/*=====给Alex加售票权限=====*/

			return $oper_button;
		}

		public static function get_alex_manage_button_list($pid, $eid)
		{
			$oper_button = array();

			$main_oper = array(
							   'action' => 'showSaleForm(1, 2)',
							   'class'  => 'manage_sale',
							   'title'  => '自己售票'
							   );
			array_push($oper_button, $main_oper);

			$main_oper = array(
							   'action' => 'showSaleForm(2, 1)',
							   'class'  => 'manage_sale',
							   'title'  => '其他售票'
							   );
			array_push($oper_button, $main_oper);
			

			/*+++++for Alex use only+++++*/
			$main_oper = array(
							   'action' => 'event_delete_oper('.$pid.','.$eid.',\'delete\')',
							   'class'  => 'delete_event',
							   'title'  => '取消活动'
							   );
			/*=====for Alex use only=====*/
			array_push($oper_button, $main_oper);

			return $oper_button;
		}

		public static function get_alex_manage_nav_tab_list($pid, $eid)
		{
			$nav_tabs = array();

			$isPaypal = self::is_Paypal_Sale($eid);

			if ( $isPaypal )
			{
				$tab = "修改-Uni售票";
				array_push($nav_tabs, $tab);
			}
			else
			{
				$tab = "Uni售票";
				array_push($nav_tabs, $tab);
			}

			$tab = "其他售票";
			array_push($nav_tabs, $tab);

			$tab = "取消活动";
			array_push($nav_tabs, $tab);

			$tab = "发送邮件";
			array_push($nav_tabs, $tab);

			$tab = "成员信息";
			array_push($nav_tabs, $tab);

			return $nav_tabs;
		}
		
		// !!! [CL3] get event map view for event page
		public static function get_event_map_view($pid, $eid) {
			// #1 default value
			$geo_code = array(
							'title' => '',
							'lat'   => '',
							'lng'   => ''
			);
			
			// #2 fill values
			$role = PeopleDAO::get_event_role_pid($pid, $eid);
			$privacy = EventDAO::get_event_privacy_eid($eid);
			if ($role >= $privacy) {
				$mysqli = MysqlInterface::get_connection();
				$stmt = $mysqli->stmt_init();
				$stmt->prepare('SELECT title, geolabel, latitude, longitude FROM event WHERE eid=? LIMIT 1;');
				$stmt->bind_param('i', $eid);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					if (!empty($row['geolabel'])) {
						$geo_code['title'] = strip_tags($row['geolabel']);
					}
					else {
						$geo_code['title'] = strip_tags($row['title']);
					}
					if (!empty($row['latitude'])) {
						$geo_code['lat'] = $row['latitude'];
					}
					if (!empty($row['longitude'])) {
						$geo_code['lng'] = $row['longitude'];
					}
				}
				$stmt->close();
			}
			return $geo_code;
		}
		
		// !!! [CL4] get event member list for event page
		public static function get_event_member_list($pid, $eid, $limit = 12, $start = 0) {
			// #1 default value
			$member_list = array(
								 'admins'  => array(),
								 'members' => array(
								 					'female' => array(),
								 					'male' => array()
								 					)
								 );
			
			// #2 fill admins
			$member_id_list = array();
			$pid_list = PeopleDAO::get_pid_list_event($eid, Role::Owner);
			$member_id_list = array_merge($member_id_list, $pid_list);
			$pid_list = PeopleDAO::get_pid_list_event($eid, Role::Admin);
			$member_id_list = array_merge($member_id_list, $pid_list);
			$role = PeopleDAO::get_event_role_pid($pid, $eid);
			foreach ($member_id_list as $tpid) 
			{
				$admin = PeopleDAO::get_people_basic_pid($tpid);
				$admin['action'] = array();
				$trole = PeopleDAO::get_event_role_pid($tpid, $eid);
				if ($role == Role::Owner && $trole == Role::Admin) {
					$admin['action'][0] = array(
												'title' => '取消管理员',
												'class' => 'degrade',
												'action' => 'emember_oper('.$pid.','.$tpid.','.$eid.',\'degrade\')'
												);
					$admin['action'][1] = array(
												'title' => '删除成员',
												'class' => 'delete',
												'action' => 'emember_oper('.$pid.','.$tpid.','.$eid.',\'delete\')'
												);
				}
				array_push($member_list['admins'], $admin);
			}
			
			// #3 fill members
			$member_id_list = PeopleDAO::get_pid_list_event($eid, Role::Member);

			if ($limit > 0) {
				$member_id_list['female'] = array_slice($member_id_list['female'], $start, $limit);
				$member_id_list['male'] = array_slice($member_id_list['male'], $start, $limit);
			}

			foreach ($member_id_list as $gender => $gender_id_list)
			{
				foreach ($gender_id_list as $tpid) 
				{
					$member = PeopleDAO::get_people_basic_pid($tpid);
					$member['action'] = array();
					$trole = PeopleDAO::get_event_role_pid($tpid, $eid);
					
					if ($role == Role::Owner && $trole == Role::Member) 
					{
						$member['action'][0] = array(
													'title' => '升级管理员',
													 'class' => 'upgrade',
													'action' => 'emember_oper('.$pid.','.$tpid.','.$eid.',\'upgrade\')'
													);
						$member['action'][1] = array(
													'title' => '删除成员',
													 'class' => 'delete',
													'action' => 'emember_oper('.$pid.','.$tpid.','.$eid.',\'delete\')'
													);
					}

					if ($role == Role::Admin && $trole == Role::Member) 
					{
						$member['action'][0] = array(
													'title' => '删除成员',
													 'class' => 'delete',
													'action' => 'emember_oper('.$pid.','.$tpid.','.$eid.',\'delete\')'
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

		// !!! [CL4_2] get event member list for event page (!no gender separated!)
		public static function get_event_member_list_nogender($pid, $eid, $limit = 12, $start = 0) {
			// #1 default value
			$member_list = array(
								 'admins'  => array(),
								 'members' => array()
								 );
			
			// #2 fill admins
			$member_id_list = array();
			$pid_list = PeopleDAO::get_pid_list_event($eid, Role::Owner);
			$member_id_list = array_merge($member_id_list, $pid_list);
			$pid_list = PeopleDAO::get_pid_list_event($eid, Role::Admin);
			$member_id_list = array_merge($member_id_list, $pid_list);
			$role = PeopleDAO::get_event_role_pid($pid, $eid);
			foreach ($member_id_list as $tpid) 
			{
				$admin = PeopleDAO::get_people_basic_pid($tpid);
				$admin['action'] = array();
				$trole = PeopleDAO::get_event_role_pid($tpid, $eid);
				if ($role == Role::Owner && $trole == Role::Admin) 
				{
					$admin['action'][0] = array(
												'title' => '取消管理员',
												'class' => 'degrade',
												'action' => 'emember_oper('.$pid.','.$tpid.','.$eid.',\'degrade\')'
												);
					$admin['action'][1] = array(
												'title' => '删除成员',
												'class' => 'delete',
												'action' => 'emember_oper('.$pid.','.$tpid.','.$eid.',\'delete\')'
												);
				}
				$admin['action'][2] = array(
											'title' => '群发邮件',
											'class' => 'groupmail',
											'action' => 'mail_oper()'
											);
				array_push($member_list['admins'], $admin);
			}
			
			// #3 fill members
			$member_id_list = PeopleDAO::get_pid_list_event_nogender($eid, Role::Member);
			if ($limit > 0) 
			{
				$member_id_list = array_slice($member_id_list, $start, $limit);
			}
			foreach ($member_id_list as $tpid) 
			{
				$member = PeopleDAO::get_people_basic_pid($tpid);
				$member['action'] = array();
				$trole = PeopleDAO::get_event_role_pid($tpid, $eid);
				if ($role == Role::Owner && $trole == Role::Member) 
				{
					$member['action'][0] = array(
												'title' => '升级管理员',
												 'class' => 'upgrade',
												'action' => 'emember_oper('.$pid.','.$tpid.','.$eid.',\'upgrade\')'
												);
					$member['action'][1] = array(
												'title' => '删除成员',
												 'class' => 'delete',
												'action' => 'emember_oper('.$pid.','.$tpid.','.$eid.',\'delete\')'
												);
				}
				if ($role == Role::Admin && $trole == Role::Member) 
				{
					$member['action'][0] = array(
												'title' => '删除成员',
												 'class' => 'delete',
												'action' => 'emember_oper('.$pid.','.$tpid.','.$eid.',\'delete\')'
												);
				}
				array_push($member_list['members'], $member);
			}
			
			return $member_list;
		}

/*get all the members*/
		public static function get_event_member_list_all($pid, $eid, $limit = 1000, $start = 0) {
			// #1 default value
			$member_list = array(
								'title'	=> '',
								'member' => array()
								 );
			// #2 fill title
			$basic = EventDAO::get_event_basic_eid($eid);
			$member_list['title'] = $basic['title'];
			// #3 fill members
			$member_id_list = PeopleDAO::get_pid_list_event_nogender($eid, Role::Member);
			
			if ($limit > 0) {
				$member_id_list = array_slice($member_id_list, $start, $limit);
			}
			foreach ($member_id_list as $tpid) {
				$member = PeopleDAO::get_people_basic_pid($tpid);
				$button_action = PeopleDAO::get_friend_action_list($pid, $tpid);
				$member['button'] = $button_action;
				array_push($member_list['member'], $member);
			}
			
			return $member_list;
		}

	//	$member_id_list_gender = PeopleDAO::get_pid_list_event($eid, Role::Member);
	//	$member_id_list = array_merge($member_id_list_gender['female'], $member_id_list_gender['male']);

		// !!! [CL5] get recommend event list for event page
		public static function get_event_recommend_list($pid, $eid, $limit = 6, $start = 0) {
			// TODO generate recommend event list
			return array();
		}
		
		// #ContentRight
		// !!! [CR1] get event info list for event page
		public static function get_info_list($pid, $eid) 
		{
			// #1 default value
			$info_list = array(
							   'title'  	=> '（暂无）',
							   '活动时间' 	=> ' (待定) ',
							   '活动日期'		=> ' (待定) ',
							   '活动地点' 	=> '（待定）',
							   '活动类型'		=> '（待定）',
							   '规模'		=> ' (待定) ',		
							   '人数规模'	 	=> '（待定）',
							   '人数'		=> ' (待定) ',
							   '活动描述' 	=> '（待定）',
							   '活动地址' 	=> array(),
							   '标签内容' 	=> ''
			);
			$tag_array = array();
			
			// #2 get info list
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT title, start_time, end_time, location, description, category, size, tag, price FROM event WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				if (!empty($row['title'])) 
				{
					$info_list['title'] = strip_tags($row['title']);
				}
				if (!empty($row['start_time']) && substr($row['start_time'], 0, 4) != "0000") 
				{
					$time_label = $row['start_time'];
					$info_list['活动日期'] = $time_label;
					if (!empty($row['end_time']) && substr($row['end_time'], 0, 4) != "0000") 
					{
						$time_label .= ' - '.$row['end_time'];
					}
					$info_list['活动时间'] = $time_label;
				}
				if (!empty($row['location'])) 
				{
					$location_temp = strip_tags($row['location']);
					$location_array_temp = explode('|', $location_temp);
					$location_real = implode(', ', $location_array_temp);
					$info_list['活动地点'] = $location_real;
					$info_list['活动地址']['street'] = $location_array_temp[0];
					$info_list['活动地址']['city'] = $location_array_temp[1];
					$info_list['活动地址']['state'] = $location_array_temp[2];
				}
				if (!empty($row['category'])) 
				{
					$const_array = EventCategory::get_const_array();
					$info_list['活动类型'] = $const_array[$row['category']];
				}
				if (!empty($row['size'])) 
				{
					$member = PeopleDAO::get_member_id_list_event($eid);
					$info_list['规模'] = $row['size'];
					$info_list['人数'] = sizeof($member);
					$info_list['人数规模'] = sizeof($member).'/'.$row['size'];
				}
				if ( $row['tag'] != "" ) 
				{
					$tag_temp = strip_tags($row['tag']);
					$info_list['活动标签'] = $tag_temp;
					$tag_temp_array = explode(",", $tag_temp);
					$tag_const_array = EventFilter::get_const_array();
					foreach ( $tag_temp_array as $tags )
					{
						$tag = $tag_const_array[$tags];
						array_push($tag_array, $tag);
					}
					$tag_temp = implode(", ", $tag_array);
					$info_list['标签内容'] = $tag_temp;
				}
				if (!empty($row['price'])) 
				{
					$info_list['活动收费'] = round($row['price'], 2);
				}
				if (!empty($row['description'])) 
				{
					$info_list['活动描述'] = strip_tags($row['description']);
				}
			}

			return $info_list;
		}
		
		// !!! [CR2] get album cover list for event page
		// public static function get_album_cover_list($pid, $eid, $limit = 4, $start = 0) {
		// 	// #1 default value
		// 	$album_cover_list = array();
			
		// 	// #2 get album id list
		// 	$album_id_list = AlbumDAO::get_album_id_list_event($eid);
		// 	$album_id_list = array_slice($album_id_list, $start, $limit);
			
		// 	// #3 get values
		// 	foreach ($album_id_list as $album_id) {
		// 		$album_cover = AlbumDAO::get_album_cover_aid($album_id);
		// 		array_push($album_cover_list, $album_cover);
		// 	}
			
		// 	return $album_cover_list;
		// }

		// !!! [CR3] get feed list for event page
		public static function get_feed_list($pid, $eid, $tag_id = 0,$bd_start = 0, $bd_limit = 20, $cm_start = 0, $cm_limit = 3) {
			return BoardDAO::get_feed_list($pid, 'event', $eid, $tag_id, $bd_start, $bd_limit, $cm_start, $cm_limit);
		}

		// #ContentFunction
		// !!! [CF1] create event, return eid
		public static function create_event($pid, $event) 
		{	
			if ($pid <= 0) {
				return 0;
			}
			$mysqli = MysqlInterface::get_connection();
			
			// insert event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO event (title, owner, gowner, start_time, end_time, location, logo, description, category, size, tag, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
			$stmt->bind_param('siisssssiiss', $event['title'], $pid, $gid, $event['start_time'], $event['end_time'], $event['location'], $event['logo'], $event['description'], $event['category'], $event['size'], $event['tag'], $event['price']);
			$stmt->execute();
			
			// get auto generated id
			$eid = $mysqli->insert_id;
			
			$stmt->close();
			
			// grant user host role
			PeopleDAO::set_event_role_pid($pid, $eid, Role::Owner);
			return $eid;
		}
		//创建活动身份
		public static function create_event_option($pid)
		{
			$option_list = array(
								'self' => '个人',
								'group' => array()
								);
			$self_group_list = PeopleDAO::get_self_group_list_admin($pid);
			foreach ($self_group_list as $group_list)
			{
				$add_on = array(
								'gid' => $group_list['gid'],
								'title' => $group_list['title']
								);
				array_push($option_list['group'], $add_on);
			}
			return $option_list;
		}

		//!!! [CF1].2 create event by group, return eid
		public static function create_event_gid($pid, $event, $gid = 0, $isschool = 0) 
		{
			// check permission
			if ($pid <= 0) {
				return 0;
			}
			$srole = PeopleDAO::get_group_role_pid($pid, $gid);
			if ($isschool == 0){
			if ($gid > 0) {	
				if ($srole < Role::Admin) {
					$gid = 0;
				}
			}
		    }
			
			if ($event['end_time'] == '') {
				$event['end_time'] = null;
			}
			
			$mysqli = MysqlInterface::get_connection();
			
			// insert event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO event (title, owner, gowner, start_time, end_time, location, logo, description, category, size, tag, price, privacy, verify) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
			$stmt->bind_param('siisssssiissii', $event['title'], $pid, $gid, $event['start_time'], $event['end_time'], $event['location'], $event['logo'], $event['description'], $event['category'], $event['size'], $event['tag'], $event['price'], $event['privacy'], $event['verify']);
			$stmt->execute();

			// get auto generated id
			$eid = $mysqli->insert_id;

			$stmt->close();
			
			// grant user host role
			PeopleDAO::set_event_role_pid($pid, $eid, Role::Owner);

			//insert into group2event
			if ($gid > 0)
			{
				$stmt = $mysqli->stmt_init();
				$stmt->prepare('INSERT INTO group2event (gid, eid, role) VALUES (?, ?, ?);');
				$stmt->bind_param('iii', $gid, $eid, $srole);
				$stmt->execute();
				$stmt->close;
			}

			return $eid;
		}

		// !!! [CF2] join event
		public static function join_event($pid, $eid) {
			$role = PeopleDAO::get_event_role_pid($pid, $eid);
			$privacy = self::get_event_privacy_eid($eid);
			if ($privacy == Privacy::NonExist) {
				return false;
			}
			switch ($role) {
				case Role::None:
					if ($privacy >= Role::Member) {
						PeopleDAO::set_event_role_pid($pid, $eid, Role::Pending);
					}
					else {
						PeopleDAO::set_event_role_pid($pid, $eid, Role::Member);
					}
					return true;
				case Role::Invited:
					PeopleDAO::set_event_role_pid($pid, $eid, Role::Member);
					return true;
			}
			return false;
		}
		
		// !!! [CF3] leave event
		public static function leave_event($pid, $eid) {
			$role = PeopleDAO::get_event_role_pid($pid, $eid);
			switch ($role) {
				case Role::Member:
				case Role::Admin:
					PeopleDAO::set_event_role_pid($pid, $eid, Role::None);
					return true;
			}
			return false;
		}
		
		// !!! [CF4] delete event
		public static function delete_event($pid, $eid) {
			$role = PeopleDAO::get_event_role_pid($pid, $eid);
			switch ($role) {
				case Role::Owner:
					self::set_event_privacy_eid($eid, Privacy::NonExist);
					PeopleDAO::set_event_role_all($eid, Role::None);
					return true;
			}
			return false;
		}
		
		// !!! [CF5] upgrade admin
		public static function upgrade_admin($pid, $tpid, $eid) {
			if (PeopleDAO::get_event_role_pid($pid, $eid) != Role::Owner) {
				return false;
			}
			$role = PeopleDAO::get_event_role_pid($tpid, $eid);
			switch ($role) {
				case Role::Member:
					PeopleDAO::set_event_role_pid($tpid, $eid, Role::Admin);
					return true;
			}
			return false;
		}
		
		// !!! [CF6] degrade admin
		public static function degrade_admin($pid, $tpid, $eid) {
			if (PeopleDAO::get_event_role_pid($pid, $eid) != Role::Owner) {
				return false;
			}
			$role = PeopleDAO::get_event_role_pid($tpid, $eid);
			switch ($role) {
				case Role::Admin:
					PeopleDAO::set_event_role_pid($tpid, $eid, Role::Member);
					return true;
			}
			return false;
		}
		
		// !!! [CF7] delete member
		public static function delete_member($pid, $tpid, $eid) {
			if (PeopleDAO::get_event_role_pid($pid, $eid) < Role::Admin) {
				return false;
			}
			$role = PeopleDAO::get_event_role_pid($tpid, $eid);
			switch ($role) {
				case Role::Invited:
				case Role::Pending:
				case Role::Member:
					PeopleDAO::set_event_role_pid($tpid, $eid, Role::None);
					return true;
			}
			return false;
		}
		
		// !!! [CF8] edit event
		public static function edit_info($pid, $eid, $event) {
			$role = PeopleDAO::get_event_role_pid($pid, $eid);
			
			if ($role < Role::Admin) {
				return false;
			}
			if ($event['end_time'] == '') {
				$event['end_time'] = null;
			}
			
			$mysqli = MysqlInterface::get_connection();
						
			// edit event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE event SET title=?, start_time=?, end_time=?, location=?, description=?, category=?, size=?, tag=?, price=?, privacy=? WHERE eid=?;');
			$stmt->bind_param('sssssiissii', $event['title'], $event['start_time'], $event['end_time'], $event['location'], $event['description'], $event['category'], $event['size'], $event['tag'], $event['price'], $event['privacy'], $eid);
			$stmt->execute();
			return true;
		}
		
		/*
		 --------------------------------
		   Getters by id
		 --------------------------------
		 */
		// get event basic info by eid: url, image(small), alt, title
		public static function get_event_basic_eid($eid) 
		{
			// #1 default value
			$event = array(
						   'url' => '',
						   'image' => DefaultImage::Event. '_small.jpg',
						   'image_large' => DefaultImage::Event.'_large.jpg',  
						   'alt' => '', 
						   'title' => ''
						   );
			
			// #2 get event basic info
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT logo, title FROM event WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$event['url'] = 'event?eid='.$eid;
				if (!empty($row['logo'])) 
				{
					$event['image'] = $row['logo'].'_small.jpg';
					$event['image_large'] = $row['logo'].'_large.jpg';
				}
				$event['alt']   = strip_tags($row['title']);
				$event['title'] = strip_tags($row['title']);
			}
			$stmt->close();
			return $event;
		}

		public static function get_event_detail_eid($eid) 
		{
			// #1 default value
			$event = array(
						   'url' => '',
						   'image' => DefaultImage::Event. '_small.jpg',
						   'image_large' => DefaultImage::Event.'_large.jpg',  
						   'alt' => '', 
						   'title' => ''
						   );
			
			// #2 get event basic info
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			// $stmt->prepare('SELECT logo, title FROM event WHERE eid=? LIMIT 1;');
			$stmt->prepare('SELECT logo, title, owner, gowner, start_time, location, privacy FROM event WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			// $stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$event['url'] = 'event?eid='.$eid;
				if (!empty($row['logo'])) 
				{
					$event['image'] = $row['logo'].'_small.jpg';
					$event['image_large'] = $row['logo'].'_large.jpg';
				}
				$event['alt']   = strip_tags($row['title']);
				$event['title'] = strip_tags($row['title']);
				$event['start_time'] = strip_tags($row['start_time']);

				if (!empty($row['location'])) 
				{
					$location_temp = strip_tags($row['location']);
					$location_array_temp = explode('|', $location_temp);
					$location_real = implode(', ', $location_array_temp);
					$event['活动地点'] = $location_real;
					$event['活动地址']['street'] = $location_array_temp[0];
					$event['活动地址']['city'] = $location_array_temp[1];
					$event['活动地址']['state'] = $location_array_temp[2];
					$member_ids = PeopleDAO::get_member_id_list_event($eid);
					$event['size'] = sizeof($member_ids);
				}
			}
			$stmt->close();
			return $event;
		}

		public static function get_event_privacy_eid($eid) {
			// #1 default value
			$privacy = Privacy::NonExist;
			
			// #2 get group basic info
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT privacy FROM event WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$privacy = $row['privacy'];
			}
			$stmt->close();
			return $privacy;
		}
		
		// get start time and end time
		public static function get_event_time_eid($eid) {
			$event_time = array(
								'start_time' => '',
								'end_time' => ''
			);
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT start_time, end_time FROM event WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (!empty($row['start_time']) && substr($row['start_time'], 0, 4) != "0000") {
					$event_time['start_time'] = $row['start_time'];
				}
				if (!empty($row['end_time']) && substr($row['end_time'], 0, 4) != "0000") {
					$event_time['end_time'] = $row['end_time'];
				}
			}
			$stmt->close();
			return $event_time;
		}
		
		/*
		 --------------------------------
		   Setters
		 --------------------------------
		 */
		// set geocode
		public static function set_event_geocode_eid($eid, $title, $latitude, $longitude) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE event SET geolabel=?, latitude=?, longitude=? WHERE eid=?;');
			$role = Role::Member;
			$stmt->bind_param('sddi', $title, $latitude, $longitude, $eid);
			$stmt->execute();
			$stmt->close();
			return true;
		}
		
		// set privacy
		public static function set_event_privacy_eid($eid, $privacy) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE event SET privacy=? WHERE eid=?;');
			$stmt->bind_param('ii', $privacy, $eid);
			$stmt->execute();
			$stmt->close();
			return true;
		}
		
		// set group logo by id
		public static function set_event_logo_eid($eid, $logo) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE event SET logo=? WHERE eid=?;');
			$stmt->bind_param('si', $logo, $eid);
			$stmt->execute();
			$stmt->close();
			return 0;
		}
		

		/*
		 --------------------------------
		   Get id list by foreign key
		 --------------------------------
		 */
		// get person event id list (whose role >= member)
		public static function get_eid_list_people($pid) {
			$event_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT eid, privacy FROM people2event WHERE pid=? AND role>=? AND privacy <'. Privacy::NonExist .' ORDER BY mtime DESC LIMIT 1000;');
			$role = Role::Member;
			$stmt->bind_param('ii', $pid, $role);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($event_ids, $row['eid']);
			}
			$stmt->close();

			return $event_ids;
		}

		// get group event id list (whose role >= admin)
		public static function get_eid_list_group($gid) 
		{
			$event_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT eid, privacy FROM group2event WHERE gid=? AND role>=? AND privacy <'. Privacy::NonExist .' ORDER BY mtime DESC LIMIT 1000;');
			$role = Role::Admin;
			$stmt->bind_param('ii', $gid, $role);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($event_ids, $row['eid']);
			}
			$stmt->close();
			return $event_ids;
		}

		/*以下是为index_in页面推荐event,人为设定*/
		public static function get_event_basic_eid_large($eid) {
			// #1 default value
			$event = array(
						   'url' => '',
						   'image' => DefaultImage::Event. '_large.jpg',  
						   'alt' => '', 
						   'title' => ''
						   );
			
			// #2 get event basic info
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT logo, title FROM event WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$event['url'] = 'event?eid='.$eid;
				if (!empty($row['logo'])) {
					$event['image'] = $row['logo'].'_large.jpg';
				}
				$event['alt']   = strip_tags($row['title']);
				$event['title'] = strip_tags($row['title']);
			}
			$stmt->close();
			return $event;
		}
/*
		public static function get_index_event_list()
		{
			// #1 event id list
			$index_event_id_list = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$limit = 4;
			$stmt->prepare('SELECT eid FROM event WHERE privacy='. Privacy::All .' ORDER BY eid DESC LIMIT ?;');
			$stmt->bind_param('i', $limit);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($index_event_id_list, $row['eid']);
			}

			// #2 default
			$index_event_list = array();
			
			// #3 get index_event_list
			foreach ($index_event_id_list as $ids)
			{
				$index_event = EventDAO::get_event_basic_eid_large($ids);
				array_push($index_event_list, $index_event);
			}
		
			return $index_event_list;
		}
*/
		public static function get_index_event_list()
		{
			//============#1 请修改这个id_list===============
			$index_event_id_list = array(
										46,
										38,
										38,
										46
											);
			//===============人艰不拆======================
			

			// #2 default
			$index_event_list = array();

			// #3 get index_event_list
			foreach ($index_event_id_list as $ids)
			{
				$index_event = EventDAO::get_event_basic_eid_large($ids);			

				array_push($index_event_list, $index_event);
			}
		

			return $index_event_list;
		}
		/*以上是为index_in页面推荐event,人为设定，纯属...*/	
		/*存储每一笔sale*/
		public static function set_event_sale_eid_oid($pid, $eid, $oid)
		{
			$mysqli = MysqlInterface::get_connection();
			
			// insert event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO Sale (eid, oid, pid) VALUES (?, ?, ?);');
			$stmt->bind_param('iii', $eid, $oid, $pid);
			$stmt->execute();
			
			// get auto generated id
			$sid = $mysqli->insert_id;
			
			$stmt->close();
			
			return true;
		}

		/*+++++++++++++++热门活动+++++++++++++++*/
		public static function get_hot_event_list($pid, $start = 0, $limit = 5)
		{
			$hot_event_list_unsorted = array();
			$hot_event_list_sorted = array();
			$event_ids = array();
			$limit_plus = 1000;
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT eid, logo, title, privacy FROM event WHERE privacy<'. Privacy::NonExist .' ORDER BY ctime DESC LIMIT ?,?;');
			$stmt->bind_param('ii', $start, $limit_plus);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$eid = $row['eid'];
				$event['url']   = 'event?eid='.$eid;
				$role = PeopleDAO::get_event_role_pid($pid, $eid);
				if ($role != Role::Invited && $role < $row['privacy']) 
				{
					continue;
				}
				$member_ids = PeopleDAO::get_member_id_list_event($eid);
				$event['title'] = $row['title'];
				$event['size'] = sizeof($member_ids);
				if (!empty($row['logo'])) 
				{
					$event['image'] = $row['logo'].'_small.jpg';
				}
				else 
				{
					$event['image'] = DefaultImage::Event.'_small.jpg';
				}
				array_push($hot_event_list_unsorted, $event);
			}
			$stmt->close();

			usort($hot_event_list_unsorted, "EventDAO::hot_cmp");

			$hot_event_list_sorted = array_slice($hot_event_list_unsorted, $start, $limit);

			return $hot_event_list_sorted;
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

		/*+++++++++++++++最新活动+++++++++++++++*/
		public static function get_newest_event_list($pid, $start = 0, $limit = 5)
		{
			$newest_event_list_unsorted = array();
			$newest_event_list_sorted = array();
			$event_ids = array();
			$limit_plus = 1000;
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT eid, logo, title, privacy, ctime FROM event WHERE privacy<'. Privacy::NonExist .' ORDER BY ctime DESC LIMIT ?,?;');
			$stmt->bind_param('ii', $start, $limit_plus);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$eid = $row['eid'];
				$event['url']   = 'event?eid='.$eid;
				$role = PeopleDAO::get_event_role_pid($pid, $eid);
				if ($role != Role::Invited && $role < $row['privacy']) 
				{
					continue;
				}
				$event['title'] = $row['title'];
				if (!empty($row['logo'])) 
				{
					$event['image'] = $row['logo'].'_small.jpg';
				}
				else 
				{
					$event['image'] = DefaultImage::Event.'_small.jpg';
				}
				$event['ctime'] = $row['ctime'];

				array_push($newest_event_list_unsorted, $event);
			}
			$stmt->close();

			$newest_event_list_sorted = array_slice($newest_event_list_unsorted, $start, $limit);

			return $newest_event_list_sorted;
		}
		/*===============最新活动===============*/

		/*+++++++++++++++++++ eventbrite access function ++++++++++++++++++++*/
		//#0 access => eventbrite attendee xml page
		//$attendee_xml = simplexml_load_file('https://www.eventbrite.com/xml/event_list_attendees?app_key=V7DWJXIVE4MCEZADXC&id=11737187243&user_key=139543901294252847805&only_display=email,order_id');
		//#1 xml 	=> json
		protected static function access_Eventbrite($param = '')
		{
			/*52*/
			// $file_url = 'https://www.eventbrite.com/xml/event_list_attendees?app_key=V7DWJXIVE4MCEZADXC&id=11737187243&user_key=139543901294252847805'.$param;

			/*63*/
			$file_url = 'https://www.eventbrite.com/xml/event_list_attendees?app_key=V7DWJXIVE4MCEZADXC&id=12034135423&user_key=139543901294252847805'.$param;
			$attendee_xml = simplexml_load_file($file_url);
			$attendee_json = json_encode($attendee_xml, TRUE);
			//#2 json 	=> php array
			$attendee_array = json_decode($attendee_json, TRUE);

			return $attendee_array;
		}

		public function pub_acc_Eb($param = '')
		{
			return self::access_Eventbrite($param);
		}

		protected static function get_attendee_email_oid($oid)
		{
			$attendee_array = self::access_Eventbrite();
			foreach ($attendee_array as $key => $attendee_list)
			{
				foreach ($attendee_list as $key_value => $attendee)
				{
					if ( $attendee['order_id'] == $oid )
					{
						$attendee_email = $attendee['email'];
						break;
					}
					else
					{
						$attendee_email = '###';
					}
				}
			}
			return $attendee_email;
		}

		protected static function get_attendee_name_oid($oid)
		{
			$attendee_array = self::access_Eventbrite();
			foreach ($attendee_array as $key => $attendee_list)
			{
				foreach ($attendee_list as $key_value => $attendee)
				{
					if ( $attendee['order_id'] == $oid )
					{
						$attendee_first_name = $attendee['first_name'];
						$attendee_last_name = $attendee['last_name'];
						$attendee_name = $attendee['first_name']."_".$attendee['last_name'];
						break;
					}
					else
					{
						$attendee_name = '###';
					}
				}
			}
			return $attendee_name;
		}

		protected static function eventbrite_Sign_up($email, $user, $pass='abcdabcd', $code="abcdabcd", $consume = false) 
		{
			if ( Authority::exist_email($email) ) 
			{
				return 0;
			}
			if ( !empty($user) ) 
			{
				if ( Authority::exist_user($user) ) 
				{
					return 0;
				}
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
			
			$signin_result = Authority::sign_in($email, $pass);

			return $pid;
		}

		protected static function eventbrite_Sign_in($email)
		{
			if (empty($email))
			{
				return 2;
			}
			
			$pass = self::get_pwd($email);

			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			if (strpos($email, '@') !== false)
			{
				$stmt->prepare('SELECT uid, email, user FROM login WHERE email=? AND pass=?;');
			}
			else
			{
				$stmt->prepare('SELECT uid, email, user FROM login WHERE user=? AND pass=?;');				
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

		protected static function get_pwd($email)
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pass FROM login WHERE email=? LIMIT 1;');
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$stmt->close();
				return $row['pass'];					
			}
			else 
			{
				$stmt->close();
				return 0;
			}
		}

		public static function get_attendee_uid_oid($oid)
		{
			$attendee_email = self::get_attendee_email_oid($oid);
			$attendee_uid = Authority::like_exist_email($attendee_email);
			
			if ($attendee_uid == 0)
			{
				$attendee_name = self::get_attendee_name_oid($oid);
				if ($attendee_email == "###")
				{

				}
				else
				{
					$attendee_uid = self::eventbrite_Sign_up($attendee_email, $attendee_name);
				}
			}
			else
			{
				$attendee_sign_in = self::eventbrite_Sign_in($attendee_email);
			}
			return $attendee_uid;
			// echo "<script>";
 		// 	echo  "window.location.href=window.location.href;";
  	// 		echo "</script>";
		}

		public static function get_eventbrite_url_eid($eid)
		{
			$address = "";

			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT address, ispaypal FROM Sale WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				if ( $row['ispaypal'] == 1 )
				{
					$stmt->close();

					$address = "payment.php?eid=".$eid;
					return $address;
				}
				else
				{
					$stmt->close();
					return $row['address'];
				}					
			}
			else 
			{
				$stmt->close();
				return 0;
			}
		}

		public static function insert_eventbrite_url($eid, $address)
		{
			$eid_exist = self::sale_eid_exist($eid);

			$mysqli = MysqlInterface::get_connection();	
			// insert
			$stmt = $mysqli->stmt_init();

			if ( $eid_exist )
			{
				$stmt->prepare('UPDATE Sale SET address=? WHERE eid=?;');
				$stmt->bind_param('si', $address, $eid);
				$stmt->execute();

				$sid = 1000000;
			}
			else
			{
				$stmt->prepare('INSERT INTO Sale (eid, address) VALUES (?, ?);');
				$stmt->bind_param('is', $eid, $address);
				$stmt->execute();
				
				// get auto generated id
				$sid = $mysqli->insert_id;
			}		
			
			$stmt->close();
			
			// grant user host role
			$set_sale = self::set_event_sale($eid);

			if ( ($sid) && ($set_sale) )
			{
				return true;
			}
			
			return false;
		}

		protected static function sale_eid_exist($eid)
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT 1 FROM Sale WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->fetch_array(MYSQLI_ASSOC))
			{
				$stmt->close();
				return true;
			}
			$stmt->close();
			return false;
		}

		protected static function set_event_sale($eid)
		{
			$mysqli = MysqlInterface::get_connection();
						
			// edit event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE event SET issale=1 WHERE eid=?;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$stmt->close();
			return true;
		}
		/*==================== eventbrite access function ====================*/


		/*+++++++++++++++++++ paypal payment function ++++++++++++++++++++*/
		/*
		 #1 get ticket information
		*/
		public static function get_ticket_info_eid($eid)
		{
			$ticket_info = array(
									'ticket'	=>	array(),
									'allowance'	=>	0,
									);
			$count = 0;

			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT ticket_id, type, price, volume, remain, tlimit, description FROM sale2paypal WHERE eid=? AND privacy<'. Privacy::NonExist .' LIMIT 1000;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) 
			{
				$ticket['id']			=	$row['ticket_id'];
				$ticket['type']			=	$row['type'];
				$ticket['price']		=	$row['price'];
				$ticket['volume']		=	$row['volume'];
				$ticket['remain']		=	$row['remain'];
				$ticket['tlimit']		=	$row['tlimit'];
				$ticket['description']	=	$row['description'];

				if ( $ticket['remain'] == 0 )
				{
					++$count;
				}

				array_push($ticket_info['ticket'], $ticket);					
			}
			$stmt->close();

			$ticket_info['allowance'] = sizeof($ticket_info['ticket']) - $count;

			return $ticket_info;
		}

		public static function get_sale_info_list($eid)
		{
			$info_list = array(
								'total_sale' => 0.00,
								'info'	=>	array(),
								);

			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT transaction_id, pid, payer_email, items, net, buyer_info FROM paypal WHERE eid=? LIMIT 10000;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			while ( $row = $result->fetch_array(MYSQLI_ASSOC) ) 
			{
				$info['id']				=	$row['transaction_id'];
				$info['pid']			=	$row['pid'];
				$info['email']			=	$row['payer_email'];
				$info['net']			=	$row['net'];

				$items			=	$row['items'];
				$items_arr 		=	explode("|", $items);
				$items_individual_type		=	"";
				$items_individual_quantity	=	"";
	            foreach ($items_arr as $key => $value)
	            {
	            	$items_individual_arr		=	explode(",", $value);
	            	if ( $key == 0 )
	            	{
	            		$items_individual_type		.=	$items_individual_arr[0];
	            		$items_individual_quantity	.=	$items_individual_arr[1];
	            	}
	            	else
	            	{
	            		$items_individual_type		.=	"&".$items_individual_arr[0];
	            		$items_individual_quantity	.=	"&".$items_individual_arr[1];
	            	}
	            }
	            $info['type']		=	$items_individual_type;
	            $info['quantity']	=	$items_individual_quantity;

				$buyer_info		=	$row['buyer_info'];
	            $buyer_arr 		=	explode("|", $buyer_info);
	            $buyer_name 	=	$buyer_arr[0];
	            $buyer_name_arr =	explode(",", $buyer_name);
	            $buyer_name_use	=	$buyer_name_arr[0]." ".$buyer_name_arr[1];
	            $info['name']	=	$buyer_name_use;

				array_push($info_list['info'], $info);
				$info_list['total_sale'] += $info['net'];					
			}
			$stmt->close();

			return $info_list;
		}

		public static function set_uni_ticket($pid, $eid, $ticket) 
		{	
			if ( !AccountDAO::define_superior_member($pid) )
			{
				return 0;
			}

			$mysqli = MysqlInterface::get_connection();
			
			// insert event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO sale2paypal (eid, type, price, volume, remain, tlimit, description) VALUES (?, ?, ?, ?, ?, ?, ?);');
			$stmt->bind_param('issiiis', $ticket['eid'], $ticket['type'], $ticket['price'], $ticket['volume'], $ticket['remain'], $ticket['tlimit'], $ticket['description']);
			$stmt->execute();		
			// get auto generated id
			$ticket_id = $mysqli->insert_id;		
			$stmt->close();

			//event表售票
			$set_sale = self::set_event_sale($eid);

			//sale表售票
			$set_paypal = self::set_paypal_sale($eid);
			
			return $ticket_id;
		}

		public static function edit_uni_ticket($pid, $eid, $ticket)
		{
			if ( !AccountDAO::define_superior_member($pid) )
			{
				return 0;
			}
			
			$mysqli = MysqlInterface::get_connection();
						
			// edit event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE sale2paypal SET eid=?, type=?, price=?, volume=?, remain=?, tlimit=?, description=? WHERE ticket_id=?;');
			$stmt->bind_param('issiiisi', $ticket['eid'], $ticket['type'], $ticket['price'], $ticket['volume'], $ticket['remain'], $ticket['tlimit'], $ticket['description'], $ticket['ticket_id']);
			$stmt->execute();
			$stmt->close();
			
			return $ticket['ticket_id'];
		}

		protected static function set_paypal_sale($eid)
		{
			$eid_exist 	=	self::sale_eid_exist($eid);
			$address	=	"http://nycuni.com/event/payment.php?eid=".$eid;	
			$ispaypal	=	1;

			$mysqli = MysqlInterface::get_connection();

			$stmt = $mysqli->stmt_init();
						
			if ( $eid_exist )
			{
				$stmt->prepare('UPDATE Sale SET ispaypal=?, address=? WHERE eid=?;');
				$stmt->bind_param('isi', $ispaypal, $address, $eid);
				$stmt->execute();

				$sid = 1000000;
			}
			else
			{
				$stmt->prepare('INSERT INTO Sale (eid, address, ispaypal) VALUES (?, ?, ?);');
				$stmt->bind_param('isi', $eid, $address, $ispaypal);
				$stmt->execute();
				
				// get auto generated id
				$sid = $mysqli->insert_id;
			}	

			$stmt->close();

			return true;
		}

		public static function del_paypalsale_type_id($pid, $ticket_id)
		{
			if ( ( $pid == 2 ) || ($pid == 99) )
			{
				self::set_paypalSale_privacy_ticket_id($ticket_id, Privacy::NonExist);

				return true;
			}

			return false;
		}

		// set privacy
		public static function set_paypalSale_privacy_ticket_id($ticket_id, $privacy)
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE sale2paypal SET privacy=? WHERE ticket_id=?;');
			$stmt->bind_param('ii', $privacy, $ticket_id);
			$stmt->execute();
			$stmt->close();
			return true;
		}

		public static function is_Paypal_Sale($eid)
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT ispaypal FROM Sale WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ( $row = $result->fetch_array(MYSQLI_ASSOC) )
			{
				$isPaypal = $row['ispaypal'];
				$stmt->close();

				if ( $isPaypal == 1 )
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			$stmt->close();
			return false;
		}

		public static function ipn_handle($order)
		{
			$mysqli = MysqlInterface::get_connection();
			
			// insert event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO paypal(transaction_id, pid, eid, payer_email, items, net, payer_status, buyer_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?);');
			$stmt->bind_param('siisssss', $order['transaction_id'], $order['pid'], $order['eid'], $order['payer_email'], $order['items'], $order['net'], $order['payer_status'], $order['buyer_info']);
			$stmt->execute();		
			// get auto generated id
			$order_id = $mysqli->insert_id;		
			$stmt->close();

			//event表售票
			
			return $order_id;
		}

		protected static function update_sale2paypal_remain($eid, $type, $quantity)
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE sale2paypal SET remain=remain-?, tlimit=remain WHERE eid=? AND type=?;');
			$stmt->bind_param('iis', $quantity, $eid, $type);
			$stmt->execute();
			$stmt->close();
			return true;
		}

		public static function update_sale2paypal_remain_order($order)
		{
			$eid = $order['eid'];
			$items = $order['items'];

			$item_array = explode("|", $items);
			$type_nums = sizeof($item_array);

			for ($i=0; $i < $type_nums; $i++)
			{ 
				$item_individual_array = explode(",", $item_array[$i]);
				$type = $item_individual_array[0];
				$quantity = $item_individual_array[1];

				self::update_sale2paypal_remain($eid, $type, $quantity);
			}
		}

		public static function generate_order_num()
		{
			$ycode = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j');
			$ordersn = $ycode[intval(date('y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

			return $ordersn;
		}

		public static function ipn_test($default = "test")
		{
			$test = "test";
			$test_2 = "test";
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO fcbs14(pid, lottery, description) VALUES (2, ?, ?);');
			$stmt->bind_param('ss', $default, $test_2);
			$stmt->execute();
			$stmt->close();
			return true;
		}

		public static function ipn_ismail($transaction_id)
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT 1 FROM paypal WHERE transaction_id=? LIMIT 1;');
			$stmt->bind_param('s', $transaction_id);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->fetch_array(MYSQLI_ASSOC)) {
				$stmt->close();
				return true;
			}
			$stmt->close();
			return false;
		}

		public static function ipn_update_mail($transaction_id)
		{
			$ismail = 1;
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE paypal SET ismail=? WHERE transaction_id=?;');
			$stmt->bind_param('is', $ismail, $transaction_id);
			$stmt->execute();
			$stmt->close();
			return true;
		}

		public static function ipn_ismail_is($transaction_id)
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT ismail FROM paypal WHERE transaction_id=? LIMIT 1;');
			$stmt->bind_param('s', $transaction_id);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				if ( $row['ismail'] == 1 )
				{
					$stmt->close();
					return true;
				}
			}
			$stmt->close();
			return false;
		}

		public static function ipn_verify($transaction_id)
		{
			$mysqli = MysqlInterface::get_connection();
			
			// insert event
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO ipn_verify(transaction_id) VALUES (?);');
			$stmt->bind_param('s', $transaction_id);
			$stmt->execute();		
			// get auto generated id
			$insert_id = $mysqli->insert_id;		
			$stmt->close();

			//event表售票
			
			return $insert_id;
		}

		public static function ipn_isverify($transaction_id)
		{
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT 1 FROM ipn_verify WHERE transaction_id=? LIMIT 1;');
			$stmt->bind_param('s', $transaction_id);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->fetch_array(MYSQLI_ASSOC)) {
				$stmt->close();
				return true;
			}
			$stmt->close();
			return false;
		}

		/*==================== paypal payment function ====================*/

		/* temporary */

		public static function join_event_temp($pid, $eid) {
			$role = PeopleDAO::get_event_role_pid($pid, $eid);
			$privacy = self::get_event_privacy_eid($eid);
			if ($privacy == Privacy::NonExist) {
				return false;
			}
			switch ($role) {
				case Role::None:
					if ($privacy >= Role::Member) {
						PeopleDAO::set_event_role_pid($pid, $eid, Role::Pending);
					}
					else {
						PeopleDAO::set_event_role_pid($pid, $eid, Role::Member);
					}
					return true;
				case Role::Invited:
					PeopleDAO::set_event_role_pid($pid, $eid, Role::Member);
					return true;
			}
			return false;
		}
	}	
?>
