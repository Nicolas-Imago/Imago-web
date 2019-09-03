
<?php include("../php/lib/init.php") ?>
<?php include("../php/lib/misc.php") ?>

<?php

    // Add favorite

    $acceptance_date = get_time();

    $user_id_1 = $_POST["user_id_1"];
    $user_id_2 = $_POST["user_id_2"];

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

?>