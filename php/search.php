<?php
require_once("mutual/init.php");
require_once("mutual/lib_model.php");
require_once("mutual/lib_view.php");


// Display functions
function display_all_list($query_id) {

    // global $video_list;
    global $content_list_1;
    global $content_list_2;
    global $content_list_3;
    global $content_list_4;
    global $content_list_5;
    global $content_list_6;
    global $query;

    global $list_size;

    if ($query == "ok") {
        // display_thumbnail_list("0", "video", title_of_type("video"), $video_list);

        $list_size["1"] = display_thumbnail_list("1", "tvshow", title_of_type("tvshow"), $content_list_1);
        $list_size["2"] = display_thumbnail_list("2", "documentary", title_of_type("documentary"), $content_list_2);
        $list_size["3"] = display_thumbnail_list("3", "podcast", title_of_type("podcast"), $content_list_3);
        $list_size["4"] = display_thumbnail_list("4", "shortfilm", title_of_type("shortfilm"), $content_list_4);
        $list_size["5"] = display_thumbnail_list("5", "humour", title_of_type("humour"), $content_list_5);
        $list_size["6"] = display_thumbnail_list("6", "music", title_of_type("music"), $content_list_6);
    }
}


function content_list_of($type_id, $query_id) {
    global $data_base, $env;

    if ($env == "prod") {

        $content_list = $data_base->prepare("
		        SELECT content_id, short_description, sub_type, video_number, duration, playback 
		        FROM imago_info_content 
		        WHERE type = ? 
		        AND env = ?
            	AND LOWER(tag) LIKE LOWER(?) 
		        AND playback != '' 
		    ");

        $content_list->execute(array($type_id, $env,"%" . $query_id . "%"));
    } else {

        $content_list = $data_base->prepare("
		        SELECT content_id, short_description, sub_type, video_number, duration, playback  
		        FROM imago_info_content 
		        WHERE type = ?
            	AND LOWER(tag) LIKE LOWER(?) 
		        AND playback != '' 
		    ");

        $content_list->execute(array($type_id, "%" . $query_id . "%"));
    }

    return $content_list->fetchAll();
}


function video_list_of($query_id) {
    global $data_base, $env;

    if ($env == "prod") {

        $video_list = $data_base->prepare("
		        SELECT video_id, content_id, title, publication_date, duration 
		        FROM imago_info_video 
		        WHERE env = ?
            	AND LOWER(title) LIKE LOWER(?) 
		    ");

        $video_list->execute(array($env,"%" . $query_id . "%"));
    } else {

        $video_list = $data_base->prepare("
		        SELECT video_id, content_id, title, publication_date, duration  
		        FROM imago_info_video 
            	WHERE LOWER(title) LIKE LOWER(?) 
			");

        $video_list->execute(array("%" . $query_id . "%"));
    }

    return $video_list->fetchAll();
}


// Display
if (isset($_GET["query_id"])) { $query_id = $_GET["query_id"]; } else { $query_id = ""; }

$message = "";

$list_size = array();
$list_size = [0, 0, 0, 0, 0, 0, 0, 0, 0];

if (isset($_GET["query_id"])) {
    if (strlen($query_id) < 3) {
        $message = "La recherche doit contenir <br> au moins 3 caractères";
        $query = "ko";
    } else {
        // $video_list = video_list_of($query_id);
        $video_list = [""];

        $content_list_1 = content_list_of("tvshow", $query_id);
        $content_list_2 = content_list_of("documentary", $query_id);
        $content_list_3 = content_list_of("podcast", $query_id);
        $content_list_4 = content_list_of("shortfilm", $query_id);
        $content_list_5 = content_list_of("humour", $query_id);
        $content_list_6 = content_list_of("music", $query_id);

        $query = "ok";

        $request_size = sizeof($content_list_1)
            + sizeof($content_list_2)
            + sizeof($content_list_3)
            + sizeof($content_list_4)
            + sizeof($content_list_5)
            + sizeof($content_list_6);
        // + sizeof($video_list);

        if ($request_size == "0") {
            $message = "Pas de résultat pour cette recherche. <br> <br> Vérifiez l'<u>orthographe</u>, ou <br> essayez avec des <u>mots seuls</u> <br> plutôt que des expressions.";
        }
    }
} else {
    $query = "ko";
}

?>


<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <link rel = "stylesheet" href = "../css/imago.css"/>
    <link rel = "stylesheet" href = "../css/mobile/imago.css"/>

    <link rel = "stylesheet" href = "../css/search.css"/>
    <link rel = "stylesheet" href = "../css/mobile/search.css"/>

    <link rel = "icon" type = "image/png" href = "../img/icons/imago_con.png"/>

    <title>ImagoTV</title>

    <meta property = "og:title" content = "ImagoTV" />
    <meta property = "og:description" content = "La plateforme vidéo des vidéastes engagés dans la transition" />
    <meta property = "og:image" content = "../img/icons/imago.jpg" />

    <script src = "../lib/jquery.js"></script>

    <!-- TRACKING -->
    <?php include("mutual/tracking.php") ?>

</head>


<body>

<!-- HEADER, MENU & USER -->
<?php
include("mutual/header.php");
include("mutual/menu.php");
include("mutual/user.php");
?>


<!-- SEARCH SCREEN -->
<div id = "screen">

    <!-- <img id = "background" src = "../img/login/imago.jpg"></img> -->

    <!-- <a id = "screen_title"> Ma recherche </a> -->

    <section id = "query">

        <form id = "form" action = "search.php" method = "get">
            <input type = "text" name = "query_id" value = "<?php ECHO $query_id ?>">
            <a id = "validate_button"> Validez </a>
        </form>

        <a id = "message" > <?php ECHO $message ?> </a>

    </section>

    <section id = "result">

        <section id = "list">
            <?php display_all_list($query_id) ?>
        </section>

    </section>

</div>


<!-- FOOTER -->
<?php include("mutual/footer.php") ?>


<!-- JS VARIABLES INIT -->
<script type = "text/javascript">

    var env = "<?php ECHO $env; ?>";
    var base_url = "<?php ECHO $base_url; ?>";

    var list_size = [];

    list_size["1"] = "<?php ECHO $list_size["1"]; ?>";
    list_size["2"] = "<?php ECHO $list_size["2"]; ?>";
    list_size["3"] = "<?php ECHO $list_size["3"]; ?>";
    list_size["4"] = "<?php ECHO $list_size["4"]; ?>";
    list_size["5"] = "<?php ECHO $list_size["5"]; ?>";
    list_size["6"] = "<?php ECHO $list_size["6"]; ?>";
    list_size["7"] = "<?php ECHO $list_size["7"]; ?>";
    list_size["8"] = "<?php ECHO $list_size["8"]; ?>";

</script>


<!-- JS FILES -->
<script src = "../js/mutual/lib.js"></script>

<script src = "../js/mutual/header.js"></script>
<script src = "../js/mutual/menu.js"></script>
<script src = "../js/mutual/user.js"></script>
<script src = "../js/mutual/footer.js"></script>

<script src = "../js/search.js"></script>

</body>
</html>
