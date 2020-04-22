<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Liste évènements</title>

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

<?php
		// Traitement des inscriptions, désinscriptions (Les liens vers les plongées sont faites dans le formulaire)
?>

<!--	Affichage des plongées  -->
  <div class="section no-pad-bot" id="index-banner">
  	<div class="container">
    	<br><br>
        <div class="row center">
            <span class="flow-text" col s12">Liste des évènements ADK :</span>
        </div>
		<div class="row center">
		<?php
			// Consultation de la base de données pour affichage
			include("tools/data_base_connection.php");
							
			$req1= $bdd->prepare('SELECT * FROM evenements'); // WHERE date_evt>NOW() ORDER BY date_evt');
			$req1->execute(array());
			
			// Mise ne place de la trame du tableau
			?>
			<div class="row center">
				<div class="input-field col s1">
					<label>Type</label>							
				</div>
				<div class="input-field col s2">
					<label>Titre <u>(Lien vers sortie)</u></label>
				</div>
				<div class="input-field col s1">
					<label>Date</label>							
				</div>
				<div class="input-field col s1">
					<label>Heure</label>
				</div>
				<div class="input-field col s1">
					<label>Date Limite</label>							
				</div>
				<div class="input-field col s1">
					<label>Heure Limite</label>
				</div>
				<div class="input-field col s1">
					<label>Niveau Mini</label>							
				</div>
				<div class="input-field col s1">
					<label>Lieu</label>
				</div>
				<div class="input-field col s2">
					<label>Remarques</label>
				</div>
				<div class="input-field col s1">
					<label>Inscription</label>
				</div>
			</div>
			
			<?php
			while ($resultat = $req1->fetch())
			{
				// On rempli le tableau avec les différentes lignes
				?>
				<div class="row center">
					<div class="input-field col s1">
						<label><?php echo $resultat['type']?></label>							
					</div>
					<div class="input-field col s2">
						<label><u><?php 
							if(strlen($resultat['titre'])>20)
							{echo substr($resultat['titre'],0,17).'...';}
							else 
								echo $resultat['titre'];
						?></u></label>							
					</div>
					<div class="input-field col s1">
						<label><?php echo date("D", strtotime($resultat['date_evt']))."<br>".$resultat['date_evt']?></label>							
					</div>
					<div class="input-field col s1">
						<label><?php echo $resultat['heure_evt']?></label>							
					</div>
					<div class="input-field col s1">
						<label><?php echo date("D", strtotime($resultat['date_lim']))."<br>".$resultat['date_lim']?></label>							
					</div>
					<div class="input-field col s1">
						<label><?php echo $resultat['heure_lim']?></label>							
					</div>
					<div class="input-field col s1">
						<label><?php echo $resultat['niveau_min']?></label>							
					</div>
					<div class="input-field col s1">
						<label><?php echo $resultat['lieu']?></label>						
					</div>
					<div class="input-field col s2">
						<label><?php 
							if(strlen($resultat['remarques'])>20)
							{echo substr($resultat['remarques'],0,17).'...';}
							else 
								echo $resultat['remarques'];
						?></label>						
					</div>
					<div class="input-field col s1">
					<?php	
							// On va lire si des inscriptions sont enregistrées dans la table "inscription" pour pouvoir afficher si le membre est inscrit ou non
							$req2= $bdd->prepare('SELECT * FROM inscriptions WHERE id_evt="'.$resultat['id'].'"'); // ### 1 a remplacer par l'ID du mec Loggé
							$req2->execute(array());
							$deja_inscrit=0;
							while ($inscrit = $req2->fetch())
							{
								if($inscrit[1]==1)	// ### 1 à remplacer par l'ID du mec connecté
								{
									$deja_inscrit=1;
								}
							}
							if($deja_inscrit==1)  		// Si la personne est déjà inscrite à la sortie, on lui offre la possibilité de se désinscrire
							{	// ### Mettre une popup pour valider la désincription sur action de clic
								?>
								<a href="https://www.facebook.com/"><i class="material-icons prefix">cancel</i></a>
								
								
							<?php }		// Sinon de s'inscrire
								// ### Mettre une pop up pour valider l'inscription sur action de clic
							else{?> <a href="https://www.facebook.com/"><i class="material-icons prefix">check_circle</i></a><?php } ?>
					</div>
				</div>
			<?php
			}
			$req1->closeCursor(); //requête terminée
		?>	


		
		</div>
    </div>
  </div>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/initi.js"></script>

</body>

