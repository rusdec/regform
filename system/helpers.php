<?php

function isAuthorized() {
	if (!session_status()) {
		session_start();
	}
	if (isset($_SESSION['auth'])) {
		return true;
	}
	
	return false;
}

?>
