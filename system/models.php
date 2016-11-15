<?php

//posix_kill(getmypid(), 19);

/*
* Таблица users
*
* Доступные извне методы:
* - Create()			: return array('result' => bool, 'msg' => string)
* - SetUserForm(array)	: return ничего
* - Auth(array)			: return array('result' => bool, 'msg' => string)
* - CheckData(array)	: return array('result' => bool, 'msg' => string)
*/
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
		'id'				=> "",
		'email'				=> "",
		'password'			=> "",
		'login'				=> "",
		'last_name'			=> "",
		'first_name'		=> ""
	);
	
	private $user_form = array(
		'id'						=> "",
		'email'						=> "",
		'password'					=> "",
		'login'						=> "",
		'last_name'					=> "",
		'first_name'				=> "",
		'registration_question_id'	=> "",
		'answer'					=> "",
	);

	private $users = array(); // array[user]
	
	function __construct() {
		$CONFIG = include('db_config.php');
		$dsn = "mysql:host=".$CONFIG['dbhost'].";dbname=".$CONFIG['dbname'].";charset=".$CONFIG['dbchar'];
		try {
			$this->db = new PDO($dsn, $CONFIG['dbuser'], $CONFIG['dbpass']);
		} catch (PDOException $e) {
			die("Cant connect to MySQL. Err: ". $e->getMessage());
		}
	}

	private function TableName() {
		return "users";
	}

	function SetUserForm($data) {
		foreach($this->user_form as $key => $nothing) {
			if ($data[$key] == "") {
				continue;
			}
			$this->user_form[$key] = $data[$key];
		}
	}

	private function SetUser($data) {
		foreach($this->user as $key => $nothing) {
			if ($data[$key] == "") {
				continue;
			}
			$this->user[$key] = $data[$key];
		}
	}

	/*
	* return array('result' => bool, 'msg' => string)
	*/
	function Auth($data) {
		$user = $this->FindOne(array(
			'login' => $data['login']
		));
		if (count($user) == 0) {
			return array(
				'result'	=> false,
				'msg'		=> 'Пользователя не существует.'
			);
		}
		if ($user['password'] != $data['password']) {
			return array(
				'result'	=> false,
				'msg'		=> 'Неверно введён пароль.'	
			);
		}
		return array(
			'result' 	=> true,
			'msg'		=> ""
		);
	}
		
	/*
	* return user[]
	*/
	private function FindOne($data) {
		$pairs = array();
	
		foreach($data as $column => $nothing) {
			$pairs[] = $column."=:".$column;	// (array of strings) pairs[0] = 'foo=:foo' ...
		}

		if (count($pairs) > 1) {
			$cond = implode(' OR ', $pairs);	// (string) cond = 'foo=:foo OR bar=:bar'
		} else {
			$cond = $pairs[0];					// (string) cond = 'foo=:foo'
		}

		$query = $this->db->prepare("SELECT * FROM users WHERE " . $cond);
		$query->execute($data);
		
		$result = $query->fetch(PDO::FETCH_ASSOC);
		if (!is_array($result)) {
			return array();
		}
	
		return $result;
	}
	
	/*
	* return array('result' => bool, 'msg' => string)	
	*/
	function Create() {

		foreach($this->user as $column => $nothing) {
			$columns[]	= $column;
			$pttrns[]	= ':'.$column;
		}
		$columns	= implode(',', $columns);	// foo,bar,...
		$pttrns		= implode(',', $pttrns);	// :foo,:bar,...
	
		
		$user = $this->FindOne(array(
				'email' => $this->user_form['email'],
				'login' => $this->user_form['login'],
		));
		if (count($user) > 0) {
			return array(
				'result'	=> false,
				'msg'		=> "Указанные эл.почта или логин уже заняты. Попробуйте ввести другие данные."
			);
		}

		/*
		* Проверка наличия id выбранного вопроса
		*/
		$question = new Question;
		$qst = $question->FindById($this->user_form['registration_question_id']);
		if (count($qst) == 0) {
			return array(
				'result'	=> false,
				'msg'		=>"Не верно выбран вопрос. Попробуйте выбрать другой вопрос."
			);
		}

		$query = $this->db->prepare("INSERT INTO " . $this->TableName()  . " (".$columns.") VALUES (".$pttrns.")");
		$this->SetUser($this->user_form);
		$isOk = $query->execute($this->user);
		if (!$isOk) {
           	return array(
				'result'	=> false,
				'msg'		=> "Неизвестная ошибка. Обратитесь к разработчику."
			);
		}
		$this->user = $this->FindOne(array(
			'login' => $this->user['login']
		));

		$user_answer = new UserAnswer;
		$user_answer->Set(array(
			'user_id'					=> $this->user['id'],
			'registration_question_id'	=> $this->user_form['registration_question_id'],
			'answer'					=> $this->user_form['answer']
		));
		$result = $user_answer->Create();
		
		if(!$result['result']) {
			return $result; // array(result => bool, msg => string) из UserAnswer::Create
		}

		return array(
			'result'	=> true,
			'msg'		=> "Пользователь зарегистрирован. Нажмите \"Войти\""
		);
	}
	
	/*
	* return array(bool, string)
	*/
	function CheckData($data) {
		$isOK = true;
		$symb = '/#$%^&*()+=-[]\';,./{}|:<>?~/';
		$elements_for_check = array(
			array(
				'name' => 'email',
				'pttrns' => array(
					'/^[a-z0-9-]{2,}@[a-z0-9]+\.[a-z]{2,7}$/'
				)
			),
			array(
				'name' => 'password',
				'pttrns'=> array( //соответсвие sha1-хешу
					'/^[a-z0-9]{40}$/',
				)
			),
			array(
				'name' => 'login',
				'pttrns' => array(
					'/^[a-zA-Z0-9]{7,14}$/',
				)
			),
			array(
				'name' => 'first_name',
				'pttrns' => array(
					'/^[a-zA-Zа-яА-Я]{2,30}$/u',
				)
			),
			array(
				'name' => 'last_name',
				'pttrns' => array(
					'/^[a-zA-Zа-яА-Я]{2,30}$/u',
				)
			),
			array(
				'name' => 'answer',
				'pttrns' => array(
					'/^[a-zA-Zа-яА-Я0-9]{2,50}$/u',
				)
			),
			array(
				'name' => 'registration_question_id',
				'pttrns' => array(
					'/[^\D]/'
				)
			)
		);

		foreach ($elements_for_check as $index => $elem) {
			foreach($elem['pttrns'] as $pttrn) {
				$isOK = preg_match($pttrn, $data[$elem['name']]);
				if (!$isOK) {
					return array(
						'result' => false,
						'msg'	=> "Содержимое ".$elem['name']." не соответсвует требованиям."
					);
				}
			}
		}
		return array(
			'result' => true,
			'msg'	=> ""
		);
	}

}

/*
* Таблица user_answers
*
* Доступные извне методы:
* - Create()	: return array('result' => bool, 'msg' => string)
* - Set()		: return ничего		
*/
class UserAnswer {

	private $db;
	
	private $user_answer = array(
		'id'						=> "",
		'answer'					=> "",
		'registration_question_id'	=> "",
		'user_id'					=> ""
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

	function Set($data) {
		foreach($this->user_answer as $key => $nothing) {
			$this->user_answer[$key] = $data[$key];
		}
	}
	
	/*
	* return array('result' => bool, 'msg' => string)	
	*/
    function Create() {

        foreach($this->user_answer as $column => $nothing) {
            $columns[]  = $column;
            $values[]   = ':'.$column;
        }
        $columns    = implode(',', $columns);
        $values     = implode(',', $values);

        $query = $this->db->prepare("INSERT INTO " . $this->TableName() ." (".$columns.") VALUES (".$values.")");
        $isOk = $query->execute($this->user_answer);
        if (!$isOk) {
            return array(
				'result'	=> false,
				'msg'		=> "Неизвестная ошибка. Обратитесь к разработчику."
			);
        }
     
        return array(
				'result'	=> true,
				'msg'		=> "успех");
	}
	
	private function TableName() {
		return "user_answers";
	}

}

/*
* Таблица registration_questions
*
* Доступные извне методы:
* - FindById(string|integer) : return array(question)
*/
class Question {

	private $db;
	
	private $question = array(
		'id'	=> "",
		'text'	=> ""
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

	private function TableName() {
		return "registration_questions";
	}

	private function Set($data) {
		foreach($this->question as $key => $nothing) {
			$this->question[$key] = $data[$key];
		}
	}

	/*
	* return question[]
	*/
	function FindById($id) {
		$query = $this->db->prepare("SELECT * FROM " . $this->TableName()  . " WHERE id = :id");
		$query->execute(array('id' => $id));

		$result = $query->fetch(PDO::FETCH_ASSOC);
		if (!is_array($result)) {
			return array();
		}
		
		return $result;
	}
	
}
