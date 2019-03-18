
<?php require_once("mutual/init.php") ?>

<?php require_once("mutual/lib_model.php") ?>
<?php require_once("mutual/lib_view.php") ?>

<?php 

    // Display functions 

    function hide() {

    	if (isset($_SESSION["login"])) {
            ECHO ' style = "visibility:hidden;" ';
        }
    }

    function display_validate() {

    	if (!isset($_SESSION["login"])) {
            ECHO ' style = "display:block;" ';
        }
    }

    function display_subscribe() {

        if (isset($_SESSION["login"])) {
            ECHO ' style = "visibility:hidden;" ';
        }
    }

    function display_enter() {

    	if (isset($_SESSION["login"]) AND isset($_POST["login"])) {
            ECHO ' style = "display:block;" ';
        }
    }
    
    function display_logout() {

    	if (isset($_SESSION["login"]) AND !isset($_POST["login"])) {
            ECHO ' style = "display:block;" ';
        }
    }

    function dislay_message() {

    	if (isset($_SESSION["login"])) {
			ECHO ' style = "visibility:visible; color:green" ';
		}
		else if (isset($_POST["login"])) { 
			ECHO ' style = "visibility:visible; color:red" ';
		}
    }


    // Check login and Display 

    $login = "";
    $password_default = "";

    $validate_message = "Valider";
    $enter_message = "Retournez sur ImagoTV";

    $message = "defaut_message";


    if (isset($_SESSION["login"]) AND isset($_POST["login"])) {
	    $message = "Bonjour " . $_SESSION["login"] . " !";
    }

    else if (isset($_SESSION["login"]) AND !isset($_POST["login"])) {
    	$message = "Vous avez été correctement déconnecté !";
    }

    else if (isset($_POST["login"]) AND isset($_POST["password"])) {

    	$login = $_POST["login"];
    	$password = $_POST["password"];

    	$member = read_member($login);
    	$test_password = password_verify($password, $member["password"]);

	    if ($test_password) {
	        $_SESSION["login"] = $login;
	    	$message = "Bonjour " . $_SESSION["login"] . " !";
	    } 
	    else {
	    	$message = "Login ou mot de passe erroné";
	    }
	}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "../css/imago.css"/>
    <link rel = "stylesheet" href = "../css/mobile/imago.css"/>

    <link rel = "stylesheet" href = "../css/login.css"/>
    <link rel = "stylesheet" href = "../css/mobile/login.css"/>

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

<!-- HEADER -->
    
    <?php include("mutual/header.php") ?>
    

<!-- MENU & USER -->    

    <?php include("mutual/menu.php") ?>
    <?php include("mutual/user.php") ?>


<!-- HOME SCREEN -->	

    <div id = "screen">

        <!-- <img id = "login_background_image" src = "../img/login/imago.jpg"></img> -->
		<a id = "login_title"> ImagoTV, la plateforme vidéo de la transition ! </a>

		<section id = "login_connection">

    		<form id = "form" action = "login.php" method = "post">

				<div class = "login_item" <?php hide() ?> >
					<a class = "login_item_title"> Pseudo : </a>
				   	<input type = "text" class = "login_item" name = "login" value = "<?php ECHO $login ?>">
				</div>

				<div class = "login_item" <?php hide() ?> >
				   	<a class = "login_item_title"> Mot de passe : </a>
				   	<input type = "password" class = "login_item" name = "password" value = "<?php ECHO $password_default ?>">
				</div>

				<a id = "message" <?php dislay_message() ?> > <?php ECHO $message ?> </a>

			</form> 

		<a id = "validate" class = "action" <?php display_validate() ?> > <?php ECHO $validate_message ?> </a>
		<a id = "enter" class = "action" <?php display_enter() ?> > <?php ECHO $enter_message ?> </a>
		<a id = "logout" class = "action" <?php display_logout() ?> > <?php ECHO $enter_message ?> </a>

        <a id = "subscribe" class = "action" <?php display_subscribe() ?> > (je ne suis pas encore inscrit) </a>

		</section>

		<!-- <img id = "login_background_image" src = "img/login/imago.jpg"></img> -->
		<!-- <a id = "imago_version"> ImagoTV - v1.0.2</a> -->

	</div>


<?php
	    if (isset($_SESSION["login"]) AND !isset($_POST["login"])) {

            // Remove session variables

            $_SESSION = array();
            session_destroy();

            // Remove cookies

            // setcookie('login', '');
            // setcookie('pass_hache', '');
    	}
?>


<!-- FOOTER -->

    <?php include("mutual/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

        var env = "<?php ECHO $env; ?>";
        var base_url = "<?php ECHO $base_url; ?>";

    </script> 


<!-- JS FILES -->

	<script src = "../js/mutual/lib.js"></script>

    <script src = "../js/mutual/header.js"></script>
    <script src = "../js/mutual/menu.js"></script>
    <script src = "../js/mutual/user.js"></script>
    <script src = "../js/mutual/footer.js"></script>

	<script src = "../js/login.js"></script>

</body>
</html>
