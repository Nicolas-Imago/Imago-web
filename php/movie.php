
<?php require_once("mutual/init.php") ?>

<?php require_once("mutual/lib_model.php") ?>
<?php require_once("mutual/lib_view.php") ?>

<?php

    // Display functions

    function display_video($movie_type) {

    	global $content, $content_id;
    	global $video_id_list;

    	if (isset($video_id_list[$movie_type])) {
	       	$video_number = sizeof($video_id_list[$movie_type]);
	    }
	    else {$video_number = 0;}

	    ECHO ' <div ';
	    	ECHO ' class = "video_thumbnail_type" ';
    	ECHO ' > ';

    	if ($video_number > 0) {
	    	for ($video_index = 0; $video_index <= $video_number - 1; $video_index++) {

                $hosting = $video_id_list[$movie_type][$video_index]["hosting"];
                $thumbnail = $video_id_list[$movie_type][$video_index]["thumbnail"];

	    		$video_id = $video_id_list[$movie_type][$video_index][$hosting . '_id'];

                if ($content["thumbnail"] == "local") {
                	$image_url = "../img/video/" . $content_id . "/" . $video_id . ".jpg";
                }
    			if ($content["thumbnail"] == "youtube") {
					$image_url = "https://img.youtube.com/vi/" . $video_id . "/mqdefault.jpg";
				}

	    		// $image_id = $movie_type . "-" . $video_index;

		    	ECHO ' <div ';
		            ECHO ' id = "thumbnail_' . $thumbnail . '_' . $movie_type . "-" . $video_index . '" ';
		            ECHO ' class = "thumbnail" ';
		    	ECHO ' > ';

	                ECHO ' <img ';
		                ECHO ' id = "thumbnail_image_' . $movie_type . "-" . $video_index . '" ';
	                	ECHO ' class = "thumbnail" ';
		                ECHO ' src = "' . $image_url . '" ';
	                ECHO ' > ';

	                ECHO ' <img ';
		                ECHO ' class = "play_logo" ';
		                ECHO ' src = "../img/icons/play.png" ';
	                ECHO ' > ';

	            ECHO '</div>';
	    	}
	    }
	    // else if ($movie_type == "movie") {

	    // 	$message = "Ce documentaire n'est malheureusement pas encore disponible au visionnage gratuit. Notre objectif est de travailler avec les ayants droits pour le rendre ponctuellement visionnable gratuitement. Plus nous serons à utiliser Imago, plus nous aurons de poids pour y arriver ! Aidez-nous ! Faites connaître Imago ! <br> <br> En attendant, il vous est possible de louer (VOD) ou d'acheter (DVD) ce documentaire via les liens disponibles sur cette page. Cette transaction se fait directement auprès de l'ayant droit et ne passe pas par Imago. Notre service est gratuit et ne prend pas de commission.";

	    // 	ECHO ' <div ';
     //           	ECHO ' class = "movie_message" ';
     //            ECHO ' >';
     //               	ECHO '<a class = "movie_message"> ' . $message . '</a>';
     //        ECHO ' </div>';
	    // }

        ECHO '</div>';
	}

    function display_title($movie_type) {

    	global $video_id_list;

    	if (isset($video_id_list[$movie_type])) {
	       	$video_number = sizeof($video_id_list[$movie_type]);
	    }
	    else {$video_number = 0;}

	    // if ($video_number == 0 AND $movie_type != "movie") {
	    if ($video_number == 0) {
	    	ECHO ' style = "display:none;" ';
	    }
    }


    // Display screen

	if (isset($_GET["type_id"])) {$type_id = $_GET["type_id"];} else {$type_id = "documentary";}
	if (isset($_GET["content_id"])) {$content_id = $_GET["content_id"];} else {$content_id = "";}
	if (isset($_GET["video_id"])) {$video_id = $_GET["video_id"];} else {$video_id = "";}

	$content = get_content_info($content_id);

	if ($content == null) {
		include("404.php");
		return;
	}

	$category = $content["category"];
	$hosting = $content["hosting"];
	$thumbnail = $content["thumbnail"];
	$link = $content["link"];

	$info_title = "Prod. / Distribution :";
	$info_data = "Non renseigné";

	if (strlen($content["vod"]) != 0) {$vod = true;} else {$vod = false;}
	if (strlen($content["dvd"]) != 0) {$dvd = true;} else {$dvd = false;}

	$author_id_list = get_author_id_list($content_id);

	$producer_id = $content["producer"];
	// $producer = get_producer_name_json($producer_id);

	$video_id_list["teaser"] = get_video_id_list("teaser", $content_id);
	$video_id_list["movie"] = get_video_id_list("movie", $content_id);
	$video_id_list["excerpt"] = get_video_id_list("excerpt", $content_id);
	$video_id_list["bonus"] = get_video_id_list("bonus", $content_id);

	// var_dump($teaser_id_list);

    // tag 

	$screen_tag = read_tag("sheet", $type_id, category_id_of($category), $content_id, $video_id);

	if (empty($screen_tag)) {
		create_tag("sheet", $type_id, category_id_of($category), $content_id, $video_id);
	}
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "sheet", $type_id, category_id_of($category), $content_id, $video_id, $view);
	}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "../css/imago.css"/>
   	<link rel = "stylesheet" href = "../css/mobile/imago.css"/>

    <link rel = "stylesheet" href = "../css/movie.css"/>
    <link rel = "stylesheet" href = "../css/mobile/movie.css"/>

    <link rel = "icon" type = "image/png" href = "../img/icons/imago_con.png"/>

    <title>ImagoTV</title>

    <meta property = "og:title" content = "<?php ECHO $content["name"] ?>" />
	<meta property = "og:description" content = "<?php ECHO $content["description"] ?>" />
	<meta property = "og:image" content = "<?php display_image("og_image") ?>" />

	<script src = "../lib/jquery.js"></script>

	<!-- TRACKING -->

	<?php include("mutual/tracking.php") ?>

</head>


<body>	

<!-- HEADER -->
	
	<?php include("mutual/header.php") ?>
	

<!-- MENU & USER -->	

	<?php include("mutual/menu.php") ?>
	<?php include("mutual/user.php") ?>


<!-- SCREEN -->

	<div id = "screen">

		<img class = "background_image" <?php display_image("background") ?> ></img>
		<img class = "cover_image" <?php display_image("cover") ?> ></img>
		
		<?php include("mutual/button.php") ?>
		<?php include("mutual/information.php") ?>

		<section id = "video">

			<a class = "thumbnail_title" <?php display_title("teaser") ?> > Bande annonce : </a>
			<div id = "teaser_thumbnail" >
				<?php display_video("teaser") ?>
			</div>

			<a class = "thumbnail_title" <?php display_title("movie") ?> > Film : </a>
			<div id = "movie_thumbnail" >
				<?php display_video("movie") ?>
			</div>

			<a class = "thumbnail_title" <?php display_title("excerpt") ?> > Extrait(s) : </a>
			<div id = "excerpt_thumbnail" >
				<?php display_video("excerpt") ?>
			</div>

			<a class = "thumbnail_title" <?php display_title("bonus") ?> > Bonus : </a>
			<div id = "bonus_thumbnail" >
				<?php display_video("bonus") ?>
			</div>

		</section>

		<section id = "link">

			<a class = "link_title" > Louer / Acheter : </a>

			<a target = "_blank" id = "vod_link" class = "link" <?php display_link("vod") ?> > 
				<img id = "vod_image" class = "icons_image" <?php display_image("vod") ?> ></img>
			</a>

			<a target = "_blank" id = "dvd_link" class = "link" <?php display_link("dvd") ?> > 
				<img id = "dvd_image" class = "icons_image" <?php display_image("dvd") ?> ></img>
			</a>

		</section>

	</div> 

	<a <?php display_next() ?> > <img id = "page_right" src = "../img/icons/footer/page_right_grey.png"></a>
	<a <?php display_preview() ?> > <img id = "page_left" src = "../img/icons/footer/page_left_grey.png"></a>


<!-- POP UP -->

	<?php include("mutual/pop_up.php") ?>


<!-- FOOTER -->

	<?php include("mutual/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

       	var env = "<?php ECHO $env; ?>";
    	var base_url = "<?php ECHO $base_url; ?>";
    	var page_url = "<?php ECHO $page_url; ?>";

    	var type_id = "<?php ECHO $type_id; ?>";
    	var content_id = "<?php ECHO $content_id; ?>";
    	var video_id = "<?php ECHO $video_id; ?>";

    	var producer_id = "<?php ECHO $producer_id; ?>";
    	var category = "<?php ECHO $category; ?>";

    	var hosting = "<?php ECHO $hosting; ?>";
    	var thumbnail = "<?php ECHO $thumbnail; ?>";

		var vod = "<?php ECHO $vod; ?>";
		var dvd = "<?php ECHO $dvd; ?>";
		var link = "<?php ECHO $link; ?>";

    	var note_1 = "<?php ECHO $content["note_1"]; ?>";
    	var note_2 = "<?php ECHO $content["note_2"]; ?>";
    	var note_3 = "<?php ECHO $content["note_3"]; ?>";

  	</script>


<!-- JS FILES -->

	<script src = "../js/mutual/lib.js"></script>

	<script src = "../js/mutual/header.js"></script>
	<script src = "../js/mutual/menu.js"></script>
	<script src = "../js/mutual/user.js"></script>
	<script src = "../js/mutual/footer.js"></script>

	<script src = "../js/movie.js"></script>

</body>
</html>