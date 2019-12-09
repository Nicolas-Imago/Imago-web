
<?php include("../php/lib/init.php") ?>
<?php include("../php/lib/model.php") ?>

<?php

    $type_id = $_POST["type_id"];
    $content_id = $_POST["content_id"];
    $section_id = $_POST["section_id"];
    $episod_id = $_POST["episod_id"];

    $video_tag = read_tag_video($type_id, $content_id, $section_id, $episod_id);

    if (empty($video_tag)) {
        create_tag_video($type_id, $content_id, $section_id, $episod_id);
    }
    else {
        $view = $video_tag["view"] + 1;
        $tag_id = $video_tag["id"];
        increment_tag_video($tag_id, $view);
    }

    $status = ["status" => "ok"];

    $status_json = json_encode($status);
    var_dump($status_json);

?>