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

<?php include("tools/navbar.php"); ?>

<?php
/*$pass_hache = password_hash("LucieCarof1*", PASSWORD_DEFAULT);
echo $pass_hache; */
?>

  <div class="section no-pad-bot" id="index-banner">
  	<div class="container">
    	<br><br>
        <div class="row center">
            <span class="flow-text" col s12">Création d'un nouvel évènement ADK :</span>
        </div>
		
		
		<?php	if(isset($_POST['type']) AND $_POST['type']!='' AND isset($_POST['titre']) AND $_POST['titre']!='' AND isset($_POST['date_evt']) AND $_POST['date_evt']!='' AND isset($_POST['heure_evt']) AND $_POST['heure_evt']!='' AND isset($_POST['date_lim']) AND $_POST['date_lim']!='' AND isset($_POST['heure_lim']) AND $_POST['heure_lim']!='')
				{	// Formulaire déjà rempli avec les champs obligatoires, on le traite
					
					
					include("tools/data_base_connection.php");						
						$result = $bdd->query("SELECT MAX(id) FROM evenements");
						$row = $result->fetch();
						$req1 = $row[0];
						$id = ++$req1;
						
						$req2= $bdd->prepare('INSERT INTO evenements(id, type, titre, date_evt, heure_evt, date_lim, heure_lim, niveau_min, lieu, remarques, pseudo, date_publi) VALUES(:id, :type, :titre, :date_evt, :heure_evt, :date_lim, :heure_lim, :niveau_min, :lieu, :remarques, \'Vide\',\'Vide\')');
						$req2->execute(array(
						  'id' => $id,
						  'type' => $_POST['type'],
						  'titre' => $_POST['titre'],
						  'date_evt' => $_POST['date_evt'],
						  'heure_evt' => $_POST['heure_evt'],
						  'date_lim' => $_POST['date_lim'],
						  'heure_lim' => $_POST['heure_lim'],
						  'niveau_min' => $_POST['niveau_min'],
						  'lieu' => $_POST['lieu'],
						  'remarques' => $_POST['remarques']));

						$req2->closeCursor(); //requête terminée
						
						// Message pour dire que le formulaire à été est pris en compte
						?>
						<div class="row center">
							<span class="flow-text" col s12">L'évènement à bien été créé</span>
						</div>
						<?php
						
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
						<form class="col s12" action="creation_evt3.php" method="post">
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
									<input id="date_evt" type="date" class="validate" name='date_evt'>
									<label for="date_evt">Date *</label>							
								</div>
								<div class="input-field col s6">
									<i class="material-icons prefix">watch</i>
									<input id="heure_evt" type="time" class="validate" name='heure_evt'>
									<label for="heure_evt">Heure *</label>
								</div>
							</div>
							<div class="row center">
								<div class="input-field col s6">
									<i class="material-icons prefix">timer_off</i>
									<input id="date_lim" type="date" class="validate" name='date_lim'>
									<label for="date_lim">Date limite d'inscription *</label>
								</div>
								<div class="input-field col s6">
									<i class="material-icons prefix">timer_off</i>
									<input id="heure_lim" type="time" class="validate" name='heure_lim'>
									<label for="heure_lim">Heure limite d'inscription *</label>
								</div>
							</div>
							<div class="row center">
								<div class="input-field col s1">
									<i class="material-icons prefix">flare</i>										
								</div> 
								<div class="input-field col s5">
										<select class = "browser-default" name="niveau_min">
										  <option value = "N1">Ouvert à tous</option>
										  <option value = "N1">N1</option>
										  <option value = "N2">N2</option>
										  <option value = "N3">N3</option>
										  <option value = "Trimix">Trimix</option>
										  <option value = "Autre">Autre</option>
									   </select>										
								</div>
								<div class="input-field col s1">
									<i class="material-icons prefix">toys</i>									
								</div> 
								<div class="input-field col s5">
										<select class = "browser-default" name="lieu">
										  <option value = "Mer">Mer</option>
										  <option value = "Piscine">Piscine</option>
										  <option value = "Club">Club</option>
										  <option value = "Locaux_sociaux">Locaux Sociaux</option>
										  <option value = "Autre">Autre</option>
									   </select>										
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

  <?php include("tools/footer.php"); ?>

  <!--  Scripts  

  -->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/initi.js"></script>

</body>


</html>