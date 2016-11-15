<?php

require ('system/http_handlers.php');
	
switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		handler($_SERVER['REQUEST_URI'], $_GET);
	break;
	case 'POST':
		handler($_SERVER['REQUEST_URI'], $_POST);
	break;
	default:
		die("Protect.");
}

function handler($req_uri, $data) {
    switch ($req_uri) {
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

		case '/authorisation':
			authorisation($data);
		break;

		case '/user/create':
			create_user($data);
		break;

        default:
            not_found();
    }
}
?>
