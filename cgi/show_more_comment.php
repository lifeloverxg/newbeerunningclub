<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit();
	}

	$auth = Authority::get_auth_arr();	

	$bid = 0;
	if (isset($_GET['bid']) && $_GET['bid'] != ""){
		$bid = $_GET['bid'];
	}

	$start = 0;
	if (isset($_GET['start']) && $_GET['start'] != ""){
		$start = $_GET['start'];
	}

	$num = 24;
	if (isset($_GET['num']) && $_GET['num'] != ""){
		$num = $_GET['num'];
	}

	$result = array(
					'error' => 'none',
					'more' => '',
					'list' => '',
					'id' => $bid
				);

	$comment_list_container = BoardDAO::get_comment_list_bid($auth['uid'], $bid, $num, $start);
	$comment_list_large = $comment_list_container['comment'];
	$next = $comment_list_container['func']['more'];

	foreach ($comment_list_large as $comment) {
		$result['list'] .= "			
										<li>
											<a href='".$home.$comment['owner']['url']."'>
												<img class='logo-small' src='".$home.$comment['owner']['image']."' alt='".$comment['owner']['alt']."' title='".$comment['owner']['title']."'>
											</a>
											<div class='comment-right-area'>
												<!-- replyer name -->
												<a class='replyer-title' href='".$home.$comment['owner']['url']."'>".$comment['owner']['title']."</a>
												<p>".$comment['content']."</p>
												<span class='comment-time-feed'>".$comment['timestamp']."</span>
											</div>
										</li>";
	}

	if (isset($next) && $next != "") {
		$result['more'] = "<a href='javascript:' onclick='".$next."';>查看更多评论</a>";
	}

	echo json_encode($result);