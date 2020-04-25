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
	    if(empty($_POST['login']) AND empty($_POST['email']) AND empty($_POST['name']) AND empty($_POST['surname']) AND empty($_POST['password'])) // La page est vierge
	    {
	      include("tools/navbar.php"); 
	      include("tools/edit_account_info_form.php");
	    }
	    else if(empty($_POST['login']) OR empty($_POST['email']) OR empty($_POST['name']) OR empty($_POST['surname']) OR empty($_POST['password'])) // Un ou plusieurs champs du formulaire sont vides
	    {
	      include("tools/navbar.php"); 
	      include("tools/edit_account_info_failure.php"); 
	      include("tools/edit_account_info_form.php"); 
	    }
	    else // Tous les champs du formulaire sont remplis 
	    {
	      include("tools/data_base_connection.php");
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
		      if( ($pseudo==$_SESSION['pseudo']) OR !$resultat) // Si le pseudo est inchangé ou le noueau pseudo est  disponible
		      {
		        // if($_POST['password1']==$_POST['password2']) 
		        // {
		          if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) // L'email a une forme valide
		          {
		            // Insertion
		            $req2= $bdd->prepare('UPDATE membres SET pseudo = :pseudo, email = :email, nom = :nom, prenom = :prenom WHERE id = :id');
		            $req2->execute(array(
		              'pseudo' => $_POST['login'],     
		              'email' => $_POST['email'],
		              'nom' => $_POST['name'],
		              'prenom' => $_POST['surname'],
		          	  'id' => $_SESSION['id']));

		            // Maj des variables de session 
		            $_SESSION['pseudo'] = $_POST['login'];
			        $_SESSION['email'] = $_POST['email'];
			        $_SESSION['prenom'] = $_POST['surname'];
			        $_SESSION['nom'] = $_POST['name'];

					include("tools/navbar.php"); 
		            include("tools/edit_account_info_success.php"); 

		            $req2->closeCursor(); //requête terminée
		          }
		          else // L'email n'a pas une forme valide
		          {
		          	include("tools/navbar.php"); 
		            include("tools/edit_account_info_failure.php"); 
		            include("tools/edit_account_info_form.php");        
		          }
		        // }
		        // else
		        // {
		        //   include("tools/edit_account_info_failure.php"); 
		        //   include("tools/edit_account_info_password_failure.php");
		        //   include("tools/edit_account_info_form.php");  
		        // }
		      }
		      else // Le pseudo est déjà pris
		      {
		      	  include("tools/navbar.php"); 
		          include("tools/edit_account_info_failure.php"); 
		          include("tools/edit_account_info_login_failure.php");
		          include("tools/edit_account_info_form.php");  
		      }

		      $req1->closeCursor(); //requête terminée
	  	  }
	  	  else // Mdp incorrect 
	  	  {
	  	      include("tools/navbar.php"); 
		      include("tools/edit_account_info_failure.php"); 
		      include("tools/edit_account_info_password_failure.php");
		      include("tools/edit_account_info_form.php");  
	  	  }
	  	  $req0->closeCursor(); //requête terminée
		}
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