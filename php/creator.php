
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php

    // Display functions

    function display_title($type_id) {

    	global $creator;

	    if ($creator[$type_id][0] == "") {
	    	ECHO ' style = "display:none;" ';
	    }
	    else if ($creator[$type_id][0] != "") {
	    	ECHO ' class = "title" ';
	    }
    }

    function display_video($type_id) {

    	global $creator;

    	if ($creator[$type_id][0] != "") {
	    	for ($index = 0; $index <= sizeof($creator[$type_id]) - 1; $index++) {

	    		$content_id = $creator[$type_id][$index];

	   			if ($type_id == "creator") {
	   				ECHO ' <img ';
		   				ECHO ' class = "thumbnail rounded" ';
		   				ECHO ' src = "../img/author/thumbnail/' . $content_id . '.png" ';
		    			ECHO ' onclick = location.href="' . $type_id . '.php?type_id=author&creator_id=' . $content_id . '" ';
	   				ECHO ' > ';
	   			}
	   			if ($type_id == "tvshow" OR $type_id == "podcast" OR $type_id == "shortfilm" OR $type_id == "humour") {
	   				ECHO ' <img ';
		   				ECHO ' class = "thumbnail panorama" ';
		   				ECHO ' src = "../img/' . $type_id . '/cover/' . $content_id . '.jpg" ';
		    			ECHO ' onclick = location.href="' . $type_id . '.php?content_id=' . $content_id . '" ';
	   				ECHO ' > ';
	   			}
	   			if ($type_id == "documentary") {
	   				ECHO ' <img ';
		   				ECHO ' class = "thumbnail portrait" ';
		   				ECHO ' src = "../img/' . $type_id . '/cover/' . $content_id . '.jpg" ';
		    			ECHO ' onclick = location.href="' . $type_id . '.php?content_id=' . $content_id . '" ';
	   				ECHO ' > ';
	   			}
	   			if ($type_id == "music") {
	   				ECHO ' <img ';
		   				ECHO ' class = "squared_thumbnail thumbnail" ';
		   				ECHO ' src = "../img/' . $type_id . '/cover/' . $content_id . '.jpg" ';
		    			ECHO ' onclick = location.href="' . $type_id . '.php?content_id=' . $content_id . '" ';
	   				ECHO ' > ';
	   			}
	    	}
	    }
    }


    function get_creator_info_json($creator_id) {

    	global $type_id;

	    $creator_json_url = "../json/" . $type_id . "_list.json";
	    $creator_json = file_get_contents($creator_json_url);
	    $creator = json_decode($creator_json, true);
	    $creator = $creator[$creator_id];

        return $creator;
    }


    // Display screen

    if (isset($_GET["type_id"])) {$type_id = $_GET["type_id"];} else {$type_id = "";}
	if (isset($_GET["creator_id"])) {$creator_id = $_GET["creator_id"];} else {$creator_id = "";}

    $creator = get_creator_info_json($creator_id);


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "../css/panorama/imago.css"/>
   	<link rel = "stylesheet" href = "../css/portrait/imago.css"/>

    <link rel = "stylesheet" href = "../css/panorama/creator.css"/>
    <link rel = "stylesheet" href = "../css/portrait/creator.css"/>

    <link rel = "icon" type = "image/png" href = "../img/icons/imago_con.png"/>

    <title> Imago TV - La plateforme vidéo de la transition </title>

    <meta property = "og:title" content = "ImagoTV" />
	<meta property = "og:description" content = "La plateforme vidéo de la transition" />
	<meta property = "og:image" content = "/img/icons/imago.jpg" />

    <script src = "../js/lib/jquery.js"></script>

	<!-- TRACKING -->

	<?php include("lib/tracking.php") ?>

</head>


<body>	

<!-- HEADER, MENU & USER -->

	<?php include("block/header.php") ?>	

	<?php include("block/menu.php") ?>
	<?php include("block/user.php") ?>


<!-- CREATOR SCREEN -->	

	<div id = "screen">

		<img id = "background" <?php ECHO 'src = "../img/' . $type_id . '/background/' . $creator_id . '.jpg"' ?> ></img>

		<section id = "information">

			<div id = "information_header">
				<span id = "title">
					<a class = "name"> <?php ECHO $creator["name"] ?> </a>
					<a class = "position"> <?php ECHO $creator["position"] ?> </a>
				</span>
			</div>

			<div id = "description"> <?php ECHO $creator["description"] ?> </div>

		</section>

		<section>

			<a id = "creator_thumbnail_title" <?php display_title("creator") ?> > Créateurs liés</a>
			<div id = "creator_thumbnail" class = "thumbnail">
				<?php display_video("creator") ?>
			</div>

			<a id = "tvshow_thumbnail_title" <?php display_title("tvshow") ?> > Emissions </a>
			<div id = "tvshow_thumbnail" class = "thumbnail">
				<?php display_video("tvshow") ?>
			</div>

			<a id = "documentary_thumbnail_title"  <?php display_title("documentary") ?> > Documentaires </a>
			<div id = "documentary_thumbnail" class = "thumbnail">
				<?php display_video("documentary") ?>
			</div>

			<a id = "podcast_thumbnail_title"  <?php display_title("podcast") ?> > Podcasts radio </a>
			<div id = "podcast_thumbnail" class = "thumbnail">
				<?php display_video("podcast") ?>
			</div>

			<a id = "shortfilm_thumbnail_title"  <?php display_title("shortfilm") ?> > Courts-métrages </a>
			<div id = "shortfilm_thumbnail" class = "thumbnail">
				<?php display_video("shortfilm") ?>
			</div>

			<a id = "humour_thumbnail_title"  <?php display_title("humour") ?> > Humour </a>
			<div id = "humour_thumbnail" class = "thumbnail">
				<?php display_video("humour") ?>
			</div>

			<a id = "music_thumbnail_title"  <?php display_title("music") ?> > Musique </a>
			<div id = "music_thumbnail" class = "thumbnail">
				<?php display_video("music") ?>
			</div>

		</section>

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

    	var type_id = "<?php ECHO $type_id; ?>";
    	var creator_id = "<?php ECHO $creator_id; ?>";

  	</script> 


<!-- JS FILES -->

	<script src = "../js/lib/misc.js"></script>
    <script src = "../js/lib/thumbnail.js"></script>
    
	<script src = "../js/block/header.js"></script>
	<script src = "../js/block/menu.js"></script>
	<script src = "../js/block/user.js"></script>
	<script src = "../js/block/footer.js"></script>

	<script src = "../js/creator.js"></script>

</body>
</html>
