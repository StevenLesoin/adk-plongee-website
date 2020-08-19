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
            <span class="flow-text" col s12">Création d'un nouvel évènement ADK :</span>
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
					{
						// Cohérence de date OK
						$date_evt = htmlspecialchars($_POST['date_evt']);
						$date_lim = htmlspecialchars($_POST['date_lim']);
						$date_evt_f = date('Y-m-d', strtotime($date_evt));
						$date_lim_f = date('Y-m-d', strtotime($date_lim));
						// Test du format de date
						
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
						$result = $bdd->query("SELECT MAX(id) FROM evenements");
						$row = $result->fetch();
						$req1 = $row[0];
						$id = ++$req1;
						
						$req2= $bdd->prepare('INSERT INTO evenements(id, type, titre, date_evt, heure_evt, date_lim, heure_lim, niveau_min, lieu,max_part, remarques, pseudo, date_publi) VALUES(:id, :type, :titre, :date_evt, :heure_evt, :date_lim, :heure_lim, :niveau_min, :lieu, :max_part, :remarques, :pseudo, NOW())');
						$req2->execute(array(
						  'id' => $id,
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

						$result->closeCursor(); //requête terminée
						$req2->closeCursor(); //requête terminée
						
						// Envoi d'un mail pour prévenir de la publication d'un événement club
						$objet = "ADK Plongee - ".$titre;
						$corps = "Bonjour, un nouvel événement ".$type." est ouvert à l'inscritpion à partir du niveau ".$niveau_min.". Rdv à ".$heure_evt." le ".$date_evt.". Retrouvez le sur le site : ".CST_add_site;
						
						envoi_mail_liste(CST_Ajout_Evt, $objet, $corps);
							
						// Message pour dire que le formulaire à été est pris en compte
						?>
						<div class="row center">
							<span class="flow-text" col s12">L'évènement à bien été créé, un mail envoyé aux membres actifs</span>
						</div>

						<div class="row center">
							L'email suivant à été envoyé aux membres actifs : <br>
							<b>Objet :</b> <?php echo $objet; ?> <br>
							<b>Message :</b> <?php echo $corps; ?> <br>
					
						</div>
						<div class="row center">
							<p><a href="liste_evenements.php">Lien vers la liste des sorties</a></p>
						</div>
						<?php
					}
					else
						// Pas de cohérence de date
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
						// Formulaire vierge
					?> 
					<div class="row center">
						<form class="col s12" action="creation_evt.php" method="post">
							<div class="row center">									
									<div class="input-field col s1">
										<i class="material-icons prefix">add_circle</i>
									</div> 
									<div class="input-field col s11">
										<select name="type">
										  <option value = "Plongée">Plongée</option>
										  <option value = "Piscine">Piscine</option>
										  <option value = "Théorie">Théorie</option>
										  <option value = "Vie du Club">Vie du club</option>
										  <option value = "Autre">Autre</option>
									     </select>
										<span class="helper-text">Type d'évènement *</span>	
									</div> 		
							</div>
							<div class="row center">
								<div class="input-field col s12">
									<i class="material-icons prefix">title</i>
									<input id="titre" type="text" class="validate" name="titre">
									<label for="titre">Titre *</label>
								</div>
							</div>
							<div class="row center">
								<div class="input-field col s6">
									<i class="material-icons prefix">date_range</i>
									<input  value="<?php echo date('m-d-Y'); ?>" id="date_evt" class="datepicker3" name='date_evt'>					 
									<span class="helper-text">Date *</span>							
								</div>
								<div class="input-field col s6">
									<i class="material-icons prefix">watch</i>
									<input id="heure_evt" type="time" class="validate" name='heure_evt' value="08:15">
									<span class="helper-text">Heure *</span>
								</div>
							</div>
							<div class="row center">
								<div class="input-field col s6">
									<i class="material-icons prefix">timer_off</i>
									<input value="<?php echo date('d-m-Y'); ?>" id="date_lim" class="datepicker2" name='date_lim'> 
									<span class="helper-text">Date limite d'inscription *</span>	
								</div>
								<div class="input-field col s6">
									<i class="material-icons prefix">timer_off</i>
									<input id="heure_lim" type="time" class="validate" name='heure_lim' value="21:00">
									<span class="helper-text">Heure limite d'inscription *</span>
								</div>
							</div>
							<div class="row center">
								<div class="input-field col s1">
									<i class="material-icons prefix">flare</i>										
								</div> 
								<div class="input-field col s4">
										<select name="niveau_min">
										  <option value = "0">Ouvert à tous</option>
										  <option value = "1">N1</option>
										  <option value = "2">N2</option>
										  <option value = "3">N3</option>
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
										  <option value = "14">14</option>
									   </select>	
										<span class="helper-text">Max</span>									   
								</div>
								<div class="input-field col s1">
									<i class="material-icons prefix">toys</i>									
								</div> 
								<div class="input-field col s4">
										<select name="lieu">
										  <option value = "Mer">Mer</option>
										  <option value = "Piscine">Piscine</option>
										  <option value = "Club">Club</option>
										  <option value = "Locaux_sociaux">Locaux Sociaux</option>
										  <option value = "Autre">Autre</option>
									   </select>	
										<span class="helper-text">Lieu</span>									   
								</div>
							</div>
							<div class="row center">
								 <div class="input-field col s12">
									<i class="material-icons prefix">event_note</i>
									<input id="remarques" type="text" class="validate" name="remarques">
									<label for="remarques">Remarques</label>
								</div>
							</div>
							<div class="row center">
								<button class="btn waves-effect waves-light blue darken-4" type="submit" name="submit">Publier l'évènement</button> 
							</div>
						</form>
					</div>
				<?php
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