
<?php include("../php/lib/init.php") ?>
<?php include("../php/lib/model.php") ?>
<?php include("../php/lib/session.php") ?>

<?php

    $type_id = $_POST["type_id"];
    $content_id = $_POST["content_id"];
    $section_id = $_POST["section_id"];
    $episod_id = $_POST["episod_id"];

    $content = get_content_info($content_id);
    $video_id_list = get_video_id_list($section_id, $content_id);

    $name = $content["name"];

    $episod = $video_id_list[$episod_id - 1];

    $hosting = $episod["hosting"];
    $audio_hosting = $episod["audio_hosting"];

    if ($status == "user" AND $type_id == "tvshow")
        if ($hosting == "peertube" OR $hosting == "wetube")
            $hosting = "youtube";

    if ($hosting == "imago")
        $video_id = $episod['peertube_id'];
    else 
        $video_id = $episod[$hosting . '_id'];

    $audio_id = $episod["audio_id"];

    $fact_checking = $episod["fact_check"];

    $resume_time = read_resume_time($user_id, $content_id, $episod_id);
    if (sizeof($resume_time) != 0) $timecode = $resume_time["0"]["resume_time"];
    else $timecode = "0";

    $later = read_later_content($user_id, $content_id, $episod_id);
    if (sizeof($later) != 0) $is_episod_later = "1";
    else $is_episod_later = "0";

    $reco = read_reco_content($user_id, $content_id, $episod_id);
    if (sizeof($reco) != 0) $is_episod_reco = "1";
    else $is_episod_reco = "0";

    $status = [
        "hosting"           => $hosting,
        "audio_hosting"     => $audio_hosting,
        "content_id"        => $content_id,
        "name"              => $name,
        "episod_id"         => $episod_id,
        "video_id"          => $video_id,
        "audio_id"          => $audio_id,
        "fact_checking"     => $fact_checking,
        "timecode"          => $timecode,
        "is_episod_later"   => $is_episod_later,
        "is_episod_reco"    => $is_episod_reco
    ];

    $status_json = json_encode($status);
    var_dump($status_json);

?>