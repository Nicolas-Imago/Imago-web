
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php

	// Display screen

	if (isset($_GET["page_id"]))	$page_id = $_GET["page_id"]; 	else $page_id = "";

	$page_url = "html/" . $page_id . ".html";

?>


<!DOCTYPE html>
<html lang = "fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "/css/panorama/imago_v110.css"/>
   	<link rel = "stylesheet" href = "/css/portrait/imago_v110.css"/>

    <link rel = "stylesheet" href = "/css/panorama/page_v110.css"/>
    <link rel = "stylesheet" href = "/css/portrait/page_v110.css"/>

    <link rel = "icon" type = "image/png" href = "/img/icons/imago_con.png"/>

    <title> Imago TV - Info </title>

    <meta property = "og:title" content = "Imago TV" />
    <meta property = "og:description" content = "La plateforme vidéo gratuite de la transition" />
	<meta property = "og:image" content = "/img/page/manifeste/og_img.jpg" />

    <meta name = "description" content = "Imago TV propose une sélection de plus de 2000 vidéos parmi les meilleurs documentaires, web séries, courts-métrages ou podcasts engagés dans la transition." />

    <script src = "/js/lib/jquery.js"></script>

	<!-- TRACKING -->

	<?php include("lib/tracking.php") ?>

</head>


<body>	

<!-- HEADER, MENU & USER -->

	<?php include("block/header.php") ?>	

	<?php include("block/menu.php") ?>
	<?php include("block/user.php") ?>


<!-- PAGE SCREEN -->	

	<div id = "screen">

		<div class = "screen_title" >
			<h1 class = "screen_title" > A propos </h1> 
		</div>

		<?php include("block/button.php") ?>

		<div class = "item_list">
			<ol class = "item_list">
		      	<li><a id = "item_1" class = "item" href = "<?php ECHO "/info/equipe" ?>" > L'équipe </a></li>
		      	<li><a id = "item_2" class = "item" href = "<?php ECHO "/info/manifeste" ?>" > Manifeste </a></li>
		      	<li><a id = "item_3" class = "item" href = "<?php ECHO "/info/revue_de_presse" ?>" > Revue de presse </a></li>
		      	<li><a id = "item_4" class = "item" href = "<?php ECHO "/info/aidez-nous" ?>" > Aidez-nous </a></li>
		      	<li><a id = "item_5" class = "item" href = "<?php ECHO "/info/questions" ?>" > Questions </a></li>
		      	<li><a id = "item_6" class = "item" href = "<?php ECHO "/info/code" ?>" > Code </a></li>
		      	<!-- <li><a id = "item_7" class = "item" href = "<?php // ECHO "/info/apps" ?>" > Apps </a></li> -->
		    </ol>
		</div>

		<section id = "text">
			<?php include("$page_url") ?>
		</section>

	</div> 


<!-- FOOTER -->

	<?php include("block/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var user_login = "<?php ECHO $user_login; ?>";
    	var user_id = "<?php ECHO $user_id; ?>";
    	var status = "<?php ECHO $status; ?>";

    	var env = "<?php ECHO $env; ?>";
    	var base_url = "<?php ECHO $base_url; ?>";
    	var page_url = "<?php ECHO $page_url; ?>";

    	var page_id = "<?php ECHO $page_id; ?>";

  	</script> 


<!-- JS FILES -->

	<script src = "/js/lib/misc_v110.js"></script>

	<script src = "/js/block/header_v110.js"></script>
	<script src = "/js/block/menu_v110.js"></script>
	<script src = "/js/block/user_v110.js"></script>
	<script src = "/js/block/footer_v110.js"></script>

	<script src = "/js/page_v110.js"></script>

</body>
</html>
