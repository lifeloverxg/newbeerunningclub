<?php	
	$home = '../../../';
	include_once ($home.'core.php');
	include_once ('../../../util/timer.php');
$bm = new Timer();
	
	if(!defined('IN_NBRC')) {
		exit('<h1>503:Service Unavailable @spec:add_feed</h1>');
	}
$bm->mark();

	$title = 'NBRC - 纽约新蜂跑团';
	$links = $_SGLOBAL['links'];

	$stylesheet = array(
						'theme/zus/spec/nyc_only_you/add_feed.css',
						);
	$javascript = array(
						'js/zus/spec/nycone.js',
						'js/zus/comment.js',
						);
	$links = $_SGLOBAL['links'];

	$feed_list = NycOne::get_feed_list();

	$auth = Authority::get_auth_arr();

	$username = '';
	if ( $auth['uid'] > 0 )
	{
		$username = $auth['title'];
	}

//	$id = NycOne::insert_feed_list($feed);
//	var_dump($id);
//	var_dump($feed_list);
$bm->mark();

	include '../template/add_feed/add_feed_frame.php';
$bm->mark();
echo '<!-- '.$bm->report().'-->';
?>