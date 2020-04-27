<?php
// On démarre la session AVANT d'écrire du code HTML
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Liste évènements</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>

<?php include("tools/navbar.php"); ?>


<?php
    	if($_SESSION['oubli_mdp'] == 1) // Si connexion avec mot de passe temporaire
		{
			header('location: edit_password.php');
		}
		else if($_SESSION['inscription_valide']==0) // Inscription non validé
		{
			include("tools/navbar.php"); 
			include("tools/print_msg.php"); // Define printMsg function 
			$email = $_SESSION['email'];
  			printMsg('Votre demande d\'inscription n\'a pas encore été validé par l\'administateur. Vous recevrez un email à l\'adresse '. $email.' lorsque celle-ci aura été traité.','',''); 
		}
		else							
		{
			  //\\    ||\\   || //
			 //  \\   || \\  ||//
			//----\\  || //  ||\\
		   //      \\ ||//   || \\	
		   ///////////////////////////////////////////////////
			// ------------ Code de la page ---------------- //
			///////////////////////////////////////////////////
			  //\\    ||\\   || //
			 //  \\   || \\  ||//
			//----\\  || //  ||\\
		   //      \\ ||//   || \\	
			?>
			
			<div class="section no-pad-bot" id="index-banner">
				<div class="container">
				<br><br>
					<div class="row center">
						<span class="flow-text" col s12">Liste des évènements ADK :</span>
					</div>
			    </div>
			</div>

		<?php
		}?>


			
		<?php}?>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/initi.js"></script>

</body>

