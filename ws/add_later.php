
<?php include("../php/lib/init.php") ?>
<?php include("../php/lib/misc.php") ?>

<?php

    if (empty($_SESSION["login"])) {
        $status = ["status" => "not_connected"];
    }

    else {

        $add_date = get_time();

        $user_id = $_POST["user_id"];
        $content_id = $_POST["content_id"];
        $episod_id = $_POST["episod_id"];

        $request = $data_base->prepare("
            INSERT INTO imago_my_later
                (`user_id`, `content_id`, `episod_id`, `add_date`) 
            VALUES 
                (:user_id, :content_id, :episod_id, :add_date)");

        $request->execute(array(
            'user_id' => $user_id, 
            'content_id' => $content_id,
            'episod_id' => $episod_id,
            'add_date' => $add_date,
        ));

        $status = ["status" => "ok"];
    }

    $status_json = json_encode($status);
    var_dump($status_json);
    
?>