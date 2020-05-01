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
			if(empty($_POST['search_name']) AND empty($_POST['search_surname']) AND empty($_POST['edit_member_id']) AND empty($_POST['validate_registration_member_id'])) // Page vierge
			{
		    	include("tools/navbar.php"); 
		    	include("tools/search_members_form.php");

		    	include("tools/data_base_connection.php");
		    	// Liste de l'ensemble des membres 
		    	$req0 = $bdd->prepare('SELECT id, pseudo, mdp, nom, prenom, email, privilege, oubli_mdp, niv_plongeur, niv_encadrant, actif_saison, certif_med, inscription_valide FROM membres ORDER BY nom');
		        $req0->execute(array());
		        include("tools/all_members_resume_tab.php");
		        $req0->closeCursor(); //requête terminée
	    	}
	    	else if(!empty($_POST['edit_member_id'])) // Champ sélectionné pour modification
	    	{
	    		include("tools/data_base_connection.php");
	    		$req1 = $bdd->prepare('SELECT id, pseudo, mdp, nom, prenom, email, privilege, oubli_mdp, niv_plongeur, niv_encadrant, actif_saison, certif_med, inscription_valide FROM membres WHERE id = :id');
		        $req1->execute(array(
		          'id' => $_POST['edit_member_id']));
		        $resultat = $req1->fetch();
		        $req1->closeCursor(); //requête terminée

		        include("tools/navbar.php"); 
	    		include("tools/edit_members_resume_form.php"); 
	    	}
	    	else if(!empty($_POST['validate_registration']) AND !empty($_POST['validate_registration_member_id'])) // Champ sélectionné pour validation inscription
	    	{
	    		echo "test";
	    		include("tools/data_base_connection.php");
	    		// Valide l'inscription
	    		$req2= $bdd->prepare('UPDATE membres SET inscription_valide = :inscription_valide WHERE id = :id');
		        $req2->execute(array(
		          'inscription_valide' => $_POST['validate_registration'],
		          'id' => $_POST['validate_registration_member_id']));
		        $req2->closeCursor(); //requête terminée

		        // Liste de l'ensemble des membres 
		    	$req0 = $bdd->prepare('SELECT id, pseudo, mdp, nom, prenom, email, privilege, oubli_mdp, niv_plongeur, niv_encadrant, actif_saison, certif_med, inscription_valide FROM membres ORDER BY nom');
		        $req0->execute(array());

		        include("tools/navbar.php"); 
		        include("tools/search_members_form.php");
		       	include("tools/all_members_resume_tab.php");
		       	$req0->closeCursor(); //requête terminée
	    	}
	    	else if(empty($_POST['search_name']) OR empty($_POST['search_surname'])) // Un ou plusieurs champs du formulaire de recherche sont vides
	    	{
	        	include("tools/navbar.php"); 
			    include("tools/print_msg.php"); // Define printMsg function 
			    printMsg('Un ou plusieurs champs n\'ont pas été remplis correctement !','',''); 
		  		printMsg('Tous les champs de recherche n\'ont pas été remplis','',''); 
			    include("tools/search_members_form.php");

		    	include("tools/data_base_connection.php");
		    	// Liste de l'ensemble des membres 
		    	$req0 = $bdd->prepare('SELECT id, pseudo, mdp, nom, prenom, email, privilege, oubli_mdp, niv_plongeur, niv_encadrant, actif_saison, certif_med, inscription_valide FROM membres ORDER BY nom');
		        $req0->execute(array());
		        include("tools/all_members_resume_tab.php");
		        $req0->closeCursor(); //requête terminée
	    	}
	    	else // Tous les champs de recherche sont remplis
	    	{
		        include("tools/data_base_connection.php");
		        // Affichage du résultat de la recherche
		        $req0 = $bdd->prepare('SELECT id, pseudo, mdp, nom, prenom, email, privilege, oubli_mdp, niv_plongeur, niv_encadrant, actif_saison, certif_med, inscription_valide FROM membres WHERE prenom = :prenom AND nom = :nom ORDER BY nom');
		        $req0->execute(array(
		          'prenom' => $_POST['search_surname'],
		      	  'nom' => $_POST['search_name']));

		        include("tools/navbar.php"); 
		        include("tools/search_members_form.php");
		       	include("tools/all_members_resume_tab.php");
		       	$req0->closeCursor(); //requête terminée
	    	}
    	}
    	else{ // Pas membre du bureeau ni admin
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