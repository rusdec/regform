<?php

require ('system/http_handler.php');
	
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
        case '/registration':
            registration();
        break;
        case '/authorisation':
            authorisation();
        break;
        default:
            not_found();
    }
}
?>
