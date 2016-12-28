<?php
    
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
 
	$title = '浏览资讯 - NBRC - 纽约新蜂跑团';

	$links = $_SGLOBAL['links'];

	$auth = Authority::get_auth_arr();

    include_once ($home.'template/information_new/back.php');

	$article_catalog_list = ArticleCategory::get_const_array();
	$article_privacy_list = Privacy::get_const_array();

$bm->mark();
	if ( isset($_POST["article_submit"]) && ($_POST["article_submit"]!="") )
	{
		if($auth['uid'] > 0) {
			$article = array(
							'title' => $_POST["article_title"],
							'category' => $_POST["article_category"],
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


include ($home."template/information_new/forum_frame.php");


$bm->mark();
echo '<!-- '.$bm->report().'-->';

?>