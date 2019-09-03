
<?php include("../php/lib/init.php") ?>

<?php

    // Remove favorite

    $user_id_1 = $_POST["user_id_1"];
    $user_id_2 = $_POST["user_id_2"];

	$request = $data_base->prepare("
	    DELETE FROM imago_my_friend
	    WHERE (user_id_1 = ? AND user_id_2 = ?)
	    OR (user_id_1 = ? AND user_id_2 = ?)
	");

	$request->execute(array($user_id_1, $user_id_2, $user_id_2, $user_id_1));	

?>
