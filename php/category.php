
<?php require_once("mutual/init.php") ?>

<?php require_once("mutual/lib_model.php") ?>
<?php require_once("mutual/lib_view.php") ?>


<?php

	// global function 

	function content_list_title_of($type_id, $category_id) {

		global $screen;

		if ($screen == "category_screen") {
		    $title = title_of_type($type_id);
		}
		else {
			$title = title_of_category($category_id);
		}		

        return $title;
	}

	function page_title($type_id, $category_id) {

		if ($type_id == "tvshow") {$page_title = "Toutes les émissions";}
		if ($type_id == "documentary") {$page_title = "Tous les documentaires";}
 		if ($type_id == "podcast") {$page_title = "Tous les podcasts";}
		if ($type_id == "shortfilm") {$page_title = "Tous les courts-métrages";}
		if ($type_id == "music") {$page_title = "Tous les albums";}

		if ($category_id == "1") {$page_title = "Eveil des consciences";}
		if ($category_id == "2") {$page_title = "Alternatives concrètes";}
 		if ($category_id == "3") {$page_title = "Media et communication";}
		if ($category_id == "4") {$page_title = "Santé et d'alimentation";}
		if ($category_id == "5") {$page_title = "Écologie";}
		if ($category_id == "6") {$page_title = "Économie";}
 		if ($category_id == "7") {$page_title = "Société";}
		if ($category_id == "8") {$page_title = "Connaissance";}		

		return $page_title;
	}


	// VIEW FUNCTION

	function display_all_list($type_id, $category_id) {

		global $list_size;

		if ($type_id == "") {
			$list_size["1"] = display_list("1", "tvshow", $category_id);
			$list_size["2"] = display_list("2", "documentary", $category_id);
			$list_size["3"] = display_list("3", "podcast", $category_id);
			$list_size["4"] = display_list("4", "shortfilm", $category_id);
			$list_size["5"] = display_list("5", "humour", $category_id);
			$list_size["6"] = display_list("6", "music", $category_id);
		}
		else {
			if ($category_id == "") {
				for ($index = 1; $index <= 8; $index++) {
					$list_size[$index] = display_list($index, $type_id, $index);
				}
			}
			else {		
				$list_size["1"] = display_list("1", $type_id, $category_id);
			}
		}
	}

	function display_list($list_id, $type_id, $category_id) {

		$title = content_list_title_of($type_id, $category_id);

		$category = category_of($category_id);
		$content_list = content_list_of($type_id, $category);

		$list_size = display_thumbnail_list($list_id, $type_id, $title, $content_list);

		return $list_size;
	}


	// MODEL FUNCTIONS

    function content_list_of($type_id, $category_id) {

        global $data_base, $env;

        // if ($env == "prod") {

	        if ($category_id != "") {
		        $content_list = $data_base->prepare("
		        	SELECT content_id, short_description, sub_type, video_number, duration, playback 
		        	FROM imago_info_content 
		        	WHERE type = ? 
		        	AND category = ?
		        	AND env = ? 
		        	AND playback != ''
		        	ORDER BY playback = 'available' DESC, RAND() ");

		        $content_list->execute(array($type_id, $category_id, "prod"));
		    }
	     //    else {
		    //     $content_list = $data_base->prepare("
		    //     	SELECT content_id, short_description, sub_type, video_number, duration, playback 
		    //     	FROM imago_info_content 
		    //     	WHERE type = ?
		    //     	AND env = ? 
		    //     	AND playback != ''
		    //     	ORDER BY RAND() ");

		    //     $content_list->execute(array($type_id, $env));
		    // }
		// }

		// else {

	 //        if ($category_id != "") {
		//         $content_list = $data_base->prepare("
		//         	SELECT content_id, short_description, sub_type, video_number, duration, playback 
		//         	FROM imago_info_content 
		//         	WHERE type = ? 
		//         	AND category = ?
		//         	AND playback != '' 
		//         	ORDER BY RAND() ");
		//         	// ORDER BY playback = 'available' DESC ");

		//         $content_list->execute(array($type_id, $category_id));
		//     }
	 //        else {
		//         $content_list = $data_base->prepare("
		//         	SELECT content_id, short_description, sub_type, video_number, duration, playback 
		//         	FROM imago_info_content 
		//         	WHERE type = ?
		//         	AND playback != ''
		//         	ORDER BY RAND() ");

		//         $content_list->execute(array($type_id));
		//     }			
		// }

        return $content_list->fetchAll();
    } 


	// Display screen

	if (isset($_GET["type_id"])) { $type_id = $_GET["type_id"]; } else { $type_id = ""; }
	if (isset($_GET["category_id"])) { $category_id = $_GET["category_id"]; } else { $category_id = ""; }

	if ($type_id == "" AND $category_id != "") { $screen = "category_screen"; }
	if ($type_id != "" AND $category_id == "") { $screen = "type_screen"; } // not used

	$list_size = array();
	$list_size = [0, 0, 0, 0, 0, 0, 0, 0, 0];

	$page_title = page_title($type_id, $category_id);

	// tag

	$screen_tag = read_tag("category", $type_id, $category_id, "", "");

	if (empty($screen_tag)) {
		create_tag("category", $type_id, $category_id, "", "");
	}
	else {
		$view = $screen_tag["view"] + 1;
		$tag_id = $screen_tag["id"];
		increment_tag($tag_id, "category", $type_id, $category_id, "", "", $view);
	}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">


    <link rel = "stylesheet" href = "../css/imago.css"/>
   	<link rel = "stylesheet" href = "../css/mobile/imago.css"/>
   	
    <link rel = "stylesheet" href = "../css/category.css"/>
    <link rel = "stylesheet" href = "../css/mobile/category.css"/>

    <link rel = "icon" type = "image/png" href = "../img/icons/imago_con.png"/>

    <title>ImagoTV</title>

    <meta property = "og:title" content = "ImagoTV" />
	<meta property = "og:description" content = "La plateforme vidéo des vidéastes engagés dans la transition" />
	<meta property = "og:image" content = "/img/icons/imago.jpg" />

	<script src = "../lib/jquery.js"></script>

	<!-- TRACKING -->

	<?php include("mutual/tracking.php") ?>

</head>

<body>
	
<!-- HEADER, MENU & USER -->

	<?php include("mutual/header.php") ?>	

	<?php include("mutual/menu.php") ?>
	<?php include("mutual/user.php") ?>


<!-- CATEGORY SCREEN -->	

	<div id = "screen">

		<div id = "screen_title">
			<a> <?php ECHO $page_title; ?></a> 
		</div>

		<section id = "list">
			<?php display_all_list($type_id, $category_id) ?>
		</section>

	</div>


<!-- FOOTER -->

	<?php include("mutual/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

    	var env = "<?php ECHO $env; ?>";
    	var base_url = "<?php ECHO $base_url; ?>";

    	var type_id = "<?php ECHO $type_id; ?>";
    	var category_id = "<?php ECHO $category_id; ?>";

    	var list_size = [];

    	list_size["1"] = "<?php ECHO $list_size["1"]; ?>";
    	list_size["2"] = "<?php ECHO $list_size["2"]; ?>";
    	list_size["3"] = "<?php ECHO $list_size["3"]; ?>";
    	list_size["4"] = "<?php ECHO $list_size["4"]; ?>";
    	list_size["5"] = "<?php ECHO $list_size["5"]; ?>";
    	list_size["6"] = "<?php ECHO $list_size["6"]; ?>";
    	list_size["7"] = "<?php ECHO $list_size["7"]; ?>";
    	list_size["8"] = "<?php ECHO $list_size["8"]; ?>";

  	</script> 


<!-- JS FILES -->

	<script src = "../js/mutual/lib.js"></script>
	
	<script src = "../js/mutual/header.js"></script>
	<script src = "../js/mutual/menu.js"></script>
	<script src = "../js/mutual/user.js"></script>
	<script src = "../js/mutual/footer.js"></script>

	<script src = "../js/category.js"></script>

</body>
</html>
