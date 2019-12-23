<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php

	function display_list($screen, $list_id, $thumbnail_type, $type_id) {

		global $page_number, $request_size, $item_number;
		global $user_id;

		$content_list = donation_content_list_of($user_id, $type_id);

		$item_number[$list_id] = sizeof($content_list);
		$title = title_of_type($thumbnail_type, $type_id, $item_number[$list_id]);

		$page_number[$list_id] = page_number_of($type_id, $content_list);

		$request_size = $request_size + sizeof($content_list);

		display_thumbnail_container($list_id, "donation", $type_id, "", $title, $content_list);
	}

	$item_number = [0, 0, 0, 0, 0];
	$request_size = 0;

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "/css/panorama/imago_v111.css"/>
   	<link rel = "stylesheet" href = "/css/portrait/imago_v111.css"/>
   	
    <link rel = "stylesheet" href = "/css/panorama/donation_v111.css"/>
    <link rel = "stylesheet" href = "/css/portrait/donation_v111.css"/>

    <link rel = "icon" type = "image/png" href = "/img/icons/imago_con.png"/>

    <title> Imago TV - Dons </title>

    <meta property = "og:title" content = "Imago TV" />
	<meta property = "og:description" content = "La plateforme vidéo de la transition" />
	<meta property = "og:image" content = "/img/icons/imago.jpg" />

    <script src = "/js/lib/jquery.js"></script>

	<!-- TRACKING -->

	<?php include("lib/tracking.php") ?>

</head>


<body>	

<!-- HEADER, MENU & USER -->

	<?php include("block/header.php") ?>	

	<?php include("block/menu.php") ?>
	<?php include("block/user.php") ?>


<!-- MEMBER SCREEN -->	

	<div id = "screen">

		<!-- <img id = "member_background_image" src = "/img/login/imago.jpg"></img> -->
		<a id = "donation_title"> Mes promesses de dons </a>
		<a id = "donation_done"> Mes dons effectués </a>

		<a id = "warning"> Cette fonctionnalité ouvre en fin d'année !! </a>

		<!-- <a id = "donation_select"> Tout sélectionner </a> -->

		<section id = donation >

			<?php display_list("donation", "1", "content", "tvshow") ?>
			<?php display_list("donation", "2", "content", "documentary") ?>
			<?php display_list("donation", "3", "content", "podcast") ?>
			<?php display_list("donation", "4", "content", "shortfilm") ?>

		</section>

<!-- 		<a id = "donation_pay" > CONCRETISER LE DON </a>
		<a id = "donation_remove" > Supprimer les promesses sélectionnées </a> -->

	</div> 


<!-- FOOTER -->

	<?php include("block/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var user_login = "<?php ECHO $user_login; ?>";
    	var user_id = "<?php ECHO $user_id; ?>";
    	var user_status = "<?php ECHO $status; ?>";

        var env = "<?php ECHO $env; ?>";
        var base_url = "<?php ECHO $base_url; ?>";

		var item_number = [];

        item_number[1] = "<?php ECHO $item_number[1]; ?>";
        item_number[2] = "<?php ECHO $item_number[2]; ?>";
        item_number[3] = "<?php ECHO $item_number[3]; ?>";
        item_number[4] = "<?php ECHO $item_number[4]; ?>";


    </script> 


<!-- JS FILES -->

	<script src = "/js/lib/misc_v111.js"></script>
    
	<script src = "/js/block/header_v111.js"></script>
	<script src = "/js/block/menu_v111.js"></script>
	<script src = "/js/block/user_v111.js"></script>
	<script src = "/js/block/footer_v111.js"></script>

    <script src = "/js/block/thumbnail_v111.js"></script>

	<script src = "/js/donation_v111.js"></script>

</body>
</html>
