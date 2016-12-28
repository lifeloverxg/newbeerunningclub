<?php
	$home = '../../';
	include_once($home.'core.php');
	include_once('handler/util.php');
	
	if (!defined('IN_ZUS')) {
		exit('<h1>503:Service Unavailable @spec/fcbs_14_fest:index</h1>');
	}

	$pid = Authority::get_uid();
	if ($pid == 0) {
		header('Location: handler/signup.php');
	}
	else {
		$role = PeopleDAO::get_event_role_pid($pid, $fcbs_eid);
		$spec = FCBS14FestDAO::get_spec($pid);
		switch ($role) {
			case Role::None:
			case Role::Invited:
			case Role::Pending:
				header('Location: handler/enroll.php');
				break;
			case Role::Member:
			case Role::Admin:
			case Role::Owner:
				if (empty($spec['lottery'])) {
					header('Location: handler/enroll.php');
				}
				else {
					header('Location: handler/dashboard.php');
				}
				break;
			case Role::Ghost:
				header('Location: handler/pudding.php');				
				break;
		}
	}
?>