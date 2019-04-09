<?php require_once("../php/mutual/init.php");

    header("HTTP/1.0 404 Not Found");
?>

<!DOCTYPE html>
<html lang="fr_FR">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "../css/imago.css"/>
    <link rel = "stylesheet" href = "../css/mobile/imago.css"/>

    <link rel = "stylesheet" href = "../index.css"/>
    <link rel = "stylesheet" href = "../index_mobile.css"/>

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

<!-- 404 ERROR SCREEN -->	

	<div id = "splashscreen" class = "screen">

		<a id = "splashscreen_title"> ERREUR 404 </a>
		<img id = "splashscreen_image" src = "../img/login/imago.png" alt="Imago splashscreen" />

	</div>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var env = "<?php ECHO $env; ?>";
    	var base_url = "<?php ECHO $base_url; ?>";

  	</script> 


<!-- JS FILES -->

	<script src = "../js/mutual/lib.js"></script>
	<script src = "../index.js"></script>

</body>
</html>
