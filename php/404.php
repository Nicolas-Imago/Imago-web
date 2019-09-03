
<?php require_once("lib/init.php") ?>

<?php

    header("HTTP/1.0 404 Not Found");

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "../css/panorama/imago.css"/>
    <link rel = "stylesheet" href = "../css/portrait/imago.css"/>

    <link rel = "stylesheet" href = "../css/panorama/index.css"/>
    <link rel = "stylesheet" href = "../css/portrait/index.css"/>

    <link rel = "icon" type = "image/png" href = "../img/icons/imago_con.png"/>

    <title> Imago TV - La plateforme vidéo gratuite de la transition </title>

    <meta property = "og:title" content = "ImagoTV" />
    <meta property = "og:description" content = "La plateforme vidéo gratuite de la transition" />
    <meta property = "og:image" content = "/img/icons/imago.jpg" />

    <meta name = "description" content = "Imago TV propose une sélection de plus de 2000 vidéos parmi les meilleurs documentaires, web séries, courts-métrages ou podcasts engagés dans la transition." />

    <script src = "../js/lib/jquery.js"></script>

	<!-- TRACKING -->

    <?php include("lib/tracking.php") ?>

</head>


<body>

<!-- HEADER, MENU & USER -->

    <?php include("block/header.php") ?>    

    <?php include("block/menu.php") ?>
    <?php include("block/user.php") ?>


<!-- 404 ERROR SCREEN -->	

	<div id = "splashscreen" class = "screen">

		<a id = "splashscreen_title"> Cette page n'existe pas ! </a>
        <a id = "splashscreen_title"> Découvrez Imago en cliquant ci-dessous ! </a>

		<img id = "splashscreen_image" src = "../img/login/imago.png"></img>

	</div>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

        var user_login = "<?php ECHO $user_login; ?>";
        var user_id = "<?php ECHO $user_id; ?>";
        var status = "<?php ECHO $status; ?>";

        var env = "<?php ECHO $env; ?>";
        var base_url = "<?php ECHO $base_url; ?>";
        var page_url = "<?php ECHO $page_url; ?>";

    </script> 


<!-- JS FILES -->

    <script src = "../js/lib/misc.js"></script>
        
    <script src = "../js/block/header.js"></script>
    <script src = "../js/block/menu.js"></script>
    <script src = "../js/block/user.js"></script>
    <script src = "../js/block/footer.js"></script>

	<script src = "../index.js"></script>

</body>
</html>
