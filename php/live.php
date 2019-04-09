<?php
include("mutual/init.php");

// Display screen
$channel = rand(1, 7);
?>


<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <link rel = "stylesheet" href = "../css/imago.css"/>
    <link rel = "stylesheet" href = "../css/mobile/imago.css"/>

    <link rel = "stylesheet" href = "../css/live.css"/>
    <link rel = "stylesheet" href = "../css/mobile/live.css"/>

    <link rel = "icon" type = "image/png" href = "../img/icons/imago_con.png"/>

    <title>ImagoTV</title>

    <meta property = "og:title" content = "ImagoTV | La plateforme vidéo de la transition " />
    <meta property = "og:description" content = "La plateforme vidéo des vidéastes engagés dans la transition" />
    <meta property = "og:image" content = "../img/icons/imago.jpg" />

    <script src = "../lib/jquery.js"></script>

    <!-- TRACKING -->
    <?php include("mutual/tracking.php") ?>

</head>


<!-- <body onmousemove = "get_mouse_position(event)" > -->
<body>

<!-- HEADER, MENU & USER -->
<?php
include("mutual/header.php");
include("mutual/menu.php");
include("mutual/user.php");
?>


<!-- HOMEPAGE SCREEN -->
<div id = "screen">

    <section id = "channel">

        <a id = "channel_title" class = "title"> ImagoTV - en direct</a>

        <img id = "channel_selector"<?php ECHO 'src = "../img/homepage/selector/channel/'.$channel.'.png"'?> alt="selection de chaine">
        <img id = "video_selector"<?php ECHO 'src = "../img/homepage/selector/video/'.$channel.'.png"' ?> alt="selection de video">

        <iframe id = "channel_player" allowfullscreen></iframe>
        <div id = "layer"></div>
        <img id = "layer" src = "../img/homepage/player.png" alt="player">

        <div id = "channel_list">
            <img id = "channel_logo_1" class = "channel_logo" src = "../img/homepage/logo/channel_1_grey.png" alt="">
            <img id = "channel_logo_2" class = "channel_logo" src = "../img/homepage/logo/channel_2_grey.png" alt="">
            <img id = "channel_logo_3" class = "channel_logo" src = "../img/homepage/logo/channel_3_grey.png" alt="">
            <img id = "channel_logo_4" class = "channel_logo" src = "../img/homepage/logo/channel_4_grey.png" alt="">
            <img id = "channel_logo_5" class = "channel_logo" src = "../img/homepage/logo/channel_5_grey.png" alt="">
            <img id = "channel_logo_6" class = "channel_logo" src = "../img/homepage/logo/channel_6_grey.png" alt="">
            <img id = "channel_logo_7" class = "channel_logo" src = "../img/homepage/logo/channel_7_grey.png" alt="">
            <img id = "channel_logo_8" class = "channel_logo" src = "../img/homepage/logo/channel_8_grey.png" alt="">
        </div>

        <div id = "live_video_list">
            <img id = "video_now" class = "video" alt="play">
            <img id = "video_next" class = "video" alt="prochaine vidéo">
        </div>

    </section>

</div>


<!-- FOOTER -->
<?php include("mutual/footer.php") ?>


<!-- JS VARIABLES INIT -->
<script type = "text/javascript">

    var env = "<?php ECHO $env; ?>";
    var base_url = "<?php ECHO $base_url; ?>";

    var channel = "<?php ECHO $channel; ?>";

</script>


<!-- JS FILES -->
<script src = "../js/mutual/lib.js"></script>

<script src = "../js/mutual/header.js"></script>
<script src = "../js/mutual/menu.js"></script>
<script src = "../js/mutual/user.js"></script>
<script src = "../js/mutual/footer.js"></script>

<script src = "../js/live.js"></script>

</body>
</html>
