
<?php include("../php/lib/init.php") ?>

<?php include("../php/lib/model.php") ?>
<?php include("../php/lib/misc.php") ?>

<?php include("../php/lib/session.php") ?>

<?php

    $content_id = $_POST["content_id"];
    $section_id = $_POST["section_id"];
    $episod_id = $_POST["episod_id"];

    if (empty($_SESSION["login"])) {

        $request = $data_base->prepare("
            SELECT c.id, c.comment, login, color, add_date
            FROM imago_related_comment c
            INNER JOIN imago_list_member m
            ON c.user_id = m.id
            WHERE c.content_id = ?
            AND c.section_id = ?
            AND c.episod_id = ?
            ORDER BY c.add_date DESC
        ");

        $request->execute(array($content_id, $section_id, $episod_id));
        $status = $request->fetchAll(PDO::FETCH_ASSOC);
    }

    else {

        $request = $data_base->prepare("
            SELECT c.id, c.comment, login, color, add_date
            FROM imago_related_comment c
            INNER JOIN imago_list_member m
            ON c.user_id = m.id
            WHERE c.user_id != ? 
            AND c.content_id = ?
            AND c.section_id = ?
            AND c.episod_id = ?
            ORDER BY c.add_date DESC
        ");

        $request->execute(array($user_id, $content_id, $section_id, $episod_id));
        $status = $request->fetchAll(PDO::FETCH_ASSOC);
    }

    $status_json = json_encode($status);
    var_dump($status_json);

?>