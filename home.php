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

  <?php include("navbar.php"); ?>

	<?php 

	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=adk_plongee_website;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e)
	{
	    die('Erreur : ' . $e->getMessage());
	}

	$pseudo = $_POST['login'];
	//  Récupération de l'utilisateur et de son pass hashé
	$req = $bdd->prepare('SELECT id, mdp FROM membres WHERE pseudo = :pseudo');
	$req->execute(array(
	    'pseudo' => $pseudo));
	$resultat = $req->fetch();

	// Comparaison du mdp envoyé via le formulaire avec la base
	$isPasswordCorrect = password_verify($_POST['password'], $resultat['mdp']);

	if (!$resultat)
	{
	    echo 'Mauvais identifiant ou mot de passe !';
	}
	else
	{
	    if ($isPasswordCorrect) {
	        session_start();
	        $_SESSION['id'] = $resultat['id'];
	        $_SESSION['pseudo'] = $pseudo;
	        echo 'Vous êtes connecté !';
	    }
	    else {
	        echo 'Mauvais identifiant ou mot de passe !';
	    }
	}

	?>

  <?php include("footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>


</html>