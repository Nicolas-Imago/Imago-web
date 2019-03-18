
<?php include("php/mutual/init.php") ?>


<?php

    header('Location: php/homepage.php');
    exit();

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "css/imago.css"/>
    <link rel = "stylesheet" href = "css/mobile/imago.css"/>

    <link rel = "stylesheet" href = "index.css"/>
    <link rel = "stylesheet" href = "index_mobile.css"/>

    <link rel = "icon" type = "image/png" href = "img/icons/imago_con.png"/>

    <title>ImagoTV</title>

    <meta property = "og:title" content = "ImagoTV" />
    <meta property = "og:description" content = "La plateforme vidéo des vidéastes engagés dans la transition" />
    <meta property = "og:image" content = "/img/icons/imago.jpg" />

	<script src = "lib/jquery.js"></script>

	<!-- TRACKING -->

	<?php include("php/mutual/tracking.php") ?>

</head>


<body>	

<!-- SPLASH SCREEN -->	

	<div id = "splashscreen" class = "screen">

		<a id = "splashscreen_title"> ImagoTV </a>

		<a id = "splashscreen_text_1" class = "splashscreen_text"> 80 émissions </a>
		<a id = "splashscreen_text_1" class = "splashscreen_text"> 80 documentaires </a>
		<a id = "splashscreen_text_1" class = "splashscreen_text"> 2000 vidéos </a>

		</section>

		<img id = "splashscreen_image" src = "img/login/imago.png"></img>

		<a id = "imago_version"> ImagoTV - version</a>

	</div>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var env = "<?php ECHO $env; ?>";
    	var base_url = "<?php ECHO $base_url; ?>";

  	</script> 


<!-- JS FILES -->

	<script src = "js/mutual/lib.js"></script>
	<script src = "index.js"></script>

</body>
</html>
