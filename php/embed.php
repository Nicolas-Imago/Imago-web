
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php

    //////////////////////////////// Get url param ///////////////////////////////

	if (isset($_GET["type_id"])) 		$type_id 	= $_GET["type_id"];			else $type_id = "";
	if (isset($_GET["content_id"])) 	$content_id = $_GET["content_id"];		else $content_id = "";
	if (isset($_GET["section_id"])) 	$section_id = $_GET["section_id"];		else $section_id = "season";
	if (isset($_GET["episod_id"])) 		$episod_id 	= (int)$_GET["episod_id"]; 	else $episod_id = "";
	if (isset($_GET["timecode"])) 		$timecode 	= $_GET["timecode"]; 		else $timecode = "";


    //////////////////////////////// Protect data ////////////////////////////////

	if ($episod_id == 0) $episod_id = "";

	$content = get_content_info($content_id);
	if ($type_id == "") $type_id = $content["type"];
	$category = $content["category"];

	// if ($content == null) {
	// 	include("404.php");
	// 	return;
	// }

	// if ($timecode == "") {
	// 	$resume_time = read_resume_time($user_id, $content_id, $episod_id);
	// 	if (sizeof($resume_time) != 0) $timecode = $resume_time["0"]["resume_time"];
	// 	else $timecode = "0";
	// }

	// $type_id = $content["type"];

	$video_id_list = get_video_id_list($section_id, $content_id);

	// if ($episod_id == 0 OR ($episod_id != "" AND !isset($video_id_list[$section_id][$episod_id - 1]))) {
	// 	include("404.php");
	// 	return;
	// }

    ////////////////////////////////// Get data //////////////////////////////////


	// $episod = $video_id_list[$episod_id - 1];
	
	// $thumbnail = $episod["thumbnail"];
	// $hosting = $episod["hosting"];

	// $video_id = $episod[$hosting . '_id'];

    
    $thumbnail_image = "https://asset.imagotv.fr/img/" . $type_id . "/episod/" . $content_id . "/origin/" . $episod_id . ".jpg";


    ////////////////////////////////// Tag //////////////////////////////////

	$screen_tag = read_tag("embed", $type_id, category_id_of($category), $content_id, "");

	if (empty($screen_tag)) {
		create_tag("embed", $type_id, category_id_of($category), $content_id, "");
	}
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "embed", $type_id, category_id_of($category), $content_id, "", $view);
	}

?>


<!DOCTYPE html>
<html lang = "fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <link rel = "stylesheet" href = "/css/panorama/embed_v111.css"/>

    <script src = "/js/lib/jquery.js"></script>

	<!-- TRACKING -->

	<?php include("lib/tracking.php") ?>

</head>


<body>	

<!-- SERIES SCREEN -->	

	<div id = "screen">

		<iframe id = "video" frameborder = "0" allowfullscreen allow = "autoplay" > </iframe>

		<div id = "layer">
			<div id = "content_layer">
				<img id = "logo_imago" src = "/img/icons/logo/imago_embed.png" > </img> 
			</div>
		</div>

		<img id = "thumbnail_image" src = <?php ECHO $thumbnail_image ?> > </img>
		<img id = "logo_play" src = "/img/icons/play/icon_1.png"; > 

	</div> 


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var user_login = "<?php ECHO $user_login; ?>";
    	var user_id = "<?php ECHO $user_id; ?>";
    	var user_status = "<?php ECHO $status; ?>";

    	var env = "<?php ECHO $env; ?>";
    	var base_url = "<?php ECHO $base_url; ?>";
    	var page_url = "<?php ECHO $page_url; ?>";

    	var type_id = "<?php ECHO $type_id ?>";
    	var content_id = "<?php ECHO $content_id ?>";
      	var section_id = "<?php ECHO $section_id ?>";
    	var episod_id = "<?php ECHO $episod_id ?>";
    	var timecode = "<?php ECHO $timecode ?>";

  	</script> 


<!-- JS FILES -->

	<script src = "/js/lib/misc_v111.js"></script>
    <script src = "/js/block/thumbnail_v111.js"></script>

	<!-- <script src = "/js/block/player_v111.js"></script> -->
	<script src = "/js/embed_v111.js"></script>

</body>
</html>
