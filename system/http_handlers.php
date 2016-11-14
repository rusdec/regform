<?php

require('models.php');
require('helpers.php');

function signin() {
	readfile('pages/header.html');
	readfile('pages/authorisation.html');
	readfile('pages/footer.html');
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
function my_page() {
	if (!isAuthorized()) {
		header('Location: /signin');
	}
}
function authorisation($data) {
	$user = new User;
}

function create_user($data) {
	//Написать метод проверки значений массива data в классе!!
	// user->Check($data) : true|false
	$user = new User;
	$user->SetUserForm($data);
	$result = $user->Create();
	header('Content-Type: application/json;charset=utf-8');
	echo json_encode($result);
	
}
?>
