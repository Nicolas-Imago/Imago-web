
<?php include("../php/lib/init.php") ?>

<?php include("../php/lib/model.php") ?>
<?php include("../php/lib/misc.php") ?>

<?php include("../php/lib/session.php") ?>


<?php

    // Add favorite

    if (empty($_SESSION["login"])) {
        $status = ["status" => "not_connected"];
    }

    else {

        $invitation_date = get_time();

        $user_id_1 = $user_id;
        $user_id_2 = $_POST["user_id_2"];

        $test_friends = are_friends($user_id_1, $user_id_2);

        if ($test_friends == false) {

            $request = $data_base->prepare("
                INSERT INTO imago_my_friend
                    (`user_id_1`, `user_id_2`, `invitation_date`) 
                VALUES 
                    (:user_id_1, :user_id_2, :invitation_date)");

            $request->execute(array(
                'user_id_1' => $user_id_1, 
                'user_id_2' => $user_id_2,
                'invitation_date' => $invitation_date,
            ));

            $status = ["status" => "ok"];
        }

        else
            $status = ["status" => "ko"];
    }

    $status_json = json_encode($status);
    var_dump($status_json);

?>