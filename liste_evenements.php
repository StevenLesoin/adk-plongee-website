<?php
// On démarre la session AVANT d'écrire du code HTML
session_start()
?>

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
<?php include("tools/data_evts.php"); ?>
<?php include("tools/fonctions_unitaires.php"); ?>
<?php date_default_timezone_set('Europe/Paris'); ?>

<?php
		$date_limi_passee = 0; 	// test pour savoir si on autorise les inscriptions
		$date_passee = 0; 		// test pour savoir si on autorise les inscriptions
		if(isset($_SESSION['pseudo'])) // Si déjà connecté
		{
			// Traitement des inscriptions, désinscriptions (Les liens vers les plongées sont faites dans le formulaire)
			if(isset($_POST['id_evt']) AND $_POST['id_evt']!='')
			{	// Clic sur un des boutons, on va récupérer le numéro ID de l'événement pour inscrire le mec dont la session est active
				include("tools/data_base_connection.php");						
				if($_POST['act']=="D")
				{
					$req2= $bdd->prepare('DELETE FROM inscriptions WHERE id_evt=:id_evt AND id_membre=:id_membre');	// On supprime l'inscription du gus
					$req2->execute(array(
					  'id_evt' => $_POST['id_evt'],
					  'id_membre' => $_SESSION['id']));			
				}
				else
				{
					$time_inscr = new DateTime();
					$req2= $bdd->prepare('INSERT INTO inscriptions(id_evt, id_membre, commentaire) VALUES(:id_evt, :id_membre, :commentaire)');
					$req2->execute(array(
					  'id_evt' => $_POST['id_evt'],
					  'id_membre' => $_SESSION['id'],
					  'commentaire' => ""));						  
				}  
				$req2->closeCursor(); //requête terminée
			}	
		}
?>

<!--	Affichage des plongées  -->

  <div class="section no-pad-bot" id="index-banner">
  	<div class="container">
    	<br><br>
        <div class="row center">
            <span class="flow-text" col s12">Liste des évènements ADK :</span>
        </div>
		<div class="row center">
		<?php if(isset($_SESSION['pseudo'])) // Si connecté, on propose d'ajouter une plongée, sinon, on ne montre pas le lien
		{?>
		<div class="row center">
            <p><a href="creation_evt.php">Lien pour créer un événement</a></p>
        </div>
			<?php
			// affichage d'un message si le certificat medical n'est pas perimé
			isPasMalade();
			
		}?>
		<div class="row center">
		<?php
			// Consultation de la base de données pour affichage
			include("tools/data_base_connection.php");
			
			// Si un bouton de filtrage d'affichage des dates à été cliqué, on adapte la récupération de la BDD
			if(isset($_POST['semaine']))
			{
				$req1= $bdd->prepare('SELECT * FROM evenements WHERE date_evt>=(CURDATE() + INTERVAL -7 DAY) ORDER BY date_evt ASC');
			}
			else if(isset($_POST['mois']))
			{
				$req1= $bdd->prepare('SELECT * FROM evenements WHERE date_evt>=(CURDATE() + INTERVAL -31 DAY) ORDER BY date_evt ASC');
			}
			else if(isset($_POST['annee']))
			{
				$req1= $bdd->prepare('SELECT * FROM evenements WHERE date_evt>=(CURDATE() + INTERVAL -365 DAY) ORDER BY date_evt ASC');
			}
			else if(isset($_POST['full']))			
			{
				$req1= $bdd->prepare('SELECT * FROM evenements ORDER BY date_evt ASC');
			}
			else	// Affichage par défaut à l'arrivée sur la page -> Evénements futurs ou à la date du jour
			{
				$req1= $bdd->prepare('SELECT * FROM evenements WHERE date_evt>=CURDATE() ORDER BY date_evt ASC'); 
			}
			// Requette commune peu importe ce qui à été demandé
			$req1->execute(array());			
			
			// Mise ne place de la trame du tableau
			?>
			<table class="striped responsive-table">
				<thead>
				  <tr>
					  <th>Titre <u>(Lien vers sortie)</u></th>
					  <th>Type</th>
					  <th>Date </br></th>
					  <th>Date Limite </br></th>
					  <th>Niv</th>
					  <th>Lieu</th>
					  <th>Remarques</th>
					  <th>Inscrits</th>
					  <th>Inscription</th>
				  </tr>
				</thead>
				<tbody>
			<?php
			$test_passage = 0;
			while ($resultat = $req1->fetch())
			{
				$test_passage = 1;
				$date_limi_passee = 0;
				$date_passee = 0;
				// On rempli le tableau avec les différentes lignes
				?>
				
					<tr>
						<td>
							<?php
							if(isset($_SESSION['pseudo'])) // Si connecté, on affiche les boutons d'ajout et de suppression d'inscription
							{?>
								<form action="affichage_evt.php" method="post">
									<input type='hidden' name='id_evt' value='<?php echo $resultat['id'];?>'>
									<button class="btn waves-effect waves-light 
									<?php 
									if($resultat['type']=="Plongée")
									{
										if(isDP($resultat['id'])==0 AND isEnough($resultat['id'])==0){echo "brown";}
										else if(isDP($resultat['id'])==0 AND isEnough($resultat['id'])==1){echo "purple";}
										else if(isDP($resultat['id'])==1 AND isEnough($resultat['id'])==0){echo "grey";}
										else if(isDP($resultat['id'])==1 AND isEnough($resultat['id'])==1 AND isFull($resultat['id'],$resultat['max_part'])==0){echo "green";}
										else if(isDP($resultat['id'])==1 AND isEnough($resultat['id'])==1 AND isFull($resultat['id'],$resultat['max_part'])==1){echo "orange";}
										else if(isDP($resultat['id'])==0 AND isFull($resultat['id'],$resultat['max_part'])==1){echo "red";}
										else{echo "grey";}
									}
									// Pour une plongée piscine, on vérifie qu'il y ait un DP piscine
									else if($resultat['type']=="Piscine")
									{
										if(isDP_piscine($resultat['id'])==0){echo "purple";}
										else{echo "green";}
									}
									else 
									{echo "blue";} ?>
											
									darken-2" type="submit" name="submit"><?php if(strlen($resultat['titre'])>30){echo substr($resultat['titre'],0,27).'...';} else {echo $resultat['titre'];}?></button>
								</form>
							<?php
							}
							else
							{ 
								if(strlen($resultat['titre'])>20)
								{echo '<label>'.substr($resultat['titre'],0,17).'...</label>';} 
								else {echo '<label>'.$resultat['titre'].'</label>';}
							}		// Affichage du titre de la sortie sans lien pour consulter en détail 
							?>							
						</td>
						<td>
							<label> <?php echo $resultat['type']?></label>
						</td>
						<td>
							<?php
							$datenow = date("Y-m-d");
							$heurenow = date("H:i:s");
							if($resultat['date_evt']<$datenow OR ($resultat['date_evt']==$datenow AND $resultat['heure_evt']<$heurenow))			
							{
								$date_passee = 1;
							}
							?>
							<label><?php echo date("D-d/m", strtotime($resultat['date_evt']))."<br>".substr ($resultat['heure_evt'],0,5)?></label>						
						</td>
						<td>
						<?php
							$datenow = date("Y-m-d");
							$heurenow = date("H:i:s");
							if($resultat['date_lim']<$datenow OR ($resultat['date_lim']==$datenow AND $resultat['heure_lim']<$heurenow))			
							{?>
								<label><b style='color: red;'><?php echo date("D-d/m", strtotime($resultat['date_lim']))."<br>".substr ($resultat['heure_lim'],0,5)?></b></label><?php
								$date_limi_passee = 1;
							}
							else
							{?>	
								<label><?php echo date("D-d/m", strtotime($resultat['date_lim']))."<br>".substr ($resultat['heure_lim'],0,5)?></label>	<?php 
							}?>							
						</td>
						<td>
							<label><?php echo "N".$resultat['niveau_min']?></label>							
						</td>
						<td>
							<label><?php 
								if(strlen($resultat['lieu'])>7)
								{echo substr($resultat['lieu'],0,7).'.';}
								else 
									echo $resultat['lieu'];
							?></label>						
						</td>
						<td>
							<label><?php 
								if(strlen($resultat['remarques'])>35)
								{echo substr($resultat['remarques'],0,32).'...';}
								else 
									echo $resultat['remarques'];
							?></label>						
						</td>
							<!-- Formulaire pour faire l'inscription ou la désincription en passant l'ID de la plongée en paramètre-->
							<form action="liste_evenements.php" method="post">
						<?php	
								// On va lire si des inscriptions sont enregistrées dans la table "inscription" pour pouvoir afficher si le membre est inscrit ou non
								$req2= $bdd->prepare('SELECT * FROM inscriptions WHERE id_evt="'.$resultat['id'].'"'); 
								$req2->execute(array());
								$req4= $bdd->prepare('SELECT * FROM invites WHERE id_evt="'.$resultat['id'].'"'); // On va chercher dans la liste d'inscription, les id des personnes inscrites
								$req4->execute(array());
								$deja_inscrit=0;
								$nb_part=0;
								while ($inscrit = $req2->fetch())		// Dans la table des membres
								{
									if(isset($_SESSION['pseudo'])) // Si connecté, on propose d'afficher une possibilité d'inscription, sinon, on ne montre pas le lien
									{
										if($inscrit[1]==$_SESSION['id'])	// Est ce que la ligne récupéré correspond à l'inscription du membre connecté
										{
											$deja_inscrit=1;
										}
									}
									$nb_part++;
								}
								while ($inscrit_invit = $req4->fetch())		// Dans la table des invités, on vient aussi les compter
								{$nb_part++;}
								// On affiche le nombre de participants ?>
						<td style="text-align:center"><?php
								echo "<label>".($nb_part."/".$resultat['max_part']."</label>");
								if($deja_inscrit==1) { echo "<br><label>Dont vous</label>";}		// Pour lever l'ambiguité de savoir si en cliquant sur le bouon il s'inscrit ou se désinscrit
								?>
						</td>	
						<td style="text-align:center">
						<?php
							// On rentre la valeur de l'ID de la plongée en cours d'affichage pour le formulaire de la ligne		
								if(isset($_SESSION['pseudo'])AND ($_SESSION['inscription_valide']==1) AND ($_SESSION['actif_saison']==1)) // Si connecté, actif pour la saison et validé, on affiche les boutons d'ajout et de suppression d'inscription
								{
									if($_SESSION['niv_plongeur']>=$resultat['niveau_min']) // Si le mec à le niveau nécessaire, on lui propose de s'incrire, sinon, non
									{
										?><input type='hidden' name='id_evt' value='<?php echo $resultat['id'];?>'> <?php
										if(($deja_inscrit==1))  		// Si la personne est déjà inscrite à la sortie, on lui offre la possibilité de se désinscrire
										{
											?>
											<input type="hidden" name="act" value = "D">
											<?php 
											if($date_passee == 0) // Si la date de l'événement n'est pas passé, on lui affiche un bouton pour s'inscrire
											{ ?>
												<button class="btn waves-effect waves-light red darken-2" type="submit" name="submit"><i class="material-icons">cancel</i></button>			<?php									
											}
											else		// Sinon, on lui empêche de se désinscrire après la date de la sortie
											{ ?>
												<button class="btn disabled"><i class="material-icons">cancel</i></button> <?php
											}
										}		// Sinon de s'inscrire
										else
										{
											if(($date_limi_passee == 1) OR ($date_passee == 1))		// Si la date lmite d'inscription est passée, on grise la case
											{
												?>
												<button class="btn disabled"><i class="material-icons">check_circle</i></button><?php
												$date_limi_passee = 0;
											}	
											else				// On autorise l'inscription
											{?>
												<input type="hidden" name="act" value = "I">
												<button class="btn waves-effect waves-light green darken-2" type="submit" name="submit"><i class="material-icons">check_circle</i></button>
											<?php 
											}
										} 
									}
									else
									{
										?>
										<button class="btn disabled"><?php echo "<b style='color: red;'>N".$resultat['niveau_min']." min</b>";?></button>
										<?php
									}
								}
								$req2->closeCursor(); //requête terminée
								?>
							</form>
						</td>
					</tr>
			<?php
			}?>
				</tbody>
			</table>
		</div>
		<?php
			if($test_passage==0)
			{	// Pas de sorties à afficher?>
			    <tr>
					<span class="flow-text" col s12">Hoooooooo, il n'y a pas de sorties pour l'instant. Je sais... moi aussi j'ai envie de pleurer.</span>
				</tr>
			
				<?php
			}
			$req1->closeCursor(); //requête terminée
		?>	
		<div class="row center">
            <span> Legende des couleurs : </span> <span style='color: blue;'>Pas d'exigences</span> / <span style='color: brown;'>Pas de DP et pas assez de monde</span> / <span style='color: purple;'>Pas de DP mais assez de monde</span> / <span style='color: grey;'>Un DP, pas assez de monde</span> / <span style='color: green;'>Un DP et assez de monde</span> / <span style='color: orange;'>Sortie complète</span> / <span style='color: red;'>Sortie complète mais sans DP</span>
        </div>
		<div class="row center">
            <span class="flow-text" col s12">Affichage des événements antiérieurs:</span>
        </div>
		<div class="row center">
			<div class="input-field col s3">
				<form action="liste_evenements.php" method="post">
					<input type='hidden' name='semaine' value='semaine'> 		
					<button class="btn waves-effect waves-light blue darken-2" type="submit" name="submit">Semaine</button>
				</form>	
			</div>
			<div class="input-field col s3">
				<form action="liste_evenements.php" method="post">
					<input type='hidden' name='mois' value='mois'> 		
					<button class="btn waves-effect waves-light blue darken-2" type="submit" name="submit">Mois</button>
				</form>
			</div>
			<div class="input-field col s3">
				<form action="liste_evenements.php" method="post">
					<input type='hidden' name='annee' value='annee'> 		
					<button class="btn waves-effect waves-light blue darken-2" type="submit" name="submit">Année</button>
				</form>
			</div>
			<div class="input-field col s3">
				<form action="liste_evenements.php" method="post">
					<input type='hidden' name='full' value='full'> 		
					<button class="btn waves-effect waves-light blue darken-2" type="submit" name="submit">Tout</button>
				</form>
			</div>
        </div>


	</div>
	</div>


	<?php include("tools/footer.php"); ?>
	<!--  Scripts-->
    <?php include("tools/scripts.php"); ?>

</body>

</html>

