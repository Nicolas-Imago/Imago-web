
<?php include("../php/lib/init.php") ?>

<?php include("../php/lib/model.php") ?>
<?php include("../php/lib/misc.php") ?>

<?php include("../php/lib/session.php") ?>


<?php

    // Remove favorite

    if (empty($_SESSION["login"])) {
        $status = ["status" => "not_connected"];
    }

    else {

	    $user_id_1 = $user_id;
	    $user_id_2 = $_POST["user_id_2"];

		$request = $data_base->prepare("
		    DELETE FROM imago_my_friend
		    WHERE (user_id_1 = ? AND user_id_2 = ?)
		    OR (user_id_1 = ? AND user_id_2 = ?)
		");

		$request->execute(array($user_id_1, $user_id_2, $user_id_2, $user_id_1));

	    $status = ["status" => "ok"];
    }

    $status_json = json_encode($status);
    var_dump($status_json);	

?>
