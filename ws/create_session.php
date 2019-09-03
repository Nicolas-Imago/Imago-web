
<?php include("../php/lib/init.php") ?>
<?php include("../php/lib/model.php") ?>

<?php
    
    $login = $_POST["login"];
    $password = $_POST["password"];

    $member = read_member($login);
    $test_password = password_verify($password, $member["password"]);

	if ($test_password) {
	    $_SESSION["login"] = $login;
	    $status = ["status" => "ok"];
	} 
	else {
        $status = ["status" => "ko"];
	}

	$status_json = json_encode($status);
    var_dump($status_json);
?>