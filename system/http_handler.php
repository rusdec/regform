<?php

require('database.php');
require('dbconfig.php');

function authorisation() {
	readfile('pages/authorisation.html');
}

function registration() {
	readfile('pages/registration.html');
}

function not_found() {
	var_dump($data);
	readfile('pages/404.html');
}

function create_user($data) {
	$db = db_conn($CONFIG);
	$result = db_create_user($db, $data);
}
?>
