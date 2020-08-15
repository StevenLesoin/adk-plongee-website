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

  <?php include("tools/navbar.php"); ?>

  <?php 
    if(empty($_POST['login']) AND empty($_POST['password1']) AND empty($_POST['password2']) AND empty($_POST['email']) AND empty($_POST['name']) AND empty($_POST['surname'])) // La page est vierge
    {
      include("tools/registration_form.php");
    }
    else if(empty($_POST['login']) OR empty($_POST['password1']) OR empty($_POST['password2']) OR empty($_POST['email']) OR empty($_POST['name']) OR empty($_POST['surname'])) // Un ou plusieurs champs du formulaire sont vides
    {
      include("tools/registration_failure.php"); 
      include("tools/registration_form.php"); 
    }
    else // Tous les champs du formulaire sont remplis 
    {
      include("tools/data_base_connection.php");
      include("tools/fonctions_unitaires.php"); 
      // Vérification de la validité des informations
      $pseudo = htmlspecialchars($_POST['login']);
      $req1 = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
      $req1->execute(array(
        'pseudo' => $pseudo));
      $resultat = $req1->fetch();
	  
	  $email = htmlspecialchars($_POST['email']);
      $req1 = $bdd->prepare('SELECT id FROM membres WHERE email = :email');
      $req1->execute(array(
        'email' => $email));
      $resultat2 = $req1->fetch();
	  
      if((!$resultat)AND(!$resultat2)) // Le pseudo est disponible
      {
        if($_POST['password1']==$_POST['password2']) 
        {
          if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) // L'email a une forme valide
          {
            // Hachage du mot de passe
            $pass_hache = password_hash($_POST['password1'], PASSWORD_DEFAULT);
			// Mise en majuscule du nom 
			$nom_MAJ = strtoupper($_POST['name']);
            // Insertion
            $req2= $bdd->prepare('INSERT INTO membres(pseudo, mdp, email, nom, prenom, privilege) VALUES(:pseudo, :password, :email, :nom, :prenom, \'membre\')');
            $privilege = "membre";
            $req2->execute(array(
              'pseudo' => $pseudo,
              'password' => $pass_hache,            
              'email' => $_POST['email'],
              'nom' => $nom_MAJ,
              'prenom' => $_POST['surname']));

            include("tools/print_msg.php"); // Define printMsg function 
            printMsg('Inscription réussie ! Un mail de confirmation vous à été envoyé sur votre adresse mail','Se connecter','login.php'); 
			envoi_mail_direct($_POST['email'],'ADK Plongée - Prise en compte de votre inscription','Votre inscription à bien été prise en compte. Un administrateur la validera pour vous donner un accès illimité au site');
            $req2->closeCursor(); //requête terminée
			
			// On va chercher l'ID de la nouvelle ligne crée
			$req1= $bdd->prepare('SELECT * FROM membres WHERE email="'.$_POST['email'].'"');
			$req1->execute(array());			
			while ($resultat = $req1->fetch())
			{
				// Ajout d'une ligne dans le champ paramètre pour la nouvelle personne crée
				$req3= $bdd->prepare('INSERT INTO parametres_membres(id_membre) VALUES(:id_membre)');
				$req3->execute(array(
				  'id_membre' => $resultat[0]));			
				$req3->closeCursor(); //requête terminée
			}
            $req1->closeCursor(); //requête terminée
		
          }
          else // L'email n'a pas une forme valide
          {
            include("tools/print_msg.php"); // Define printMsg function 
            printMsg('Un ou plusieurs champs n\'ont pas été remplis correctement !','',''); 
            printMsg('Email invalide','',''); 
            include("tools/registration_form.php");        
          }
        }
        else
        {
          include("tools/print_msg.php"); // Define printMsg function 
          printMsg('Un ou plusieurs champs n\'ont pas été remplis correctement !','',''); 
          printMsg('Les deux mot de passe sont différents','',''); 
          include("tools/registration_form.php");  
        }
      }
      else // Le pseudo est déjà pris
      {
        include("tools/print_msg.php"); // Define printMsg function 
        printMsg('Un ou plusieurs champs n\'ont pas été remplis correctement !','',''); 
        printMsg('Ce pseudo n\'est pas dipsonible ou ce mail est déjà enregistré','',''); 
        include("tools/registration_form.php");  
      }

      $req1->closeCursor(); //requête terminée
    }

  ?>

  <div id="index-banner" class="parallax-container">
    <div class="parallax"><img class="responsive-img" src="img/bioSurTole2.jpg" alt="Unsplashed background img 1"></div>
  </div>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <?php include("tools/scripts.php"); ?>

  </body>

</html>