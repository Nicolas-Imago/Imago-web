
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
        $episod_id = $_POST["episod_id"];
        $resume_time = (int)$_POST["resume_time"];

        $previous_resume = read_resume_time($user_id, $content_id, $episod_id);

        if (sizeof($previous_resume) == 0) {

            $request = $data_base->prepare("
                INSERT INTO imago_my_resume
                    (`user_id`, `content_id`, `episod_id`, `resume_time`, `add_date`) 
                VALUES 
                    (:user_id, :content_id, :episod_id, :resume_time, :add_date)");

            $request->execute(array(
                'user_id' => $user_id, 
                'content_id' => $content_id,
                'episod_id' => $episod_id,
                'resume_time' => $resume_time,
                'add_date' => $add_date,
            ));
        }

        else {

            $id = $previous_resume["0"]["id"];

            $request = $data_base->prepare("
                UPDATE
                    imago_my_resume 
                SET 
                    resume_time = :resume_time,
                    add_date = :add_date
                WHERE 
                    id = :id
            ");

            $request->execute(array(
                'resume_time' => $resume_time,
                'add_date' => $add_date,
                'id' => $id
            ));
        }

        $status = ["status" => $resume_time];
    }

    $status_json = json_encode($status);
    var_dump($status_json);

?>