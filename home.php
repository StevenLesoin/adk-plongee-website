<?php
// On démarre la session AVANT d'écrire du code HTML
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>ADK plongée</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>

	<?php 
	if(isset($_SESSION['pseudo'])) // Si déjà connecté
    {
    	if($_SESSION['oubli_mdp'] == 1) // Si connexion avec mot de passe temporaire
		{
			//header('location: edit_password.php');
			?><meta http-equiv="Refresh" content="0; url=http://www.adkplongee.ovh/edit_password.php" /><?php
		}
		else if($_SESSION['inscription_valide']==0) // Inscription non validé
		{
			include("tools/navbar.php"); 
			include("tools/print_msg.php"); // Define printMsg function 
			$email = $_SESSION['email'];
  			printMsg('Votre demande d\'inscription n\'a pas encore été validé par l\'administateur. Vous recevrez un email à l\'adresse '. $email.' lorsque celle-ci aura été traité.','',''); 
		}
		else{
	    	include("tools/navbar.php"); 
	    	include("tools/account_info.php"); 
    	}
    }
	else if((isset($_POST['login'])OR (isset($_POST['mail']))) AND isset($_POST['password'])) // Si tentative de connexion
	{
		include("tools/data_base_connection.php");

		//  Récupération de l'utilisateur et de son pass hashé
		
		if(isset($_POST['mail']))  // Login avec son mail
		{
			$mail = htmlspecialchars($_POST['mail']);
			$req = $bdd->prepare('SELECT id, pseudo, mdp, email, nom, prenom, privilege, oubli_mdp, niv_plongeur, niv_encadrant, actif_saison, certif_med, inscription_valide FROM membres WHERE email = :mail');
			$req->execute(array(
		    'mail' => $mail));
			$resultat = $req->fetch();
			
		}
		else		// Login avec le pseudo
		{
			$pseudo = htmlspecialchars($_POST['login']);
			$req = $bdd->prepare('SELECT id, pseudo, mdp, email, nom, prenom, privilege, oubli_mdp, niv_plongeur, niv_encadrant, actif_saison, certif_med, inscription_valide FROM membres WHERE pseudo = :pseudo');
			$req->execute(array(
		    'pseudo' => $pseudo));
			$resultat = $req->fetch();
		}

		if (!$resultat) // Pseudo inconnu 
		{
			include("tools/navbar.php"); 
			include("tools/print_msg.php"); // Define printMsg function 
  			printMsg('Pseudo Ou Mail inconnu','Réessayer','login.php'); 
		}
		else
		{
			// Comparaison du mdp envoyé via le formulaire avec la base
			$isPasswordCorrect = password_verify($_POST['password'], $resultat['mdp']);

		    if ($isPasswordCorrect) {
		        $_SESSION['id'] = $resultat['id'];
		        $_SESSION['pseudo'] = $resultat['pseudo'];
		        $_SESSION['email'] = $resultat['email'];
		        $_SESSION['prenom'] = $resultat['prenom'];
		        $_SESSION['nom'] = $resultat['nom'];
		        $_SESSION['privilege'] = $resultat['privilege'];	
		        $_SESSION['oubli_mdp'] = $resultat['oubli_mdp'];
		        $_SESSION['niv_plongeur'] = $resultat['niv_plongeur'];	
		        $_SESSION['niv_encadrant'] = $resultat['niv_encadrant'];	
		        $_SESSION['actif_saison'] = $resultat['actif_saison'];	
		        $_SESSION['certif_med'] = $resultat['certif_med'];	
		        $_SESSION['inscription_valide'] = $resultat['inscription_valide'];		      
				
				if($_SESSION['oubli_mdp'] == 1) // Si connexion avec mot de passe temporaire
				{
					//header('location: edit_password.php');
					?><meta http-equiv="Refresh" content="0; url=http://www.adkplongee.ovh/edit_password.php" /><?php
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
					//header('location:index.php');
					?><meta http-equiv="Refresh" content="0; url=http://www.adkplongee.ovh/index.php" /><?php
				}
		    }
		    else { // Erreur de mot de passe
		    	include("tools/navbar.php"); 
		        include("tools/print_msg.php"); // Define printMsg function 
  				printMsg('Mot de passe incorrect','Réessayer','login.php'); 
  				printMsg('','Mot de passe oublié','forgotten_password.php'); 
		    }
		}

		$req->closeCursor(); //requête terminée
	}
	else
	{
		//header('location: login.php');
		?><meta http-equiv="Refresh" content="0; url=http://www.adkplongee.ovh/login.php" /><?php
	}
	?>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <?php include("tools/scripts.php"); ?>

  </body>


</html>