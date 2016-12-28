<?php	
	if(!defined('IN_ZUS')) {
		exit('<h1>403:Forbidden @util:unicorn.php</h1>');
	}

	class Unicorn {
		public static function show($home, $message = '') {
			ob_clean();
			
			include_once($home.'core.php');
			$title = '出错啦';
			$auth = Authority::get_auth_arr();
			$deviceType = Mobile_Detect::deviceType();
			$links = array(
							   'about'		=>		'about',
								'auth'		=> 		'auth',
								'contact'	=> 		'contact',
								'event' 	=> 		'event',
								'faq'		=> 		'information',
								'favicon' 	=> 		'theme/icon/favicon.ico',
								'group' 	=>	 	'group',
								'help'  	=> 		'help',
								'login' 	=>		'login',
								'logo'  	=> 		'theme/images/logo.png',
								'logout'  	=> 		'logout',
								'm_css' 	=> 		'theme/mobile/m_default_theme.css',
								'm_js' 		=> 		'js/mobile/m_common.js',	
								'people' 	=> 		'people',
								'privacy'  	=> 		'privacy',
								'search' 	=>		'search',
								'setting'  	=> 		'account',	
								'team' 		=>		'team',	
								'terms'  	=> 		'terms',
			);
			
			$stylesheet = array('theme/zus/inprogress.css');
			$m_stylesheet = array('theme/zus/mobile_css/inprogress.css');
			$javascript = array();
			$m_javascript = array('js/mobile/index.js');
			
			$image = DefaultImage::ErrPg;

			if ( ($deviceType == "phone") ) 
			{
				include S_ROOT."template/mobile/unicorn/m_unicorn_frame.php";
			}
			else if ( ($deviceType == "tablet") )
			{
				include S_ROOT."template/unicorn/unicorn_frame.php";
			}
			else 
			{
				include S_ROOT."template/unicorn/unicorn_frame.php";
			}
			
			exit(1);
		}
	}
?>