<?php

require('models.php');

function signin() {
	readfile('pages/header.html');
	readfile('pages/authorisation.html');
	readfile('pages/footer.html');
}

function signout() {
	session_start();
	unset($_SESSION['auth']);
	session_destroy();
	header('Content-Type: application/json;charset=utf-8');
	echo json_encode(array('redirect'=>'/'));
	return;
}

function registration() {
	readfile('pages/header.html');
	readfile('pages/registration.html');
	readfile('pages/footer.html');
}

function not_found() {
	readfile('pages/header.html');
	readfile('pages/404.html');
	readfile('pages/footer.html');
}

function user() {
	session_start();
	if (!isset($_SESSION['auth'])) {
		header('Location: /signin');
		return;
	}
	readfile('pages/header.html');
	readfile('pages/user.html');
	readfile('pages/footer.html');
}
function authorisation($data) {
	$user = new User;
	$isOK = $user->Auth($data);
	if (!$isOK['result']) {
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode($isOK);
		return;
	}
	$min = 30;
	session_cache_expire($min);
	session_start();
	$_SESSION['auth'] = $_SERVER['REMOTE_ADDR'];
	header('Content-Type: application/json;charset=utf-8');
	echo json_encode(array('redirect'=>'/'));
	return;
}

function create_user($data, $raddr) {
	$timeout = new Timeout;
	$timeout->Set($raddr);
	$isOK = $timeout->FindOne();
	if (!$isOK['result']) {
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode($isOK);
		return;
	}

	$user = new User;
	$isOK = $user->CheckData($data);
	if (!$isOK['result']) {
		header('Content-Type: application/json;charset=utf-8');
		echo json_encode($isOK);
		return;
	}
	$user->SetUserForm($data);
	$result = $user->Create();
	// Если пользователь создан, установить время ожидания
	if ($result['result']) {
		$timeout->Create();
	}
	header('Content-Type: application/json;charset=utf-8');
	echo json_encode($result);
}
?>
