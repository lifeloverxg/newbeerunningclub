<?php
	if (!defined('TIMER')) {
		@define('TIMER', TRUE);
		
		class Timer {
			protected $time_record;

			public function __construct() {
				$this->time_record = array();
				array_push($this->time_record, microtime(true));
			}
			
			public function mark() {
				array_push($this->time_record, microtime(true));				
			}
			
			public function report() {
				$result = '';
				$last = 0;
				foreach ($this->time_record as $title => $marker) {
					if ($last == 0) {
						$last = $marker;
					}
					$result .= '#'.$title.': '.($marker-$last).' s; ';
					$last = $marker;
				}
				return $result;
			}
		}
	}
	?>