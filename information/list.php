<?php
 
    $home = '../';

	include_once ($home.'core.php');

$bm = new Timer();

	   
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @information:browser</h1>');
	}

	 $stylesheet = array(
	 					"template/information_new/header.css"
	 					);

	 $javascript = array(
	 					"template/information_new/test.js"

	 					);
 
	

	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();

    include_once ($home.'template/information_new/back.php');

    if (isset( $_GET['category']) && isset($_GET['page']) )
	{
		$category = $_GET['category'];
		$page = $_GET['page'];
	}
	else {
		header('Location: index.php');
	}

    $pagesize = 20;
    $pagenumber = FORUM::get_article_list_pagenumber( $pagesize );
	$category_name = array( '人在纽约' , '茶余饭后' );
	$article_catalog_list = ArticleCategory::get_const_array();
	$article_privacy_list = Privacy::get_const_array();
	
	$title = '浏览资讯 -'.$category_name[$category].' - NBRC - 纽约新蜂跑团' ;
	
$bm->mark();
	if ( isset($_POST["article_submit"]) && ($_POST["article_submit"]!="") )
	{
		if($auth['uid'] > 0) {
			$article = array(
							'title' => $_POST["article_title"],
							'category' => 6,
							'tag' => $_POST["article_tag"],
							'privacy' => $_POST["article_privacy"],
							'content' => $_POST["article_content"]
						);

			$bid = ArticleDAO::post_article_people($auth['uid'], $article);

			if ( !empty($bid) )
			{
				header('Location: '.$home.'information/index.php');
			}
		}
		else {
			header('Location: ' . $home);
		}
	}

include ($home."template/information_new/list_frame.php");


$bm->mark();
echo '<!-- '.$bm->report().'-->';

?>