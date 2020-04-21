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
  // #### Récupérer aussi le type d'évènement qui n'est pas loggé pour l'instant ni la date
    if(empty($_POST['titre']) OR empty($_POST['date_evt']) OR empty($_POST['heure_evt']) OR empty($_POST['date_lim']) OR empty($_POST['heure_lim'])) // Le formulaire n'est pas rempli intégralement
	{
      include("tools/registration_failure.php"); 
  // #### Afficher une erreure pour mauvaise saisie 
    }
    else // Tous les champs du formulaire sont remplis 
    {
      include("tools/data_base_connection.php");
      
	  // Insertion #####Récupérer aussi le pseudo du mec connecté
            /*
			$type = $_POST['type'];
			$titre = $_POST['titre'];
			$date_evt = $_POST['date_evt'];
			$heure_evt = $_POST['heure_evt'];
			$date_lim = $_POST['date_lim'];
			$heure_lim = $_POST['heure_lim'];
			$niveau_min = $_POST['niveau_min'];
			$lieu = $_POST['lieu'];
			$remarques = $_POST['remarques'];
			$pseudo = '0';
			$date_publi = '0';*/
			
			
			$req2= $bdd->prepare('INSERT INTO evenements(type, titre, date_evt, heure_evt, date_lim, heure_lim, niveau_min, lieu, remarques, pseudo, date_publi) VALUES(:type, :titre, :date_evt, :heure_evt, :date_lim, :heure_lim, :niveau_min, :lieu, :remarques, \'Vide\', \'Vide\')');
            $req2->execute(array(
              'type' => $_POST['type'],
			  'titre' => $_POST['titre'],
			  'date_evt' => $_POST['date_evt'],
			  'heure_evt' => $_POST['heure_evt'],
			  'date_lim' => $_POST['date_lim'],
			  'heure_lim' => $_POST['heure_lim'],
			  'niveau_min' => $_POST['niveau_min'],
			  'lieu' => $_POST['lieu'],
			  'remarques' => $_POST['remarques']));

            // ####Page pour confirmer la prise en compte du nouvel évènement 
            $req2->closeCursor(); //requête terminée
    }

  ?>


  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>

</html>