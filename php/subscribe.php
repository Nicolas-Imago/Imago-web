
<?php require_once("mutual/init.php") ?>

<?php require_once("mutual/lib_model.php") ?>
<?php require_once("mutual/lib_view.php") ?>

<?php

    // Functions 

    function display_message($status) {

        if ($status == "error") {
            ECHO ' style = "visibility:visible; color:red" ';
        }
		else { 
            ECHO ' style = "visibility:visible; color:green" ';
		}
    }

    function display_enter($status) {

        if ($status == "created") {
            ECHO ' style = "display:bloc" ';
        }
        else { 
            ECHO ' style = "display:none" ';
        }
    }

    function display_form($status) {

        if ($status == "created") {
            ECHO ' style = "display:none" ';
        }
    }

    function display_value($field) {

    	if (!empty($_POST[$field])) {ECHO ' value = "' . $_POST[$field] . '"';}
    }


    // Display

    $subscription_message = "";
    $subscription_status = "";
    $enter_message = "Retournez sur ImagoTV";

    if (!empty($_POST)) {

        $current_date = get_time();

		$test_member = read_member($_POST['login']);

    	$first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $login = $_POST['login'];

    	$password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];

        if (empty($login)) {
        	$subscription_message = "Attention ! <br> Le champ 'Login' doit être rempli";
            $subscription_status = "error";
    	}
        else if (empty($password_1)) {
        	$subscription_message = "Attention ! <br> Le champ 'mot de passe' doit être rempli";
            $subscription_status = "error";
        }
        else if ($password_1 != $password_2) {
        	$subscription_message = "Attention ! <br> Les 2 mots de passe sont différents";
            $subscription_status = "error";
        }
        else if (!empty($test_member)) {
        	$subscription_message = "Attention ! <br> Ce 'pseudo' est déjà utilisé";
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
<html>

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "../css/imago.css"/>
   	<link rel = "stylesheet" href = "../css/mobile/imago.css"/>
   	
    <link rel = "stylesheet" href = "../css/subscribe.css"/>
    <link rel = "stylesheet" href = "../css/mobile/subscribe.css"/>

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
    

<!-- TV SHOW SCREEN -->	

	<div id = "screen">

		<!-- <img id = "subscribe_background_image" src = "../img/login/imago.jpg"></img> -->
		<a id = "subscribe_title"> Veuillez remplir vos informations : </a>

		<section id = "subscribe_information">

    		<form id = "form" action = "subscribe.php" method = "post" <?php display_form($subscription_status) ?> >

				<!-- USER INFORMATION -->

				<div id = "subscribe_first_name_input" class = "subscribe_item">
				   	<a class = "subscribe_item_title"> Prénom (facultatif) : </a>
				   	<input type = "text" name = "first_name" <?php display_value("first_name") ?> >
				</div>

				<div class = "subscribe_item">
					<a class = "subscribe_item_title"> Nom (facultatif) : </a>
				   	<input type = "text" name = "last_name" <?php display_value("last_name") ?> >
				</div>

				<div class = "subscribe_item">
					<a class = "subscribe_item_title"> Email (newsletter) : </a>
				   	<input type = "text" name = "email" <?php display_value("email") ?> >
				</div>

				<div id = "subscribe_login_input" class = "subscribe_item">
				   	<a class = "subscribe_item_title"> Pseudo * (obligatoire) : </a>
				   	<input type = "text" name = "login" <?php display_value("login") ?> >
				</div>		


				<!-- PASSWORD -->

				<a id = "subscribe_update_title"> Saisissez 2 fois votre mot de passe puis validez : </a>

				<div id = "subscribe_pwd_input" class = "subscribe_item">
				   	<a class = "subscribe_item_title"> Mot de passe * : </a>
				   	<input type = "password" name = "password_1" value = "">
				</div>

				<div class = "subscribe_item">
				   	<a class = "subscribe_item_title"> Recopie mot de passe * : </a>
				   	<input type = "password" name = "password_2" value = "">
				</div>

				<a id = "subscribe_update_button"> Valider </a>			

			</form> 

			<a id = "subscription_message" <?php display_message($subscription_status) ?> > <?php ECHO $subscription_message ?> </a>

            <a id = "enter" <?php display_enter($subscription_status) ?> > <?php ECHO $enter_message ?> </a>


		</section>

	</div> 


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

	<script src = "../js/subscribe.js"></script>

</body>
</html>
