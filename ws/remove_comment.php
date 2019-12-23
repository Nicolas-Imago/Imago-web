
<?php include("../php/lib/init.php") ?>

<?php include("../php/lib/model.php") ?>
<?php include("../php/lib/misc.php") ?>

<?php include("../php/lib/session.php") ?>


<?php

    if (empty($_SESSION["login"])) {
        $status = ["status" => "not_connected"];
    }

    else {

        $add_date = get_time();

        $content_id = $_POST["content_id"];
        $section_id = $_POST["section_id"];
        $episod_id = $_POST["episod_id"];

        $request = $data_base->prepare("
            SELECT *
            FROM imago_related_comment
            WHERE content_id = ?
            AND section_id = ?
            AND episod_id = ?
            AND user_id = ?
        ");

        $request->execute(array($content_id, $section_id, $episod_id, $user_id));

        if (sizeof($request->fetchAll()) != 0) {

            $request = $data_base->prepare("
                DELETE FROM imago_related_comment
                WHERE content_id = ?
                AND section_id = ?
                AND episod_id = ?
                AND user_id = ?
            ");

            $request->execute(array($content_id, $section_id, $episod_id, $user_id));
        
            $status = ["status" => "removed"];
        }

        else {
            $status = ["status" => "ko"];
        }       
    }

    $status_json = json_encode($status);
    var_dump($status_json);

?>



