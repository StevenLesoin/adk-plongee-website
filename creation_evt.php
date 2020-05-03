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
   
      <script type = "text/javascript"
         src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>           
		<script>
		 $(document).ready(function() {
			$('select').material_select();
		 });
		 
	  </script>
  
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
		
		<?php	if(isset($_POST['type']) AND htmlspecialchars($_POST['type'])!='' AND isset($_POST['titre']) AND htmlspecialchars($_POST['titre'])!='' AND isset($_POST['date_evt']) AND htmlspecialchars($_POST['date_evt'])!='' AND isset($_POST['heure_evt']) AND htmlspecialchars($_POST['heure_evt'])!='' AND isset($_POST['date_lim']) AND htmlspecialchars($_POST['date_lim'])!='' AND isset($_POST['heure_lim']) AND htmlspecialchars($_POST['heure_lim'])!=''
					AND ((htmlspecialchars($_POST['date_evt'])>htmlspecialchars($_POST['date_lim'])) OR (htmlspecialchars($_POST['date_evt'])==htmlspecialchars($_POST['date_lim']))AND(htmlspecialchars($_POST['heure_evt'])>=htmlspecialchars($_POST['heure_lim']))))
				
				{	// Formulaire déjà rempli avec les champs obligatoires, on le traite

					// Gestion des formats de date
					$date_evt = htmlspecialchars($_POST['date_evt']);
					$date_lim = htmlspecialchars($_POST['date_lim']);

					// Test du format de date
					
//##					if(isValid($date_lim) AND isValid($date_evt))		// Pas de problèmes de date
//##					{
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
						
						// Date courante
						$datecourante = date_create();
						$datecourantes = (string)date_format($datecourante, 'D-d/m/Y H:i:s');
//##						$date_lim_f = date("Y-d-m", strtotime($date_lim));		// Mise au format de la date courante
//##						$date_evt_f = date("Y-d-m", strtotime($date_evt));		// Mise au format de la date courante
						$req2= $bdd->prepare('INSERT INTO evenements(id, type, titre, date_evt, heure_evt, date_lim, heure_lim, niveau_min, lieu,max_part, remarques, pseudo, date_publi) VALUES(:id, :type, :titre, :date_evt, :heure_evt, :date_lim, :heure_lim, :niveau_min, :lieu, :max_part, :remarques, :pseudo, :date_publi)');
						$req2->execute(array(
						  'id' => $id,
						  'type' => $type,
						  'titre' => $titre,
						  'date_evt' => $date_evt,
//##						  'date_evt' => $date_evt_f,
						  'heure_evt' => $heure_evt,
						  'date_lim' => $date_lim,
//##						  'date_lim' => $date_lim_f,
						  'heure_lim' => $heure_lim,
						  'niveau_min' => $niveau_min,
						  'lieu' => $lieu,
						  'max_part' => $max_part,
						  'remarques' => $remarques,
						  'pseudo' => ($_SESSION['nom']." ".$_SESSION['prenom']),
						  'date_publi' => $datecourantes));

						$result->closeCursor(); //requête terminée
						$req2->closeCursor(); //requête terminée
						
						// Message pour dire que le formulaire à été est pris en compte
						?>
						<div class="row center">
							<span class="flow-text" col s12">L'évènement à bien été créé</span>
						</div>
						<div class="row center">
							<p><a href="liste_evenements.php">Lien vers la liste des sorties</a></p>
						</div>
						<?php
//##					}
//##					else	// Problème de date
/*					{
						// Message pour dire que la date rentrée n'est pas au bon format
						?>
						<div class="row center">
							<span class="flow-text" col s12"> <b style='color: red;'>Les dates doivent être rentrées via le calendrier intégré ou en respectant le formalisme jj/mm/aaaa</b></span>
						</div>
						<div class="row center">
							<p><a href="creation_evt.php">Retentes ta chance</a></p>
						</div>
						<?php
					}
*/											
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
					if(isset($_POST['date_evt']) AND htmlspecialchars($_POST['date_evt'])!='' AND isset($_POST['heure_evt']) AND htmlspecialchars($_POST['heure_evt'])!='' AND isset($_POST['date_lim']) AND htmlspecialchars($_POST['date_lim'])!='' AND isset($_POST['heure_lim']) AND htmlspecialchars($_POST['heure_lim'])!=''
					AND((htmlspecialchars($_POST['date_evt'])<htmlspecialchars($_POST['date_lim']))OR((htmlspecialchars($_POST['date_evt'])==htmlspecialchars($_POST['date_lim']))AND(htmlspecialchars($_POST['heure_evt'])<=htmlspecialchars($_POST['heure_lim'])))))
					{
						// Message pour dire que la date d'inscription doit être inférieure à la date de l'événement
						?>
						<div class="row center">
							<span class="flow-text" col s12"> <b style='color: red;'>La date / heure limite d'inscription limite doit être antiéreure à la date / heure de l'événement</b></span>
						</div>
						<?php
					}
					
						// Formulaire vierge
					?> 
					<div class="row center">
						<form class="col s12" action="creation_evt.php" method="post">
							<div class="row center">									
									<div class="col">
										<i class="material-icons prefix">add_circle</i>
									</div> 
									<div class="col s2">
										<label>Type d'évènement *</label>
									</div> 
									<div class="col s11">
										<select class = "browser-default" name="type">
										  <option value = "Plongée">Plongée</option>
										  <option value = "Piscine">Piscine</option>
										  <option value = "Théorie">Théorie</option>
										  <option value = "Vie du Club">Vie du club</option>
										  <option value = "Autre">Autre</option>
									   </select>
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
									<input value="<?php echo date('d-m-Y'); ?>" id="date_evt" class="datepicker" name='date_evt'> 
									<span class="helper-text">Date*</span>							
								</div>
								<div class="input-field col s6">
									<i class="material-icons prefix">watch</i>
									<input id="heure_evt" type="time" class="validate" name='heure_evt'>
									<span class="helper-text">Heure *</span>
								</div>
							</div>
							<div class="row center">
								<div class="input-field col s6">
									<i class="material-icons prefix">timer_off</i>
									<input value="<?php echo date('d-m-Y'); ?>" id="date_lim" class="datepicker" name='date_lim'> 
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
										<select class = "browser-default" name="niveau_min">
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
										<select class = "browser-default" name="max_part">
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
										<select class = "browser-default" name="lieu">
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