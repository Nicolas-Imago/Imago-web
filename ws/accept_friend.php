
<?php include("../php/lib/init.php") ?>

<?php include("../php/lib/model.php") ?>
<?php include("../php/lib/misc.php") ?>

<?php include("../php/lib/session.php") ?>


<?php

    $user_id_1 = $_POST["user_id_1"];
    $user_id_2 = $_POST["user_id_2"];

    // Accept favorite

    if (empty($_SESSION["login"])) {
        $status = ["status" => "not_connected"];
    }

    else if ($user_id != $user_id_1 AND $user_id != $user_id_2) {
        $status = ["status" => "bad_user"];
    }

    else {

        $acceptance_date = get_time();

        $request = $data_base->prepare("
            UPDATE
                imago_my_friend 
            SET 
                acceptance_date = :acceptance_date
            WHERE 
                user_id_1 = :user_id_1
            AND 
                user_id_2 = :user_id_2
        ");

        $request->execute(array(
            'acceptance_date' => $acceptance_date,
            'user_id_1' => $user_id_1,
            'user_id_2' => $user_id_2
        ));

        $status = ["status" => "ok"];
    }

    $status_json = json_encode($status);
    var_dump($status_json);

?>