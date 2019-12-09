
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php

    // Functions

	function display_more($screen, $list_id, $thumbnail_type, $type_id, $content_id) {

		$content_list = get_more_content_list($type_id, $content_id);

		$item_number = sizeof($content_list);
		$title = "Vous aimerez aussi";

		display_thumbnail_container($list_id, $thumbnail_type, $type_id, "", $title, $content_list);
	}

	function display_list($screen, $list_id, $thumbnail_type, $type_id, $content_id, $author_id_list) {

		global $page_number, $user_id, $has_comment, $comment_list;

		if ($thumbnail_type == "content")
			$content_list = get_related_content_list($type_id, $content_id, $author_id_list);

		if ($thumbnail_type == "comment") {
			$content_list = get_related_comment_list($user_id, $content_id);
			$comment_list = $content_list;
		}

		$item_number = sizeof($content_list);
		$title = content_list_title_of($screen, $type_id, "", $item_number);

		$page_number[$list_id] = page_number_of($type_id, $content_list);

		if ($thumbnail_type == "content")
			display_thumbnail_container($list_id, $thumbnail_type, $type_id, "", $title, $content_list);

		if ($thumbnail_type == "comment")
			display_thumbnail_container($list_id, "comment", $thumbnail_type, "", $title, $content_list);
	}	


    ///////////////////////////////// Get url param /////////////////////////////////

	if (isset($_GET["content_id"])) 	$content_id = $_GET["content_id"];		else $content_id = "";
	if (isset($_GET["type_id"])) 		$type_id 	= $_GET["type_id"];			else $type_id = "";
	if (isset($_GET["section_id"])) 	$section_id = $_GET["section_id"]; 		else $section_id = "";
	if (isset($_GET["episod_id"])) 		$episod_id 	= (int)$_GET["episod_id"]; 	else $episod_id = "";
	if (isset($_GET["timecode"])) 		$timecode 	= $_GET["timecode"]; 		else $timecode = "";

	if (isset($_GET["fbclid"])) 		$fbclid 	= $_GET["fbclid"];			else $fbclid = "";

	if ($episod_id == 0) $episod_id = "";

	$content = get_content_info($content_id);
	if ($type_id == "") $type_id = $content["type"];

	// if ($timecode == "") {
	// 	$resume_time = read_resume_time($user_id, $content_id, $episod_id);
	// 	if (sizeof($resume_time) != 0) $timecode = $resume_time["0"]["resume_time"];
	// 	else $timecode = "0";
	// }

    ////////////////////////////////// Redirection //////////////////////////////////

    $request_url = $_SERVER["REQUEST_URI"];
    $request_url = explode("/", $request_url);

    if ($request_url[1] == "php") {

    	$type = type_of($type_id);
		header("Status: 301 Moved Permanently", false, 301);

		if ($section_id == "")
		    header('Location: /'. $type . '/' . str_replace("_", "-" , $content_id) . '/' . $episod_id);
		else if ($section_id == "teaser")
			header('Location: /'. $type . '/' . str_replace("_", "-" , $content_id) . '/bande-annonce/' . $episod_id);
		else if ($section_id == "movie")
			header('Location: /'. $type . '/' . str_replace("_", "-" , $content_id) . '/film/' . $episod_id);
		else if ($section_id == "excerpt")
			header('Location: /'. $type . '/' . str_replace("_", "-" , $content_id) . '/extraits/' . $episod_id);
		else if ($section_id == "bonus")
			header('Location: /'. $type . '/' . str_replace("_", "-" , $content_id) . '/bonus/' . $episod_id);

	    exit();
    }

    //////////////////////////////// Protect data ////////////////////////////////

	if ($content == null) {
		include("404.php");
		return;
	}

	$section_list = ["teaser", "movie", "bonus", "excerpt", ""];

	if (!in_array($section_id, $section_list)) {
		include("404.php");
		return;
	}

	$video_id_list["teaser"] = get_video_id_list("teaser", $content_id);
	$video_id_list["movie"] = get_video_id_list("movie", $content_id);
	$video_id_list["excerpt"] = get_video_id_list("excerpt", $content_id);
	$video_id_list["bonus"] = get_video_id_list("bonus", $content_id);

	if ($episod_id == "0") {
		include("404.php");
		return;
	}

	if ($episod_id != "" AND !isset($video_id_list[$section_id][$episod_id - 1])) {
		include("404.php");
		return;
	}

    ////////////////////////////////// Get data //////////////////////////////////

	$page_number = array();
	$page_number = [0, 0, 0, 0, 0, 0, 0, 0, 0];

	$author_id_list = get_author_id_list($type_id, $content_id);
	if (sizeof($author_id_list) == 0) $author_id_list = [0];

    $author_name = display_author_name($author_id_list);

	$category = $content["category"];

	$info_title = "Production / Distribution :";
	$info_data = $content["producer"];
	if ($info_data == "default") $info_data = "non renseigné";

    $crowdfunding_url = $content["crowdfunding"];

	$producer_id = $content["producer"];

	if ($section_id != "" && $episod_id != "") {

		$episod = $video_id_list[$section_id][$episod_id - 1];
	    $thumbnail = $episod["thumbnail"];
	    $fact_check_url = $episod["fact_check"];

		// $hosting = $episod["hosting"];
		// $video_id = $episod[$hosting . '_id'];
    }
    else {
    	$thumbnail = "";
    	$fact_check_url = "";

    	// $hosting = "";
    	// $video_id = "";	
    }

	if (isset($video_id_list["movie"]["0"])) $fact_check_url = $video_id_list["movie"]["0"]["fact_check"];
	else $fact_check_url = "";

    if ($status == "user" AND !empty(read_favorite_content($user_id, $content_id, ""))) $is_favorite = "1";
    else $is_favorite = "0";

    if ($status == "user" AND !empty(read_later_content($user_id, $content_id, ""))) $is_content_later = "1";
    else $is_content_later = "0";

    if ($status == "user" AND !empty(read_reco_content($user_id, $content_id, ""))) $is_content_reco = "1";
    else $is_content_reco = "0";

    // if ($status == "user" AND !empty(read_later_content($user_id, $content_id, $episod_id))) $is_later = "1";
    // else $is_later = "0";

    // if ($status == "user" AND !empty(read_reco_content($user_id, $content_id, $episod_id))) $is_episod_reco = "1";
    // else $is_episod_reco = "0";

    // if ($status == "user" AND !empty(get_user_comment_list($user_id, $content_id))) $has_comment = "1";
    // else $has_comment = "0";
	
	$background_url = "https://www.asset.imagotv.fr/img/" . $type_id . "/background/" . $content_id . ".jpg";
	$logo_url = "";
	$cover_url = "https://www.asset.imagotv.fr/img/" . $type_id . "/cover_big/" . $content_id . ".jpg";

	$canonical_url = "https://www.imagotv.fr/" . type_of($type_id) . "/" . str_replace ("_", "-" , $content_id);

	$video_object_url = "https://www.asset.imagotv.fr/img/" . $type_id . "/episod/" . $content_id . "/movie_1.jpg";
	$video_object_duration = video_object_duration_of($content["duration"]);

	// $content_list = content_list_of($type_id, $category);
	// $content_list_size = sizeof($content_list);

	// for ($index = 0; $index < $content_list_size; $index++)
	// 	if ($content_list[$index] == $content_id) $content_index = $index;

	// $previous_content_id = $content_list[$content_list_size - 1];
	// $next_content_id = $content_list[0];

	// if ($content_index > 0) $previous_content_id = $content_list[$content_index - 1];
	// if ($content_index < ($content_list_size - 1)) $next_content_id = $content_list[$content_index + 1];

	// $arrow_left_page_href = "movie.php?type_id=" . $type_id . "&content_id=" . $previous_content_id;
	// $arrow_right_page_href = "movie.php?type_id=" . $type_id . "&content_id=" . $next_content_id;


    ////////////////////////////////// OG //////////////////////////////////

	$og_title = $content["name"];
	$meta_title = "Voir : " . $content["name"] . ", sur Imago TV";


	////////////////////////////////// Tag //////////////////////////////////
    
	$screen_tag = read_tag("sheet", $type_id, category_id_of($category), $content_id, "");

	if (empty($screen_tag)) {
		create_tag("sheet", $type_id, category_id_of($category), $content_id, "");
	}
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "sheet", $type_id, category_id_of($category), $content_id, "", $view);
	}

?>


<!DOCTYPE html>
<html lang = "fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "/css/panorama/imago_v110.css"/>
   	<link rel = "stylesheet" href = "/css/portrait/imago_v110.css"/>

    <link rel = "stylesheet" href = "/css/panorama/movie_v110.css"/>
    <link rel = "stylesheet" href = "/css/portrait/movie_v110.css"/>

    <link rel = "icon" type = "image/png" href = "/img/icons/imago_con.png"/>

    <?php include("lib/wpa.php") ?>

    <title> <?php ECHO $meta_title ?> </title>

    <link rel = "canonical" href = "<?php ECHO $canonical_url ?>" />

	<script type = "application/ld+json">

		{
	  		"@context": "https://schema.org",
	  		"@type": "VideoObject",
	  		"name": "<?php ECHO $og_title ?>",
	  		"description": "<?php ECHO $content["description"] ?>",
	  		"thumbnailUrl": "<?php ECHO $video_object_url ?>",
	  		"uploadDate": "2018-12-18T18:00:00+08:00",
	  		"duration": "<?php ECHO $video_object_duration ?>"
		}
		
	</script>

    <meta property = "og:title" content = "<?php ECHO $og_title ?>" />
	<meta property = "og:description" content = "<?php ECHO $content["description"] ?>" />
	<meta property = "og:image" content = "<?php display_og_image($type_id, $content_id, $episod_id) ?>" />

	<meta name = "description" content = "<?php ECHO $content["description"] ?>" />

    <script src = "/js/lib/jquery.js"></script>
	<script src = "/js/lib/jquery.jrumble.1.3.js"></script>

	<!-- TRACKING -->

	<?php include("lib/tracking.php") ?>

</head>


<body>	

<!-- HEADER, MENU & USER -->

	<?php include("block/header.php") ?>	

	<?php include("block/menu.php") ?>
	<?php include("block/user.php") ?>

	<div id = "black_layer"> </div>


<!-- MOVIE SCREEN -->

	<div id = "screen">

		<img class = "background_image" src = <?php ECHO $background_url ?> ></img>
		<img class = "cover_image" src = <?php ECHO $cover_url ?> ></img>

<!-- 		<a class = "partner_text"> En partenariat avec : </a>
		<img class = "partner_image" src = <?php ECHO $partner_url ?> ></img> -->
		
		<?php include("block/button.php") ?>
		<?php include("block/information.php") ?>


		<div id = "donation_area_sheet">

			<a class = "donation_text_sheet"> Ce film vous est offert par fokus21, un don est possible sur </a> 

			<a target = "_blank" href = "https://www.helloasso.com/associations/fokus-21/formulaires/3">
				<img class = "donation_button_sheet" src = "/img/icons/button/helloasso_inline.png" > </img>
			</a>

		</div>

		<section id = "video">

			<?php display_movie_video($content_id, $content, $video_id_list, $type_id, "teaser") ?>
			<?php display_movie_video($content_id, $content, $video_id_list, $type_id, "movie") ?>
			<?php display_movie_video($content_id, $content, $video_id_list, $type_id, "excerpt") ?>
			<?php display_movie_video($content_id, $content, $video_id_list, $type_id, "bonus") ?>
		
		</section>

		<div class = "more_content"> </div>

		<section id = "related_thumbnail">

			<?php display_more("movie", "0", "content", $type_id, $content_id) ?>

 			<?php display_list("movie", "1", "content", "tvshow", $content_id, $author_id_list) ?>
			<?php display_list("movie", "2", "content", "documentary", $content_id, $author_id_list) ?>
			<?php display_list("movie", "3", "content", "podcast", $content_id, $author_id_list) ?>		
			<?php display_list("movie", "4", "content", "shortfilm", $content_id, $author_id_list) ?> 

			<?php display_list("movie", "6", "content", "book", "", $author_id_list) ?>
			<?php display_list("series", "7", "content", "show", "", $author_id_list) ?>
			<?php // display_list("series", "8", "content", "dvd", "", $author_id_list) ?>	

 			<?php // display_list("series", "5", "comment", "comment", $content_id, "") ?>			

		</section>

<!-- 		<a href = "<?php // ECHO $arrow_left_page_href ?>" >
			<img id = "arrow_left_page"  class = "arrow_page" src = "/img/icons/arrow/page_left_grey.png" >
		</a>

		<a href = "<?php // ECHO $arrow_right_page_href ?>" >		
			<img id = "arrow_right_page" class = "arrow_page" src = "/img/icons/arrow/page_right_grey.png" >
		</a> -->

	</div> 


<!-- POP UP -->

	<?php include("block/pop_up.php") ?>


<!-- FOOTER -->

	<?php include("block/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var env = "<?php ECHO $env ?>";
    	var page_url = "<?php ECHO $page_url ?>";
    	var status = "<?php ECHO $status ?>";

    	// var fbclid = "<?php // ECHO $fbclid ?>";

    	var type_id = "<?php ECHO $type_id ?>";
    	var category = "<?php ECHO $category ?>";

    	var content_id = "<?php ECHO $content_id ?>";
    	var section_id = "<?php ECHO $section_id ?>";
    	// var video_id = "<?php // ECHO $video_id ?>";
    	// var audio_id = "<?php // ECHO $audio_id ?>";
    	var episod_id = "<?php ECHO $episod_id ?>";
    	var timecode = "<?php ECHO $timecode ?>";

    	var producer_id = "<?php ECHO $producer_id ?>";




    	// var content_index = "<?php // ECHO $content_index ?>";
    	// var content_list_size = "<?php // ECHO $content_list_size ?>";

    	// var hosting = "<?php // ECHO $hosting ?>";
    	// var audio_hosting = "<?php // ECHO $audio_hosting ?>";

		var fact_check_url = "<?php ECHO $fact_check_url ?>";
		var crowdfunding_url = "<?php ECHO $crowdfunding_url ?>";

    	var is_favorite = "<?php ECHO $is_favorite ?>";
    	var is_content_later = "<?php ECHO $is_content_later ?>";
    	var is_content_reco = "<?php ECHO $is_content_reco ?>";
    	// var is_later = "<?php // ECHO $is_later ?>";
    	// var is_episod_reco = "<?php // ECHO $is_episod_reco ?>";

    	// var has_comment = "<?php // ECHO $has_comment ?>";
    	var comment_list = <?php ECHO json_encode($comment_list) ?>;

    	var page_number = [];

    	page_number[0] = "1";
    	page_number[1] = "<?php ECHO $page_number["1"] ?>";
    	page_number[2] = "<?php ECHO $page_number["2"] ?>";
    	page_number[3] = "<?php ECHO $page_number["3"] ?>";
    	page_number[4] = "<?php ECHO $page_number["4"] ?>";
    	page_number[5] = "<?php ECHO $page_number["5"] ?>";
    	page_number[6] = "<?php ECHO $page_number["6"] ?>";

    	var note_1 = "<?php ECHO $content["note_1"] ?>";
    	var note_2 = "<?php ECHO $content["note_2"] ?>";
    	var note_3 = "<?php ECHO $content["note_3"] ?>";

  	</script>


<!-- JS FILES -->

	<script src = "/js/lib/misc_v110.js"></script>
    
	<script src = "/js/block/header_v110.js"></script>
	<script src = "/js/block/menu_v110.js"></script>
	<script src = "/js/block/user_v110.js"></script>
	<script src = "/js/block/footer_v110.js"></script>

    <script src = "/js/block/button_v110.js"></script>
    <script src = "/js/block/thumbnail_v110.js"></script>
    <script src = "/js/block/information_v110.js"></script>

    <script src = "/js/block/player_v110.js"></script>
	<script src = "/js/movie_v110.js"></script>

</body>
</html>
