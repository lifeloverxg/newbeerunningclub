<?php
	if ( !defined('IN_ZUS') ) {
		exit('<h1>403:Forbidden @util:article.php</h1>');
	}
	
	class ArticleDAO 
	{
		/*
		 --------------------------------
		   Core API
		 --------------------------------
		 */
		// !!! get article list for any type
		// !!! post article
		public static function post_article($pid, $gid, $article) 
		{
			$role = PeopleDAO::get_group_role_pid($pid, $gid);
			if ($role < Role::Member) {
				return 0;
			}
			
			if (empty($article['title'])) {
				$article['title'] = '无题';
			}
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO board (owner, content, gowner, isarticle, privacy) VALUES (?, ?, ?, 1, ?);');
			$stmt->bind_param('isii', $pid, $article['title'], $gid, $article['privacy']);
			$stmt->execute();
			// get auto generated id
			$bid = $mysqli->insert_id;
			$stmt->close();
			
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO article (bid, title, content, category, tag, privacy) VALUES (?, ?, ?, ?, ?, ?);');
			$stmt->bind_param('issisi', $bid, $article['title'], $article['content'], $article['category'], $article['tag'], $article['privacy']);
			$stmt->execute();
			$stmt->close();
			
			// // #2 post to group self
			// $stmt = $mysqli->stmt_init();
			// $stmt->prepare('INSERT INTO group2board (gid, bid, source) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE source=?;');
			// $stmt->bind_param('iiii', $gid, $bid, $role, $role);
			// $stmt->execute();
			// $stmt->close();

/*以后考虑增不增加article表
			//#3 post to my_article
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO group2board (gid, bid, source) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE source=?;');
			$stmt->bind_param('iiii', $gid, $bid, $role, $role);
			$stmt->execute();
			$stmt->close();
*/

			return $bid;
		}

		//以个人形式发表文章
		public static function post_article_people($pid, $article) 
		{	
			$role = Role::Owner;
			if (empty($article['title'])) {
				$article['title'] = '无题';
			}
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO board (owner, content, isarticle, privacy) VALUES (?, ?, 1, ?);');
			$stmt->bind_param('isi', $pid, $article['title'], $article['privacy']);
			$stmt->execute();
			// get auto generated id
			$bid = $mysqli->insert_id;
			$stmt->close();
			
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO article (bid, title, content, category, tag, privacy) VALUES (?, ?, ?, ?, ?, ?);');
			$stmt->bind_param('issisi', $bid, $article['title'], $article['content'], $article['category'], $article['tag'], $article['privacy']);
			$stmt->execute();
			$stmt->close();
			
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO people2board (pid, bid, source) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE source=?;');
			$stmt->bind_param('iiii', $pid, $bid, $role, $role);
			$stmt->execute();
			$stmt->close();

			return $bid;
		}

		// get article by bid
		public static function get_article_bid($pid, $bid) 
		{
			$article = array(
							 'id'    => $bid,
							 'owner' => array(),
							 'ctime' => '',
							 'title' => '',
							 'content' => '',
							 'category' => 0,
							 'tag' => '',
							 'comments' => array(),
							 'func'      => array(
												  'reply' => 'reply_to('.$pid.','.$bid.')'
												  )
			);
			
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT owner, gowner, ctime, isarticle, privacy FROM board WHERE bid=? LIMIT 1;');
			$stmt->bind_param('i', $bid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if (empty($row['gowner']) || empty($row['isarticle'])) {
					$stmt->close();
					return '';
				}
				$gid = $row['gowner'];
				$role = PeopleDAO::get_group_role_pid($pid, $gid);
				if ($role < $row['privacy']) {
					$stmt->close();
					return '';
				}
				$p_role = PeopleDAO::get_group_role_pid($row['owner'], $gid);
				if ($p_role >= Role::Admin) {
					$article['owner'] = GroupDAO::get_group_basic_gid($row['gowner']);
				}
				else {
					$article['owner'] = PeopleDAO::get_people_basic_pid($row['owner']);
				}
				$article['ctime'] = strip_tags($row['ctime']);
			}
			$stmt->close();
			
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT title, content, category, tag FROM article WHERE bid=? LIMIT 1;');
			$stmt->bind_param('i', $bid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$article['title'] = strip_tags($row['title']);
				$article['content'] = $row['content'];
				$article['category'] = $row['category'];
				$article['tag'] = strip_tags($row['tag']);
			}
			$stmt->close();
			if (empty($article['content'])) {
				return '';
			}
			$article['tag_list'] = array();
			$article['tag_list'][0] = array(
											'class'  => 'on',
											'title'  => '文章',
											'action' => ''
											);
			
			$article['tag_list'][1] = array(
											'class'  => 'off',
											'title'  => '新鲜事',
											'action' => 'update_feed_tag(0,'.$gid.',\'group\')'
											);

			$article['comments'] = BoardDAO::get_comment_list_bid($pid, $bid, 1000, 0);
			return $article;
		}

		public static function get_arid_list_pid($pid)
		{
			$isarticle = 1;
			$article_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT bid, owner, ctime FROM board WHERE owner=? and isarticle=? ORDER BY ctime DESC LIMIT 1000;');
			$stmt->bind_param('ii', $pid, $isarticle);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$article = array(
								'author_id' => $row['owner'],
								'article_id' => $row['bid'],
								'ctime' => $row['ctime']
								);
				array_push($article_ids, $article);
			}
			$stmt->close();

			return $article_ids;
		}

		public static function get_arid_list_all()
		{
			$isarticle = 1;
			$article_ids = array();
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT bid, owner, ctime FROM board WHERE isarticle=? ORDER BY ctime DESC LIMIT 1000;');
			$stmt->bind_param('i', $isarticle);
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$article = array(
								'author_id' => $row['owner'],
								'article_id' => $row['bid'],
								'ctime' => $row['ctime']
								);
				array_push($article_ids, $article);
			}
			$stmt->close();

			return $article_ids;
		}

		public static function get_article_basic_arid($arid)
		{
			//#1 default value
			$article = array(
							'url' => '',
							'title' => '',
							'content' => '',
							'category' => '',
							'tag' => '',
							);

			//#2 get article basic info
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT title, content, category, tag FROM article WHERE bid=? LIMIT 1;');
			$stmt->bind_param('i', $arid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$article['url'] = 'information/detail.php?arid='.$arid;
				$article['title'] = strip_tags($row['title']);
				$article['content'] = $row['content'];
				
				// did you check the ']' at the end of img? 
				// better use regex to replace, sth like replace("\{\[(^[\]]+)\]\}", "\{\[$1\]\}") or sth. you may find useful instructions and tools online, such as regex tester for php
				$article['content'] = str_replace("{[img}", "<img", $article['content']);
				$article['content'] = str_replace("{[br]}", "<br>", $article['content']);
				$article['category'] = strip_tags($row['category']);

				if (!empty($row['tag'])) {
					$article['tag'] = $row['tag'];
				}
			}
			$stmt->close();

			return $article;
		}

		public static function get_my_article_pid($pid)
		{
			$article = array(
							);

			$article_temp = array();
			
			$article_id_list = self::get_arid_list_pid($pid);

			foreach ($article_id_list as $key => $article_id)
			{
				$article_temp['author'] = PeopleDAO::get_people_basic_pid($article_id['author_id']);
				$article_temp['detail'] = self::get_article_basic_arid($article_id['article_id']);
				$article_temp['ctime'] = $article_id['ctime'];
				array_push($article, $article_temp);
			}

			return $article;
		}

		//get all article by article_id_list 
		public static function get_all_article_arids()
		{
			$article = array();
			$article_temp = array();

			$article_id_list = self::get_arid_list_all();

			foreach ($article_id_list as $key => $article_id)
			{
				$article_temp['author'] = PeopleDAO::get_people_basic_pid($article_id['author_id']);
				$article_temp['detail'] = self::get_article_basic_arid($article_id['article_id']);
				$article_temp['ctime'] = $article_id['ctime'];
				array_push($article, $article_temp);
			}

			return $article;
		}

		//sort the article list by ctime
		public static function cmp($a, $b)
		{
			return strcmp($b["ctime"], $a["ctime"]);
		}

		//get_article_by_friend_list sort by ctime
		public static function get_friend_article_list_pid($pid , $limit = 6, $start = 0)
		{
			// #1 default value
			$friend_article_unsorted = array();
			$friend_article_sorted = array();
			$friend_article_temp = array();

			// #2 get id list
			$friend_id_list = PeopleDAO::get_friend_id_list_people($pid);
			
			// #3 fill friend article list
			foreach ($friend_id_list as $friend_id)
			{
				$article_temp = self::get_my_article_pid($friend_id);
				
				if ( !empty($article_temp) )
				{
					foreach($article_temp as $article_temp_list)
					{
						if ( !empty($article_temp_list) )
						{
							array_push($friend_article_unsorted, $article_temp_list);
						}
					}
				}
			}

			usort($friend_article_unsorted, "ArticleDAO::cmp");

			$friend_article_sorted = array_slice($friend_article_unsorted, 0, $limit);

			return $friend_article_sorted;
		}

		public static function get_article_list_small($pid)
		{
			// #1 default value
			$article_list_small = array();

			// #2 fill article_list_large
			$my_article = self::get_my_article_pid($pid);
			$friend_article = self::get_friend_article_list_pid($pid);
			$recommend_article = array();

			$article_list_small = array(
										array(
											'head' => '我的文章',
											'list' => $my_article
											),
										array(
											'head' => '好友文章',
											'list' => $friend_article
											),
										array(
											'head' => '推荐文章',
											'list' => array()
											)
										);

			return $article_list_small;
		}

		public static function get_article_list_large_me($pid, $limit = 10, $start = 0)
		{
			// #1 default value
			$article_list_large_unsorted = array();
			$article_list_large_sorted = array();

			// #2 fill article_list_large
			$my_article = self::get_my_article_pid($pid);
			$friend_article = self::get_friend_article_list_pid($pid);
			$recommend_article = array();

			foreach($my_article as $myarticle)
			{
				array_push($article_list_large_unsorted, $myarticle);
			}

			foreach($friend_article as $friendarticle)
			{
				array_push($article_list_large_unsorted, $friendarticle);
			}

			foreach($recommend_article as $recommendarticle)
			{
				array_push($article_list_large_unsorted, $recommendarticle);
			}

			usort($article_list_large_unsorted, "ArticleDAO::cmp");

			$article_list_large_sorted = array_slice($article_list_large_unsorted, 0, $limit);

			return $article_list_large_sorted;
		}

		public static function get_article_list_large_all($limit = 10, $start = 0)
		{
			// #1 default value
			$article_list_large_all_unsorted = array();
			$article_list_large_all_sorted = array();

			// #2 fill article_list_large_all
			$article_list_large_all_unsorted = self::get_all_article_arids();

			usort($article_list_large_all_unsorted, "ArticleDAO::cmp");

			$article_list_large_all_sorted = array_slice($article_list_large_all_unsorted, 0, $limit);

			return $article_list_large_all_sorted;
		}

		public static function get_article_detail_arid($arid)
		{
			$article = self::get_article_basic_arid($arid);

			//get article post_date and owner
			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT owner, ctime FROM board WHERE bid=? LIMIT 1;');
			$stmt->bind_param('i', $arid);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$article['ctime'] = strip_tags($row['ctime']);
				$author_id = $row['owner'];
			}
			$stmt->close();

			//author_id
			$article['author_id'] = $author_id;
			//get article author information
			$article['author'] = PeopleDAO::get_people_basic_pid($author_id);

			return $article;
		}

		public static function get_article_list_small_category()
		{
			$article_list_category = array(
											ArticleCategory::a => array(),
											ArticleCategory::b => array(),
											ArticleCategory::c => array(),
											ArticleCategory::d => array(),
											ArticleCategory::e => array(),
											ArticleCategory::f1 => array(),
											ArticleCategory::f2 => array(),
											ArticleCategory::f3 => array(),
											ArticleCategory::g => array()
											);
			$article_list = self::get_all_article_arids();

			foreach($article_list as $key => $article)
			{
				switch ( $article['detail']['category'] ) 
				{
					case '1':
						array_push($article_list_category[ArticleCategory::a], $article);
						break;
					case '2':
						array_push($article_list_category[ArticleCategory::b], $article);
						break;
					case '3':
						array_push($article_list_category[ArticleCategory::c], $article);
						break;
					case '4':
						array_push($article_list_category[ArticleCategory::d], $article);
						break;
					case '5':
						array_push($article_list_category[ArticleCategory::e], $article);
						break;
					case '6':
						array_push($article_list_category[ArticleCategory::f1], $article);
						break;
					case '7':
						array_push($article_list_category[ArticleCategory::f2], $article);
						break;
					case '8':
						array_push($article_list_category[ArticleCategory::f3], $article);
						break;
					default:
						array_push($article_list_category[ArticleCategory::g], $article);
						break;
				}
			}

			foreach($article_list_category as $category) {
				if(count($category > 5)) $category = array_slice($category, 0, 5);
			}

			return $article_list_category;
		}

		public static function get_group_article_list($gowner, $limit = 3)
	    {
	    	$article_list = array();
	    	$article_id_list = array();

			$mysqli = MysqlInterface::get_connection();
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('SELECT bid FROM board WHERE gowner = ? AND isarticle = 1 ORDER BY ctime DESC LIMIT ?');
			$stmt->bind_param('ii', $gowner, $limit);
			$stmt->execute();
			$result = $stmt->get_result();

			while( $row = $result->fetch_array(MYSQLI_ASSOC) )
			{
				$article = self::get_article_detail_arid($row['bid']);
				array_push($article_list, $article);
			}
			

			$stmt->close();

			return $article_list;
		}

	}	
?>
