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
	    if(empty($_POST['password']) AND empty($_POST['new_password1']) AND empty($_POST['new_password2'])) // La page est vierge
	    {
	      include("tools/navbar.php"); 
	      if($_SESSION['oubli_mdp'] == 1) // Si connexion avec mot de passe temporaire
		  {
			include("tools/login_success.php");
		  }
	      include("tools/edit_password_form.php");
	    }
	    else if(empty($_POST['password']) OR empty($_POST['new_password1']) OR empty($_POST['new_password2'])) // Un ou plusieurs champs du formulaire sont vides
	    {
	      include("tools/navbar.php"); 
	      include("tools/edit_password_failure.php"); 
	      include("tools/edit_password_form.php"); 
	    }
	    else // Tous les champs du formulaire sont remplis 
	    {
	      include("tools/data_base_connection.php");
	      // Vérification du mot de passe
	      $req1 = $bdd->prepare('SELECT mdp, oubli_mdp FROM membres WHERE pseudo = :pseudo');
	      $req1->execute(array(
	        'pseudo' => $_SESSION['pseudo']));
	      $resultat = $req1->fetch();
	      // Comparaison du mdp envoyé via le formulaire avec la base
		  $isPasswordCorrect = password_verify($_POST['password'], $resultat['mdp']);
		  if($isPasswordCorrect) // Mdp OK
		  {
		  	if($_POST['new_password1']==$_POST['new_password2']) 
		    {
		    	// Hachage du mot de passe
            	$pass_hache = password_hash($_POST['new_password1'], PASSWORD_DEFAULT);

		        // Insertion
		        $req2= $bdd->prepare('UPDATE membres SET mdp = :mdp, oubli_mdp = :oubli_mdp WHERE pseudo = :pseudo');
		        $req2->execute(array(
		            'mdp' => $pass_hache,
		            'oubli_mdp' => 0,
		            'pseudo' => $_SESSION['pseudo']));

		        $_SESSION['oubli_mdp'] = 0;

				include("tools/navbar.php"); 
		        include("tools/edit_password_success.php"); 

		        $req2->closeCursor(); //requête terminée
		    }
		    else
		    {
		    include("tools/edit_password_failure.php"); 
		    include("tools/edit_password_new_password_failure.php");
		    include("tools/edit_password_form.php");  
		    }

		      $req1->closeCursor(); //requête terminée
	  	  }
	  	  else // Mdp incorrect 
	  	  {
	  	      include("tools/navbar.php"); 
		      include("tools/edit_password_password_failure.php");
		      include("tools/edit_password_form.php");  
	  	  }
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