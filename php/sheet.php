
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php

    // Functions

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


    ////////////////////////////////// Get url param //////////////////////////////////

	if (isset($_GET["type_id"])) 		$type_id 	= $_GET["type_id"];			else $type_id = "";
	if (isset($_GET["content_id"])) 	$content_id = $_GET["content_id"];		else $content_id = "";

	if (isset($_GET["video_id"])) 		$video_id 	= $_GET["video_id"]; 		else $video_id = "";

	if (isset($_GET["section_id"])) 	$section_id = $_GET["section_id"]; 		else $section_id = "";
	if (isset($_GET["episod_id"])) 		$episod_id 	= $_GET["episod_id"]; 		else $episod_id = "";

	if (isset($_GET["timecode"])) 		$timecode 	= $_GET["timecode"];		else $timecode = "";


    ////////////////////////////////// Get data //////////////////////////////////

	$type_list = ["tvshow", "podcast", "music", "humour", "documentary", "shortfilm"];

	if (!in_array($type_id, $type_list)) {
		include("404.php");
		return;
	}


	$content = get_content_info($content_id);

	if ($content == null) {
		include("404.php");
		return;
	}

	$page_number = array();
	$page_number = [0, 0, 0, 0, 0, 0, 0, 0, 0];

	$author_id_list = get_author_id_list($content_id);
    $author_name = display_author_name($author_id_list);

	$category = $content["category"];

	if ($type_id == "documentary" OR $type_id == "shortfilm") {
		$info_title = "Prod. / Distribution :";
		$info_data = $content["producer"];
		if ($info_data == "default") $info_data = "non renseigné";
	else {
		$info_title = "Format :";
		$info_data = $content["format"];	
	}

    $crowdfunding_url = $content["crowdfunding"];

	$producer_id = $content["producer"];
	// $producer = get_producer_name_json($producer_id);

	$video_id_list["teaser"] = get_video_id_list("teaser", $content_id);
	$video_id_list["movie"] = get_video_id_list("movie", $content_id);
	$video_id_list["excerpt"] = get_video_id_list("excerpt", $content_id);
	$video_id_list["bonus"] = get_video_id_list("bonus", $content_id);


	if ($section_id != "" && $episod_id != "") {
		
		if (isset($video_id_list[$section_id][$episod_id - 1])) {
			$episod = $video_id_list[$section_id][$episod_id - 1];

	        $thumbnail = $episod["thumbnail"];
	        $fact_check_url = $episod["fact_check"];

			$hosting = $episod["hosting"];

			if ($hosting == "invidio") $video_id = $episod["youtube_id"];
            else $video_id = $episod[$hosting . '_id'];
	    }
	    else {
			include("404.php");
			return;	    	
	    }
    }
    else {
    	$hosting = "youtube";
    	$thumbnail = "youtube";
    	$fact_check_url = "";
    }

	if (isset($video_id_list["movie"]["0"])) $fact_check_url = $video_id_list["movie"]["0"]["fact_check"];
	else $fact_check_url = "";

    if ($status == "user" AND !empty(read_favorite_content($user_id, $content_id, $episod_id))) $is_favorite = "1";
    else $is_favorite = "0";

    if ($status == "user" AND !empty(read_watch_later_content($user_id, $content_id, $episod_id))) $watch_later = "1";
    else $watch_later = "0";

	if ($status == "user" AND !empty(get_user_comment_list($user_id, $content_id))) $has_comment = "1";
	else $has_comment = "0";   
	
	$background_url = "/img/content/" . $type_id . "/background/" . $content_id . ".jpg";
	$cover_url = "/img/content/" . $type_id . "/cover_big/" . $content_id . ".jpg";
	$logo_url = "/img/content/" . $type_id . "/thumbnail/" . $content_id . ".jpg";

	$partner_url = "/img/icons/partner/parc_avesnois.png"; 

	$content_list = content_list_of($type_id, $category);
	$content_list_size = sizeof($content_list);

	for ($index = 0; $index < $content_list_size; $index++)
		if ($content_list[$index] == $content_id) $content_index = $index;

	$previous_content_id = $content_list[$content_list_size - 1];
	$next_content_id = $content_list[0];

	if ($content_index > 0) $previous_content_id = $content_list[$content_index - 1];
	if ($content_index < ($content_list_size - 1)) $next_content_id = $content_list[$content_index + 1];

	$arrow_left_page_href = "sheet.php?type_id=" . $type_id . "&content_id=" . $previous_content_id;
	$arrow_right_page_href = "sheet.php?type_id=" . $type_id . "&content_id=" . $next_content_id;
////////////////////////////////// OG //////////////////////////////////

if ($type_id == "music" AND $episod_id != "") {
	$og_info = $video_id_list[$episod_id - 1];
	$og_name = $author_name . ' - ' . $og_info["title"];
}
else {
	$og_name = $content["name"];
}

    ////////////////////////////////// Tag //////////////////////////////////
    

	$screen_tag = read_tag("sheet", $type_id, category_id_of($category), $content_id, $video_id);

	if (empty($screen_tag)) create_tag("sheet", $type_id, category_id_of($category), $content_id, $video_id);
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "sheet", $type_id, category_id_of($category), $content_id, $video_id, $view);
	}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "/css/panorama/imago.css"/>
   	<link rel = "stylesheet" href = "/css/portrait/imago.css"/>

    <link rel = "stylesheet" href = "/css/panorama/sheet.css"/>
    <link rel = "stylesheet" href = "/css/portrait/sheet.css"/>

    <link rel = "icon" type = "image/png" href = "/img/icons/imago_con.png"/>

    <title> <?php ECHO $og_name ?> sur Imago TV </title>

<meta property = "og:title" content = "<?php ECHO $og_name ?>" />
	<meta property = "og:description" content = "<?php ECHO $content["description"] ?>" />
	<meta property = "og:image" content = "<?php display_og_image($type_id, $content_id, $thumbnail, $episod_id, $video_id) ?>" />

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
		<div class = "background_shadow"></div>	
		<img class = "cover_image" src = <?php ECHO $cover_url ?> ></img>

<!-- 		<a class = "partner_text"> En partenariat avec : </a>
		<img class = "partner_image" src = <?php ECHO $partner_url ?> ></img> -->
		
		<?php include("block/button.php") ?>
		<?php include("block/information.php") ?>

		<section id = "video">
			<?php display_movie_video($content_id, $content, $video_id_list, $type_id, "teaser") ?>
			<?php display_movie_video($content_id, $content, $video_id_list, $type_id, "movie") ?>
			<?php display_movie_video($content_id, $content, $video_id_list, $type_id, "excerpt") ?>
			<?php display_movie_video($content_id, $content, $video_id_list, $type_id, "bonus") ?>
			<?php display_list("series", "1", "content", "tvshow", $content_id, $author_id_list) ?>
			<?php display_list("series", "2", "content", "documentary", $content_id, $author_id_list) ?>
			<?php display_list("series", "3", "content", "shortfilm", $content_id, $author_id_list) ?>
			<?php display_list("series", "4", "content", "podcast", $content_id, $author_id_list) ?>			

			<?php display_list("series", "5", "comment", "comment", $content_id, "") ?>			

			<?php display_list("series", "6", "content", "book", "", $author_id_list) ?>	
		</section>

		<div id = "shadow_info"></div>

		<a href = "<?php ECHO $arrow_left_page_href ?>" >
			<img id = "arrow_left_page"  class = "arrow_page" src = "/img/icons/category/page_left_grey.png" >
		</a>

		<a href = "<?php ECHO $arrow_right_page_href ?>" >		
			<img id = "arrow_right_page" class = "arrow_page" src = "/img/icons/category/page_right_grey.png" >
		</a>

	</div> 


<!-- POP UP -->

	<?php include("block/pop_up.php") ?>

	<!-- <div id="player"></div> -->


<!-- FOOTER -->

	<?php include("block/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var user_login = "<?php ECHO $user_login ?>";
    	var user_id = "<?php ECHO $user_id ?>";
    	var status = "<?php ECHO $status ?>";

    	var env = "<?php ECHO $env ?>";
    	var base_url = "<?php ECHO $base_url ?>";
    	var page_url = "<?php ECHO $page_url ?>";

    	var type_id = "<?php ECHO $type_id ?>";
    	var category = "<?php ECHO $category ?>";

    	var content_id = "<?php ECHO $content_id ?>";
    	var video_id = "<?php ECHO $video_id ?>";
    	var episod_id = "<?php ECHO $episod_id ?>";
    	var timecode = "<?php ECHO $timecode ?>";

		var current_season = "<?php ECHO $current_season ?>";
    	var producer_id = "<?php ECHO $producer_id ?>";

    	var content_index = "<?php ECHO $content_index ?>";
    	var content_list_size = "<?php ECHO $content_list_size ?>";

    	var hosting = "<?php ECHO $hosting ?>";

		var fact_check_url = "<?php ECHO $fact_check_url ?>";
		var crowdfunding_url = "<?php ECHO $crowdfunding_url ?>";

    	var is_favorite = "<?php ECHO $is_favorite ?>";
    	var watch_later = "<?php ECHO $watch_later ?>";

    	var has_comment = "<?php ECHO $has_comment ?>";
    	var comment_list = <?php echo json_encode($comment_list) ?>;

    	var page_number = [];

    	page_number["1"] = "<?php ECHO $page_number["1"] ?>";
    	page_number["2"] = "<?php ECHO $page_number["2"] ?>";
    	page_number["3"] = "<?php ECHO $page_number["3"] ?>";
    	page_number["4"] = "<?php ECHO $page_number["4"] ?>";
    	page_number["5"] = "<?php ECHO $page_number["5"] ?>";
    	page_number["6"] = "<?php ECHO $page_number["6"] ?>";

    	var note_1 = "<?php ECHO $content["note_1"] ?>";
    	var note_2 = "<?php ECHO $content["note_2"] ?>";
    	var note_3 = "<?php ECHO $content["note_3"] ?>";

  	</script>


<!-- JS FILES -->

	<script src = "/js/lib/misc.js"></script>
    
	<script src = "/js/block/header.js"></script>
	<script src = "/js/block/menu.js"></script>
	<script src = "/js/block/user.js"></script>
	<script src = "/js/block/footer.js"></script>

    <script src = "/js/block/button.js"></script>
    <script src = "/js/block/thumbnail.js"></script>
    <script src = "/js/block/information.js"></script>

    <script src = "/js/block/player.js"></script>

	<script src = "/js/sheet.js"></script>

</body>
</html>
