
<?php include("../php/mutual/init.php") ?>

<?php

    // Remove favorite

    $user_id = $_POST["$user_id"];
    $content_id = $_POST["content_id"];

    $request = $data_base->prepare("
        DELETE FROM imago_favorite_content
        WHERE user_id = ?
        AND content_id = ?
    ");

    $request->execute(array($user_id, $content_id));

?>
