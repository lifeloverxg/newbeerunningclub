<?php
	$home = '../';
	include_once ($home.'core.php');
	
	if(!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @auth:index</h1>');
	}
	
	if (Authority::get_uid()) {
		header('Location: '.S_ROOT);
	}
	
	$args = array(
				  'web_charset' => $_SCONFIG['web_charset'],
				  'title'       => '[ZUS] Sign In | Sign Up', 
				  'links'       => $_SGLOBAL['links'],
				  'home'        => $home,
				  'auth'        => Authority::get_auth_arr(),
				  'style_sheet' => 'theme/zus/auth.css'
				  );
	
	Template::html_begin();
	Template::head_begin();
	
	$frame = new Template(S_ROOT.'template/auth/index_frame.htm', $args);
	$frame->render();
	
	Template::head_end();
	Template::body_begin('style="background-color: #CCC;"');

	$header = new Template(S_ROOT.'template/common/header.htm', $args);
	$header->render();
	
	echo '<div style="position: absolute; top: 100px; width: 100%">';
	echo '<div style="margin-left: auto; margin-right: auto; width: 720px;">';
	echo '<div style="float: left; padding: 50px; width: 360px;">';
	$signin_form = new Template(S_ROOT.'template/auth/sign_in.htm', $args);
	$signin_form->render();
	echo '</div>';
	
	echo '<div style="float: left; padding: 50px; width: 360px;">';
	$signup_form = new Template(S_ROOT.'template/auth/sign_up.htm', $args);
	$signup_form->render();
	echo '</div>';
	echo '</div></div>';
	
	$footer = new Template(S_ROOT.'template/common/footer.htm', $args);
	$footer->render();
	
	Template::body_end();
	Template::html_end();

?>
