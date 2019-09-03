
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php	


    ////////////////////////////////// Display functions //////////////////////////////////


	function display_all_list($screen, $query_id) {

		global $query, $request_size, $display_message;

		if ($screen == "search" AND $query == "ko");

		else if ($screen == "friend") {
			if ($query == "ok") 
				display_list($screen, "1", "search", "user", $query_id);
			
			display_list($screen, "2", "pending_in", "user", "");
			display_list($screen, "3", "pending_out", "user", "");
			display_list($screen, "4", "friend", "user", "");
		}

		else {
			display_list($screen, "1", "video", "tvshow", $query_id);
			display_list($screen, "2", "audio", "podcast", $query_id);

			display_list($screen, "3", "content", "tvshow", $query_id);
			display_list($screen, "4", "content", "documentary", $query_id);
			display_list($screen, "5", "content", "podcast", $query_id);
			display_list($screen, "6", "content", "shortfilm", $query_id);
			display_list($screen, "7", "content", "humour", $query_id);
			display_list($screen, "8", "content", "music", $query_id);
		}

		if ($request_size != "0") {$display_message = "ko";}
	}


	function display_list($screen, $list_id, $thumbnail_type, $type_id, $query_id) {

		global $page_number, $request_size;
		global $user_id;

		if ($screen == "folder") {
			if ($thumbnail_type == "video") 		$content_list = search_video_list_of($query_id);
			if ($thumbnail_type == "audio") 		$content_list = search_audio_list_of($query_id);
			if ($thumbnail_type == "content") 		$content_list = search_content_list_of($type_id, $query_id);
		}

		if ($screen == "search") {
			if ($thumbnail_type == "video") 		$content_list = search_video_list_of($query_id);
			if ($thumbnail_type == "audio") 		$content_list = search_audio_list_of($query_id);
			if ($thumbnail_type == "content") 		$content_list = search_content_list_of($type_id, $query_id);
		}

		if ($screen == "favorite") {
			if ($thumbnail_type == "video") 		$content_list = favorite_video_list_of($user_id);
			if ($thumbnail_type == "audio") 		$content_list = favorite_audio_list_of($user_id);
			if ($thumbnail_type == "content") 		$content_list = favorite_content_list_of($type_id, $user_id);
		}

		if ($screen == "watch_later") {
			if ($thumbnail_type == "video") 		$content_list = watch_later_video_list_of($user_id);
			if ($thumbnail_type == "audio") 		$content_list = watch_later_audio_list_of($user_id);
			if ($thumbnail_type == "content") 		$content_list = watch_later_content_list_of($type_id, $user_id);
		}

		if ($screen == "friend") {
			if ($thumbnail_type == "search") 		$content_list = connect_search_list_of($query_id);
			if ($thumbnail_type == "pending_in") 	$content_list = connect_pending_list_of($user_id, "in");
			if ($thumbnail_type == "pending_out") 	$content_list = connect_pending_list_of($user_id, "out");
			if ($thumbnail_type == "friend") 		$content_list = connect_friend_list_of($user_id);
		}


		$item_number = sizeof($content_list);
		$title = title_of_type($thumbnail_type, $type_id, $item_number);

		$page_number[$list_id] = page_number_of($type_id, $content_list);

		$request_size = $request_size + sizeof($content_list);

		display_thumbnail_container($list_id, $thumbnail_type, $type_id, "", $title, $content_list);
	}


    ////////////////////////////////// Get url param //////////////////////////////////

	if (isset($_GET["list_id"]))	$list_id 	= $_GET["list_id"];		else $list_id = "";
	if (isset($_GET["query_id"]))	$query_id 	= $_GET["query_id"];	else $query_id = "";


    ////////////////////////////////// Get data //////////////////////////////////

	$screen = $list_id;

	if ($screen == "favorite" OR $screen == "watch_later" OR $screen == "friend") {
	    if (empty($_SESSION["login"])) {
			header('Location: login.php');
			exit();
		}
	}

	if ($screen != "folder") $screen_title = screen_title($screen, "", "");

	if ($screen == "folder") {
		$banner_image_url = "../img/folder/banner/" . $query_id . ".jpg";
		$small_banner_image_url = "../img/folder/small_banner/" . $query_id . ".jpg";
	}

	$page_number = array();
	$page_number = [0, 0, 0, 0, 0, 0, 0, 0, 0];

	$message = "";
	$request_size = "0";

	if (isset($_GET["query_id"])) {
		if (strlen($query_id) < 3) {
			$message = "La recherche doit contenir <br> 
						au moins 3 caractères";
			$display_message = "ok";
			$query = "ko";
		}
		else {
			$message = "Pas de résultat pour cette recherche. <br> <br> 
						Vérifiez l'<u>orthographe</u>, ou <br> 
						essayez avec des <u>mots seuls</u> <br> 
						plutôt que des expressions.";
			$display_message = "ok";
			$query = "ok";
		}
	}
	else {
		$query = "ko";
	}


    ////////////////////////////////// Tag //////////////////////////////////


	$screen_tag = read_tag("list", $screen, "", "", "");

	if (empty($screen_tag)) create_tag("list", $screen, "", "", "");
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "list", $screen, "", "", "", $view);
	}	

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "../css/panorama/imago.css"/>
   	<link rel = "stylesheet" href = "../css/portrait/imago.css"/>
   	
    <link rel = "stylesheet" href = "../css/panorama/list.css"/>
    <link rel = "stylesheet" href = "../css/portrait/list.css"/>

    <link rel = "icon" type = "image/png" href = "../img/icons/imago_con.png"/>

    <title> Imago TV - La plateforme vidéo gratuite de la transition </title>

    <meta property = "og:title" content = "Imago TV" />
	<meta property = "og:description" content = "La plateforme vidéo de la transition" />
	<meta property = "og:image" content = "../img/icons/imago.jpg" />

    <script src = "../js/lib/jquery.js"></script>

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

		<div id = "screen_title">
			<?php if ($screen != "folder") {ECHO '<a>' . $screen_title . '</a>';} ?>
		</div>

		<?php include("block/button.php") ?>

		<div id = "folder_image">
			<?php if ($screen == "folder") {
				ECHO '<img id = "banner" class = "big_image" src = '. $banner_image_url .'> </img>';
				ECHO '<img id = "banner" class = "small_image" src = '. $small_banner_image_url .'> </img>';
			} ?>
		</div>

		<section id = "query" >
    		<form id = "form" action = "list.php" method = "get">
    			<input type = "text" name = "list_id" value = "<?php ECHO $screen ?>" style = "display : none;">
				<input id = "query" type = "text" name = "query_id" value = "<?php ECHO $query_id ?>">
				<a id = "validate_button"> Validez </a>			
			</form> 
		</section>

		<section id = "list" class = <?php ECHO $screen ?> >
			<?php display_all_list($screen, $query_id) ?>
		</section>

		<a id = "message" > <?php if ($display_message == "ok") { ECHO $message; } ?> </a>

	</div> 


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

    	var screen = "<?php ECHO $screen; ?>";

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

	<script src = "../js/lib/misc.js"></script>
    
	<script src = "../js/block/header.js"></script>
	<script src = "../js/block/menu.js"></script>
	<script src = "../js/block/user.js"></script>
	<script src = "../js/block/footer.js"></script>

    <script src = "../js/block/button.js"></script>
    <script src = "../js/block/thumbnail.js"></script>

	<script src = "../js/list.js"></script>

</body>
</html>
