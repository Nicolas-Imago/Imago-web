<?php include("../php/mutual/init.php");

// Get parameters and set notes
$type_id = $_POST["type_id"];
$content_id = $_POST["content_id"];
$note_1 = $_POST["note_1"];
$note_2 = $_POST["note_2"];
$note_3 = $_POST["note_3"];

$data_base->query("
        UPDATE imago_info_content 
        SET note_1 = '$note_1', note_2 = '$note_2', note_3 = '$note_3'
        WHERE content_id = '$content_id' 
        AND type = '$type_id' 
        ");