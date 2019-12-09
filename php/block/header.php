
<?php 

	if (isset($_SESSION["login"]))
		$src = "/img/icons/user/user_icon_open_grey.png";
	else
		$src = "/img/icons/user/user_icon_open_grey_red.png";

?>

	<div id = "header">

		<img id = "menu_button" src = "/img/icons/menu/menu_icon_open_grey.png"></img>

		<span id = "header_left">
			<a href = "/emissions" 			id = "tvshow_text" 		class = "header_text" > EMISSIONS </a>
			<a href = "/documentaires" 		id = "documentary_text" class = "header_text" > DOCU </a>
			<a href = "/podcasts" 			id = "podcast_text" 	class = "header_text" > PODCASTS </a>
			<a href = "/courts-metrages"	id = "shortfilm_text" 	class = "header_text" > COURTS </a>
		</span>

		<a href = "/" > 
			<img id = "imago_logo" src = "/img/icons/logo/imago_header.png" > </img>
		</a>

		<span id = "header_right">
			<a id = "category_text" class = "header_text" > THEMATIQUES </a>
			<a href = "/recherche" id = "search_text" class = "header_text" > RECHERCHE </a>
		</span>

		<img id = "user_button" src = "<?php ECHO $src ?> " > </img>

	</div>

	<ol id = "sub_list">
		<li><a href = "/conscience" 	class = "header_text" > Conscience </a></li>
		<li><a href = "/alternatives" 	class = "header_text" > Alternatives </a></li>
		<li><a href = "/medias" 		class = "header_text" > Médias </a></li>
		<li><a href = "/sante" 			class = "header_text" > Santé </a></li>
		<li><a href = "/ecologie" 		class = "header_text" > Écologie </a></li>
		<li><a href = "/economie" 		class = "header_text" > Économie </a></li>
		<li><a href = "/societe" 		class = "header_text" > Société </a></li>
		<li><a href = "/histoire" 		class = "header_text" > Histoire </a></li>
	</ol>
	