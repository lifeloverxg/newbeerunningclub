<?php
	if(!defined('IN_ZUS')) {
		exit('<h1>403:Forbidden @util:qrcode.php</h1>');
	}
	
	class QRCodeDAO {
		public static function get_qr_code_people($pid) {
			global $_SCONFIG;
			
			return 'http://chart.apis.google.com/chart?cht=qr&chs=350x350&chl=http%3A//'.$_SCONFIG['host'].'/people%3Fpid%3D'.$pid.'&chld=H|0';
		}

		public static function get_qr_code_group($gid) {
			global $_SCONFIG;
			
			return 'http://chart.apis.google.com/chart?cht=qr&chs=350x350&chl=http%3A//'.$_SCONFIG['host'].'/group%3Fgid%3D'.$gid.'&chld=H|0';
		}

		public static function get_qr_code_event($eid) {
			global $_SCONFIG;
			
			return 'http://chart.apis.google.com/chart?cht=qr&chs=350x350&chl=http%3A//'.$_SCONFIG['host'].'/event%3Feid%3D'.$eid.'&chld=H|0';
		}
		
		public static function get_url_people($pid) {
			global $_SCONFIG;
			return 'http://'.$_SCONFIG['host'].'/people?pid='.$pid;
		}

		public static function get_url_group($gid) {
			global $_SCONFIG;
			return 'http://'.$_SCONFIG['host'].'/group?gid='.$gid;
		}

		public static function get_url_event($eid) {
			global $_SCONFIG;
			return 'http://'.$_SCONFIG['host'].'/event?eid='.$eid;
		}
	}
?>