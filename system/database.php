<?php

function db_conn($CONFIG) {
	$dsn = "mysql:host=".$CONFIG['dbhost'].";dbname=".$CONFIG['dbname'].";charset=".$CONFIG['dbchar'];
	try {
		$result = new PDO($dsn, $CONFIG['dbuser'], $CONFIG['dbpass']);
	} catch (PDOException $e) {
		die("Cant connect to MySQL. Err: ". $e->getMessage());
	}

	return $result;
}

function db_find_user($db, $user) {

	$pairs		= array();
	$userCond	= array();

	foreach($user as $col => $val) {
		switch ($col) {
			case 'email' || 'login':
				$userCond[$col] = $val;
			break;
			default:
				continue;
		}
	}

	//Формирование условия для запроса
	foreach ($userCond as $col => $val) {
		$pairs[] = $col."=:".$col;			// (array of strings) pairs[0] = 'foo=:foo' ...
	}
	if (count($pairs) > 1) {
		$cond = implode(' OR ', $pairs);	// (string) cond = 'foo=:foo OR bar=:bar'
	} else {
		$cond = $pairs[0];					// (string) cond = 'foo=:foo'
	}

	$query = $db->prepare("SELECT * FROM users WHERE " . $cond);
	$query->execute($userCond);
	$result = $query->fetchAll();
	
	return $result;
}

function db_create_user($db, $user) {
	$userExist = db_find_user($db, $user);
	if (count($userExist) > 0) {
		echo "Уже существует.\n";
		return array(false, "Пользователь с такими данными уже существует");

	} else {
		echo "Не найден, добавляю...\n";
		$query = $db->prepare("INSERT INTO users (`email`, `password`, `login`, `first_name`, `last_name`) VALUES (:email, :password, :login, :first_name, :last_name)");
		$result = $query->execute($user);
	}

	return $result;
}

//$users = array();
//$u = findUser($db, array('login' => 'alex', 'email' => 'kcm.ru@mail.ru'));
//createUser($db, array('login' => 'alex1', 'first_name' => 'тралала', 'email' => 'kcum.ru@mail.ru', 'last_name' => 'трололо', 'password' => 'sjdjeJsjx4'));
