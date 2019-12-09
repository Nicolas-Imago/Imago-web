
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php


	////////////////////////////////// Get data //////////////////////////////////

	function tile_class_of($corner_size) {

		if ($corner_size == "1") $tile_class = "one_tile";
		if ($corner_size == "2") $tile_class = "two_tiles";
		if ($corner_size == "3") $tile_class = "three_tiles";
		if ($corner_size == "4") $tile_class = "four_tiles";

		return $tile_class;
	}

	function display_folder($folder_list, $folder_index) {

		$tile_title = $folder_list[$folder_index - 1]["title"];
		$tile_href_text = $folder_list[$folder_index - 1]["href"];
		$tile_type = "folder";

		$tile_href[0] = $tile_href_text;
		$tile_image[0] = $folder_list[$folder_index - 1]["image_url"];
		$tile_class[0] = "one_tile";

		for ($index = 1; $index <=3; $index++) {
			$tile_href[$index] = "";
			$tile_image[$index] = "";
			$tile_class[$index] = "no_display";
		}
	 
		include("block/tile.php");

	}

	function display_corner($corner_sub_type, $corner_size) {

		$corner_list = homepage_corner_list($corner_sub_type);
		$corner_tile_class = tile_class_of($corner_size);

		$tile_title = $corner_list[0]["title"];
		$tile_href_text = "";
		$tile_type = "corner";

		for ($index = 0; $index <= $corner_size - 1 ; $index++) {
			$tile_href[$index] = $corner_list[$index]["href"];
			$tile_image[$index] = $corner_list[$index]["image_url"];
			$tile_class[$index] = $corner_tile_class;
		}

		for ($index = $corner_size; $index <=  3 ; $index++) {
			$tile_href[$index] = "";
			$tile_image[$index] = "";
			$tile_class[$index] = "no_display";
		}
	 
		include("block/tile.php");

	}

    ////////////////////////////////// Redirection //////////////////////////////////

    $request_url = $_SERVER["REQUEST_URI"];
    $request_url = explode("/", $request_url);

    if ($request_url[1] == "php") {

		header("Status: 301 Moved Permanently", false, 301);
	    header('Location: /');
	    exit();
    }


    ////////////////////////////////// Get data //////////////////////////////////

	$video_list = homepage_video_id_list(8);
	$audio_list = homepage_audio_id_list(6);

	$folder_list = homepage_folder_list();

	$tvshow_list = homepage_content_list_of("tvshow", 8);
	$documentary_list = homepage_content_list_of("documentary", 10);	
	$shortfilm_list = homepage_content_list_of("shortfilm", 8);	

	$member_number = count_member()[0];


    ////////////////////////////////// Tag //////////////////////////////////

	$screen_tag = read_tag("homepage", "", "", "", "");

	if (empty($screen_tag)) create_tag("homepage", "", "", "", "");
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "homepage", "", "", "", "", $view);
	}	

?>


<!DOCTYPE html>
<html lang = "fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <link rel = "stylesheet" href = "/css/panorama/imago_v110.css"/>
   	<link rel = "stylesheet" href = "/css/portrait/imago_v110.css"/>

    <link rel = "stylesheet" href = "/css/panorama/homepage_v110.css"/>
    <link rel = "stylesheet" href = "/css/portrait/homepage_v110.css"/>

    <link rel = "icon" type = "image/png" href = "/img/icons/imago_con.png"/>

    <?php include("lib/wpa.php") ?>

    <title> Imago TV - La plateforme vidéo gratuite de la transition </title>

    <meta property = "og:title" content = "Imago" />
    <meta property = "og:type" content = "website" />
	<meta property = "og:description" content = "La plateforme vidéo gratuite de la transition" />
	<meta property = "og:image" content = "http://asset.imagotv.fr/img/imago.jpg" />

	<meta name = "description" content = "Imago propose une sélection de plus de 2000 vidéos parmi les meilleurs documentaires, web séries, courts-métrages ou podcasts engagés dans la transition." />

    <script src = "/js/lib/jquery.js"></script>

	<!-- TRACKING -->

	<?php include("lib/tracking.php") ?>

</head>


<body>	

<!-- HEADER, MENU & USER -->

	<?php include("block/header.php") ?>	

	<?php include("block/menu.php") ?>
	<?php include("block/user.php") ?>

	<div id = "black_layer"> </div>


<!-- HOMEPAGE SCREEN -->	

	<div id = "screen">

		<div class = "screen_title" >
			<h1 class = "screen_title" > La plateforme vidéo gratuite de la transition </h1> 
			<a class = "screen_title" > Une sélection de plus de 2500 vidéos </a> <br>
			<a class = "screen_title" > docu, web séries, courts-métrages et podcasts</a> <br>
			<a class = "screen_title" >  engagés dans la transition. </a>
		</div>

		<?php include("block/button.php") ?>

		<?php

			ECHO '<section id = "category" class = "list">';
			ECHO 	'<a id = "category_list_title" class = "title"> Tous les contenus </a>';
			ECHO 	'<div id = "category_list_thumbnail" class = "link"> ';

			for ($index = 1; $index <= 4; $index++) {

				ECHO '<a href = "/' . type_of(type_id_of($index)) . '" >';
				ECHO 	'<img class = "four_tiles" src = "/img/homepage/type/' . type_id_of($index) . '.jpg"></img>';
				ECHO '</a> ';
			}

			ECHO	'</div>';
			ECHO '</section>';

		?>

<!-- 		<section id = "live">
			<a id = "live_title" class = "title"> En ce moment sur ImagoTV</a>
			<div class = "live_player">
				<iframe class = "live_player" allowfullscreen></iframe>
			</div>
			<a id = "switch_en" class = "switch" > (Ecouter en anglais) </a>
			<a id = "switch_fr" class = "switch" > (Ecoute en français) </a>
		</section> -->

		<?php 

			display_corner("exclus", 2);

			// display_folder($folder_list, 1);

			// display_corner("tres_court", 3);

			// display_corner("cine", 2);

			display_thumbnail_container("1", "video", "tvshow", "", "Les dernières vidéos", $video_list);

			display_folder($folder_list, 2);

			display_thumbnail_container("2", "audio", "podcast", "", "Les derniers podcasts", $audio_list);

			display_folder($folder_list, 4);

			display_corner("info", 4);

			display_folder($folder_list, 3);

			// display_corner("theatre", 2);

			// display_folder($folder_list, 5);

			display_thumbnail_container("3", "content", "tvshow", "", "Emissions", $tvshow_list);

			display_folder($folder_list, 4);

			display_thumbnail_container("4", "content", "documentary", "", "Documentaires", $documentary_list);

			// display_folder($folder_list, 5);

			// display_corner("media", 4);

			// display_folder($folder_list, 6);

			// display_corner("asso", 4);

			// display_folder($folder_list, 7);

			// display_corner("producer", 4);

			display_folder($folder_list, 8);

			display_thumbnail_container("5", "content", "shortfilm", "", "Courts-métrages", $shortfilm_list);

			display_folder($folder_list, 9);


			ECHO '<section id = "category" class = "list">';
			ECHO 	'<a id = "category_list_title" class = "title"> Toutes les thématiques </a>';
			ECHO 	'<div id = "category_list_thumbnail" class = "link"> ';

			for ($index = 1; $index <= 8; $index++) {

				ECHO '<a href = "' . category_of($index) . '" >';
				ECHO 	'<img class = "four_tiles" src = "/img/homepage/category/' . $index . '_grey.jpg"></img>';
				ECHO '</a> ';
			}

			ECHO	'</div>';
			ECHO '</section>';

			display_folder($folder_list, 10);
		?>

	</div>


<!-- FOOTER -->

	<?php include("block/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var env = "<?php ECHO $env; ?>";
    	var page_url = "<?php ECHO $page_url; ?>";
    	var status = "<?php ECHO $status ?>";

    	var page_number = [];

    	page_number["1"] = 2;
    	page_number["2"] = 1;
    	page_number["3"] = 2;
    	page_number["4"] = 2;
    	page_number["5"] = 2;

    </script> 


<!-- JS FILES -->

	<script src = "/js/lib/misc_v110.js"></script>
    	
	<script src = "/js/block/header_v110.js"></script>
	<script src = "/js/block/menu_v110.js"></script>
	<script src = "/js/block/user_v110.js"></script>
	<script src = "/js/block/footer_v110.js"></script>

    <script src = "/js/block/button_v110.js"></script>
    <script src = "/js/block/thumbnail_v110.js"></script>

	<script src = "/js/homepage_v110.js"></script>

</body>
</html>
