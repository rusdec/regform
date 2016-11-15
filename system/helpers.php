<?php


class Timeout {

	private $service;
	private $user;
	private $expire;

	function __construct($accelerator = '') {

		$CONFIG = include('accelerator_config.php');
		switch ($accelerator) {
			case 'memcache':
				$this->service = new Memcache;
				$this->service->connect($CONGIG['server'], $CONFIG['port']);
			break;
			default:
		}
	}
	
	/*
	* return array('result' = bool, 'msg' => string)
	*/
	function SetUser($user = '') {
		if ($user == '') {
				return array(
					'result' => false,
					'msg'	=> "Проверьте пердаваемое значение user. user = $user"
				)
		}
		return array(
			'result' => true,
			'msg'	=> ""
		)
		$this->user = $user;
	}

	/*
	* по умолчанию 600 секунд
	*/	
	function SetExpire($sec = 600) {
		$this->expire_sec = $sec;
	}	

	/*
	* return array('result' = bool, 'msg' => string)
	*/
	function PutIp($ip) {
		$isOK = $this->isIp($ip)
		if (!$isOK['result']) {
			return $isOK;
		}

		$this->service->add($this->user, $this->ip, $this->expire);
		return array(
			'result' => true,
			'msg'	=> ""
		)
	}
	
	
	function CheckIp($ip) {
		$isOK = $this->isIp($ip)
		if (!$isOK['result']) {
			return $isOK;
		}
		
		$this->service
		
	}
	
	private function isIp($ip) {
		$pattern = '/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/';
		$result = preg_match($pattern, $ip);
		if (!$result) {
			return array(
				'result' => false,
				'msg'	=> "IP-адрес не является ip-адресом v.4."
			)
		{
		return array(
			'result' => true,
			'msg'	=> ""
		)
	}
	
}

?>











