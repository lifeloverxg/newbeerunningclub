<?php
	$home = '../';
	include_once ($home.'template/mobile/shared/list/m_across_list.php');
	
	$list = array();
	$item1 = array(
				   'url' => 'http://nycuni.com',
				   'logo' => 'http://nycuni.com/upload/1/1391671205_large.jpg',
				   'title' => 'Oyster',
				   'sub_title' => 'Oyster',
				   'desc' => 'Next version name: Chipotle!'
				   );
	$item2 = array(
				   'url' => 'http://nycuni.com',
				   'logo' => 'http://nycuni.com/upload/1/1391671205_large.jpg',
				   'title' => 'Oyster',
				   'sub_title' => 'Oyster',
				   'desc' => 'Again: Next version name: Chipotle!'
				   );
	array_push($list, $item1);
	array_push($list, $item2);
	m_across_list::render($list);
?>