<?php
// On démarre la session AVANT d'écrire du code HTML
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Nouvel évènement</title>
   
  
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    
	<!-- Fonctions de la feuille -->

  
</head>

<body>

<?php
include("tools/fonctions_unitaires.php"); 
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
	else{
		include("tools/navbar.php"); 
		?>

  <div class="section no-pad-bot" id="index-banner">
  	<div class="container">
    	<br><br>
        <div class="row center">
            <span class="flow-text" col s12">Modification d'un nouvel évènement ADK :</span>
        </div>
		
		<?php	
				
				if(isset($_POST['type']) AND htmlspecialchars($_POST['type'])!=''){$type_s = htmlspecialchars($_POST['type']);}
				if(isset($_POST['date_evt']) AND htmlspecialchars($_POST['date_evt'])!=''){$date_evt_s = date('Y-m-d', strtotime(htmlspecialchars($_POST['date_evt'])));}
				if(isset($_POST['heure_evt']) AND htmlspecialchars($_POST['heure_evt'])!=''){$heure_evt_s = htmlspecialchars($_POST['heure_evt']);}
				if(isset($_POST['date_lim']) AND htmlspecialchars($_POST['date_lim'])!=''){$date_lim_s = date('Y-m-d', strtotime(htmlspecialchars($_POST['date_lim'])));}
				if(isset($_POST['heure_lim']) AND htmlspecialchars($_POST['heure_lim'])!=''){$heure_lim_s = htmlspecialchars($_POST['heure_lim']);}
						
				if(isset($_POST['type']) AND htmlspecialchars($_POST['type'])!='' AND isset($_POST['titre']) AND htmlspecialchars($_POST['titre'])!='' AND isset($date_evt_s) AND isset($heure_evt_s) AND isset($date_lim_s) AND isset($heure_lim_s))
				{	// Formulaire déjà rempli avec les champs obligatoires, on le traite
					if(($date_evt_s>$date_lim_s) OR ($date_evt_s==$date_lim_s AND $heure_evt_s>=$heure_lim_s))
						// Cohérence des dates
					{
							// Gestion des formats de date
						$date_evt = htmlspecialchars($_POST['date_evt']);
						$date_lim = htmlspecialchars($_POST['date_lim']);
						$date_evt_f = date('Y-m-d', strtotime($date_evt));
						$date_lim_f = date('Y-m-d', strtotime($date_lim));
						// Test du format de date
						
						// Récupération de l'id de l'événement en question
						$id_evt_local = htmlspecialchars($_POST['id_evt_local']);
						
						$type = htmlspecialchars($_POST['type']);
						$titre = htmlspecialchars($_POST['titre']);
						$heure_evt = htmlspecialchars($_POST['heure_evt']);
						$heure_lim = htmlspecialchars($_POST['heure_lim']);
						if(empty($_POST['niveau_min'])){$niveau_min="0";}else{$niveau_min=htmlspecialchars($_POST['niveau_min']);}
						if(empty($_POST['lieu'])){$lieu="Mer";}else{$lieu=htmlspecialchars($_POST['lieu']);}
						if(empty($_POST['max_part'])){$max_part="12";}else{$max_part=htmlspecialchars($_POST['max_part']);}
						if(empty($_POST['remarques'])){$remarques=" ";}else{$remarques=htmlspecialchars($_POST['remarques']);}

						include("tools/data_base_connection.php");						
						// Recherche du numéro d'index à affecter
						
						$req2= $bdd->prepare('UPDATE evenements SET type=:type, titre=:titre, date_evt=:date_evt, heure_evt=:heure_evt, date_lim=:date_lim, heure_lim=:heure_lim, niveau_min=:niveau_min, lieu=:lieu,max_part=:max_part, remarques=:remarques, pseudo=:pseudo WHERE id=:id_evt_local');
						$req2->execute(array(
						  'id_evt_local' => $id_evt_local,
						  'type' => $type,
						  'titre' => $titre,
						  'date_evt' => $date_evt_f,
						  'heure_evt' => $heure_evt,
						  'date_lim' => $date_lim_f,
						  'heure_lim' => $heure_lim,
						  'niveau_min' => $niveau_min,
						  'lieu' => $lieu,
						  'max_part' => $max_part,
						  'remarques' => $remarques,
						  'pseudo' => ($_SESSION['nom']." ".$_SESSION['prenom'])));
						$req2->closeCursor(); //requête terminée
						
						// On prépare un mail pour notifier aux participants inscrits que l'événement à été modifié (Si leur préférence est renseignée)
						$objet = "ADK Plongee - ".$titre." / Modification de l'événement";
						$corps = "Bonjour, l'événement ".$type." auquel vous êtes inscrit le ".$date_evt." à été modifié. Votre inscription reste valide mais vérifiez les changements apportés a cet événements : ".CST_add_site;
						
						envoi_mail_modif_evt(CST_Modf_Evt, $id_evt_local, $objet, $corps);
						
						// Message pour dire que le formulaire à été est pris en compte
						?>
						<div class="row center">
							<span class="flow-text" col s12">L'évènement à bien été modifié</span>
						</div>
						<div class="row center">
							<p><a href="liste_evenements.php">Lien vers la liste des sorties</a></p>
						</div>
						<?php										
					}
					else		// Pas de cohérence de date
					{
						// Message pour dire que la date d'inscription doit être inférieure à la date de l'événement
						?>
						<div class="row center">
							<span class="flow-text" col s12"> <b style='color: red;'>La date / heure limite d'inscription limite doit être antiéreure à la date / heure de l'événement</b></span>
						</div>
						<?php
					}
				}
				else
				{	// Formulaire à remplir ou formulaire incomplet : 
					if (isset($_POST['type']) OR isset($_POST['titre']) OR isset($_POST['date_evt']) OR isset($_POST['heure_evt']) OR isset($_POST['date_lim']) OR isset($_POST['heure_lim']))
					{	// Formulaire incomplet
						// Message pour dire que le formulaire est incomplet et à renvoyer
						?>
						<div class="row center">
							<span class="flow-text" col s12"> <b style='color: red;'>Formulaire incomplet, remplissez tous les champs avec un * </b></span>
						</div>
						<?php
					}
					
					// Sinon, on affiche l'événement à modifier et c'est partie
					if(isset($_POST['id_mod']) AND htmlspecialchars($_POST['id_mod'])!='')
					{
						$id_evt = htmlspecialchars($_POST['id_mod']);
						// On va chercher les données de l'événement dans les BDD : 
						include("tools/data_base_connection.php");	
						$result = $bdd->query("SELECT * FROM evenements WHERE id = '$id_evt'");
						$row = $result->fetch();
						$result->closeCursor(); //requête terminée
						
						$type_evt = $row[1];
						$titre = $row[2];
						$date_evt = $row[3];
						$heure_evt = $row[4];
						$date_lim = $row[5];
						$heure_lim = $row[6];
						$niv_min = $row[7];
						$lieu  = $row[8];
						$nb_max_part = $row[9];
						$remarques = $row[10];
												
						// Formulaire vierge
					?> 
						<div class="row center">
							<form class="col s12" action="modif_evt.php" method="post">
								<div class="row center">									
										<div class="input-field col s1">
											<i class="material-icons prefix">add_circle</i>
										</div> 
										<!-- Affichage du type d'événement pré remplie -->
										<div class="input-field col s11">
											<select name="type">
												<?php
												if($type_evt=="Plongée")
												{	?>
													<option value = "Plongée" selected>Plongée</option>
													<option value = "Piscine">Piscine</option>
													<option value = "Théorie">Théorie</option>
													<option value = "Vie du Club">Vie du club</option>
													<option value = "Autre">Autre</option>  <?php
												}
												else if($type_evt=="Piscine")
												{	?>
													<option value = "Plongée">Plongée</option>
													<option value = "Piscine" selected>Piscine</option>
													<option value = "Théorie">Théorie</option>
													<option value = "Vie du Club">Vie du club</option>
													<option value = "Autre">Autre</option>  <?php													
												}	
												else if($type_evt=="Théorie")
												{	?>
													<option value = "Plongée">Plongée</option>
													<option value = "Piscine">Piscine</option>
													<option value = "Théorie" selected>Théorie</option>
													<option value = "Vie du Club">Vie du club</option>
													<option value = "Autre">Autre</option>  <?php													
												}
												else if($type_evt=='Vie du club')
												{	?>
													<option value = "Plongée">Plongée</option>
													<option value = "Piscine">Piscine</option>
													<option value = "Théorie">Théorie</option>
													<option value = "Vie du Club" selected>Vie du club</option>
													<option value = "Autre">Autre</option>  <?php													
												}
												else
												{	?>
													<option value = "Plongée">Plongée</option>
													<option value = "Piscine">Piscine</option>
													<option value = "Théorie">Théorie</option>
													<option value = "Vie du Club">Vie du club</option>
													<option value = "Autre" selected>Autre</option>  <?php													
												}
												?>
											 </select>
											<span class="helper-text">Type d'évènement *</span>	
										</div> 		
								</div>
								<div class="row center">
									<div class="input-field col s12">
										<i class="material-icons prefix">title</i>
										<input id="titre" type="text" class="validate" name="titre" value='<?php echo $titre;?>'>
										<label for="titre">Titre *</label>
									</div>
								</div>
								<div class="row center">
									<div class="input-field col s6">
										<i class="material-icons prefix">date_range</i>
										<input  value="<?php echo date('d-m-Y', strtotime($date_evt));?>" id="date_evt" class="datepicker2" name='date_evt'>					 
										<span class="helper-text">Date *</span>							
									</div>
									<div class="input-field col s6">
										<i class="material-icons prefix">watch</i>
										<input id="heure_evt" type="time" class="validate" name='heure_evt' value="<?php echo $heure_evt;?>">
										<span class="helper-text">Heure *</span>
									</div>
								</div>
								<div class="row center">
									<div class="input-field col s6">
										<i class="material-icons prefix">timer_off</i>
										<input value="<?php echo date('d-m-Y', strtotime($date_lim)); ?>" id="date_lim" class="datepicker2" name='date_lim'> 
										<span class="helper-text">Date limite d'inscription *</span>	
									</div>
									<div class="input-field col s6">
										<i class="material-icons prefix">timer_off</i>
										<input id="heure_lim" type="time" class="validate" name='heure_lim' value="<?php echo $heure_lim;?>">
										<span class="helper-text">Heure limite d'inscription *</span>
									</div>
								</div>
								<div class="row center">
									<div class="input-field col s1">
										<i class="material-icons prefix">flare</i>										
									</div> 
									<div class="input-field col s4">
											<select name="niveau_min">
											<?php
												if($niv_min=="0")
												{	?>
												  <option value = "0" selected>Ouvert à tous</option>
												  <option value = "1">N1</option>
												  <option value = "2">N2</option>
												  <option value = "3">N3</option>		<?php	
												}
												else if($niv_min=="1")
												{	?>
												  <option value = "0">Ouvert à tous</option>
												  <option value = "1" selected>N1</option>
												  <option value = "2">N2</option>
												  <option value = "3">N3</option>		<?php													
												}	
												else if($niv_min=="2")
												{	?>
												  <option value = "0">Ouvert à tous</option>
												  <option value = "1">N1</option>
												  <option value = "2" selected>N2</option>
												  <option value = "3">N3</option>		<?php														
												}
												else
												{	?>
												  <option value = "0">Ouvert à tous</option>
												  <option value = "1">N1</option>
												  <option value = "2">N2</option>
												  <option value = "3" selected>N3</option>		<?php										
												}
												?>
											  <!--<option value = "trimix">Trimix</option>
											  <option value = "Autre">Autre</option>     On supprime cette option car elle ne permet pas de trier sur un chiffre) -->
										   </select>	
										   <span class="helper-text">Niveau mini</span>
									</div>
									<div class="input-field col s1">
										<i class="material-icons prefix">group</i>									
									</div>
									<div class="input-field col s1">
											<select name="max_part">
											<?php
												if($nb_max_part=="12")
												{	?>
												  <option value = "12" selected>12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php	
												}
												else if($nb_max_part=="7")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7" selected>7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}
												else if($nb_max_part=="6")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6" selected>6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}	
												else if($nb_max_part=="99")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99" selected>99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}	
												else if($nb_max_part=="1")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1" selected>1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}	
												else if($nb_max_part=="2")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2" selected>2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}	
												else if($nb_max_part=="3")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3" selected>3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}	
												else if($nb_max_part=="4")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4" selected>4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}	
												else if($nb_max_part=="5")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5" selected>5 </option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}	
												else if($nb_max_part=="8")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8" selected>8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}	
												else if($nb_max_part=="9")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9" selected>9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}
												else if($nb_max_part=="10")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10" selected>10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}
												else if($nb_max_part=="11")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11" selected>11</option>
												  <option value = "13">13</option>
												  <option value = "14">14</option>		<?php													
												}
												else if($nb_max_part=="13")
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13" selected>13</option>
												  <option value = "14">14</option>		<?php													
												}
												else
												{	?>
												  <option value = "12">12</option>
												  <option value = "7">7</option>
												  <option value = "6">6</option>
												  <option value = "99">99</option>
												  <option value = "1">1</option>
												  <option value = "2">2</option>
												  <option value = "3">3</option>
												  <option value = "4">4</option>
												  <option value = "5">5</option>
												  <option value = "8">8</option>
												  <option value = "9">9</option>
												  <option value = "10">10</option>
												  <option value = "11">11</option>
												  <option value = "13">13</option>
												  <option value = "14" selected>14</option>		<?php													
												}
												?>
										   </select>	
											<span class="helper-text">Max</span>									   
									</div>
									<div class="input-field col s1">
										<i class="material-icons prefix">toys</i>									
									</div> 
									<div class="input-field col s4">
											<select name="lieu">
											<?php
												if($lieu=="Mer")
												{	?>
												  <option value = "Mer" selected>Mer</option>
												  <option value = "Piscine">Piscine</option>
												  <option value = "Club">Club</option>
												  <option value = "Locaux_sociaux">Locaux Sociaux</option>
												  <option value = "Autre">Autre</option>		<?php													
												}
												else if($lieu=="Piscine")
												{	?>
												  <option value = "Mer">Mer</option>
												  <option value = "Piscine" selected>Piscine</option>
												  <option value = "Club">Club</option>
												  <option value = "Locaux_sociaux">Locaux Sociaux</option>
												  <option value = "Autre">Autre</option>		<?php	
												}
												else if($lieu=="Club")
												{	?>
												  <option value = "Mer">Mer</option>
												  <option value = "Piscine">Piscine</option>
												  <option value = "Club" selected>Club</option>
												  <option value = "Locaux_sociaux">Locaux Sociaux</option>
												  <option value = "Autre">Autre</option>		<?php	
												}
												else if($lieu=='Locaux_sociaux')
												{	?>
												  <option value = "Mer">Mer</option>
												  <option value = "Piscine">Piscine</option>
												  <option value = "Club">Club</option>
												  <option value = "Locaux_sociaux" selected>Locaux Sociaux</option>
												  <option value = "Autre">Autre</option>		<?php	
												}
												else
												{	?>
												  <option value = "Mer">Mer</option>
												  <option value = "Piscine">Piscine</option>
												  <option value = "Club">Club</option>
												  <option value = "Locaux_sociaux">Locaux Sociaux</option>
												  <option value = "Autre" selected>Autre</option>		<?php												
												} ?>
										   </select>	
											<span class="helper-text">Lieu</span>									   
									</div>
								</div>
								<div class="row center">
									 <div class="input-field col s12">
										<i class="material-icons prefix">event_note</i>
										<input id="remarques" type="text" class="validate" name="remarques" value='<?php echo $remarques?>'>
										<label for="remarques">Remarques</label>
									</div>
								</div>
								<div class="row center">
									<input id="id_evt_local" type='hidden' name='id_evt_local' value=<?php echo $id_evt;?>> 										
									<button class="btn waves-effect waves-light blue darken-4" type="submit" name="submit">Modifier l'évènement</button> 
								</div>
							</form>
						</div> <?php
					}
				
				} ?>
            
        </div>
  	</div>
  </div>
  <?php		// Fin de la partie acessible aux membres en règle
	}
}
else	// Pas loggé
{
	include("tools/navbar.php"); 

	?>
	<div class="row center">
	<span class="flow-text" col s12"> <b style='color: red;'>Vous n'avez pas accès à cette page, il vaut avoir un compte validé pour y avoir accès</b></span>
	</div>
	<?php
}
?>
	<?php include("tools/footer.php"); ?>
	<!--  Scripts-->
    <?php include("tools/scripts.php"); ?>


</body>


</html>