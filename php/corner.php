
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php	


    ////////////////////////////////// Display functions //////////////////////////////////


	function display_all_list($screen, $corner_id) {

		$content_list = corner_content_list_of($corner_id);
		$content_number = sizeof($content_list);

		for ($index = 0; $index < $content_number; $index++) {

			$content_id = corner_content_list_of($corner_id)[$index]["content_id"];
			$title = corner_content_list_of($corner_id)[$index]["name"];

			display_list($screen, $index + 1, $title, "video", "tvshow", $content_id);
		}
	}

	function display_list($screen, $list_id, $title, $thumbnail_type, $type_id, $content_id) {

		global $page_number, $request_size;

		$content_list = corner_video_list_of($content_id);
		$item_number = sizeof($content_list);
		$title = $title  . " (" . $item_number . ")";

		$page_number[$list_id] = page_number_of($type_id, $content_list);

		display_thumbnail_container($list_id, $thumbnail_type, $type_id, "", $title, $content_list);
	}


    ////////////////////////////////// Get url param //////////////////////////////////

	if (isset($_GET["list_id"])) 		$list_id 	= $_GET["list_id"];		else $list_id = "";
	if (isset($_GET["corner_id"])) 		$corner_id 	= $_GET["corner_id"];	else $corner_id = "";

	if (isset($_GET["content_id"])) 	$content_id = $_GET["content_id"];	else $content_id = "";
	if (isset($_GET["episod_id"])) 		$episod_id 	= $_GET["episod_id"];	else $episod_id = "";


    ////////////////////////////////// Get data //////////////////////////////////

	$screen = $list_id;

	// $screen_title = screen_title($screen, "", "");

	$page_number = array();
	$page_number = [0, 0, 0, 0, 0, 0, 0, 0, 0];

	$message = "";
	$request_size = "0";

	$banner_image_url = "/img/corner/" . $corner_id . ".jpg";

	if ($episod_id != "" and $content_id != "") {	

		$video_id_list = get_episod_id_list($content_id);

		if (isset($video_id_list[$episod_id - 1])) {
			$episod = $video_id_list[$episod_id - 1];

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
    	$hosting = "";
    	$video_id = "";
    }


    ////////////////////////////////// Tag //////////////////////////////////


	$screen_tag = read_tag("corner", $screen, "", "", "");

	if (empty($screen_tag)) create_tag("corner", $screen, "", "", "");
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "corner", $screen, "", "", "", $view);
	}	

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "/css/panorama/imago_v110.css"/>
   	<link rel = "stylesheet" href = "/css/portrait/imago_v110.css"/>
   	
    <link rel = "stylesheet" href = "/css/panorama/corner_v110.css"/>
    <link rel = "stylesheet" href = "/css/portrait/corner_v110.css"/>

    <link rel = "icon" type = "image/png" href = "/img/icons/imago_con.png"/>

    <title> Imago TV - La plateforme vidéo gratuite de la transition </title>

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

	<div id = "black_layer"> </div>


<!-- LIST SCREEN -->	

	<div id = "screen">

		<img id = "banner_image" src = <?php ECHO $banner_image_url ?> > </img>

		<?php include("block/button.php") ?>

		<section id = "list">
			<?php display_all_list($screen, $corner_id) ?>
		</section>

	</div> 


<!-- POP UP -->

	<?php include("block/pop_up.php") ?>


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

    	var corner_id = "<?php ECHO $corner_id; ?>";
    	var video_id = "<?php ECHO $video_id; ?>";
    	var hosting = "<?php ECHO $hosting; ?>";

    	var page_number = [];

    	page_number["1"] = "<?php ECHO $page_number["1"]; ?>";
    	page_number["2"] = "<?php ECHO $page_number["2"]; ?>";
    	page_number["3"] = "<?php ECHO $page_number["3"]; ?>";
    	page_number["4"] = "<?php ECHO $page_number["4"]; ?>";
    	page_number["5"] = "<?php ECHO $page_number["5"]; ?>";
    	page_number["6"] = "<?php ECHO $page_number["6"]; ?>";
    	page_number["7"] = "<?php ECHO $page_number["7"]; ?>";
    	page_number["8"] = "<?php ECHO $page_number["8"]; ?>";

    </script> 


<!-- JS FILES -->

	<script src = "/js/lib/misc_v110.js"></script>

	<script src = "/js/block/header_v110.js"></script>
	<script src = "/js/block/menu_v110.js"></script>
	<script src = "/js/block/user_v110.js"></script>
	<script src = "/js/block/footer_v110.js"></script>

    <script src = "/js/block/button_v110.js"></script>
    <script src = "/js/block/thumbnail_v110.js"></script>

    <script src = "/js/block/player_v110.js"></script>

	<script src = "/js/corner_v110.js"></script>

</body>
</html>