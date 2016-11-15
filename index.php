<?php

require ('system/http_handlers.php');
	
switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		get_handler($_SERVER, $_GET);
	break;
	case 'POST':
		post_handler($_SERVER, $_POST);
	break;
	default:
		die("Protect.");
}

function post_handler($server_array, $data) {
    switch ($server_array['REQUEST_URI']) {
		case '/authorisation':
			authorisation($data);
		break;
		case '/user/create':
			create_user($data, $server_array['REMOTE_ADDR']);
		break;
        default:
            not_found();
    }
}

function get_handler($server_array, $data) {
    switch ($server_array['REQUEST_URI']) {
		case '/':
			user();
		break;
        case '/registration':
            registration();
        break;
        case '/signin':
            signin();
        break;
        case '/signout':
            signout();
        break;
        default:
            not_found();
	}
}
?>
