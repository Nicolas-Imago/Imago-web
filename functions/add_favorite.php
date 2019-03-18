
<?php include("../php/mutual/init.php") ?>

<?php

    // Add favorite

    $user_id = $_POST["user_id"];
    $content_id = $_POST["content_id"];

    $request = $data_base->prepare("
        INSERT INTO imago_favorite_content
            (`user_id`, `content_id`) 
        VALUES 
            (:user_id, :content_id)");

    $request->execute(array(
        'user_id' => $user_id, 
        'content_id' => $content_id,
    ));

?>