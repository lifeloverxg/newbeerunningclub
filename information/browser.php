<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @information:browser</h1>');
	}

	$title = '浏览资讯 - NBRC - 纽约新蜂跑团';

	$stylesheet = array(
						"theme/zus/information_css/article.css",
						"theme/zus/information_css/information.css",
						"theme/zus/search.css",
						"theme/zus/group_css/post_article.css"
						);

	$javascript = array(
						"js/zus/article/article.js"
						);
	$links = $_SGLOBAL['links'];
	$auth = Authority::get_auth_arr();
	
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

	$article_list_small = ArticleDAO::get_article_list_small($auth['uid']);

	$article_list_large = ArticleDAO::get_article_list_large_all();

	$article_category = ArticleDAO::get_article_list_small_category();
	
	if (PeopleDAO::get_people_privacy_pid($auth['uid']) != Privacy::NonExist) 
	{
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

	$category_list = ArticleCategory::get_const_array(); 
	$article_catalog_list = ArticleCategory::get_const_array();
	$article_privacy_list = Privacy::get_const_array();
	$expression_list = Expression::get_expression_list();
	$exp_path = Expression::get_path();

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

	include S_ROOT."template/information/browser_frame.php";
?>
