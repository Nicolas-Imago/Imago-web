
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php 

    ////////////////////////////////// Redirection //////////////////////////////////

    $request_url = $_SERVER["REQUEST_URI"];
    $request_url = explode("/", $request_url);

    if ($request_url[1] == "php") {

        header("Status: 301 Moved Permanently", false, 301);
        header('Location: /connexion');
        exit();
    }


    ////////////////////////////////// Get data //////////////////////////////////

    if (!empty($_SESSION["login"])) {
        header('Location: /profil');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "/css/panorama/imago_v111.css"/>
    <link rel = "stylesheet" href = "/css/portrait/imago_v111.css"/>

    <link rel = "stylesheet" href = "/css/panorama/login_v111.css"/>
    <link rel = "stylesheet" href = "/css/portrait/login_v111.css"/>

    <link rel = "icon" type = "image/png" href = "/img/icons/imago_con.png"/>

    <title> Imago TV - Connexion </title>

    <meta property = "og:title" content = "Imago TV" />
    <meta property = "og:description" content = "La plateforme vidéo gratuite de la transition" />
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


<!-- LOGIN SCREEN -->	

    <div id = "screen">

		<a id = "login_title"> Connectez-vous pour profiter des fonctions coopératives ! </a>

		<section id = "login_connection">

			<div class = "login_item" >
				<a class = "login_item_title"> Pseudo : </a>
			   	<input id = "login" type = "text" class = "login_item" > </input>
			</div>

			<div class = "login_item" >
		     	<a class = "login_item_title"> Mot de passe : </a>
			   	<input id = "password" type = "password" class = "login_item" > </input>
			</div>

			<a id = "message" > Login ou mot de passe erroné </a>

    		<a id = "validate" class = "action" > valider </a>
            <a href = "/inscription" id = "subscribe" class = "action" > (je ne suis pas encore inscrit) </a>
            <a id = "forget" class = "action" href = "mailto:contact@imagotv.fr" > Mot de passe oublié </a>

		</section>

	</div>


<!-- FOOTER -->

    <?php include("block/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

        var user_login = "<?php ECHO $user_login; ?>";
        var user_id = "<?php ECHO $user_id; ?>";
        var user_status = "<?php ECHO $status; ?>";

        var env = "<?php ECHO $env; ?>";
        var base_url = "<?php ECHO $base_url; ?>";

    </script> 


<!-- JS FILES -->

    <script src = "/js/lib/misc_v111.js"></script>
    
    <script src = "/js/block/header_v111.js"></script>
    <script src = "/js/block/menu_v111.js"></script>
    <script src = "/js/block/user_v111.js"></script>
    <script src = "/js/block/footer_v111.js"></script>

	<script src = "/js/login_v111.js"></script>

</body>
</html>
