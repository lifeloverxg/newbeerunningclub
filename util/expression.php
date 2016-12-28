<?php
	class Expression {
		const Path    = 'theme/images/expression/'; 
		const Happy = '00.jpg'; 
		const Smile = '01.jpg'; 
		const Laugh  = '03.jpg'; 
		const Cry   = '04.jpg'; 
		const Angry   = '05.jpg'; 
		const Hungry   = '06.jpg';
		
		public static function get_path() {
			return self::Path;
		}
		
		public static function get_expression_list() {
			return array(
						 self::Happy    => '开心',
						 self::Smile => '微笑',
						 self::Laugh => '大笑',
						 self::Cry  => '哭',
						 self::Angry   => '生气',
						 self::Hungry   => '饿'
						 );
		}
	}
?>