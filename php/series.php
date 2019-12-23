
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

	if (isset($_GET["type_id"])) 		$type_id 	= $_GET["type_id"];			else $type_id = "";
	if (isset($_GET["content_id"])) 	$content_id = $_GET["content_id"];		else $content_id = "";
	if (isset($_GET["section_id"])) 	$section_id = $_GET["section_id"]; 		else $section_id = "season";
	if (isset($_GET["episod_id"])) 		$episod_id 	= (int)$_GET["episod_id"]; 	else $episod_id = "";
	if (isset($_GET["timecode"])) 		$timecode 	= $_GET["timecode"]; 		else $timecode = "";

	if (isset($_GET["fbclid"])) 		$fbclid 	= $_GET["fbclid"];			else $fbclid = "";

	if ($episod_id == 0) $episod_id = "";

	$content = get_content_info($content_id);
	if ($type_id == "") $type_id = $content["type"];

	if ($content == null) {
		include("404.php");
		return;
	}

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

	    header('Location: /'. $type . '/' . str_replace("_", "-" , $content_id) . '/' . $episod_id);

	    exit();
    }

    //////////////////////////////// Protect data ////////////////////////////////

	if ($content == null) {
		include("404.php");
		return;
	}

	$video_id_list = get_video_id_list("season", $content_id);
    $video_number = sizeof($video_id_list);

	if ($episod_id == "0") {
		include("404.php");
		return;
	}

	if ($episod_id != "" AND !isset($video_id_list[$episod_id - 1])) {
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

	$info_title = "Format :";
	$info_data = $content["format"];


    $crowdfunding_url = $content["crowdfunding"];

	if($content["season_size"] != "") $season_size = intval($content["season_size"]); else $season_size = 12;

    $season_number = intval(($video_number - 1) / $season_size) + 1;

	if ($episod_id != "") {
		$current_season = intval(($episod_id - 1) / $season_size) + 1;

		$episod = $video_id_list[$episod_id - 1];
	    $thumbnail = $episod["thumbnail"];
	    $fact_check_url = $episod["fact_check"];
    }
    else {
    	$current_season = $season_number;
    	$thumbnail = "";
    	$fact_check_url = ""; 	
    }

    if ($status == "user" AND !empty(read_favorite_content($user_id, $content_id, "", ""))) $is_favorite = "1";
    else $is_favorite = "0";

    if ($status == "user" AND !empty(read_later_content($user_id, $content_id, "", ""))) $is_content_later = "1";
    else $is_content_later = "0";

    if ($status == "user" AND !empty(read_reco_content($user_id, $content_id, "", ""))) $is_content_reco = "1";
    else $is_content_reco = "0"; 


    $background_url = "https://www.asset.imagotv.fr/img/" . $type_id . "/background/" . $content_id . ".jpg";
	$logo_url = "https://www.asset.imagotv.fr/img/" . $type_id . "/thumbnail/" . $content_id . ".jpg";

	$canonical_url = "/" . type_of($type_id) . "/" . str_replace ("_", "-" , $content_id);


    ////////////////////////////////// OG //////////////////////////////////

	if ($type_id == "music" AND $episod_id != "") {
		$og_info = $video_id_list[$episod_id - 1];
		$og_title = $author_name . ' - ' . $og_info["title"];
	}
	else 
		$og_title = $content["name"];

	if ($type_id == "music" OR $type_id == "podcast")
		$meta_title = "Ecouter : " . $content["name"] . ", sur Imago TV";
	else
		$meta_title = "Voir : " . $content["name"] . ", sur Imago TV";


    ////////////////////////////////// Tag //////////////////////////////////

	$screen_tag = read_tag("sheet", $type_id, category_id_of($category), $content_id, "");

	if (empty($screen_tag)) {
		create_tag("sheet", $type_id, category_id_of($category), $content_id, "");
	}
	else {
		$view = (int)$screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "sheet", $type_id, category_id_of($category), $content_id, "", $view);
	}

?>


<!DOCTYPE html>
<html lang = "fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "/css/panorama/imago_v111.css"/>
   	<link rel = "stylesheet" href = "/css/portrait/imago_v111.css"/>

    <link rel = "stylesheet" href = "/css/panorama/series_v111.css"/>
    <link rel = "stylesheet" href = "/css/portrait/series_v111.css"/>

    <link rel = "icon" type = "image/png" href = "/img/icons/imago_con.png"/>

    <?php include("lib/wpa.php") ?>

    <title> <?php ECHO $meta_title ?> </title>

    <!-- <link rel = "canonical" href = "<?php // ECHO $canonical_url ?>" /> -->

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


<!-- SERIES SCREEN -->	

	<div id = "screen">

		<img class = "background_image" src = <?php ECHO $background_url ?> ></img>
		<div class = "background_shadow"></div>

		<?php include("block/information.php") ?>

		<section id = "filter"> 
			<div id = "season_list">
				<?php display_season($season_number) ?>
	    	</div>
	    	
			<img id = "grid" class = "display" > </img>
			<img id = "list" class = "display" > </img>
		</section>

		<section id = "video_thumbnail">
			<?php display_series_video($content_id, $content, $video_id_list, $type_id, $section_id) ?>			
		</section> 

		<div class = "more_content"> </div>

		<section id = "related_thumbnail">

			<?php display_more("series", "0", "content", $type_id, $content_id) ?>

			<?php display_list("series", "1", "content", "tvshow", $content_id, $author_id_list) ?>
			<?php display_list("series", "2", "content", "documentary", $content_id, $author_id_list) ?>
			<?php display_list("series", "3", "content", "podcast", $content_id, $author_id_list) ?>	
			<?php display_list("series", "4", "content", "shortfilm", $content_id, $author_id_list) ?>

			<?php display_list("series", "6", "content", "book", "", $author_id_list) ?>			
			<?php display_list("series", "7", "content", "show", "", $author_id_list) ?>	
			<?php // display_list("series", "8", "content", "dvd", "", $author_id_list) ?>	

		</section>

	</div> 

	<?php include("block/button.php") ?>


<!-- POP UP -->

	<?php include("block/player.php") ?>


<!-- FOOTER -->

	<?php include("block/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var env = "<?php ECHO $env ?>";
    	var page_url = "<?php ECHO $page_url ?>";
    	var user_status = "<?php ECHO $status ?>";

    	// var fbclid = "<?php // ECHO $fbclid ?>";

    	var type_id = "<?php ECHO $type_id ?>";
    	var category = "<?php ECHO $category ?>";

    	var content_id = "<?php ECHO $content_id ?>";
      	var section_id = "<?php ECHO $section_id ?>";
    	var episod_id = "<?php ECHO $episod_id ?>";
    	var timecode = "<?php ECHO $timecode ?>";
    	
    	var season_number = "<?php ECHO $season_number ?>";
    	var current_season = "<?php ECHO $current_season ?>";
    	var video_number = "<?php ECHO $video_number ?>";
    	var season_size = "<?php ECHO $season_size ?>";

		// var fact_check_url = "<?php // ECHO $fact_check_url ?>";
		var crowdfunding_url = "<?php ECHO $crowdfunding_url ?>";

    	var is_content_favorite = "<?php ECHO $is_favorite ?>";
    	var is_content_later = "<?php ECHO $is_content_later ?>";
    	var is_content_reco = "<?php ECHO $is_content_reco ?>";

    	var comment_list = <?php ECHO json_encode($comment_list) ?>;

    	var note_1 = "<?php ECHO $content["note_1"] ?>";
    	var note_2 = "<?php ECHO $content["note_2"] ?>";
    	var note_3 = "<?php ECHO $content["note_3"] ?>";

  	</script> 


<!-- JS FILES -->

	<script src = "/js/lib/misc_v111.js"></script>

	<script src = "/js/block/header_v111.js"></script>
	<script src = "/js/block/menu_v111.js"></script>
	<script src = "/js/block/user_v111.js"></script>
	<script src = "/js/block/footer_v111.js"></script>

    <script src = "/js/block/button_v111.js"></script>
    <script src = "/js/block/thumbnail_v111.js"></script>
    <script src = "/js/block/information_v111.js"></script>

    <script src = "/js/block/player_v111.js"></script>
	<script src = "/js/series_v111.js"></script>

</body>
</html>
