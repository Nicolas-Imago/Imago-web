
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
        $comment = $_POST["comment"];

        $request = $data_base->prepare("
            SELECT *
            FROM imago_related_comment
            WHERE content_id = ?
            AND user_id = ?
        ");

        $request->execute(array($content_id, $user_id));

        if (sizeof($request->fetchAll()) == 0) {

            $request = $data_base->prepare("
                INSERT INTO imago_related_comment
                    (`user_id`, `content_id`, `comment`, `add_date`) 
                VALUES 
                    (:user_id, :content_id, :comment, :add_date)");

            $request->execute(array(
                'user_id' => $user_id, 
                'content_id' => $content_id,
                'comment' => $comment,
                'add_date' => $add_date,
            ));
        
            $status = ["status" => "created"];
        }

        else {

            $request = $data_base->prepare("
                UPDATE
                    imago_related_comment 
                SET 
                    comment = :comment,
                    add_date = :add_date  
                WHERE 
                    content_id = :content_id
                AND
                    user_id = :user_id
            ");

            $request->execute(array(
                'comment' => $comment,
                'add_date' => $add_date,
                'content_id' => $content_id,
                'user_id' => $user_id
            ));
        
            $status = ["status" => "modified"];
        }
    }

    $status_json = json_encode($status);
    var_dump($status_json);

?>