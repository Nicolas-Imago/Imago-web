
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

			display_list($screen, "4", "friend", "user", "");		
			display_list($screen, "2", "pending_in", "user", "");
			display_list($screen, "3", "pending_out", "user", "");
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
		global $user_id, $status;

		if ($query_id != "") 					$user = $query_id;
		else 									$user = $user_id;

		if ($user == $user_id) 					$level = 4;
		// else if (are_friends($user, $user_id))	$level = 3;
		else if ($status == "user") 			$level = 2;
		else 									$level = 1;


		if ($screen == "folder") {
			if ($thumbnail_type == "video") 	$content_list = search_video_list_of($query_id);
			if ($thumbnail_type == "audio") 	$content_list = search_audio_list_of($query_id);
			if ($thumbnail_type == "content") 	$content_list = search_content_list_of($type_id, $query_id);
		}

		if ($screen == "search") {
			if ($thumbnail_type == "video") 	$content_list = search_video_list_of($query_id);
			if ($thumbnail_type == "audio") 	$content_list = search_audio_list_of($query_id);
			if ($thumbnail_type == "content") 	$content_list = search_content_list_of($type_id, $query_id);
		}

		if ($screen == "favorite") {
			if ($thumbnail_type == "video") 	$content_list = favorite_video_list_of($user, $level);
			if ($thumbnail_type == "audio") 	$content_list = favorite_audio_list_of($user, $level);
			if ($thumbnail_type == "content") 	$content_list = favorite_content_list_of($type_id, $user, $level);
		}

		if ($screen == "later") {
			if ($thumbnail_type == "video") 	$content_list = later_video_list_of($user, $level);
			if ($thumbnail_type == "audio") 	$content_list = later_audio_list_of($user, $level);
			if ($thumbnail_type == "content") 	$content_list = later_content_list_of($type_id, $user, $level);
		}

		if ($screen == "reco") {
			if ($thumbnail_type == "video") 	$content_list = reco_video_list_of($user, $level);
			if ($thumbnail_type == "audio") 	$content_list = reco_audio_list_of($user, $level);
			if ($thumbnail_type == "content") 	$content_list = reco_content_list_of($type_id, $user, $level);
		}

		if ($screen == "friend") {
			if ($thumbnail_type == "search") 		$content_list = connect_search_list_of($query_id);
			if ($thumbnail_type == "pending_in") 	$content_list = connect_pending_list_of($user_id, "in");
			if ($thumbnail_type == "pending_out") 	$content_list = connect_pending_list_of($user_id, "out");
			if ($thumbnail_type == "friend") 		$content_list = connect_friend_list_of($user);
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


    ////////////////////////////////// Redirection //////////////////////////////////

    $request_url = $_SERVER["REQUEST_URI"];
    $request_url = explode("/", $request_url);

    if ($request_url[1] == "php") {

    	$list = list_of($list_id);

		header("Status: 301 Moved Permanently", false, 301);
	    header('Location: /'. $list . '/' . urlencode($query_id));
	    exit();
    }

    //////////////////////////////// Protect data ////////////////////////////////

	$list_list = ["search", "favorite", "later", "reco", "friend", "folder"];

	if (!in_array($list_id, $list_list)) {
		include("404.php");
		return;
	}


    ////////////////////////////////// Get data //////////////////////////////////

	$screen = $list_id;

	if ($screen == "favorite" OR $screen == "later" OR $screen == "reco" OR $screen == "friend") {
	    if (empty($_SESSION["login"])) {
			header('Location: /connexion');
			exit();
		}
	}

	if ($screen == "reco") $friend_user_id = $query_id;

	if ($screen != "folder") $screen_title = screen_title($screen, "", "");

	if ($screen == "folder") {
		$banner_image_url = "/img/folder/banner/" . $query_id . ".jpg";
		$small_banner_image_url = "/img/folder/small_banner/" . $query_id . ".jpg";
	}

	$page_number = array();
	$page_number = [0, 0, 0, 0, 0, 0, 0, 0, 0];

	$message = "";
	$request_size = "0";

	if (($screen == "search" OR $screen == "friend") AND isset($_GET["query_id"])) {
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


    ////////////////////////////////// OG //////////////////////////////////

	$og_name = screen_title($screen, "", "");
	

    ////////////////////////////////// Tag //////////////////////////////////

	if ($screen == "folder") 
		$folder_id = $_GET["query_id"];
	else
		$folder_id = "";

	$screen_tag = read_tag("list", $screen, "", $folder_id, "");

	if (empty($screen_tag)) create_tag("list", $screen, "", $folder_id, "");
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "list", $screen, "", $folder_id, "", $view);
	}	

?>


<!DOCTYPE html>
<html lang = "fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "/css/panorama/imago_v110.css"/>
   	<link rel = "stylesheet" href = "/css/portrait/imago_v110.css"/>
   	
    <link rel = "stylesheet" href = "/css/panorama/list_v110.css"/>
    <link rel = "stylesheet" href = "/css/portrait/list_v110.css"/>

    <link rel = "icon" type = "image/png" href = "/img/icons/imago_con.png"/>

    <?php include("lib/wpa.php") ?>

    <title> Imago TV - <?php ECHO $og_name ?> </title>

    <meta property = "og:title" content = "Imago" />
    <meta property = "og:type" content = "website" />
	<meta property = "og:description" content = "La plateforme vidéo de la transition" />
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


<!-- LIST SCREEN -->	

	<div id = "screen">

		<div class = "screen_title">
			<?php if ($screen != "folder") {ECHO '<h1 class = "screen_title" >' . $screen_title . '</h1>';} ?>
		</div>

		<!-- <a id = "warning"> Cette fonctionnalité ouvre très bientôt !! </a> -->

		<?php include("block/button.php") ?>

		<div id = "folder_image">
			<?php if ($screen == "folder") {
				ECHO '<img id = "banner" class = "big_image" src = '. $banner_image_url .'> </img>';
				ECHO '<img id = "banner" class = "small_image" src = '. $small_banner_image_url .'> </img>';
			} ?>
		</div>

		<section id = "query" >
    		<form id = "form" action = "/php/list.php" method = "get">
    			<input type = "text" name = "list_id" value = "<?php ECHO $screen ?>" style = "display : none;">
				<input id = "query" type = "text" name = "query_id" value = "<?php ECHO $query_id ?>">
				<a id = "validate_button"> Recherchez </a>			
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

    	var env = "<?php ECHO $env; ?>";
    	var page_url = "<?php ECHO $page_url; ?>";
    	var status = "<?php ECHO $status ?>";

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

	<script src = "/js/lib/misc_v110.js"></script>
    
	<script src = "/js/block/header_v110.js"></script>
	<script src = "/js/block/menu_v110.js"></script>
	<script src = "/js/block/user_v110.js"></script>
	<script src = "/js/block/footer_v110.js"></script>

    <script src = "/js/block/button_v110.js"></script>
    <script src = "/js/block/thumbnail_v110.js"></script>

	<script src = "/js/list_v110.js"></script>

</body>
</html>
