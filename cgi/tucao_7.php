<?php
	$home = '../';
	include_once ($home.'core.php');

	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @tucao:tucao part2</h1>');
	}

	$pid = Authority::get_uid();
	$article_category = ArticleDAO::get_article_list_small_category();
	$tucao_category = ArticleCategory::f2;
	$article_error = "";

	if ( isset($_POST["tucao7_title"]) && isset($_POST["tucao7_content"]) )
	{
		if($pid > 0) {
			$article = array(
							'title' => $_POST["tucao7_title"],
							'category' => 7,
							'tag' => '',
							'privacy' => 0,
							'content' => $_POST["tucao7_content"]
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