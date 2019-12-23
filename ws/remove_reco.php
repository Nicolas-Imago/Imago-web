
<?php include("../php/lib/init.php") ?>

<?php include("../php/lib/model.php") ?>
<?php include("../php/lib/misc.php") ?>

<?php include("../php/lib/session.php") ?>


<?php

    if (empty($_SESSION["login"])) {
        $status = ["status" => "not_connected"];
    }

    else {

	    $content_id = $_POST["content_id"];
	    $section_id = $_POST["section_id"];
	    $episod_id = $_POST["episod_id"];

		$request = $data_base->prepare("
		    DELETE FROM imago_my_reco
		    WHERE user_id = ?
		    AND content_id = ?
		    AND section_id = ?
		    AND episod_id = ?
		");

		$request->execute(array($user_id, $content_id, $section_id, $episod_id));	

        $status = ["status" => "ok"];
    }

    $status_json = json_encode($status);
    var_dump($status_json);

?>
