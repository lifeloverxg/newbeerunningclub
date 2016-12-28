<?php
	if(!defined('IN_NBRC')) {
		exit('<h1>403:Forbidden @util:notification.php</h1>');
	}
	
	// Notification System for users.
	class NotificationDAO {
		
		public static function add_notification($pid, $message, $icon, $category = 0, $expire = '') {
			if (empty($icon)) {
				$icon = DefaultImage::Icon;
			}
			if (!isset($category)) {
				$category = 0;
			}
			if (empty($expire)) {
				$edt = new DateTime();
				$edt->modify('+14 day');
				$expire = $edt->format('Y-m-d H:i:s');
			}
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO notification (pid, icon, message, isread, category, expire) VALUES (?, ?, ?, 0, ?, ?);');
			$stmt->bind_param('issis', $pid, $icon, $message, $category, $expire);
			$stmt->execute();
			$stmt->close();
			return true;
		}
		
		public static function get_notifications($pid, $unreadonly = true, $category = 0, $limit = 6) {
			$notification_list = array();
			$isread_bound = 0;
			if (!$unreadonly) {
				$isread_bound = 1;
			}
			if ($limit <= 0) {
				$limit = 10000;
			}
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			if ($category > 0) {
				$stmt->prepare('SELECT nid, pid, icon, message, isread, category FROM notification WHERE pid=? AND isread<=? ORDER BY nid DESC LIMIT ?;');
				$stmt->bind_param('iii', $pid, $isread_bound, $limit);
			}
			else {
				$stmt->prepare('SELECT nid, pid, icon, message, isread, category FROM notification WHERE pid=? AND category=? AND isread<=? ORDER BY nid DESC LIMIT ?;');
				$stmt->bind_param('iiii', $pid, $category, $isread_bound, $limit);
			}
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (!empty($row['nid'])) {
					$notification = array(
										  'nid' => $row['nid'],
										  'pid' => $row['pid'],
										  'icon' => empty($row['icon'])?DefaultImage::Icon:$row['icon'],
										  'message' => $row['message'],
										  'isread' => $row['isread'],
										  'category' => $row['category']
					);
					array_push($notification_list, $notification);
				}
			}
			$stmt->close();
			return $notification_list;
		}
		
		public static function mark_as_read($nid) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE notification SET isread=1 WHERE nid=?;');
			$stmt->bind_param('i', $nid);
			$stmt->execute();
			$stmt->close();
			return true;
		}
		
		public static function clean_up_expired() {
			
		}
	}
?>