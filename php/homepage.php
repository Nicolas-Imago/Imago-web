<?php
require_once("mutual/init.php");
require_once("mutual/lib_model.php");
require_once("mutual/lib_view.php");


// Display functions
function display_slideshow($tvshow_list) {

    // Display slideshow

    // ECHO ' <div ';
    //     ECHO ' id = "slideshow_container" ';
    // ECHO ' > ';
    //     display_slideshow_thumbnail($tvshow_list);
    // ECHO ' </div> ';

    // Display pager

    // ECHO ' <div class = "slideshow_pager_container" > ';

    // for ($index = 1; $index <= 4; $index++) {
    //     ECHO ' <div ';
    //         ECHO ' id = "slideshow_pager_' . $index . '" ';
    //         ECHO ' class = "slideshow_pager" ';
    //         ECHO ' > ';
    //     ECHO ' </div> ' ;
    // }

    // ECHO ' </div> ';
}


function display_slideshow_thumbnail($tvshow_list) {

    for ($index = 0; $index < 4; $index++) {

        $content_id = $tvshow_list[$index]["content_id"];

        $line_1 = $tvshow_list[$index]["name"];
        // $line_2 = $tvshow_list[$index]["description"];

        // $line_2 = substr($line_2, 0, 200);
        // $line_2 = $line_2 . "...";

        ECHO ' <div ';
        ECHO ' id = "slideshow-' . $index . '-' . $content_id . '" ';
        ECHO ' class = "slideshow_thumbnail_info slideshow" ';
        ECHO ' > ';

        ECHO ' <img ';
        ECHO ' src = "../img/tvshow/background/' . $tvshow_list[$index]["content_id"] . '.jpg" ';
        ECHO ' class = "slideshow_thumbnail slideshow" ';
        // ECHO ' alt = "' . $content_id . '" ';
        ECHO ' > ';

        ECHO ' <div ';
        ECHO ' id = "slideshow_info_' . $content_id . '" ';
        ECHO ' class = "slideshow_info slideshow" ';
        ECHO ' > ';

        ECHO ' <div ';
        ECHO ' id = "slideshow_info_line_1_' . $content_id . '" ';
        ECHO ' class = "slideshow_info_line_1" ';
        ECHO ' >';
        ECHO '<a class = "slideshow_line_1">' . $line_1 . '</a>';
        ECHO ' </div>';

        //    ECHO ' <div ';
        //    ECHO ' id = "slideshow_info_line_2_' . $content_id . '" ';
        // ECHO ' class = "slideshow_info_line_2" ';
        //    ECHO ' >';
        //    	ECHO '<a class = "slideshow_line_2">' . $line_2 . '</a>';
        //    ECHO ' </div>';

        ECHO ' </div>';

        ECHO ' </div>';
    }
}


// Display functions
function content_list_of($type_id) {

    global $data_base, $env;

    if ($type_id == "documentary") {$limit = "5";} else {$limit = "4";}

    if ($env == "prod") {

        $content_list = $data_base->prepare("
	        	SELECT content_id, name, short_description, description, sub_type, video_number, duration, playback   
	        	FROM imago_info_content
	        	WHERE type = ?
	        	AND env = ? 
		        AND playback != ''
		        ORDER BY RAND()
	        	LIMIT $limit ");

        $content_list->execute(array($type_id, $env));
    }
    else {
        $content_list = $data_base->prepare("
	        	SELECT content_id, name, short_description, description, sub_type, video_number, duration, playback  
	        	FROM imago_info_content
	        	WHERE type = ?
		        AND playback != ''
		        ORDER BY RAND()
	        	LIMIT $limit ");

        $content_list->execute(array($type_id));
    }

    return $content_list->fetchAll();
}

$tvshow_list = content_list_of("tvshow");
$documentary_list = content_list_of("documentary");
$shortfilm_list = content_list_of("shortfilm");

// tag

$screen_tag = read_tag("homepage", "", "", "", "");

if (empty($screen_tag)) {
    create_tag("homepage", "", "", "", "");
}
else {
    $view = $screen_tag["view"] + 1;
    $tag_id = $screen_tag["id"];
    increment_tag($tag_id, "homepage", "", "", "", "", $view);
}

?>


<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <link rel = "stylesheet" href = "../css/imago.css"/>
    <link rel = "stylesheet" href = "../css/mobile/imago.css"/>

    <link rel = "stylesheet" href = "../css/slideshow.css"/>

    <link rel = "stylesheet" href = "../css/homepage.css"/>
    <link rel = "stylesheet" href = "../css/mobile/homepage.css"/>

    <link rel = "icon" type = "image/png" href = "../img/icons/imago_con.png"/>

    <title>ImagoTV</title>

    <meta property = "og:title" content = "ImagoTV" />
    <meta property = "og:description" content = "La plateforme vidéo des vidéos engagés dans la transition" />
    <meta property = "og:image" content = "/img/icons/imago.jpg" />

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


<!-- HOMEPAGE SCREEN -->
<div id = "screen">

    <section id = "slideshow">
        <?php display_slideshow($tvshow_list) ?>
    </section>

    <section id = "type" class = "list">

        <a id = "type_list_title" class = "title"> Tous les programmes </a>
        <div id = "type_list_thumbnail" class = "link">
            <img class = "type link" src = "../img/homepage/tvshow_image.jpg" alt="show tv">
            <img class = "type link" src = "../img/homepage/documentary_image.jpg" alt="documentaire">
            <img class = "type link" src = "../img/homepage/podcast_image.jpg" alt="podcast">
            <img class = "type link" src = "../img/homepage/shortfilm_image.jpg" alt="court métrage">
        </div>

    </section>

    <!-- 		<section id = "live">

                <a id = "live_title" class = "title"> En ce moment sur ImagoTV</a>
                <div class = "live_player">
                    <iframe class = "live_player" allowfullscreen></iframe>
                </div>

            </section> -->

    <section id = "type" class = "list">

        <a id = "type_list_title" class = "title"> Découvrez Imago ! </a>
        <div id = "type_list_thumbnail" class = "link">
            <img class = "promo link info" src = "../img/homepage/link_info.jpg" alt="info">
            <img class = "promo link facebook" src = "../img/homepage/link_facebook.jpg" alt="facebook">
            <img class = "promo link subscribe" src = "../img/homepage/link_subscribe.jpg" alt="souscrire">
        </div>

    </section>

    <section id = "list">
        <?php display_thumbnail_list("1", "tvshow", "Emissions - à découvrir", $tvshow_list); ?>
    </section>

    <section id = "list">
        <?php display_thumbnail_list("2", "documentary", "Documentaires - à découvrir", $documentary_list); ?>
    </section>

    <section id = "list">
        <?php display_thumbnail_list("3", "shortfilm", "Courts-métrages - à découvrir", $shortfilm_list); ?>
    </section>

    <section id = "category" class = "list">

        <a id = "category_list_title" class = "title"> Toutes les thématiques </a>
        <div id = "category_list_thumbnail" class = "link">
            <img class = "category link" src = "../img/homepage/category/1_grey.jpg" alt="">
            <img class = "category link" src = "../img/homepage/category/2_grey.jpg" alt="">
            <img class = "category link" src = "../img/homepage/category/3_grey.jpg" alt="">
            <img class = "category link" src = "../img/homepage/category/4_grey.jpg" alt="">
            <img class = "category link" src = "../img/homepage/category/5_grey.jpg" alt="">
            <img class = "category link" src = "../img/homepage/category/6_grey.jpg" alt="">
            <img class = "category link" src = "../img/homepage/category/7_grey.jpg" alt="">
            <img class = "category link" src = "../img/homepage/category/8_grey.jpg" alt="">
        </div>

    </section>

</div>


<!-- FOOTER -->
<?php include("mutual/footer.php") ?>


<!-- JS VARIABLES INIT -->
<script type = "text/javascript">

    var env = "<?php ECHO $env; ?>";
    var base_url = "<?php ECHO $base_url; ?>";

</script>


<!-- JS FILES -->
<script src = "../js/mutual/lib.js"></script>

<script src = "../js/mutual/header.js"></script>
<script src = "../js/mutual/menu.js"></script>
<script src = "../js/mutual/user.js"></script>
<script src = "../js/mutual/footer.js"></script>

<script src = "../js/homepage.js"></script>

</body>
</html>
