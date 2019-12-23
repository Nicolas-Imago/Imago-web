
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
        header('Location: /inscription');
        exit();
    }

    ////////////////////////////////// Get data //////////////////////////////////

    if (!empty($_SESSION["login"])) {
        header('Location: /profil');
        exit();
    }

    if (empty($_POST["first_name"]))    $first_name = "";     else    $first_name = $_POST["first_name"];
    if (empty($_POST["last_name"]))     $last_name = "";      else    $last_name = $_POST["last_name"];
    if (empty($_POST["email"]))         $email = "";          else    $email = $_POST["email"];
    if (empty($_POST["login"]))         $login = "";          else    $login = $_POST["login"];

    if (empty($_POST["password_1"]))    $password_1 = "";     else    $password_1 = $_POST["password_1"];
    if (empty($_POST["password_2"]))    $password_2 = "";     else    $password_2 = $_POST["password_2"];

    $subscription_message = "";
    $subscription_status = "";

    if (!empty($_POST)) {

        $current_date = get_time();
        $test_member = read_member($_POST["login"]);

        if (empty($login)) {
        	$subscription_message = "Attention ! <br> Vous devez saisir un pseudo";
            $subscription_status = "error";
    	}
        else if (strlen($login) < 4) {
            $subscription_message = "Attention ! <br> Votre pseudo doit compter au moins 4 lettres";
            $subscription_status = "error";
        }
        else if (strpos($login, "@") != "") {
            $subscription_message = "Attention ! <br> Votre pseudo ne doit pas contenir le caractère @";
            $subscription_status = "error";
        }
        else if (!empty($test_member)) {
            $subscription_message = "Attention ! <br> Ce pseudo est déjà utilisé";
            $subscription_status = "error";
        }
        else if (empty($password_1)) {
        	$subscription_message = "Attention ! <br> Vous devez saisir un mot de passe";
            $subscription_status = "error";
        }
        else if ($password_1 != $password_2) {
        	$subscription_message = "Attention ! <br> Les 2 mots de passe saisis sont différents";
            $subscription_status = "error";
        }
       	else {
        	create_member($first_name, $last_name, $email, $login, $password_1, $current_date);
        	$_SESSION["login"] = $_POST['login'];
        	$subscription_message = "Bravo " . $login . "<br>votre profil vient d'être créé";
            $subscription_status = "created";
        }
    }

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "/css/panorama/imago_v111.css"/>
    <link rel = "stylesheet" href = "/css/portrait/imago_v111.css"/>
   	
    <link rel = "stylesheet" href = "/css/panorama/subscribe_v111.css"/>
    <link rel = "stylesheet" href = "/css/portrait/subscribe_v111.css"/>

    <link rel = "icon" type = "image/png" href = "/img/icons/imago_con.png"/>

    <title> Imago TV - Inscription </title>

    <meta property = "og:title" content = "Imago TV" />
    <meta property = "og:description" content = "La plateforme vidéo de la transition" />
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
    

<!-- SUBSCRIBE SCREEN -->	

	<div id = "screen">

		<!-- <img id = "subscribe_background_image" src = "/img/login/imago.jpg"></img> -->
		<a id = "subscribe_title"> Veuillez remplir vos informations : </a>

		<section id = "subscribe_information">

    		<form id = "form" action = "/inscription" method = "post" >

				<!-- USER INFORMATION -->

				<div id = "subscribe_first_name_input" class = "subscribe_item">
				   	<a class = "subscribe_item_title"> Prénom (facultatif) : </a>
				   	<input type = "text" name = "first_name" value = "<?php  ECHO $first_name ?>" > </input>
				</div>

				<div class = "subscribe_item">
					<a class = "subscribe_item_title"> Nom (facultatif) : </a>
				   	<input type = "text" name = "last_name" value = "<?php  ECHO $last_name ?>" > </input>
				</div>

				<div class = "subscribe_item">
					<a class = "subscribe_item_title"> Email (newsletter) : </a>
				   	<input type = "text" name = "email" value = "<?php  ECHO $email ?>" > </input>
				</div>

				<div id = "subscribe_login_input" class = "subscribe_item">
				   	<a class = "subscribe_item_title"> Pseudo * (obligatoire) : </a>
				   	<input type = "text" name = "login" value = "<?php  ECHO $login ?>" > </input>
				</div>		


				<!-- PASSWORD -->

				<a id = "subscribe_update_title"> Saisissez 2 fois votre mot de passe puis validez : </a>

				<div id = "subscribe_pwd_input" class = "subscribe_item">
				   	<a class = "subscribe_item_title"> Mot de passe * : </a>
				   	<input type = "password" name = "password_1" value = ""> </input>
				</div>

				<div class = "subscribe_item">
				   	<a class = "subscribe_item_title"> Recopie mot de passe * : </a>
				   	<input type = "password" name = "password_2" value = ""> </input>
				</div>
			
                <a id = "subscribe"> valider </a>
            
			</form> 

			<a id = "subscription_message" > <?php ECHO $subscription_message ?> </a>
            <a href = "/" id = "enter" > Retournez sur Imago TV </a>

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

        var subscription_status = "<?php ECHO $subscription_status; ?>";

    </script> 


<!-- JS FILES -->

	<script src = "/js/lib/misc_v111.js"></script>

    <script src = "/js/block/header_v111.js"></script>
    <script src = "/js/block/menu_v111.js"></script>
    <script src = "/js/block/user_v111.js"></script>
    <script src = "/js/block/footer_v111.js"></script>

	<script src = "/js/subscribe_v111.js"></script>

</body>
</html>
