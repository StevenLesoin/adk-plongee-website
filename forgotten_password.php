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
	    if(empty($_POST['pseudo']) AND empty($_POST['email'])) // La page est vierge
	    {
	      include("tools/navbar.php"); 
	      include("tools/forgotten_password_form.php");
	    }
	    else if(empty($_POST['pseudo']) OR empty($_POST['email'])) // Tous les champs du formulaire ne sont pas remplis 
	    {
	      include("tools/navbar.php"); 
		  include("tools/print_msg.php"); // Define printMsg function 
		  printMsg('Un ou plusieurs champs n\'ont pas été remplis correctement !','',''); 
		  printMsg('Tous les champs n\'ont pas été remplis','',''); 
	      include("tools/forgotten_password_form.php");
	    }
	    else if(!empty($_POST['pseudo']) AND !empty($_POST['email'])) // Tous les champs du formulaire sont remplis 
	    {
	      include("tools/data_base_connection.php");
	      // Vérification du mot de passe
	      $req1 = $bdd->prepare('SELECT nom, prenom, email, oubli_mdp FROM membres WHERE pseudo = :pseudo AND email = :email');
	      $req1->execute(array(
	        'pseudo' => $_POST['pseudo'],
	    	'email' => $_POST['email']));
	      $resultat = $req1->fetch();	      

		  if(!$resultat) // Email inconnu 
		  {
		  	include("tools/navbar.php"); 
		  	include("tools/print_msg.php"); // Define printMsg function 
		  	printMsg('Un ou plusieurs champs n\'ont pas été remplis correctement !','',''); 
		  	printMsg('Email inconnu','',''); 
	      	include("tools/forgotten_password_form.php");
		  }
		  else
		  {
		  	$email = $resultat['email'];

		  	// Mot de passe aléatoire provisoir
            $new_password = rand();

            	include("tools/mail_adk.php");
				// Rédacion du mail
				$objet = 'Nouveau mot de passe ADK plongée website';
                $to = $resultat['email'];
 
                        //===== Contenu de votre message
                        $contenu =  "Mr, Mme ".$resultat['nom'].". Vous avez fait une demande de réinitialisation de votre mot de passe sur le site ADK plongée. Nous vous faisons parvenir votre mot de passe provisoir. Une fois connecté avec celui-ci, veuillez suivre la procédure de réinitialisation. Mot de passe provisoir: ".$new_password." .";
                        //===== Envoi du mail
            			$resMail = sendMailAdk($to,$objet,$contenu);



		    // Hachage du mot de passe
            $new_pass_hache = password_hash($new_password, PASSWORD_DEFAULT);

		    // Insertion
		    $req2= $bdd->prepare('UPDATE membres SET mdp = :mdp, oubli_mdp = :oubli_mdp WHERE pseudo = :pseudo AND email = :email');
		    $req2->execute(array(
		        'mdp' => $new_pass_hache,
		        'oubli_mdp' => 1,
		        'pseudo' => $_POST['pseudo'],
		        'email' => $email));

			include("tools/navbar.php");
		    include("tools/print_msg.php"); // Define printMsg function 
		    if ($resMail){
		  		printMsg('Un email avec un mot de passe provisoir vient de vous être envoyé à l\'adresse suivante : '.$email.'. Veuillez changer ce mot de passe après l\'avoir utilisé pour vous connecter.','','');  
		  	}else{
		  		printMsg('Erreur lors de l\'envoi d\'un email à l\'adresse suivante : '.$email.'. Veuillez réessayer','','');  
		  	}

		    $req2->closeCursor(); //requête terminée	      
	  	  }
	  	  $req1->closeCursor(); //requête terminée
		}
	?>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <?php include("tools/scripts.php"); ?>

  </body>


</html>