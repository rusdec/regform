<?php

function isAuthorized() {
	if (isset($_SESSION)) {
		return true;
	}
	
	return false;
}

?>
