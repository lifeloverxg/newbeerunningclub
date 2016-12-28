<?php
	$home = '../';
	include_once ($home.'core.php');
		
	$pid = 1;
	$event = array(
				   'title' => 'TTT',
				   'start_time' => '',
				   'end_time' => '',
				   'location' => 'TTT',
				   'logo' => 'TTT',
				   'description' => 'TTT',
				   'category' => 'TTT',
				   'size' => 5,
				   'tag' => 'TTT',
				   'price' => 'TTT',
				   'privacy' => '99',
				   'verify' => 0
	);
	$gid = 1;
	
		// check permission
		if ($gid > 0) {
			$srole = PeopleDAO::get_group_role_pid($pid, $gid);
			if ($srole < Role::Admin) {
				$gid = 0;
			}
		}
		
		$mysqli = MysqlInterface::get_connection();
	print_r ($event);
		
		// insert event
		$stmt = $mysqli->stmt_init();
		$stmt->prepare('INSERT INTO event (title, owner, gowner, start_time, end_time, location, logo, description, category, size, tag, price, privacy, verify) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
		$stmt->bind_param('siisssssiissii', $event['title'], $pid, $gid, $event['start_time'], $event['end_time'], $event['location'], $event['logo'], $event['description'], $event['category'], $event['size'], $event['tag'], $event['price'], $event['privacy'], $event['verify']);
		$stmt->execute();
		
		// get auto generated id
		$eid = $mysqli->insert_id;
	print_r ($stmt);
	
		$stmt->close();
		
		// grant user host role
		PeopleDAO::set_event_role_pid($pid, $eid, Role::Owner);
		
		//insert into group2event
		if ($gid > 0)
		{
			$stmt = $mysqli->stmt_init();
			$stmt->prepare('INSERT INTO group2event (gid, eid, role) VALUES (?, ?, ?);');
			$stmt->bind_param('iii', $gid, $eid, $srole);
			$stmt->execute();
			$stmt->close;
		}
		
	
	?>