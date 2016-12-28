<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @tucao:tucao part1</h1>');
	}

	$pid = Authority::get_uid();
	$article_category = ArticleDAO::get_article_list_small_category();
	$tucao_category = ArticleCategory::f1;
	$article_error = "";

	if ( isset($_POST["tucao6_title"]) && isset($_POST["tucao6_content"]) )
	{
		if($pid > 0) {
			$article = array(
							'title' => $_POST["tucao6_title"],
							'category' => 6,
							'tag' => '',
							'privacy' => 0,
							'content' => $_POST["tucao6_content"]
						);

			$bid = ArticleDAO::post_article_people($pid, $article);

			if ( !empty($bid) )
			{
				$article_category = ArticleDAO::get_article_list_small_category();
			}
		}
		else {
			$article_error = "请先登录";
		}
	}

// Friend List Content
include $home . "template/information/tucao_category.php";
?>