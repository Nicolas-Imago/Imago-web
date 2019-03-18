
<?php require_once("mutual/init.php") ?>

<?php require_once("mutual/lib_model.php") ?>
<?php require_once("mutual/lib_view.php") ?>

<?php require_once("mutual/session.php") ?>

<?php

    // Display functions

    function display_season() {

    	global $content;
    	global $season_number;

    	for ($season_index = 1; $season_index <= $season_number ; $season_index++) {
    		ECHO ' <a ';
	    		ECHO ' id = "season_' . $season_index . '" ';
	    		ECHO ' class = "season" >';
		    		ECHO ' SAISON ' . $season_index;
    		ECHO ' </a>';
    	}
    }

    function display_video() {

    	global $content, $video_id_list;
    	global $format, $content_id, $season_number, $video_number_last_season;

    	for ($season_index = $season_number; $season_index >= 1; $season_index--) {

    		ECHO ' <div ';
	    		ECHO ' id = "video_thumbnail_season_' . $season_index . '" ';
	    		ECHO ' class = "video_thumbnail_season" ';
    		ECHO ' > ';

	        for ($video_index = 12; $video_index >= 1; $video_index--) {

	            if (($season_index != $season_number) OR ($video_index <= $video_number_last_season)) {

	            	$episod_id = 12 * ($season_index - 1) + $video_index;

                	$hosting = $video_id_list[$episod_id - 1]["hosting"];
                	$thumbnail = $video_id_list[$episod_id - 1]["thumbnail"];

                	$video_id  = $video_id_list[$episod_id - 1][$hosting . '_id'];

                	$publication_date = $video_id_list[$episod_id - 1]["publication_date"];
                	$duration = $video_id_list[$episod_id - 1]["duration"];

                	$title = "#" . $video_id_list[$episod_id - 1]["title"];
                	$date = month_of($publication_date) . " " . year_of($publication_date);
                	$duration = duration_of($duration);

                	if ($title != "##") {$line_1 = $title;} else {$line_1 = "";}
                	if ($duration != "0 min ") {$line_2 = $duration . '   -   ' . $date;} else {$line_2 = "";}

    				if ($thumbnail == "youtube") {
						$image_url = "https://img.youtube.com/vi/" . $video_id  . "/mqdefault.jpg";
					}
                	else {
                		$image_url = "../img/video/" . $content_id . "/" . $video_id  . ".jpg";
                	}

		    		ECHO ' <div ';
		                ECHO ' id = "thumbnail_' . $thumbnail . '_' . $episod_id . '" ';
		                ECHO ' class = "thumbnail ' . $format . '" ';
		    		ECHO ' > ';

	                	ECHO ' <img ';
		                	ECHO ' id = "thumbnail_image_' . $episod_id . '" ';
		                	ECHO ' class = "thumbnail" ';
		                	ECHO ' src = "' . $image_url . '" ';
	                	ECHO ' > ';

	                	ECHO ' <img ';
		                	ECHO ' class = "play_logo_' . $format . '" ';
		                	ECHO ' src = "../img/icons/play.png" ';
	                	ECHO ' > ';

		                ECHO ' <div ';
		                ECHO ' id = "info_' . $episod_id . '" ';
		                ECHO ' class = "info_' . $format . '" ' . $format . '" '; 
		                ECHO ' > ';

		                    ECHO ' <div>';
		                    ECHO ' <a class = "line_1">' . $line_1 . '</a>';
		                    ECHO ' </div>';

		                    ECHO ' <div>';
		                    ECHO ' <a class = "line_2">' . $line_2 . ' </a>';
		                    ECHO ' </div>';

		                ECHO ' </div>';

	                ECHO '</div>';
                }
            }

            ECHO '</div>';
        }
    }


    // Display screen

	if (isset($_GET["type_id"])) {$type_id = $_GET["type_id"];} else {$type_id = "tvshow";}
	if (isset($_GET["content_id"])) {$content_id = $_GET["content_id"];} else {$content_id = "";}

	if (isset($_GET["season_id"])) {$season_id = $_GET["season_id"];} else {$season_id = "";}
	if (isset($_GET["episod_id"])) {$episod_id = $_GET["episod_id"];} else {$episod_id = "";}
	if (isset($_GET["video_id"])) {$video_id = $_GET["video_id"];} else {$video_id = "";}

	if ($type_id == "podcast") {$format = "squared";}
	if ($type_id != "podcast") {$format = "panorama";}

	$content = get_content_info($content_id);

	if ($content == null) {
		include("404.php");
		return;
	}

	$category = $content["category"];
	$info_title = "Format :";
	$info_data = $content["sub_type"];

	$author_id_list = get_author_id_list($content_id);
	$video_id_list = get_episod_id_list($content_id);

	$video_number = sizeof($video_id_list);
    $season_number = intval(($video_number - 1) / 12) + 1;
    $video_number_last_season = $video_number - 12 * ($season_number - 1);

    if ($season_id != "") {
    	$current_season = $season_id;
   	}

	if ($episod_id != "") {
		$current_season = intval(($episod_id - 1) / 12) + 1;
		$hosting = $video_id_list[$episod_id - 1]["hosting"];
        $thumbnail = $video_id_list[$episod_id - 1]["thumbnail"];
        $video_id = get_video_id($content_id, $episod_id)[0][$hosting . '_id'];
    }
    else {
    	$current_season = $season_number;
    	$hosting = "";
    	$thumbnail = "";
    }

    if ($status == "login" AND !empty(read_favorite_content($user_id, $content_id))) {
    	$is_favorite = "1";
    }
    else {
    	// add_favorite_content($user_id, $content_id);
    	$is_favorite = "0";
    }

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

    <link rel = "stylesheet" href = "../css/series.css"/>
    <link rel = "stylesheet" href = "../css/mobile/series.css"/>

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
		<div class = "background_shadow"></div>

		<?php include("mutual/button.php") ?>
		<?php include("mutual/information.php") ?>

		<section id = "filter_list"> 

			<div id = "season_list">
				<?php display_season() ?>
	    		<img id = "season_selector" src = "../img/icons/tvshow/season_selector_grey.png"></img>
	    	</div>

<!-- 	    	<img id = "list_icon" class = "display_icon" src = "../img/icons/series/list_icon_grey.png"></img>
	    		<img id = "sheet_icon" class = "display_icon" src = "../img/icons/series/sheet_icon_grey.png"></img>
				<img id = "mosaic_icon" class = "display_icon" src = "../img/icons/series/mosaic_icon_grey.png"></img>
	    		<img id = "icons_selector" src = "../img/icons/series/selector_icon.png"></img> -->

		</section>

		<section id = "video_thumbnail">
			<?php display_video() ?>			
		</section> 

		<div id = "shadow_info"></div>

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
    	var current_season = "<?php ECHO $current_season; ?>";
    	
    	var category = "<?php ECHO $category; ?>";
    	var hosting = "<?php ECHO $hosting; ?>";

    	var is_favorite = "<?php ECHO $is_favorite; ?>";
    	var user_id = "<?php ECHO $user_id; ?>";

    	var note_1 = "<?php ECHO $content["note_1"]; ?>";
    	var note_2 = "<?php ECHO $content["note_2"]; ?>";
    	var note_3 = "<?php ECHO $content["note_3"]; ?>";

  	</script> 


<!-- JS FILES -->

	<script src = "../js/mutual/lib.js"></script>

	<!-- <script src = "<?php ECHO $root_url; ?>/js/mutual/lib.js"></script> -->

	<script src = "../js/mutual/header.js"></script>
	<script src = "../js/mutual/menu.js"></script>
	<script src = "../js/mutual/user.js"></script>
	<script src = "../js/mutual/footer.js"></script>

	<script src = "../js/series.js"></script>

</body>
</html>