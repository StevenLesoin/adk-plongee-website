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
            echo $new_password; // TODO : supprimer une fois l'envoi de mail ok 

				// Rédacion du mail
				$objet = 'Nouveau mot de passe ADK-plongée';
                $to = $resultat['email'];
 
                    	//===== Création du header du mail.
                        $header = "From: NOM_DE_LA_PERSONNE <no-reply@test.com> \n";
                        $header .= "Reply-To: ".$to."\n";
                        $header .= "MIME-version: 1.0\n";
                        $header .= "Content-type: text/html; charset=utf-8\n";
                        $header .= "Content-Transfer-Encoding: 8bit";
 
                        //===== Contenu de votre message
                        $contenu =  "<html>".
                            "<body>".
                            "<p style='text-align: center; font-size: 18px'><b>Bonjour Mr, Mme".$resultat['nom']."</b>,</p><br/>".
                            "<p style='text-align: justify'><i><b>Nouveau mot de passe : </b></i>".$new_password."</p><br/>".
                            "</body>".
                            "</html>";
                        //===== Envoi du mail
						
						//mail($to, $objet, $contenu, $header);
						// echo ini_get('SMTP') . ":" . ini_get('smtp_port');
						// // The message
						// $message = "Line 1\r\nLine 2\r\nLine 3";
						// // In case any of our lines are larger than 70 characters, we should use wordwrap()
						// $message = wordwrap($message, 70, "\r\n");
      //                   $bool = mail('steven.lesoin@gmail.com', 'Here Is What I Wanted to Send', $message);
						// var_dump($bool);



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
		  	printMsg('Un email avec un mot de passe provisoir vient de vous être envoyé à l\'adresse suivante : '.$email.'. Veuillez changer ce mot de passe après l\'avoir utilisé pour vous connecter.','','');  

		    $req2->closeCursor(); //requête terminée	      
	  	  }
	  	  $req1->closeCursor(); //requête terminée
		}
	?>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>


</html>