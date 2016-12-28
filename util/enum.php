<?php
	class Role {
		const __default = self::None;
		
		const None    = 0; // 游客
		const Invited = 1; // 邀请中
		const Pending = 2; // 申请中
		const Member  = 3; // 成员
		const Admin   = 4; // 管理员
		const Owner   = 5; // 创建人
		const Ghost   = -1;
		
		public static function get_const_array() {
			return array(
						 self::None    => '游客',
						 self::Invited => '邀请中',
						 self::Pending => '申请中',
						 self::Member  => '成员',
						 self::Admin   => '管理员',
						 self::Owner   => '创建人',
						 self::Ghost   => '不存在'
						 );
		}
		
		public static function get_role_icon() {
			return array(
						 self::None    => '',
						 self::Invited => '',
						 self::Pending => '',
						 self::Member  => '',
						 self::Admin   => '',
						 self::Owner   => '',
						 self::Ghost   => ''
						 );
		}
	}
	
	class EventCategory {
		const __default = self::All;
		
		const All  = 0;
		const a  = 1;
		const b = 2;
		const c = 3;
		const d = 4;
		const e = 5;
		const f = 99;

		public static function get_const_array() {
			return array(
						 self::All  => '全部',
						 self::a => '跑步/约跑',
						 self::b => '比赛/nyrr',
						 self::c => '马拉松',
						 self::d => '训练建议',
						 self::e => '跑步文章',
						 self::f => '其他'
						 );
		}
	}

	class GroupCategory {
		const __default = self::All;
		
		const All  = 0;
		const a  = 1; // 官方
		const b = 2;
		const c = 3;
		const d = 4;
		const e = 5;
		const f = 99;
		
		public static function get_const_array() {
			return array(
						 self::All  => '全部',
						 self::a => '官方',
						 self::b => '科技',
						 self::c => '人文',
						 self::d => '生活',
						 self::e => '娱乐',
						 self::f => '其他'
						 );
		}
	}

	class ArticleCategory 
	{
		const __default = self::All;
		
		const All  = 0;
		const a  = 1; // 官方
		const b = 2;
		const c = 3;
		const d = 4;
		const e = 5;
		const f1 = 6;
		const f2 = 7;
		const f3 = 8;
		const g = 99;
		
		public static function get_const_array() 
		{
			return array(
						 self::All  => '全部',
						 self::a => '科普',
						 self::b => '时尚',
						 self::c => '人文',
						 self::d => '吃喝玩乐',
						 self::e => '二手租房',
						 self::f1 => '树洞',
						 self::f2 => '闲言碎语',
						 self::f3 => '创作园地',
						 self::g => '其他'
						 );
		}
	}
	
	class Privacy {
		const __default = self::All;
		
		const All   = 0;
		const Follower = 1;
		const Member   = 3;
		const Self     = 5;
		const NonExist = 99;
		
		public static function get_const_array() {
			return array(
						 self::All   => '公开',
						 self::Follower => '粉丝可见',
						 self::Member   => '成员可见',
						 self::Self     => '仅自己'
						 );
		}		
	}
	
	class Relation {
		const __default = self::None;

		const None          = 0;
		const Follower      = 1;
		const Following     = 2;
		const Friend        = 3;
		const Self          = 4;
		const Banned        = -1;

		public static function get_const_array() {
			return array(
						 self::None          => '无',
						 self::Follower      => '粉丝',   //p2 add p1
						 self::Following     => '关注中',  //p1 add p2
						 self::Friend        => '好友',
						 self::Self          => '我', 
						 self::Banned        => '黑名单'  // p1 banned p2
						 );
		}
	}

	class DefaultImage {
		const __default = '';
		
		const People = 'theme/images/default/default_people';
		const Event  = 'theme/images/default/default_group';
		const Group  = 'theme/images/default/default_group';
		const Photo  = 'theme/images/default/default_photo_original';
		const QR     = 'theme/images/default/default_qr.png';
		const ErrPg  = 'theme/images/default/default_photo_new.png';
		const Icon   = 'theme/images/default/default_photo_new.png';
	}
	
	class RepeatTimeSpan {
		const __default = self::None;

		const None   = 0;
		const Day    = 1;
		const Week   = 2;
		const Month  = 3;
		const Season = 4;
		const Year   = 5;
		
	}
	
	class oysterGender 
	{
		const __default = self::Unknown;

		const Unknown  = 0;
		const Female   = 1;
		const Male     = 2;
		const WomanMan = 3;
		const ManWoman = 4;
		const LORI     = 5;
		const TeenBoy  = 6;
		const Meow     = 7;
		const Wong     = 8;
		const Animal   = 9;
		const Altman   = 10;
		const Monster  = 11;
		const Robot    = 12;
		const Zombie   = 13;
		const Ghost    = 14;
		const Bug      = 15;
		const Other    = 99;
		const All 	   = 100;
		
		public static function get_const_array() 
		{
			return array(
						self::Unknown  => '未知',
						self::Female   => '女',
						self::Male     => '男',
						self::WomanMan => '女汉子',
						self::ManWoman => '伪娘',
						self::LORI     => '萝莉',
						self::TeenBoy  => '正太',
						self::Meow     => '喵星人',
						self::Wong     => '汪星人',
						self::Animal   => '小萌物',
						self::Altman   => '凹凸曼',
						self::Monster  => '小怪兽',
						self::Robot    => '机器人',
						self::Zombie   => '僵尸',
						self::Ghost    => '幽灵',
						self::Bug      => '小强',
						self::Other    => '其它',
						self::All      => '全部'
			);
		}
	}

	class Gender 
	{
		const __default = self::Unknown;

		const Female   = 0;
		const Male     = 1;
		
		public static function get_const_array() 
		{
			return array(
						 self::Female   => '女',
						 self::Male     => '男'
			);
		}
	}

	class time_Hour
	{
		const __default = self::a;

		const a = '00';
		const b = '01';
		const c = '02';
		const d = '03';
		const e = '04';
		const f = '05';
		const g = '06';
		const h = '07';
		const i = '08';
		const j = '09';
		const k = '10';
		const l = '11';
		const m = '12';
		const n = '13';
		const o = '14';
		const p = '15';
		const q = '16';
		const r = '17';
		const s = '18';
		const t = '19';
		const u = '20';
		const v = '21';
		const w = '22';
		const x = '23';

		public static function get_const_array()
		{
			return array(
							self::a => '00',
							self::b => '01',
							self::c => '02',
							self::d => '03',
							self::e => '04',
							self::f => '05',
							self::g => '06',
							self::h => '07',
							self::i => '08',
							self::j => '09',
							self::k => '10',
							self::l => '11',
							self::m => '12',
							self::n => '13',
							self::o => '14',
							self::p => '15',
							self::q => '16',
							self::r => '17',
							self::s => '18',
							self::t => '19',
							self::u => '20',
							self::v => '21',
							self::w => '22',
							self::x => '23',
						);
		}
	}

	class time_Minute
	{
		const __default = self::a;

		const a = '00';
		const b = '05';
		const c = '10';
		const d = '15';
		const e = '20';
		const f = '25';
		const g = '30';
		const h = '35';
		const i = '40';
		const j = '45';
		const k = '50';
		const l = '55';

		public static function get_const_array()
		{
			return array(
							self::a => '00',
							self::b => '05',
							self::c => '10',
							self::d => '15',
							self::e => '20',
							self::f => '25',
							self::g => '30',
							self::h => '35',
							self::i => '40',
							self::j => '45',
							self::k => '50',
							self::l => '55',
						);
		}
	}

	class state_city_list
	{
		public static function getStatesList()
		{
			$states = array(
							'AL'=>"Alabama",
							'AK'=>"Alaska",
							'AZ'=>"Arizona",
							'AR'=>"Arkansas",
							'CA'=>"California",
							'CO'=>"Colorado",
							'CT'=>"Connecticut",
							'DE'=>"Delaware",
							'DC'=>"District Of Columbia",
							'FL'=>"Florida",
							'GA'=>"Georgia",
							'HI'=>"Hawaii",
							'ID'=>"Idaho",
							'IL'=>"Illinois",
							'IN'=>"Indiana",
							'IA'=>"Iowa",
							'KS'=>"Kansas",
							'KY'=>"Kentucky",
							'LA'=>"Louisiana",
							'ME'=>"Maine",
							'MD'=>"Maryland",
							'MA'=>"Massachusetts",
							'MI'=>"Michigan",
							'MN'=>"Minnesota",
							'MS'=>"Mississippi",
							'MO'=>"Missouri",
							'MT'=>"Montana",
							'NE'=>"Nebraska",
							'NV'=>"Nevada",
							'NH'=>"New Hampshire",
							'NJ'=>"New Jersey",
							'NM'=>"New Mexico",
							'NY'=>"New York",
							'NC'=>"North Carolina",
							'ND'=>"North Dakota",
							'OH'=>"Ohio",
							'OK'=>"Oklahoma",
							'OR'=>"Oregon",
							'PA'=>"Pennsylvania",
							'RI'=>"Rhode Island",
							'SC'=>"South Carolina",
							'SD'=>"South Dakota",
							'TN'=>"Tennessee",
							'TX'=>"Texas",
							'UT'=>"Utah",
							'VT'=>"Vermont",
							'VA'=>"Virginia",
							'WA'=>"Washington",
							'WV'=>"West Virginia",
							'WI'=>"Wisconsin",
							'WY'=>"Wyoming"
							);
			return $states;
		}
	}
?>
