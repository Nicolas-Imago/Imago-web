<?php

	// Get Session info

	if (isset($_SESSION["login"])) {
		$user_login = $_SESSION["login"];
		$user_id = read_member($user_login)["id"];
		$status = "login";
	}
	else {
		$user_login = "";
		$user_id = "";
		$status = "logout";
	}

?>

<!-- JS VARIABLES INIT -->

    <script type="text/javascript">

    	var user_login = "<?php ECHO $user_login; ?>";
    	var user_id = "<?php ECHO $user_id; ?>";
    	var status = "<?php ECHO $status; ?>";
    	
  	</script> 