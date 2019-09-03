
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php

	// Functions

	function add_href($html) {

    	global $content_id;

    	ECHO ' href = "../php/page.php?page_id=' . $html . '" ';
    }

    // Display screen

	if (isset($_GET["page_id"])) {$page_id = $_GET["page_id"];} else {$page_id = "";}

	$page_url = "../html/" . $page_id . ".html";

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "../css/panorama/imago.css"/>
   	<link rel = "stylesheet" href = "../css/portrait/imago.css"/>

    <link rel = "stylesheet" href = "../css/panorama/page.css"/>
    <link rel = "stylesheet" href = "../css/portrait/page.css"/>

    <link rel = "icon" type = "image/png" href = "../img/icons/imago_con.png"/>

    <title> Imago TV - La plateforme vidéo de la transition </title>

    <meta property = "og:title" content = "ImagoTV" />
	<meta property = "og:description" content = "La plateforme vidéo de la transition" />
	<meta property = "og:image" content = "/img/page/manifeste/og_img.jpg" />

    <script src = "../js/lib/jquery.js"></script>

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

		<div class = "item_list">
			<ol class = "item_list">
		      	<li><a id = "item_1" class = "item" <?php add_href("qui_sommes_nous") ?> > L'équipe </a></li>
		      	<li><a id = "item_2" class = "item" <?php add_href("manifeste") ?> > Le manifeste </a></li>
		      	<li><a id = "item_3" class = "item" <?php add_href("media") ?> > Revue de presse </a></li>
		      	<li><a id = "item_4" class = "item" <?php add_href("aidez_nous") ?> > Aidez-nous </a></li>
		      	<li><a id = "item_5" class = "item" <?php add_href("faq") ?> > FAQ </a></li>
		      	<li><a id = "item_6" class = "item" <?php add_href("version") ?> > Code </a></li>
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

	<script src = "../js/lib/misc.js"></script>

	<script src = "../js/block/header.js"></script>
	<script src = "../js/block/menu.js"></script>
	<script src = "../js/block/user.js"></script>
	<script src = "../js/block/footer.js"></script>

	<script src = "../js/page.js"></script>

</body>
</html>
