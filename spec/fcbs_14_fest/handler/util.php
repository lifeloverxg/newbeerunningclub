<?php
	@define('IN_FCBS', TRUE);

	if (!defined('IN_ZUS') && !defined('IN_FCBS')) {
		exit('<h1>403:Forbidden @spec/fcbs_14_fest/handler:util.php</h1>');
	}

	// !!! update this if data is truncated !!!
	$fcbs_eid = 24;
	// ########################################
	
	class FCBS14FestDAO {
		public static function sign_up($email, $pass, $name) {
			if (Authority::exist_email($email)) {
				return 1;
			}
			
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO login (email, pass) VALUES (?, PASSWORD(?));');
			$stmt->bind_param('ss', $email, $pass);
			$stmt->execute();
			$pid = $mysqli->insert_id;
			
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO people (pid, name, avatar, privacy, credit) VALUES (?, ?, ?, 0, 0);');
			$avatar = DefaultImage::People;
			$stmt->bind_param('iss', $pid, $name, $avatar);
			$stmt->execute();
			$stmt->close();
			
			return Authority::sign_in($email, $pass);
		}
		
		public static function enroll($pid, $lottery, $description) {
			global $fcbs_eid;
			$role = PeopleDAO::get_event_role_pid($pid, $fcbs_eid);
			switch ($role) {
				case Role::None:
				case Role::Invited:
				case Role::Pending:
					PeopleDAO::set_event_role_pid($pid, $fcbs_eid, Role::Member);
					break;
				case Role::Member:
				case Role::Admin:
				case Role::Owner:
					break;
				case Role::Ghost:
					header('Location: handler/pudding.php');				
					break;
			}
			
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO fcbs14 (pid, lottery, description) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE lottery=?, description=?;');
			$stmt->bind_param('issss', $pid, $lottery, $description, $lottery, $description);
			$stmt->execute();
			return true;
		}
		
		public static function get_spec($pid) {
			$spec = array(
						  'lottery' => '', 
						  'description' => ''
			);
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT lottery, description FROM fcbs14 WHERE pid=? LIMIT 1;');
			$stmt->bind_param('i', $pid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$spec['lottery'] = strip_tags($row['lottery']);
				$spec['description'] = strip_tags($row['description']);
			}
			return $spec;
		}

		public static function get_dashboard($pid) {
			global $fcbs_eid;
			$dashboard = array();
			$member = self::get_member_info($pid, $pid);

			array_push($dashboard, $member);
			$pid_list = PeopleDAO::get_member_id_list_event($fcbs_eid);
			foreach ($pid_list as $tpid) {
				if ($tpid != $pid) {
					$member = self::get_member_info($pid, $tpid);
					array_push($dashboard, $member);
				}
			}
			return $dashboard;
		}
		
		public static function get_member_info($pid, $tpid) {
			$member = PeopleDAO::get_people_basic_pid($tpid);
			$spec = self::get_spec($tpid);
			$member['lottery'] = $spec['lottery'];
			$member['description'] = $spec['description'];
			if ($pid == $tpid) {
				$action = array(
								'action' => 'window.location.href=\'avatar.php\'',
								'class'  => 'edit_info',
								'title'  => '修改头像'
								);
				$action_list = array();
				array_push($action_list, $action);
				$member['button'] = $action_list;				
			}
			else {
				$member['button']  = PeopleDAO::get_friend_action_list($pid, $tpid);
			}
			return $member;
		}
	}
	
	?>
