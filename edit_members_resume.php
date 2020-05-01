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
	if(isset($_SESSION['pseudo']) AND isset($_SESSION['id'])) // Si connecté
    {   	
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
		else if($_SESSION['privilege']=='administrateur' OR $_SESSION['privilege']=='bureau') // Membre du bureeau ou admin
		{
		    if(empty($_POST['login']) AND empty($_POST['email']) AND empty($_POST['name']) AND empty($_POST['surname']) AND empty($_POST['password']) AND empty($_POST['privilege']) AND empty($_POST['niv_plongeur']) AND empty($_POST['niv_encadrant']) AND empty($_POST['certif_med']) AND empty($_POST['inscription_valide']) AND empty($_POST['edit_member_id']) ) // La page est vierge
		    {
		      header('location: admin.php');
		    }
		    else if(empty($_POST['login']) OR empty($_POST['email']) OR empty($_POST['name']) OR empty($_POST['surname']) OR empty($_POST['password']) OR empty($_POST['privilege']) OR !isset($_POST['niv_plongeur']) OR !isset($_POST['niv_encadrant']) OR !isset($_POST['actif_saison']) OR empty($_POST['certif_med']) OR !isset($_POST['inscription_valide'])) // Un ou plusieurs champs du formulaire sont vides
		    {
		      include("tools/data_base_connection.php");
	    	  $req = $bdd->prepare('SELECT id, pseudo, mdp, nom, prenom, email, privilege, oubli_mdp, niv_plongeur, niv_encadrant, actif_saison, certif_med, inscription_valide FROM membres WHERE id = :id');
		      $req->execute(array(
		          'id' => $_POST['edit_member_id']));
		      $resultat = $req->fetch();
		      $req->closeCursor(); //requête terminée

		      include("tools/navbar.php"); 
		      include("tools/print_msg.php"); // Define printMsg function 
		      printMsg('Un ou plusieurs champs n\'ont pas été remplis correctement !','',''); 
	  		  printMsg('Tous les champs n\'ont pas été remplis','',''); 
		      include("tools/edit_members_resume_form.php");
		    }
		    else // Tous les champs du formulaire sont remplis 
		    {
		      include("tools/data_base_connection.php");

		      // récupération des infos du membre à modifier pour retourner le formulaire en cas d'erreur
		      $req = $bdd->prepare('SELECT id, pseudo, mdp, nom, prenom, email, privilege, oubli_mdp, niv_plongeur, niv_encadrant, actif_saison, certif_med, inscription_valide FROM membres WHERE id = :id');
			  $req->execute(array(
			          'id' => $_POST['edit_member_id']));
			  $backup_resultat = $req->fetch();
			  $req->closeCursor(); //requête terminée

		      // Vérification du mot de passe
		      $req0 = $bdd->prepare('SELECT mdp FROM membres WHERE pseudo = :pseudo');
		      $req0->execute(array(
		        'pseudo' => $_SESSION['pseudo']));
		      $resultat = $req0->fetch();
		      // Comparaison du mdp envoyé via le formulaire avec la base
			  $isPasswordCorrect = password_verify($_POST['password'], $resultat['mdp']);
			  if($isPasswordCorrect) // Mdp OK
			  {	  
			      // Vérification de la validité des informations
			      $pseudo = htmlspecialchars($_POST['login']);
			      $req1 = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
			      $req1->execute(array(
			        'pseudo' => $pseudo));
			      $resultat = $req1->fetch();
			      if( ($pseudo==$backup_resultat['pseudo']) OR !$resultat) // Si le pseudo est inchangé ou le noueau pseudo est  disponible
			      {
			          if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) // L'email a une forme valide
			          {
			            // Insertion
			            $req2= $bdd->prepare('UPDATE membres SET pseudo = :pseudo, email = :email, nom = :nom, prenom = :prenom, privilege = :privilege, niv_plongeur = :niv_plongeur, niv_encadrant = :niv_encadrant, actif_saison = :actif_saison, certif_med = :certif_med, inscription_valide = :inscription_valide WHERE id = :id');
			            $req2->execute(array(
			              'pseudo' => $_POST['login'],     
			              'email' => $_POST['email'],
			              'nom' => $_POST['name'],
			              'prenom' => $_POST['surname'],
			              'privilege' => $_POST['privilege'],
			              'niv_plongeur' => $_POST['niv_plongeur'],
			              'niv_encadrant' => $_POST['niv_encadrant'],
			              'actif_saison' => $_POST['actif_saison'],
			              'certif_med' => $_POST['certif_med'],
			              'inscription_valide' => $_POST['inscription_valide'],
			          	  'id' => $_POST['edit_member_id']));

						include("tools/navbar.php"); 
			            include("tools/print_msg.php"); // Define printMsg function 
			         	printMsg('Informations modifiées avec succès !','Liste des membres','admin.php'); 

			            $req2->closeCursor(); //requête terminée
			          }
			          else // L'email n'a pas une forme valide
			          {
			          	$resultat = $backup_resultat;
			          	include("tools/navbar.php"); 
			          	include("tools/print_msg.php"); // Define printMsg function 
			         	printMsg('Un ou plusieurs champs n\'ont pas été remplis correctement !','',''); 
	  		  		  	printMsg('Email invalide','',''); 
			            include("tools/edit_members_resume_form.php");       
			          }
			      }
			      else // Le pseudo est déjà pris
			      {
			      	  $resultat = $backup_resultat;
			      	  include("tools/navbar.php"); 
			      	  include("tools/print_msg.php"); // Define printMsg function 
			          printMsg('Un ou plusieurs champs n\'ont pas été remplis correctement !','',''); 
	  		  		  printMsg('Ce pseudo n\'est pas disponible','',''); 
			          include("tools/edit_members_resume_form.php");;  
			      }

			      $req1->closeCursor(); //requête terminée
		  	  }
		  	  else // Mdp incorrect 
		  	  {
		  	  	  $resultat = $backup_resultat;
		  	      include("tools/navbar.php"); 
		  	      include("tools/print_msg.php"); // Define printMsg function 
			      printMsg('Un ou plusieurs champs n\'ont pas été remplis correctement !','',''); 
	  		  	  printMsg('Mot de passe incorrect','',''); 
			      include("tools/edit_members_resume_form.php");
		  	  }
		  	  $req0->closeCursor(); //requête terminée
			}
		}
		else
		{ // Pas membre du bureeau ni admin
    		header('location: home.php');
    	}
	}
	else
	{
		header('location: login.php');
	}
	?>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <!-- script src="js/materialize.min.js"></script> -->
  <script src="js/scripts.js"></script>

  </body>


</html>