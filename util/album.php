<?php
	if(!defined('IN_NBRC')) {
		exit('<h1>403:Forbidden @util:album.php</h1>');
	}
	
	class AlbumDAO {
		/*
		 --------------------------------
		   Core API
		 --------------------------------
		 */

		public static function get_default_album_people($pid) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT pid, album FROM people WHERE pid=? LIMIT 1;');
			$stmt->bind_param('i', $pid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (empty($row['album'])) {
					$stmt->close();
					$aid = AlbumDAO::create_album('个人默认相册', $pid, DefaultImage::People);
					$stmt = $mysqli->stmt_init();
					$stmt->prepare('UPDATE people SET album=? WHERE pid=?;');
					$stmt->bind_param('ii', $aid, $pid);
					$stmt->execute();
					$stmt->prepare('INSERT INTO album2display (aid) VALUES (?);');
					$stmt->bind_param('i', $aid);
					$stmt->execute();
					$stmt->close();					
				}
				else {
					$aid = $row['album'];
					$stmt->close();
				}
				return $aid;
			}
			$stmt->close();
			return 0;
		}

		public static function get_default_album_event($eid) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT eid, album, owner FROM event WHERE eid=? LIMIT 1;');
			$stmt->bind_param('i', $eid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (empty($row['album'])) {
					$stmt->close();
					$aid = AlbumDAO::create_album('活动默认相册', $row['owner'], DefaultImage::Event);
					$stmt = $mysqli->stmt_init();
					$stmt->prepare('UPDATE event SET album=? WHERE eid=?;');
					$stmt->bind_param('ii', $aid, $eid);
					$stmt->execute();
					$stmt->prepare('INSERT INTO album2display (aid) VALUES (?);');
					$stmt->bind_param('i', $aid);
					$stmt->execute();
					$stmt->close();					
				}
				else {
					$aid = $row['album'];
					$stmt->close();
				}
				return $aid;
			}
			$stmt->close();
			return 0;
		}

		public static function get_aid_photoid($photoid) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT aid FROM photo WHERE photo_id=? LIMIT 1;');
			$stmt->bind_param('i', $photoid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$aid = $row['aid'];
				$stmt->close();
				return $aid;
			}
			$stmt->close();

			return 0;
		}

		public static function get_display_aid($aid) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT display FROM album2display WHERE aid=? LIMIT 1;');
			$stmt->bind_param('i', $aid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$display = $row['display'];
			}
			else {
				$display = "0,0,0,0,0,0";
			}
			$stmt->close();

			return $display;
		}

		public static function get_photo_list_people($pid) {
			$aid = self::get_default_album_people($pid);
			if ($aid != 0) {
				$album = AlbumDAO::get_album_aid($aid);
				return $album['photo_list'];
			}
			return array();
		}

		public static function get_photo_display_people($pid) {
			$aid = self::get_default_album_people($pid);
			$display = "0,0,0,0,0,0";
			$photo_display = array();
			$photo_list  = self::get_album_aid_limit($aid, 5, 0)['photo_list'];
			$photo_flag = 0;
			if ($aid != 0) {
				$display = self::get_display_aid($aid);
			}
			$display_array = explode(",", $display);
			foreach ($display_array as $photo_id) {
				$photo_id = (int)$photo_id;
				if ($photo_id == 0) {
					if(isset($photo_list[$photo_flag])) {
						$photo_default = $photo_list[$photo_flag];
						$photo_flag++;
					} else {
						$photo_default = array('photo_id' => 0, 
							   'image' => DefaultImage::Photo.'.png',
							   'title' => '暂无图片',
							   'alt' => '暂无图片'
							   );
					}
					
					array_push($photo_display, $photo_default);
				}
				else
					array_push($photo_display, self::get_photo_id($photo_id));
			}
			return $photo_display;
		}
		
		public static function get_photo_list_event($eid)
		{
			$aid = self::get_default_album_event($eid);
			if ($aid != 0)
			{
				$album = AlbumDAO::get_album_aid($aid);
				return $album['photo_list'];
			}
			return array();		
		}

		public static function get_photo_display_event($eid) {
			$aid = self::get_default_album_event($eid);
			$display = "0,0,0,0,0,0";
			$photo_display = array();
			$photo_list  = self::get_album_aid_limit($aid, 6, 0)['photo_list'];
			$photo_flag = 0;
			if ($aid != 0) {
				$display = self::get_display_aid($aid);
			}
			$display_array = explode(",", $display);
			foreach ($display_array as $photo_id) {
				$photo_id = (int)$photo_id;
				if ($photo_id == 0) {
					if(isset($photo_list[$photo_flag])) {
						$photo_default = $photo_list[$photo_flag];
						$photo_flag++;
					} else {
						$photo_default = array('photo_id' => 0, 
									// 'image' => DefaultImage::Photo.'.png',
									'image' => '',
									'title' => '暂无图片',
									'alt' => '暂无图片'
							   );
					}

					array_push($photo_display, $photo_default);
				}
				else
					array_push($photo_display, self::get_photo_id($photo_id));
			}
			return $photo_display;			
		}
		
		// set people album photo by id
		public static function add_photo_people($pid, $photo, $title='default')
		{
			$aid = self::get_default_album_people($pid);
			if ($aid != 0) {
				$mysqli = MysqlInterface::get_connection();
				$stmt = $mysqli->stmt_init();
				$stmt->prepare('INSERT INTO photo (aid, title, owner, file) VALUES (?, ?, ?, ?);');
				$stmt->bind_param('isis', $aid, $title, $pid, $photo);
				$stmt->execute();
				$stmt->close();
			}
			return 0;
		}

		// set people album photo by id
		public static function add_photo_event($eid, $photo, $owner, $title="default") 
		{
			$aid = self::get_default_album_event($eid);
			if ($aid != 0) {
				$mysqli = MysqlInterface::get_connection();		
				$stmt = $mysqli->stmt_init();
				$stmt->prepare('INSERT INTO photo (aid, title, owner, file) VALUES (?, ?, ?, ?);');
				$stmt->bind_param('isis', $aid, $title, $owner, $photo);
				$stmt->execute();
				$stmt->close();
			}
			return 0;
		}

		/*
		 --------------------------------
		   Getters by id
		 --------------------------------
		 */
		// get photo by photo id
		public static function get_photo_id($photo_id) {
			// #1 default value
			$photo = array(
						   'photo_id' => $photo_id,
						   'image' => DefaultImage::Photo.'_large.jpg',
						   'title' => '',
						   'alt'   => ''
			);
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT title, file FROM photo WHERE photo_id=? LIMIT 1;');
			$stmt->bind_param('i', $photo_id);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (!empty($row['file'])) {
					$photo['image'] = $row['file'].'_large.jpg';
				}
				$photo['alt']     = strip_tags($row['title']);
				$photo['title']   = strip_tags($row['title']);
			}
			$stmt->close();
			return $photo;
		}

		public static function get_photo_full($home, $photo_id) {
			// #1 default value
			$photo = '';
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT file FROM photo WHERE photo_id=? LIMIT 1;');
			$stmt->bind_param('i', $photo_id);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (!empty($row['file'])) {
					$photo = $row['file'].'_full.jpg';
					if(!file_exists($home.$photo)) $photo = '';
				}
			}
			$stmt->close();
			return $photo;
		}
		
		// get album cover by aid
		public static function get_album_cover_aid($aid) {
			// #1 default value
			$album_cover = array(
								 'image'  => DefaultImage::Event.'_large.jpg',
								 'title'  => '',
								 'alt'    => '',
								 'action' => ''
			);
			
			// #2 get values
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT title, cover FROM album WHERE aid=? LIMIT 1');
			$stmt->bind_param('i', $aid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (isset($row['cover'])) {
					$album_cover['image'] = $row['cover'].'_large.jpg';
				}
				$album_cover['title']  = strip_tags($row['title']);
				$album_cover['alt']    = strip_tags($row['title']);
				$album_cover['action'] = $aid;
			}
			$stmt->close();
			return $album_cover;
		}
		
		// get all photos by aid
		public static function get_album_aid($aid) {
			$album = array(
						   'cover'      => array(),
						   'photo_list' => array()
			);
			
			$album['cover'] = self::get_album_cover_aid($aid);

			/*+++++yi for official photo only+++++*/
			$param = "event";
			/*=====yi for official photo only=====*/
			
			// #1 default value
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			// $stmt->prepare('SELECT title, file, photo_id, ctime FROM photo WHERE aid=? ORDER BY ctime DESC;');
			//privacy 99 对任何人都不可见（删除功能）
			$stmt->prepare('SELECT title, file, photo_id, ctime FROM photo WHERE aid=? AND privacy!=99 ORDER BY ctime DESC;');
			$stmt->bind_param('i', $aid);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$photo = array();
				$photo['photo_id'] = $row['photo_id'];
				$photo['ctime'] = $row['ctime'];
				if (!empty($row['file'])) 
				{
					/*+++++for official photo only+++++*/
					if ( stristr($row['file'], $param) === false )
					{
						$photo['image'] = $row['file'].'_large.jpg';
					}
					/*=====for official photo only=====*/				
					else
					{
						$photo['image'] = $row['file'].'_large.jpg';
					}			
				}
				else 
				{
					$photo['image'] = DefaultImage::Photo.'_large.jpg';
				}
				$photo['alt']     = strip_tags($row['title']);
				$photo['title']   = strip_tags($row['title']);

				array_push($album['photo_list'], $photo);
			}
			$stmt->close();
			return $album;
		}

		//get limited photos
		public static function get_album_aid_limit($aid, $limit=20, $start=0) {
			$album = array(
						   'cover'      => array(),
						   'photo_list' => array(),
						   'more' => ''
			);
			
			$album['cover'] = self::get_album_cover_aid($aid);

			/*+++++yi for official photo only+++++*/
			$param = "event";
			/*=====yi for official photo only=====*/
			
			// #1 default value
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			// $stmt->prepare('SELECT title, file, photo_id, ctime FROM photo WHERE aid=? ORDER BY ctime DESC;');
			//privacy 99 对任何人都不可见（删除功能）
			$limit_plus = $limit + 1;
			$stmt->prepare('SELECT title, file, photo_id, ctime FROM photo WHERE aid=? AND privacy!=99 ORDER BY ctime DESC LIMIT ?,?;');
			$stmt->bind_param('iii', $aid, $start, $limit_plus);
			$stmt->execute();
			$result = $stmt->get_result();
			$count = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$count++;
				if($count > $limit) {
					$start = $start + $limit;
					$album['more'] = 'showMorePhoto('. $aid .', '. $limit .', '. $start .')';
					break;
				}
				$photo = array();
				$photo['photo_id'] = $row['photo_id'];
				$photo['ctime'] = $row['ctime'];
				if (!empty($row['file'])) 
				{
					/*+++++for official photo only+++++*/
					if ( stristr($row['file'], $param) === false )
					{
						$photo['image'] = $row['file'].'_large.jpg';
					}
					/*=====for official photo only=====*/				
					else
					{
						// $photo['image'] = $row['file'].'.jpg';
						$photo['image'] = $row['file'].'_large.jpg';
					}			
				}
				else 
				{
					$photo['image'] = DefaultImage::Photo.'_large.jpg';
				}
				$photo['alt']     = strip_tags($row['title']);
				$photo['title']   = strip_tags($row['title']);

				array_push($album['photo_list'], $photo);
			}
			$stmt->close();
			return $album;
		}
				
		/*
		 --------------------------------
		   Setters
		 --------------------------------
		 */
		//create new album
		public static function create_album($title, $pid, $cover) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO album (title, owner, cover) VALUES (?, ?, ?);');
			$stmt->bind_param('sis', $title, $pid, $cover);
			$stmt->execute();
			//get auto generated album id
			$aid = $mysqli->insert_id;
			$stmt->close();
			return $aid;
		} 
		// set group album photo by id
		public static function set_album_photo_aid($aid, $uid, $photo, $title="默认") {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO photo (aid, title, owner, file) VALUES (?, ?, ?, ?);');
			$stmt->bind_param('isis', $aid, $title, $uid, $photo);
			$stmt->execute();
			$stmt->close();
			return 0;
		}
		// set group album cover by id
		public static function set_album_cover_aid($aid, $cover) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE album SET cover=? WHERE aid=?;');
			$stmt->bind_param('si', $cover, $aid);
			$stmt->execute();
			$stmt->close();
			return 0;
		}

		//set people display photo
		public static function set_display_aid($aid, $index, $new_photoid) {
			$display_array = explode(",", self::get_display_aid($aid));
			$display_array[$index] = $new_photoid;
			$display = implode(",", $display_array);
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('UPDATE album2display SET display=? WHERE aid=?;');
			$stmt->bind_param('si', $display, $aid);
			$stmt->execute();

			$stmt->close();
			return 0;
		}

		//delete photos(album type 为1代表个人和活动相册)
		public static function delete_photo_photoids($photoids, $album_type=1) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			foreach ($photoids as $photo_id) {
				$stmt->prepare('UPDATE photo SET privacy=99 WHERE photo_id=?;');
				$stmt->bind_param('i', $photo_id);
				$stmt->execute();

				if ($album_type) {
					$aid = self::get_aid_photoid($photo_id);
					$stmt->prepare('SELECT display FROM album2display WHERE aid=? LIMIT 1;');
					$stmt->bind_param('i', $aid);
					$stmt->execute();
					$result = $stmt->get_result();
					if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$display_array = explode(",", $row['display']);
						$flag = false;
						foreach ($display_array as $key => $display) {
							if((int)$display == $photo_id) {
								$display_array[$key] = "0";	
								$flag = true;
							}
						}
						if ($flag) {
							$display = implode(",", $display_array);
							$stmt->prepare('UPDATE album2display SET display=? WHERE aid=?;');
							$stmt->bind_param('si', $display, $aid);
							$stmt->execute();
						}
					}
				}
			}

			$stmt->close();

			return 0;
		}

		/*
		 --------------------------------
		   Get id list by foreign key
		 --------------------------------
		 */
		// get album id list for event
		// public static function get_album_id_list_event($eid, $limit = 1000) {
		// 	$mysqli = MysqlInterface::get_connection();
		// 	$stmt = $mysqli->stmt_init();
		// 	$stmt->prepare('SELECT aid FROM event2album WHERE eid=? ORDER BY aid DESC LIMIT ?');
		// 	$stmt->bind_param('ii', $eid, $limit);
		// 	$stmt->execute();
		// 	$result = $stmt->get_result();
		// 	$album_ids = array();
		// 	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		// 		array_push($album_ids, $row['aid']);
		// 	}
		// 	$stmt->close();
		// 	return $album_ids;
		// }

		// get album id list for people
		// public static function get_album_id_list_people($pid, $limit = 1000) {
		// 	$mysqli = MysqlInterface::get_connection();
		// 	$stmt = $mysqli->stmt_init();
		// 	$stmt->prepare('SELECT aid FROM people2album WHERE pid=? ORDER BY aid DESC LIMIT ?');
		// 	$stmt->bind_param('ii', $pid, $limit);
		// 	$stmt->execute();
		// 	$result = $stmt->get_result();
		// 	$album_ids = array();
		// 	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		// 		array_push($album_ids, $row['aid']);
		// 	}
		// 	$stmt->close();
		// 	return $album_ids;
		// }

		// get album id list for group
		public static function get_album_id_list_group($gid, $limit = 1000) {
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT aid FROM group2album WHERE gid=? ORDER BY aid DESC LIMIT ?');
			$stmt->bind_param('ii', $gid, $limit);
			$stmt->execute();
			$result = $stmt->get_result();
			$album_ids = array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				array_push($album_ids, $row['aid']);
			}
			$stmt->close();
			return $album_ids;
		}

		/*
		 --------------------------------
		   Non-Public Functions
		 --------------------------------
		 */

		/*
		 --------------------------------
		   Old Version
		   People & Event Display Photo
		 --------------------------------
		 */
		// public static function set_display_photo($old_photoid, $new_photoid, $display) {
		// 	//$display = AlbumDAO::get_display_photoid($old_photoid);
		// 	$mysqli = MysqlInterface::get_connection();
		// 	$stmt = $mysqli->stmt_init();
		// 	$stmt->prepare('UPDATE photo SET display=? WHERE photo_id=?;');
		// 	$stmt->bind_param('ii', $display, $new_photoid);
		// 	$stmt->execute();

		// 	if($old_photoid > 0) {
		// 		$stmt->prepare('UPDATE photo SET display=0 WHERE photo_id=?;');
		// 		$stmt->bind_param('i', $old_photoid);
		// 		$stmt->execute();
		// 	}
		// 	$stmt->close();
		// 	return 0;
		// }

		// public static function get_album_display_aid($aid) {
		// 	$display = array();
			
		// 	$mysqli = MysqlInterface::get_connection();
		// 	$stmt = $mysqli->stmt_init();
		// 	$stmt->prepare('SELECT title, file, photo_id, ctime, display FROM photo WHERE aid=? AND display>0 ORDER BY display;');
		// 	$stmt->bind_param('i', $aid);
		// 	$stmt->execute();
		// 	$result = $stmt->get_result();
		// 	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		// 		$photo = array();
		// 		$photo['photo_id'] = $row['photo_id'];
		// 		$photo['display'] = $row['display'];
		// 		$photo['ctime'] = $row['ctime'];
		// 		if (!empty($row['file'])) {
		// 			$photo['image'] = $row['file'].'_large.jpg';
		// 		}
		// 		else {
		// 			$photo['image'] = DefaultImage::Photo.'_large.jpg';
		// 		}
		// 		$photo['alt']     = strip_tags($row['title']);
		// 		$photo['title']   = strip_tags($row['title']);
		// 		array_push($display, $photo);
		// 	}
		// 	$stmt->close();
		// 	return $display;
		// }

		// public static function get_album_others_aid($aid) {
		// 	$others = array();
			
		// 	$mysqli = MysqlInterface::get_connection();
		// 	$stmt = $mysqli->stmt_init();
		// 	$stmt->prepare('SELECT title, file, photo_id, ctime, display FROM photo WHERE aid=? AND display=0;');
		// 	$stmt->bind_param('i', $aid);
		// 	$stmt->execute();
		// 	$result = $stmt->get_result();
		// 	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		// 		$photo = array();
		// 		$photo['photo_id'] = $row['photo_id'];
		// 		$photo['display'] = $row['display'];
		// 		$photo['ctime'] = $row['ctime'];
		// 		if (!empty($row['file'])) {
		// 			$photo['image'] = $row['file'].'_large.jpg';
		// 		}
		// 		else {
		// 			$photo['image'] = DefaultImage::Photo.'_large.jpg';
		// 		}
		// 		$photo['alt']     = strip_tags($row['title']);
		// 		$photo['title']   = strip_tags($row['title']);
		// 		array_push($others, $photo);
		// 	}
		// 	$stmt->close();
		// 	return $others;
		// }

		// public static function get_photo_display_event($eid) {
		// 	$mysqli = MysqlInterface::get_connection();
		// 	$stmt = $mysqli->stmt_init();
		// 	$stmt->prepare('SELECT eid, album, owner FROM event WHERE eid=? LIMIT 1;');
		// 	$stmt->bind_param('i', $eid);
		// 	$stmt->execute();
		// 	$result = $stmt->get_result();
		// 	if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		// 		if (empty($row['album'])) {
		// 			$stmt->close();
		// 			$aid = AlbumDAO::create_album('活动默认相册', $row['owner'], DefaultImage::Event);
		// 			$stmt = $mysqli->stmt_init();
		// 			$stmt->prepare('UPDATE event SET album=? WHERE eid=?;');
		// 			$stmt->bind_param('ii', $aid, $eid);
		// 			$stmt->execute();
		// 			$stmt->close();
		// 		}
		// 		else {
		// 			$aid = $row['album'];
		// 			$stmt->close();
		// 		}
		// 		$display = AlbumDAO::get_album_display_aid($aid);
		// 		return $display;
		// 	}
		// 	$stmt->close();
		// 	return array();			
		// }

		// public static function get_photo_others_event($eid) {
		// 	$mysqli = MysqlInterface::get_connection();
		// 	$stmt = $mysqli->stmt_init();
		// 	$stmt->prepare('SELECT eid, album, owner FROM event WHERE eid=? LIMIT 1;');
		// 	$stmt->bind_param('i', $eid);
		// 	$stmt->execute();
		// 	$result = $stmt->get_result();
		// 	if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		// 		if (empty($row['album'])) {
		// 			$stmt->close();
		// 			$aid = AlbumDAO::create_album('活动默认相册', $row['owner'], DefaultImage::Event);
		// 			$stmt = $mysqli->stmt_init();
		// 			$stmt->prepare('UPDATE event SET album=? WHERE eid=?;');
		// 			$stmt->bind_param('ii', $aid, $eid);
		// 			$stmt->execute();
		// 			$stmt->close();
		// 		}
		// 		else {
		// 			$aid = $row['album'];
		// 			$stmt->close();
		// 		}
		// 		$others = AlbumDAO::get_album_others_aid($aid);
		// 		return $others;
		// 	}
		// 	$stmt->close();
		// 	return array();			
		// }

		// public static function get_photo_display_people($pid) {
		// 	$mysqli = MysqlInterface::get_connection();
		// 	$stmt = $mysqli->stmt_init();
		// 	$stmt->prepare('SELECT pid, album FROM people WHERE pid=? LIMIT 1;');
		// 	$stmt->bind_param('i', $pid);
		// 	$stmt->execute();
		// 	$result = $stmt->get_result();
		// 	if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		// 		if (empty($row['album'])) {
		// 			$stmt->close();
		// 			$aid = AlbumDAO::create_album('个人默认相册', $pid, DefaultImage::People);
		// 			$stmt = $mysqli->stmt_init();
		// 			$stmt->prepare('UPDATE people SET album=? WHERE pid=?;');
		// 			$stmt->bind_param('ii', $aid, $pid);
		// 			$stmt->execute();
		// 			$stmt->close();					
		// 		}
		// 		else {
		// 			$aid = $row['album'];
		// 			$stmt->close();
		// 		}
		// 		$display = AlbumDAO::get_album_display_aid($aid);
		// 		return $display;
		// 	}
		// 	$stmt->close();
		// 	return array();
		// }

		// public static function get_photo_others_people($pid) {
		// 	$mysqli = MysqlInterface::get_connection();
		// 	$stmt = $mysqli->stmt_init();
		// 	$stmt->prepare('SELECT pid, album FROM people WHERE pid=? LIMIT 1;');
		// 	$stmt->bind_param('i', $pid);
		// 	$stmt->execute();
		// 	$result = $stmt->get_result();
		// 	if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		// 		if (empty($row['album'])) {
		// 			$stmt->close();
		// 			$aid = AlbumDAO::create_album('个人默认相册', $pid, DefaultImage::People);
		// 			$stmt = $mysqli->stmt_init();
		// 			$stmt->prepare('UPDATE people SET album=? WHERE pid=?;');
		// 			$stmt->bind_param('ii', $aid, $pid);
		// 			$stmt->execute();
		// 			$stmt->close();					
		// 		}
		// 		else {
		// 			$aid = $row['album'];
		// 			$stmt->close();
		// 		}
		// 		$others = AlbumDAO::get_album_others_aid($aid);
		// 		return $others;
		// 	}
		// 	$stmt->close();
		// 	return array();
		// }
	}
?>