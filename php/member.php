
<?php require_once("mutual/init.php") ?>

<?php require_once("mutual/lib_model.php") ?>
<?php require_once("mutual/lib_view.php") ?>

<?php

    // Functions 

    function dislay_message() {

    	global $first_name, $last_name, $email, $login;
    	global $new_password_1, $new_password_2, $test_password;
    	global $test_login;

       	if (empty($login)) {
	        ECHO ' style = "visibility:visible; color:red" ';
	    }
       	else if ($test_login == "0") {
        	ECHO ' style = "visibility:visible; color:red" ';
        }
        else {
        	if ($test_password == "1") {
	        	if (empty($new_password_1) OR empty($new_password_2)) {
				    ECHO ' style = "visibility:visible; color:green" ';      			
	        	}
	        	else if ($new_password_1 != $new_password_2) {
	        		ECHO ' style = "visibility:visible; color:red" ';
	        	}
		       	else {
				    ECHO ' style = "visibility:visible; color:green" ';
		        }
		    } 
	    	else {
	    		ECHO ' style = "visibility:visible; color:red" ';
	    	}
    	}
    }


    // Display

    if (empty($_SESSION["login"])) {
		header('Location: login.php');
		exit();
	}

    $update_message = "";
    $test_login = "0";
    $current_date = get_time();

    $current_member = read_member($_SESSION["login"]);
    $current_password = $current_member["password"];

    if (!empty($_POST)) {

    	// Get POST data

    	$id = $_POST["id"];

    	$first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $login = $_POST["login"];

    	$new_password_1 = $_POST["new_password_1"];
        $new_password_2 = $_POST["new_password_2"];

		$password = $_POST["password"];


		// Get test (login and password) parameters

        $test_member = read_member($login);

	   	if (empty($test_member) OR $test_member["id"] == $id) {
	   		$test_login = "1";
       	}

        $test_password = password_verify($password, $current_password);


        // Display message and update profil

       	if (empty($login)) {
	        $update_message = "Attention ! <br> Le champ 'Login' doit être rempli";
	    }

       	else if ($test_login == "0") {
        	$update_message = "Ce 'Login' est déjà utilisé";
        }

        else {

        	if ($test_password == "1") {

	        	if (empty($new_password_1) OR empty($new_password_2)) {
				    update_member_info($id, $first_name, $last_name, $email, $login, $current_date);
				    $_SESSION["login"] = $_POST["login"];
				    $update_message = "Votre profil <br> a été mis à jour";       			
	        	}
	        	
	        	else if ($new_password_1 != $new_password_2) {
	        		$update_message = "Attention !<br>Vous devez saisir 2 fois le même nouveau mot de passe";
	        	}

		       	else {
				    update_member_info($id, $first_name, $last_name, $email, $login, $current_date);
				    update_member_pwd($id, $new_password_1, $current_date);
				    $_SESSION["login"] = $_POST["login"];
				    $update_message = "Votre profil et votre mot de passe <br> ont été mis à jour";
		        }
		    }
	        
	    	else {
	    		$update_message = "Attention ! <br> Votre mot de passe est erroné";
	    	}
    	}
    }

    $member = read_member($_SESSION["login"]);

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset = "utf-8"/>
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <link rel = "stylesheet" href = "../css/imago.css"/>
   	<link rel = "stylesheet" href = "../css/mobile/imago.css"/>
   	
    <link rel = "stylesheet" href = "../css/member.css"/>
    <link rel = "stylesheet" href = "../css/mobile/member.css"/>

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

		<!-- <img id = "member_background_image" src = "../img/login/imago.jpg"></img> -->
		<a id = "member_title"> Bonjour <?php ECHO $member["login"] ?> ! </a>

		<section id = "member_information">

    		<form id = "form" action = "member.php" method = "post">

  				<!-- USER GAMING NOTES -->

<!-- 				<div class = "member_item">
					<a class = "member_item_title"> Conscience : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["note_1"] ?> </a>
				</div>

				<div class = "member_item">
					<a class = "member_item_title"> Alternatives : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["note_2"] ?> </a>
				</div>

				<div class = "member_item">
					<a class = "member_item_title"> Santé : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["note_3"] ?> </a>
				</div>

				<div class = "member_item">
					<a class = "member_item_title"> Esprit critique : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["note_4"] ?> </a>
				</div>

				<div class = "member_item">
					<a class = "member_item_title"> Ecologie : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["note_5"] ?> </a>
				</div>

				<div class = "member_item">
					<a class = "member_item_title"> Economie : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["note_6"] ?> </a>
				</div>

				<div class = "member_item">
					<a class = "member_item_title"> Société : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["note_7"] ?> </a>
				</div>

				<div class = "member_item">
					<a class = "member_item_title"> Connaissance : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["note_8"] ?> </a>
				</div>	 -->


    			<!-- USER ID -->

				<div id = "member_id_input" class = "member_item">
					<a class = "member_item_title"> Membre numéro : </a>
				   	<input type = "text" class = "readonly" name = "id" value = "<?php ECHO $member["id"] ?>">
				</div>

				<div class = "member_item">
				   	<a class = "member_item_title"> Statut : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["status"] ?> </a>
				</div>

				<div class = "member_item">
				   	<a class = "member_item_title"> Date d'inscription : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["subscription_date"] ?> </a>
				</div>

				<div id = "member_mod_date_input" class = "member_item">
				   	<a class = "member_item_title"> Dernière modification : </a>
				   	<a class = "member_item_value"> <?php ECHO $member["modification_date"] ?> </a>
				</div>


				<!-- USER INFORMATION -->

				<div id = "member_first_name_input" class = "member_item">
				   	<a class = "member_item_title"> Prénom : </a>
				   	<input type = "text" name = "first_name" value = "<?php ECHO $member["first_name"] ?>">
				</div>

				<div class = "member_item">
					<a class = "member_item_title"> Nom : </a>
				   	<input type = "text" name = "last_name" value = "<?php ECHO $member["last_name"] ?>">
				</div>

				<div class = "member_item">
					<a class = "member_item_title"> Email : </a>
				   	<input type = "text" name = "email" value = "<?php ECHO $member["email"] ?>">
				</div>

				<div id = "member_login_input" class = "member_item">
				   	<a class = "member_item_title"> Pseudo : </a>
				   	<input type = "text" name = "login" value = "<?php ECHO $member["login"] ?>">
				</div>		


				<!-- CHANGE PASSWORD -->

				<a id = "member_new_pwd_title"> Saisissez 2 fois votre nouveau mot de passe pour le modifier : </a>

				<div id = "member_new_pwd_input_1" class = "member_item">
				   	<a class = "member_item_title"> Nouveau mot de passe : </a>
				   	<input type = "password" name = "new_password_1" value = "">
				</div>

				<div id = "member_new_pwd_input_2" class = "member_item">
				   	<a class = "member_item_title"> Recopie mot de passe : </a>
				   	<input type = "password" name = "new_password_2" value = "">
				</div>


				<!-- PASSWORD -->

				<a id = "member_update_title"> Pour mettre à jour vos informations, saisissez votre mot de passe actuel puis appuyer sur le bouton 'valider' : </a>

				<div id = "member_pwd_input" class = "member_item">
				   	<a class = "member_item_title"> Mot de passe actuel : </a>
				   	<input type = "password" name = "password" value = "">
				</div>

				<a id = "member_update_button"> Valider </a>			

			</form> 

			<a id = "member_update_message" <?php dislay_message() ?> > <?php ECHO $update_message ?> </a>

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

	<script src = "../js/member.js"></script>

</body>
</html>
