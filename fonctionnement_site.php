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
			</div>
        </div>
		<div class="row center"><div class="input-field col s12"></div></div>		<!-- Ligne vide pour créer de l'espace car les </br> ne sont pas gérés par materialyze -->
		<div class="row center">
		    <div class="input-field col s12">
            <label>Une fois votre inscription effectuée sur le site, une <u><b>validation de votre inscription</u></b> est nécessaire avant de pouvoir utiliser les fonctionnalités du site. Cette vaildation est faite par un administrateur ou par le bureau.</label>
			</div>
		</div>
		<div class="row center">
		    <div class="input-field col s12">
            <label>En tant que <u>membre</u>, vous pourrez vous inscrire à tous les événements (Accessibles à votre niveau), inviter un participant (Non prioritaire), et ajouter un événement. </label>
			</div>
		</div>
		<div class="row center">
		    <div class="input-field col s12">
            <label>Si votre certificat medical est daté de plus d'un an, il est toujours possible de s'inscrire à des événements, mais votre nom apparaitra en rouge sur la liste des inscrits. Cela vous permet de vous inscrire à des événements hors plongée et d'attirer l'attention du DP si vous vous inscrivez à un événement de plongée. Vous apparaitrez également en rouge sur la page d'inscription si l'événement est de type "Plongée" ou "Piscine" </label>
			</div>
		</div>
		<div class="row center"><div class="input-field col s12"></div></div>		<!-- Ligne vide pour créer de l'espace car les </br> ne sont pas gérés par materialyze -->
		<div class="row center">
		    <div class="input-field col s12">
            <label>Pour la création d'un événément, il existe plusieur types : </br>
			- <u>Plongée</u> : Nécessite un DP (N5 Mini). 4 Personnes inscrites minimum dont au moins 3 membres du club. Le DP est défini automatiquement suivant les règles de la section. Attention, si de l'enseignement est réalisé sur la plongée, le DP indiqué devra être modifié pour un E3 minimum</br> 
			- <u>Piscine</u> : Nécessite un DP (E1 Mini), et pas de minimum d'inscrits, juste un DP et un créneau piscine... </br>
			- <u>Théorie</u> : Pas de vérification, vous pouvez créer ce type d'événement et l'organiser comme vous voulez. </br>
			- <u>Vie du club</u> : Idem, pas de vérification </br>
			- <u>Autre</u> : Idem, pas de vérifications </br>
			</div>
		</div>
		<div class="row center"><div class="input-field col s12"></div></div>		<!-- Ligne vide pour créer de l'espace car les </br> ne sont pas gérés par materialyze -->
		<div class="row center"><div class="input-field col s12"></div></div>		<!-- Ligne vide pour créer de l'espace car les </br> ne sont pas gérés par materialyze -->
		<div class="row center"><div class="input-field col s12"></div></div>		<!-- Ligne vide pour créer de l'espace car les </br> ne sont pas gérés par materialyze -->
		<div class="row center">
		    <div class="input-field col s12">
            <label>Les informations de votre compte sont modifiables par les membres du bureau (Niveau, Date de certificat médical...), vos infos personnelles sont modifiables par vous même</label>
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
			- Assurez vous que vous avez le niveau nécessaire pour vous inscrire à la sortie</br>
			- Assurez vous que la date limite d'inscription ne soit pas dépassée
			</label>
			</div>
        </div>
		<div class="row center"><div class="input-field col s12"></div></div>		<!-- Ligne vide pour créer de l'espace car les </br> ne sont pas gérés par materialyze -->
		<div class="row center">
		    <div class="input-field col s12">
            <label>En cas niveau de plongée non à jour ou de date de certificat médical périmé, veuillez contacter le secrétaire pour une mise à jour</br>
			En cas de problème fonctionnel sur le site, contactez Steven ou Clément </br>
			</label>
			</div>
        </div>
		<div class="row center"><div class="input-field col s12"></div></div>		<!-- Ligne vide pour créer de l'espace car les </br> ne sont pas gérés par materialyze -->
		
		<div class="row center">

    </div>
  </div>

  <?php include("tools/footer.php"); ?>
  <!--  Scripts-->
  <?php include("tools/scripts.php"); ?>

</body>