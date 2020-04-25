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
	if(isset($_SESSION['pseudo']) AND isset($_SESSION['privilege'])) // Si déjà connecté
    {
    	if($_SESSION['oubli_mdp'] == 1) // Si connexion avec mot de passe temporaire
		{
			header('location: edit_password.php');
		}
    	include("tools/navbar.php"); 
    	include("tools/account_info.php"); 
    }
	else if(isset($_POST['login']) AND isset($_POST['password'])) // Si tentative de connexion
	{
		include("tools/data_base_connection.php");

		$pseudo = htmlspecialchars($_POST['login']);
		//  Récupération de l'utilisateur et de son pass hashé
		$req = $bdd->prepare('SELECT id, mdp, email, nom, prenom, privilege, oubli_mdp FROM membres WHERE pseudo = :pseudo');
		$req->execute(array(
		    'pseudo' => $pseudo));
		$resultat = $req->fetch();

		// Comparaison du mdp envoyé via le formulaire avec la base
		$isPasswordCorrect = password_verify($_POST['password'], $resultat['mdp']);

		if (!$resultat) // Pseudo inconnu 
		{
			include("tools/navbar.php"); 
			include("tools/login_failure.php");
		}
		else
		{
		    if ($isPasswordCorrect) {
		        $_SESSION['id'] = $resultat['id'];
		        $_SESSION['pseudo'] = $pseudo;
		        $_SESSION['email'] = $resultat['email'];
		        $_SESSION['prenom'] = $resultat['prenom'];
		        $_SESSION['nom'] = $resultat['nom'];
		        $_SESSION['privilege'] = $resultat['privilege'];	
		        $_SESSION['oubli_mdp'] = $resultat['oubli_mdp'];	      
				
				if($_SESSION['oubli_mdp'] == 1) // Si connexion avec mot de passe temporaire
				{
					header('location: edit_password.php');
				}
				else
				{
					include("tools/navbar.php"); 
					include("tools/login_success.php");
					include("tools/account_info.php"); 
				}
		    }
		    else { // Erreur de mot de passe
		    	include("tools/navbar.php"); 
		        include("tools/login_failure.php");
		    }
		}

		$req->closeCursor(); //requête terminée
	}
	else
	{
		header('location: login.php');
	}
	?>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>


</html>