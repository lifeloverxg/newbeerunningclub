<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit();
	}

	$auth = Authority::get_auth_arr();	

	$tag_id = 0;
	if (isset($_GET['tag']) && $_GET['tag'] != ""){
		$tag_id = $_GET['tag'];
	}

	$page_id = 0;
	if (isset($_GET['id']) && $_GET['id'] != "") {
		$page_id = $_GET['id'];
	}

	$page_type = "";
	if (isset($_GET['type']) && $_GET['type'] != "") {
		$page_type = $_GET['type'];
	}

	$start = 0;
	if (isset($_GET['start']) && $_GET['start'] != "") {
		$start = $_GET['start'];
	}

	$num = 20;
	if (isset($_GET['num']) && $_GET['num'] != "") {
		$num = $_GET['num'];
	}

	$result = array(
					'error' => 'none',
					'more' => '',
					'list' => ''
				);

	$feed_list = array();
	if ($page_type == "event") {
		$feed_list = EventDAO::get_feed_list($auth['uid'], $page_id, $tag_id, $start, $num);
	}
	else if ($page_type == "group") {
		$feed_list = GroupDAO::get_feed_list($auth['uid'], $page_id, $tag_id, $start, $num);
	}
	else if ($page_type == "people") {
		$feed_list = PeopleDAO::get_feed_list($auth['uid'], $page_id, $tag_id, $start, $num);
	}

	$tag_list = $feed_list["tag_list"];
	$feed_list_large = $feed_list["feed_list_large"];
	$next = $feed_list["next"];

	foreach ($feed_list_large as $feed) {
		$result['list'] .= "
						<li class='li-feed-list-large'>
							<!-- left area: poster -->
							<div class='feed-left-area'>
								<a href='".$home.$feed['owner']['url']."'>
									<img class='logo-medium' src='".$home.$feed['owner']['image']."' alt='".$feed['owner']['alt']."' title='".$feed['owner']['title']."'>
								</a>
							</div>
							<!-- right area-->
							<div class='feed-right-area'>
								<!-- board area -->
								<div class='div-feed-list-feed'>";
		if (isset($feed['score']) && $feed['score'] != "") {
			$result['list'] .= "
										<!-- review score area appears only if there is a score -->
										<div class='div-feed-list-feed-score'>
											<div class='div-rating-small'>
												<div class='rating-small-stars'></div>
												<div class='rating-small-score'><span></span></div>
											</div>
										</div>";
		}
		$result['list'] .= "
									<!-- board content -->
									<a href='".$home.$feed['owner']['url']."'>
										<span class='list-title-member'>".$feed['owner']['title']."</span>
									</a>
									<p>".$feed['content']."</p>";
		if (isset($feed['image']) && $feed['image']['url'] != "") {
			$result['list'] .= "
									<div class='div-feed-list-feed-image'>
											<img class='image-large' src='".$home.$feed['image']['url']."' alt='".$feed['image']['alt']."' title='".$feed['image']['title']."'>
									</div>";
		}
		$result['list'] .= "
									<!-- board timestamp -->
									<span class='time-feed'>".$feed['timestamp']."</span>
								</div>
								
								<!-- comments area -->
								
								<div class='div-feed-list-comment-list'>
									<!-- comment list -->
									<div class='div-feed-list-more-comment' id='div-feed-list-more-comment-".$feed['id']."'>";
		if (isset($feed['func']['more']) && $feed['func']['more'] != "") {
			$result['list'] .= "
										<a href='javascript:' onclick='".$feed['func']['more']."'>查看更多评论</a>";
		}
		$result['list'] .= "
									</div>
									<ul class='ul-feed-list-comment-list' id='ul-feed-list-comment-list-".$feed['id']."'>";
		foreach ($feed['comments']['comment'] as $comment) {
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
		$result['list'] .= "
									</ul>
								</div>";
		if($auth['uid'] > 0) {
			$result['list'] .= "
								<!-- reply area -->
								<div class='ul-feed-list-reply'>
									<a href='".$home.$auth['url']."'>
										<img class='self-logo-small' src='".$home.$auth['image']."' alt='".$auth['alt']."' title='".$auth['title']."'>
									</a>
									<div>
										<textarea class='comment-textarea' id='comment-textarea-".$feed['id']."' placeholder='发表评论' title='发表评论' value='发表评论'></textarea>
										<button class='button-reply' onclick='".$feed['func']['reply']."'>评论</button>
									</div>
								</div>";
		}
		$result['list'] .= "
							</div>
						</li>";
	}

	if (isset($next) && $next != "") {
		$result['more'] = "<a href='javascript:' onclick='showMoreEvent(24, $next)';>查看更多</a>";
	}

	echo json_encode($result);