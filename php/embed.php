
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php

    //////////////////////////////// Get url param ///////////////////////////////

	if (isset($_GET["content_id"])) 	$content_id = $_GET["content_id"];		else $content_id = "";
	if (isset($_GET["episod_id"])) 		$episod_id 	= (int)$_GET["episod_id"]; 	else $episod_id = "";


    //////////////////////////////// Protect data ////////////////////////////////

	$content = get_content_info($content_id);

	if ($content == null) {
		include("404.php");
		return;
	}

	$type_id = $content["type"];

	$video_id_list = get_episod_id_list($content_id);
    $video_number = sizeof($video_id_list);

	if ($episod_id == 0 OR ($episod_id != "" AND !isset($video_id_list[$episod_id - 1]))) {
		include("404.php");
		return;
	}

    ////////////////////////////////// Get data //////////////////////////////////

	$category = $content["category"];

	$episod = $video_id_list[$episod_id - 1];

	$thumbnail = $episod["thumbnail"];
	$hosting = $episod["hosting"];

	$video_id = $episod[$hosting . '_id'];

    if ($thumbnail == "local")
        $thumbnail_image = "/img/video/" . $content_id . "/hd/" . $episod_id . ".jpg";
    else
        $thumbnail_image = "https://img.youtube.com/vi/" . $video_id . "/maxresdefault.jpg";


    ////////////////////////////////// Tag //////////////////////////////////


	$screen_tag = read_tag("embed", $type_id, category_id_of($category), $content_id, $video_id);

	if (empty($screen_tag)) {
		create_tag("embed", $type_id, category_id_of($category), $content_id, $video_id);
	}
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "embed", $type_id, category_id_of($category), $content_id, $video_id, $view);
	}

?>


<!DOCTYPE html>
<html lang = "fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <link rel = "stylesheet" href = "../css/panorama/embed.css"/>

    <script src = "../js/lib/jquery.js"></script>

	<!-- TRACKING -->

	<?php include("lib/tracking.php") ?>

</head>


<body>	

<!-- SERIES SCREEN -->	

	<div id = "screen">

		<iframe id = "video" frameborder = "0" allowfullscreen allow = "autoplay" > </iframe>

		<div id = "layer">
			<div id = "content_layer">
				<img id = "logo_imago" src = "../img/icons/header/logo_white.png" > </img> 
			</div>
		</div>

		<img id = "thumbnail_image" src = <?php ECHO $thumbnail_image ?> > </img>
		<img id = "logo_play" src = "../img/icons/play.png"; > 

	</div> 


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var user_login = "<?php ECHO $user_login; ?>";
    	var user_id = "<?php ECHO $user_id; ?>";
    	var status = "<?php ECHO $status; ?>";

    	var env = "<?php ECHO $env; ?>";
    	var base_url = "<?php ECHO $base_url; ?>";
    	var page_url = "<?php ECHO $page_url; ?>";

    	var type_id = "<?php ECHO $type_id; ?>";
    	var category = "<?php ECHO $category; ?>";

    	var content_id = "<?php ECHO $content_id; ?>";
    	var video_id = "<?php ECHO $video_id; ?>";
    	var episod_id = "<?php ECHO $episod_id; ?>";

    	var hosting = "<?php ECHO $hosting; ?>";

  	</script> 


<!-- JS FILES -->

	<script src = "../js/lib/misc.js"></script>
    <script src = "../js/lib/thumbnail.js"></script>

	<script src = "../js/embed.js"></script>

</body>
</html>
