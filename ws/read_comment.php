
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
            SELECT c.id, c.comment, user_id, login, add_date, color
            FROM imago_related_comment c
            INNER JOIN imago_list_member m
            ON c.user_id = m.id
            WHERE c.content_id = ?
            AND c.section_id = ?
            AND c.episod_id = ?
            AND c.user_id = ?
        ");

        $request->execute(array($content_id, $section_id, $episod_id, $user_id));
        $status = $request->fetchAll();
    }

    $status_json = json_encode($status);
    var_dump($status_json);

?>