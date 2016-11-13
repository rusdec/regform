<?php

//posix_kill(getmypid(), 19);

class User {
	
	private $db;

	/**
	* Необходимая структура таблицы users
	* После добавления столбца в таблицу users:
	* - Добавить <input> в registration.html
	*	- name  = название столбца, 
	*	- group = "include".
	* - Добавить элемент в массив ниже
	*	- индекс элемента = название столбца.
	*/
	private	$user = array(
		'id'		=> "",
		'email'		=> "",
		'password'	=> "",
		'login'		=> "",
		'last_name' => "",
		'first_name'=> ""
	);


	function __construct() {
		$CONFIG = include('db_config.php');
		$dsn = "mysql:host=".$CONFIG['dbhost'].";dbname=".$CONFIG['dbname'].";charset=".$CONFIG['dbchar'];
		try {
			$this->db = new PDO($dsn, $CONFIG['dbuser'], $CONFIG['dbpass']);
		} catch (PDOException $e) {
			die("Cant connect to MySQL. Err: ". $e->getMessage());
		}
	}

	function Init($data) {
		foreach($this->user as $key => $nothing) {
			$this->user[$key] = $data[$key];
		}
	}

	function Find($data) {
	
		$pairs		= array();
		$columns	= array();
	
		foreach($data as $column => $value) {
			switch ($column) {
				//Поля условия запроса SELECT
				case "email":
				case "login":
					$columns[$column] = $value;
					$pairs[] = $column."=:".$column; // (array of strings) pairs[0] = 'foo=:foo' ...
				break;
				default:
					continue;
			}
		}

		//Формирование условия для запроса
		if (count($pairs) > 1) {
			$cond = implode(' OR ', $pairs);	// (string) cond = 'foo=:foo OR bar=:bar'
		} else {
			$cond = $pairs[0];					// (string) cond = 'foo=:foo'
		}
		echo "Find:\n";
		echo "SELECT * FROM users WHERE " . $cond."\n";	
		var_dump($columns);
		$query = $this->db->prepare("SELECT * FROM users WHERE " . $cond);
		$query->execute($columns);
		$result = $query->fetchAll();
	
		return $result;
	}
	
	function Authorisation() {
	
	}

	function Create() {

		// Формирование полей запроса INSERT и наполнение массива
		foreach($this->user as $column => $nothing) {
			$columns[]	= $column;
			$values[]	= ":".$column;
		}
		$columns	= implode(',', $columns);
		$values		= implode(',', $values);
	
		$exist_users = $this->Find($this->user);
		if (count($exist_users) > 0) {
			return array(false, "Пользователь с такими данными уже существует");
		} else {
			echo "\nCreate:\n";
			echo "INSERT INTO users (".$columns.") VALUES (".$values.")\n";
			$query = $this->db->prepare("INSERT INTO users (".$columns.") VALUES (".$values.")");
//			foreach($this->user as $column => $value) {
//				echo "BindParam = :$column, $value\n";
//				$query->bindParam(":".$column, $value);
//			}
			$isOk = $query->execute($this->user);
			echo "isOk = ".$isOk."\n";
			if (!$isOk) {
				return array(false, "Неизвестная ошибка.");
			}
		}

		return $isOk;
	}
}
