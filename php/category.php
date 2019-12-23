
<?php require_once("lib/init.php"); ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php


    ////////////////////////////////// Display functions //////////////////////////////////

	function display_all_list($screen, $type_id, $category_id) {

		if ($screen == "category") {
			display_list($screen, "1", "tvshow", $category_id);
			display_list($screen, "2", "documentary", $category_id);
			display_list($screen, "3", "podcast", $category_id);
			display_list($screen, "4", "shortfilm", $category_id);
			display_list($screen, "5", "humour", $category_id);
			display_list($screen, "6", "music", $category_id);
		}

		if ($screen == "type") 
			for ($index = 1; $index <= 8; $index++)
				display_list($screen, $index, $type_id, $index);
		

		if ($screen == "category_type")		
			display_list($screen, "1", $type_id, $category_id);
	}


	function display_list($screen, $list_id, $type_id, $category_id) {

		global $page_number, $total_item_number;

		$category = category_title_of($category_id);
		$content_list = category_content_list_of($type_id, $category);

		$item_number = sizeof($content_list);
		$total_item_number = $total_item_number + $item_number;
		$title = content_list_title_of($screen, $type_id, $category_id, $item_number);

		$page_number[$list_id] = page_number_of($type_id, $content_list);

		display_thumbnail_container($list_id, "content", $type_id, $category_id, $title, $content_list);
	}


    ///////////////////////////////// Get url param /////////////////////////////////

	if (isset($_GET["type_id"])) 		$type_id 		= $_GET["type_id"];			else $type_id = "";
	if (isset($_GET["category_id"]))	$category_id 	= $_GET["category_id"];		else $category_id = "";

	if ($type_id == "" AND $category_id != "") 	$screen = "category";
    if ($type_id != "" AND $category_id == "") 	$screen = "type";
	if ($type_id != "" AND $category_id != "") 	$screen = "category_type";


    ////////////////////////////////// Redirection //////////////////////////////////

    $request_url = $_SERVER["REQUEST_URI"];
    $request_url = explode("/", $request_url);

    if ($request_url[1] == "php") {

    	$type = type_of($type_id);
    	$category = category_of($category_id);

		header("Status: 301 Moved Permanently", false, 301);

		if ($screen == "category")			header('Location: /'. $category);
	    if ($screen == "type")				header('Location: /'. $type);
		if ($screen == "category_type")		header('Location: /'. $type . '/' . $category);

	    exit();
    }


    ////////////////////////////////// Get data //////////////////////////////////

	$type_list = ["", "tvshow", "documentary", "shortfilm", "podcast", "music", "humour", "book"];
	$category_list = ["", "1", "2", "3", "4", "5", "6", "7", "8"];

	if (!in_array($type_id, $type_list)) {
		include("404.php");
		return;
	}

	if (!in_array($category_id, $category_list)) {
		include("404.php");
		return;
	}
	
	$screen_title = screen_title($screen, $type_id, $category_id);

	$page_number = array();
	$page_number = [0, 0, 0, 0, 0, 0, 0, 0, 0];

	$total_item_number = 0;

	if ($category_id != "") {
		if ($category_id > 1) 	$previous_category_id = $category_id - 1; 	else $previous_category_id = 8;
		if ($category_id < 8) 	$next_category_id = $category_id + 1; 		else $next_category_id = 1;

		$type = type_of($type_id);

		$arrow_left_page_href = "/" . $type . "/" . category_of($previous_category_id);
		$arrow_right_page_href = "/" . $type . "/" . category_of($next_category_id);
	}


    ////////////////////////////////// OG //////////////////////////////////

	$og_name = $screen_title;
	
	
    ////////////////////////////////// Tag //////////////////////////////////


	$screen_tag = read_tag("category", $type_id, $category_id, "", "");

	if (empty($screen_tag)) create_tag("category", $type_id, $category_id, "", "");
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "category", $type_id, $category_id, "", "", $view);
	}

?>


<!DOCTYPE html>
<html lang = "fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <link rel = "stylesheet" href = "/css/panorama/imago_v111.css"/>
   	<link rel = "stylesheet" href = "/css/portrait/imago_v111.css"/>
   	
    <link rel = "stylesheet" href = "/css/panorama/category_v111.css"/>
    <link rel = "stylesheet" href = "/css/portrait/category_v111.css"/>

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


<!-- CATEGORY SCREEN -->	

	<div id = "screen">

		<div class = "screen_title">
			<h1 class = "screen_title" > <?php ECHO $screen_title; ?> </h1> 
		</div>

		<?php include("block/button.php") ?>

		<section id = "list">
			<?php display_all_list($screen, $type_id, $category_id) ?>
		</section>

		<a href = "<?php ECHO $arrow_left_page_href ?>" >
			<img id = "arrow_left_page"  class = "arrow_page" src = "/img/icons/arrow/page_left_grey.png" >
		</a>

		<a href = "<?php ECHO $arrow_right_page_href ?>" >		
			<img id = "arrow_right_page" class = "arrow_page" src = "/img/icons/arrow/page_right_grey.png" >
		</a>

	</div>


<!-- FOOTER -->

	<?php include("block/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var env = "<?php ECHO $env; ?>";
    	var page_url = "<?php ECHO $page_url; ?>";
    	var user_status = "<?php ECHO $status ?>";

    	var type_id = "<?php ECHO $type_id; ?>";
    	var category_id = "<?php ECHO $category_id; ?>";

    	var page_number = [];

    	page_number["1"] = "<?php ECHO $page_number["1"]; ?>";
    	page_number["2"] = "<?php ECHO $page_number["2"]; ?>";
    	page_number["3"] = "<?php ECHO $page_number["3"]; ?>";
    	page_number["4"] = "<?php ECHO $page_number["4"]; ?>";
    	page_number["5"] = "<?php ECHO $page_number["5"]; ?>";
    	page_number["6"] = "<?php ECHO $page_number["6"]; ?>";
    	page_number["7"] = "<?php ECHO $page_number["7"]; ?>";
    	page_number["8"] = "<?php ECHO $page_number["8"]; ?>";

    	var total_item_number = "<?php ECHO $total_item_number; ?>";

  	</script> 


<!-- JS FILES -->

	<script src = "/js/lib/misc_v111.js"></script>
    	
	<script src = "/js/block/header_v111.js"></script>
	<script src = "/js/block/menu_v111.js"></script>
	<script src = "/js/block/user_v111.js"></script>
	<script src = "/js/block/footer_v111.js"></script>

    <script src = "/js/block/button_v111.js"></script>
    <script src = "/js/block/thumbnail_v111.js"></script>

	<script src = "/js/category_v111.js"></script>

</body>
</html>
