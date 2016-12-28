<?php

@define('IN_ZUS', TRUE);
include_once ($home."core.php");

class ZUS_Database
{
	protected static $_connection;
	public static function get_connection()
	{
		if(empty(self::$_connection))
		{
			global $_SCONFIG;
			self::$_connection = new mysqli($_SCONFIG['mysql_host'], $_SCONFIG['mysql_user'], $_SCONFIG['mysql_pass'], $_SCONFIG['mysql_database']);
			$error=self::$_connection->connect_errno;
			while($error)
			{
				time_nanosleep(0, 10000000);
				self::$_connection = new mysqli($_SCONFIG['mysql_host'], $_SCONFIG['mysql_user'], $_SCONFIG['mysql_pass'], $_SCONFIG['mysql_database']);
				$error=self::$_connection->connect_errno;
			}
			self::$_connection->set_charset($_SCONFIG['mysql_charset']);
		}
		return self::$_connection;
	}
}

class FORUM
{
    public static function get_people_info($pid)
    {
        $mysqli = ZUS_Database::get_connection();

        $stmt = $mysqli->stmt_init();
        $stmt->prepare('SELECT name,avatar FROM people WHERE pid = ? ');
        $stmt->bind_param('i', $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        $peopleinfo = array('name' => '',
                        'avatar' => '');

        if( $row = $result->fetch_array(MYSQLI_ASSOC) )
        {
             //echo var_dump($row);
             $peopleinfo['name'] = $row['name'];
             $peopleinfo['avatar'] = $row['avatar'];
        }

        $stmt->close();

        return $peopleinfo;

    }
    public static function get_board_info($bid)
    {
        $mysqli = ZUS_Database::get_connection();

        $stmt = $mysqli->stmt_init();
        $stmt->prepare('SELECT ctime, owner FROM board WHERE bid = ? ');
        $stmt->bind_param('i', $bid);
        $stmt->execute();
        $result = $stmt->get_result();
        $boardinfo = array('ctime' => '',
                            'name' => '' );

        if( $row = $result->fetch_array(MYSQLI_ASSOC) )
        {
            //echo var_dump($row);
            $boardinfo['ctime'] = $row['ctime'];
            $boardinfo['name'] = self::get_people_info($row['owner'])['name']; 
        }

        $stmt->close();

        return $boardinfo;

    }

    public static function get_group_article_list($gowner)
    {
        $mysqli = ZUS_Database::get_connection();

        $stmt = $mysqli->stmt_init();
        $stmt->prepare('SELECT bid, content, ctime FROM board WHERE gowner = ? AND isarticle = 1 ORDER BY ctime ');
        $stmt->bind_param('i', $gowner);
        $stmt->execute();
        $result = $stmt->get_result();
        $article = array();
        $i = 0;

        while( $row = $result->fetch_array(MYSQLI_ASSOC) )
        {
            $article[$i]['url']     = 'information/detail.php?arid='.$row['bid'];
            $article[$i]['title']   = $row['content'];
            $article[$i]['time']    = $row['ctime'];
            $i++;
        }

        $stmt->close();

        return $article;
    }

    // public static function get_group_article_bid($gowner, $limit = 1000)
    // {
    //     $mysqli = ZUS_Database::get_connection();

    //     $stmt = $mysqli->stmt_init();
    //     $stmt->prepare('SELECT bid FROM board WHERE gowner = ? AND isarticle = 1 ORDER BY ctime LIMIT ? ');
    //     $stmt->bind_param('ii', $gowner, $limit);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $article_bid = array();

    //     if( $row = $result->fetch_array(MYSQLI_ASSOC) )
    //     {
    //         $article_bid  = $row; 
    //     }

    //     $stmt->close();

    //     return $article_bid;
    // }

    // public static function get_article_info_bid($bid)
    // {
    //     $mysqli = ZUS_Database::get_connection();

    //     $stmt = $mysqli->stmt_init();        
    //     $stmt->prepare('SELECT bid, title, content, tag FROM article WHERE bid = ? AND privacy = 0');
    //     $stmt->bind_param('i', $bid);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $article = array();
 
    //     // $row = $result->fetch_array(MYSQLI_ASSOC);
    //     // return $row;
        
    //     if ( $row = $result->fetch_array(MYSQLI_ASSOC) )
    //     {
    //         //echo var_dump($row);
            
    //         $article['url']     = 'information/detail.php?arid='.$row['bid'];
    //         $article['title']   = strip_tags($row['title']);
    //         $article['content'] = strip_tags($row['content']);
    //         $article['content'] = str_replace("{[img}", "<img", $article[$i]['content']);
    //         $article['content'] = str_replace("{[br]}", "<br>", $article[$i]['content']);
    //         $article['name']    = self::get_board_info($row['bid'])['name'];
    //         $article['time']    = self::get_board_info($row['bid'])['ctime'];
    //         $article['tag']     = $row['tag'];
    //         $i++;
    //     }

    //     $stmt->close();
    //     return $article;
    // }

    // public static function get_group_article_list($gid, $limit = 1000)
    // {
    //     $article_bid = self::get_group_article_bid($gid, $limit);
    //     $article_list = array();
    //     foreach ($article_bid as $bid) {
    //         $article = self::get_article_info_bid($bid);
    //         array_push($article_list, $article);
    //     }
    //     return $article_list;
    // }

    //  public static function get_group_article_list_page($gid, $page, $pagesize)
    // {
    //     $article_list = self::get_group_article_list($gid, 1000);

    //     $article_list_page = array();

    //     for ($i = ($page-1)*$pagesize; $i != $page*$pagesize; $i++)
    //         array_push( $article_list_page, $article_list[$i] );

    //     return $article_list_page;
    // }
    
    // public static function get_group_article_list_pagenumber( $pagesize )
    // {
    //     $article_list = self::get_group_article_list($gid, 1000);

    //     $pagenumber = (float)sizeof( $article_list ) / $pagesize;
    //     if (sizeof($article_list) % $pagesize == 0)
    //         return $pagenumber;
    //     else 
    //         return ceil( $pagenumber );
    // }



	public static function get_article_info($category, $limit)
	{
		$mysqli = ZUS_Database::get_connection();

        $stmt = $mysqli->stmt_init();
        if ($category == 0)
            $stmt->prepare('SELECT bid, title, content, tag FROM article WHERE category IN (0, 1, 2, 3, 4, 5) AND privacy = 0  ORDER BY bid DESC LIMIT ?');
        elseif ($category == 1)
            $stmt->prepare('SELECT bid, title, content, tag FROM article WHERE category IN (6, 7, 8, 99) AND privacy = 0 ORDER BY bid DESC LIMIT ?');
        else return 0;
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $article = array();
 
        // $row = $result->fetch_array(MYSQLI_ASSOC);
        // return $row;
        $i = 0;
        while ( $row = $result->fetch_array(MYSQLI_ASSOC) )
        {
            //echo var_dump($row);
            
            $article[$i]['url']     = 'information/detail.php?arid='.$row['bid'];
            $article[$i]['title']   = strip_tags($row['title']);
            $article[$i]['content'] = strip_tags($row['content']);
            $article[$i]['content'] = str_replace("{[img}", "<img", $article[$i]['content']);
            $article[$i]['content'] = str_replace("{[br]}", "<br>", $article[$i]['content']);
            $article[$i]['name']    = self::get_board_info($row['bid'])['name'];
            $article[$i]['time']    = self::get_board_info($row['bid'])['ctime'];
            $article[$i]['tag']     = $row['tag'];
            $article[$i]['bid']     = $row['bid'];
            $i++;
        }

        $stmt->close();
        return $article;
    }

    public static function get_article_list_page($category, $page, $pagesize)
    {
        $article_list = self::get_article_info($category, 1000);

        $article_list_page = array();

        for ($i = ($page-1)*$pagesize; $i != $page*$pagesize; $i++){
            if ($article_list[$i] != '')
            array_push( $article_list_page, $article_list[$i] );
        }
        return $article_list_page;
    }

    public static function get_article_list_pagenumber( $pagesize )
    {
        $article_list = self::get_article_info($category, 1000);

        $pagenumber = (float)sizeof( $article_list ) / $pagesize;
        if (sizeof($article_list) % $pagesize == 0)
            return $pagenumber;
        else 
            return ceil( $pagenumber );
    }

     public static function get_comment_info($bid, $limit)
     {
         $mysqli = ZUS_Database::get_connection();

         $stmt = $mysqli->stmt_init();
         $stmt->prepare ('SELECT cid, text, owner, ctime FROM comment WHERE bid = ? ORDER BY cid DESC LIMIT ?');
         $stmt->bind_param('ii', $bid, $limit);
         $stmt->execute();
         $result = $stmt->get_result();

         $comment = array();

         $i = 0;
         while ( $row = $result->fetch_array(MYSQLI_ASSOC) )
         {
            //echo var_dump($row);

            $comment[$i]['text'] = $row['text'];
            $comment[$i]['time'] = $row['ctime'];
            $comment[$i]['name'] = self::get_people_info($row['owner'])['name'];
            $comment[$i]['avatar'] = self::get_people_info($row['owner'])['avatar'];
            $i++;
         }

         $stmt->close();
         return $comment;
    }

}

class School
{
    public static function get_event_list($gid, $limit)
    {
        $mysqli = ZUS_Database::get_connection();

        $stmt = $mysqli->stmt_init();
        $stmt->prepare ('SELECT eid FROM group2event WHERE gid = ? ORDER BY eid DESC LIMIT ?');
        $stmt->bind_param('ii',$gid,$limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $list = array();
         $i = 0;

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $list[$i] = $row;
            $i++;
        }
        return $list;
    }

    public static function get_event_info($eid)
    {
        $mysqli = ZUS_Database::get_connection();

        $stmt = $mysqli->stmt_init();
        $stmt->prepare ('SELECT title, start_time, location, logo FROM event WHERE eid = ?');
        $stmt->bind_param('i',$eid);
        $stmt->execute();
        $result = $stmt->get_result();

        $list = array();


        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $list = $row;      
        }
        return $list;
    }
}
 
