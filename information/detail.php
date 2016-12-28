<?php

	$home = '../';
	include_once ($home.'core.php');
	
$bm = new Timer();
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @information:detail</h1>');
	}

	if (isset($_GET['arid'])) {
		$arid = $_GET['arid'];
	}
	else {
		header('Location: browser.php');
	}

	$auth = Authority::get_auth_arr();

	$article_detail = ArticleDAO::get_article_detail_arid($arid);
	$expression_list = Expression::get_expression_list();
	$exp_path = Expression::get_path();

	$title = $article_detail['title'] . ' - 文章内容 - NBRC - 纽约新蜂跑团';
	$stylesheet = array(
						"theme/zus/information_css/article_detail_page.css",
						"theme/zus/search.css",
						"theme/zus/group_css/post_article.css",
						"theme/zus/group_css/group_feed_list.css"
						);
	$javascript = array(
						"js/zus/article/article.js"
						);
	$links = $_SGLOBAL['links'];
$bm->mark();
	
	$tpid = $article_detail['author_id'];
	$large_logo = PeopleDAO::get_people_logo($auth['uid'], $tpid);
	$info_list = PeopleDAO::get_info_list($auth['uid'], $tpid);
	// $info_list['title'] = '作者信息';

	$target_article_list = ArticleDAO::get_my_article_pid($tpid);

	$search = array(
					'catalog' => 0,
					'keyword' => '',
					'func' => array(
									'assist' => '',
									'search' => ''
									)
					);
	
	if (isset($_GET['catalog'])) {
		$search['catalog'] = $_GET['catalog'];
	}
	if (isset($_GET['keyword'])) {
		$search['keyword'] = $_GET['keyword'];
	}

$bm->mark();

	if (PeopleDAO::get_people_privacy_pid($auth['uid']) != Privacy::NonExist) {
		$button_list_large = array(
								   array(
										 'title' => '发表文章',
										 'class' => 'article',
										 'action' => 'post_article(' . $auth['uid'] . ')',
										 )
								   );
	}
	else
	{
		$button_list_large = array();
	}
	
	$article_catalog_list = ArticleCategory::get_const_array();
	$article_privacy_list = Privacy::get_const_array(); 

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
				header('Location: '.$home.'information/detail.php?arid='.$bid);
			}
		}
		else {
			header('Location: ' . $home);
		}
	}
	
	include S_ROOT."template/information/detail_frame.php";
$bm->mark();
echo '<!-- '.$bm->report().'-->';
