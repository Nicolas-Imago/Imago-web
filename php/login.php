
<?php require_once("lib/init.php") ?>

<?php require_once("lib/model.php") ?>
<?php require_once("lib/view.php") ?>
<?php require_once("lib/misc.php") ?>

<?php require_once("lib/session.php") ?>

<?php 

    // Display functions 

    // function hide() {

    // 	if (isset($_SESSION["login"])) {
    //         ECHO ' style = "visibility:hidden;" ';
    //     }
    // }

    // function display_validate() {

    // 	if (!isset($_SESSION["login"])) {
    //         ECHO ' style = "display:block;" ';
    //     }
    // }

    // function display_subscribe() {

    //     if (isset($_SESSION["login"])) {
    //         ECHO ' style = "visibility:hidden;" ';
    //     }
    // }

    // function display_enter() {

    // 	if (isset($_SESSION["login"]) AND isset($_POST["login"])) {
    //         ECHO ' style = "display:block;" ';
    //     }
    // }
    
    // function display_logout() {

    // 	if (isset($_SESSION["login"]) AND !isset($_POST["login"])) {
    //         ECHO ' style = "display:block;" ';
    //     }
    // }

  //   function dislay_message() {

  //   	if (isset($_SESSION["login"])) {
		// 	ECHO ' style = "visibility:visible; color:green" ';
		// }
		// else if (isset($_POST["login"])) { 
		// 	ECHO ' style = "visibility:visible; color:red" ';
		// }
  //   }

    // Check login and Display

    // $login_status = "";

    if (!empty($_SESSION["login"])) {
        header('Location: member.php');
        exit();
    }

    // $login = "";
    // $password_default = "";

    // $validate_message = "Valider";
    // $enter_message = "Retournez sur ImagoTV";

    // $message = "defaut_message";


    // if (isset($_SESSION["login"]) AND isset($_POST["login"])) {
	   //  $message = "Bonjour " . $_SESSION["login"] . " !";
    // }

    // else if (isset($_SESSION["login"]) AND !isset($_POST["login"])) {
    // 	$message = "Vous avez été correctement déconnecté !";
    // }

 //    if (isset($_POST["login"]) AND isset($_POST["password"])) {

 //    	$login = $_POST["login"];
 //    	$password = $_POST["password"];

 //    	$member = read_member($login);
 //    	$test_password = password_verify($password, $member["password"]);

	//     if ($test_password) {
	//         $_SESSION["login"] = $login;
 //            header('Location: homepage.php');
 //            exit();
	//     } 
	//     else {
 //            $login_status = "error";
	//     }
	// }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "../css/panorama/imago.css"/>
    <link rel = "stylesheet" href = "../css/portrait/imago.css"/>

    <link rel = "stylesheet" href = "../css/panorama/login.css"/>
    <link rel = "stylesheet" href = "../css/portrait/login.css"/>

    <link rel = "icon" type = "image/png" href = "../img/icons/imago_con.png"/>

    <title> Imago TV - La plateforme vidéo de la transition </title>

    <meta property = "og:title" content = "Imago TV" />
    <meta property = "og:description" content = "La plateforme vidéo gratuite de la transition" />
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


<!-- LOGIN SCREEN -->	

    <div id = "screen">

		<a id = "login_title"> Connectez-vous pour profiter des fonctions coopératives ! </a>

		<section id = "login_connection">

			<div class = "login_item" >
				<a class = "login_item_title"> Pseudo : </a>
			   	<input id = "login" type = "text" class = "login_item" >
			</div>

			<div class = "login_item" >
		     	<a class = "login_item_title"> Mot de passe : </a>
			   	<input id = "password" type = "password" class = "login_item" >
			</div>

			<a id = "message" > Login ou mot de passe erroné </a>

    		<a id = "validate" class = "action" > VALIDER </a>
            <a href = "subscribe.php" id = "subscribe" class = "action" > (je ne suis pas encore inscrit) </a>
            <a id = "forget" class = "action" > Mot de passe oublié </a>

		</section>

	</div>


<?php

	    // if (isset($_SESSION["login"]) AND !isset($_POST["login"])) {
        //      $_SESSION = array();
        //      session_destroy();
    	// }
?>


<!-- FOOTER -->

    <?php include("block/footer.php") ?>


<!-- JS VARIABLES INIT -->

    <script type = "text/javascript">

        var user_login = "<?php ECHO $user_login; ?>";
        var user_id = "<?php ECHO $user_id; ?>";
        var status = "<?php ECHO $status; ?>";

        var env = "<?php ECHO $env; ?>";
        var base_url = "<?php ECHO $base_url; ?>";

        // var login_status = "<?php ECHO $login_status; ?>";

    </script> 


<!-- JS FILES -->

    <script src = "../js/lib/misc.js"></script>
    
    <script src = "../js/block/header.js"></script>
    <script src = "../js/block/menu.js"></script>
    <script src = "../js/block/user.js"></script>
    <script src = "../js/block/footer.js"></script>

	<script src = "../js/login.js"></script>

</body>
</html>
