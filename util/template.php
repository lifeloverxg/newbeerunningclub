<?php
	if(!defined('IN_ZUS')) {
		exit('<h1>403:Forbidden @util:auth.php</h1>');
	}
	
	// Template class for php to load html
	class Template {
		protected $args;
		protected $file;
		
		public function __construct($file, $args = array()) {
			$this->file = $file;
			$this->args = $args;
		}
		
		// overload get function to allow html page load args
		public function __get($name) {
			return $this->args[$name];
		}
		
		// start render
		public function render() {
			include $this->file;
			return 0;
		}
		
	}
?>