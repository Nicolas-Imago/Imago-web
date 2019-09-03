<?php

	// Get Session info

	if (isset($_SESSION["login"])) {
		$user_login = $_SESSION["login"];
		$user_id = read_member($user_login)["id"];
		// $status = "login";
		$status = read_member($user_login)["status"];
	}
	else {
		$user_login = "";
		$user_id = "";
		$status = "logout";
	}

?>

