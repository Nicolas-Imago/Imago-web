
<?php 

	if (isset($_SESSION["login"]))
		$src = "../img/icons/user/user_icon_open_grey.png";
	else
		$src = "../img/icons/user/user_icon_open_grey_red.png";

?>

	<div id = "header">

		<img id = "menu_button" src = "../img/icons/menu/menu_icon_open_grey.png"></img>

		<span id = "header_left">
			<!-- <a id = "live_text" class = "header_text" > ACCUEIL </a> -->
			<a href = "category.php?type_id=tvshow" id = "tvshow_text" class="header_text" > EMISSIONS </a>
			<a href = "category.php?type_id=documentary" id = "documentary_text" class="header_text" > DOCU </a>
			<a href = "category.php?type_id=podcast" id = "podcast_text" class="header_text" > PODCASTS </a>
			<a href = "category.php?type_id=shortfilm" id = "shortfilm_text" class="header_text" > COURTS </a>
		</span>

		<a href = "homepage.php" > 
			<img href = "homepage.php" id = "imago_logo" src = "../img/icons/header/logo.png"></img>
		</a>

		<span id = "header_right">
			<a id = "category_text" class="header_text" > THEMATIQUES </a>
			<a href = "list.php?list_id=search" id = "search_text" class = "header_text" > RECHERCHE </a>
		</span>

		<img id = "user_button" src = "<?php ECHO $src ?> "></img>


	</div>

	<ol id = "sub_list">
		<li><a href = "category.php?category_id=1" class = "header_text" > Conscience </a></li>
		<li><a href = "category.php?category_id=2" class = "header_text" > Alternatives </a></li>
		<li><a href = "category.php?category_id=3" class = "header_text" > Médias </a></li>
		<li><a href = "category.php?category_id=4" class = "header_text" > Santé </a></li>
		<li><a href = "category.php?category_id=5" class = "header_text" > Écologie </a></li>
		<li><a href = "category.php?category_id=6" class = "header_text" > Économie </a></li>
		<li><a href = "category.php?category_id=7" class = "header_text" > Société </a></li>
		<li><a href = "category.php?category_id=8" class = "header_text" > Histoire </a></li>
	</ol>

	