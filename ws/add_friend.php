
<?php include("../php/lib/init.php") ?>
<?php include("../php/lib/misc.php") ?>

<?php

    // Add favorite

    $invitation_date = get_time();

    $user_id_1 = $_POST["user_id_1"];
    $user_id_2 = $_POST["user_id_2"];

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

?>