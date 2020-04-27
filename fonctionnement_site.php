<?php
// On démarre la session AVANT d'écrire du code HTML
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Informations site</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>

<?php include("tools/navbar.php"); ?>

<?php
/*$pass_hache = password_hash("LucieCarof1*", PASSWORD_DEFAULT);
echo $pass_hache; */
?>

<!--	Affichage des plongées  -->
  <div class="section no-pad-bot" id="index-banner">
  	<div class="container">
    	<br><br>
        <div class="row center">
            <div class="input-field col s12">
			<span class="flow-text">Informations de fonctionnement du site :</span>
			</div>
        </div>
		<div class="row center">
		   <div class="input-field col s12">
				<label>Les pages accessibles sans être membre du site sont les suivantes : </br>
				- Page d'inscription </br>
				- Page de consultation des sorties organisées (Pas d'info sur qui est inscrit ni accès aux détails de la plongée)</br></br>
				</label>
		<div class="row center"><div class="input-field col s12"></div></div>		<!-- Ligne vide pour créer de l'espace car les </br> ne sont pas gérés par materialyze -->
        </div>
		<div class="row center">
		    <div class="input-field col s12">
            <label>Une fois votre inscription effectuée sur le site, une <u><b>validation de votre inscription</u></b> est nécessaire avant de pouvoir utiliser les fonctionnalités du site. </label>
			</div>
		</div>
		<div class="row center">
		    <div class="input-field col s12">
            <label>En tant que <u>membre</u>, vous pourrez vous inscrire à tous les événements, inviter un participant (Non prioritaire), et ajouter un événement. </label>
			</div>
		</div>
		<div class="row center"><div class="input-field col s12"></div></div>		<!-- Ligne vide pour créer de l'espace car les </br> ne sont pas gérés par materialyze -->
		<div class="row center">
		    <div class="input-field col s12">
            <span class="flow-text" col s12">Résolution de problèmes</span>
			</div>
        </div>
		<div class="row center">
		    <div class="input-field col s12">
            <label>Si vous ne réusssisez pas à vous inscrire sur la page listant les différents événements ou à obtenir les détails d'un événement: </br>
			- Vérifiez la connexion à votre esace membre</br>
			</label>
			</div>
        </div>
		<div class="row center">
		    <div class="input-field col s12">
            <label>En cas niveau de plongée non à jour ou de date de certificat médical périmé, veuillez contacter le secrétaire pour une mise à jour</br>
			En cas de problème fonctionnel sur le site, contacter Steven ou Clément </br>
			</label>
			</div>
        </div>
		<div class="row center"><div class="input-field col s12"></div></div>		<!-- Ligne vide pour créer de l'espace car les </br> ne sont pas gérés par materialyze -->
		
		<div class="row center">

    </div>
  </div>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/initi.js"></script>

</body>
