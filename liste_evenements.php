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


<?php $date_limi_passee = 0; 		// test pour savoir si on autorise les inscriptions?>

<?php include("tools/navbar.php"); ?>
<?php include("tools/data_evts.php"); ?>
<?php date_default_timezone_set('Europe/Paris'); ?>

<?php
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
					  'id_membre' => $_SESSION['id']));				// ### A changer par l'ID de la session active   
				}
				else
				{
					$time_inscr = new DateTime();
					$req2= $bdd->prepare('INSERT INTO inscriptions(id_evt, id_membre, commentaire) VALUES(:id_evt, :id_membre, :commentaire)');
					$req2->execute(array(
					  'id_evt' => $_POST['id_evt'],
					  'id_membre' => $_SESSION['id'],
					  'commentaire' => " "));				// ### A changer par l'ID de la session active				  
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
		<?php if(isset($_SESSION['pseudo'])) // Si connecté, on propose d'ajouter une plongée, sinon, on ne montre pas le lien
		{?>
		<div class="row center">
            <p><a href="creation_evt.php">Lien pour créer un événement</a></p>
        </div>
			<?php
			// Determination de la date d'il y a un an
			$yaunan = strtotime('-1 year -1 day');		// timestamp d'il y a un an	
			$yaunanmoinsunmois = strtotime('-1 month');
			if(strtotime($_SESSION['certif_med'])<$yaunan)		// Si le gars est pas à jour de certif médical, on lui affiche une message énorme en rouge sur les inscriptions
			{?>
				<div class="row center">
					<span class="flow-text" col s12"><b style='color: red;'>Attention, votre certificat médical n'est pas à jour !!</b></span>
				</div>
			<?php
			}
			else if(strtotime($_SESSION['certif_med'])<$yaunanmoinsunmois)
			{?>
				<div class="row center">
					<span class="flow-text" col s12"><b style='color: orange;'>Attention, votre certificat médical expire le <?php echo date("D-d/m/Y",strtotime('+1 year',strtotime($_SESSION['certif_med'])))?></b></span>
				</div>
			<?php
			}
		}?>
		<div class="row center">
		<?php
			// Consultation de la base de données pour affichage
			include("tools/data_base_connection.php");
							
			$req1= $bdd->prepare('SELECT * FROM evenements ORDER BY date_evt ASC'); // ## a mettre en place WHERE date_evt>NOW() ORDER BY date_evt');
			$req1->execute(array());
			
			// Mise ne place de la trame du tableau
			?>
			<table class="striped">
				<thead>
				  <tr>
					  <th>Type</th>
					  <th>Titre <u>(Lien vers sortie)</u></th>
					  <th>Date</th>
					  <th>Date Limite</th>
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
				// On rempli le tableau avec les différentes lignes
				?>
				
					<tr>
						<td>
							<?php
							// Pour une plongée, on vérifie qu'il y ait un DP et un minimum d'inscrits
							// ### Faire un différence entre plongée du bord (pas de mini) et plongée bateau
							if($resultat['type']=="Plongée")
							{
								if(isDP($resultat['id'])==0 AND isEnough($resultat['id'])==0){echo ("<label style='color: brown'>".$resultat['type']."</label>");}
								else if(isDP($resultat['id'])==0 AND isEnough($resultat['id'])==1){echo ("<label style='color: purple'>".$resultat['type']."</label>");}
								else if(isDP($resultat['id'])==1 AND isEnough($resultat['id'])==0){echo ("<label style='color: blue'>".$resultat['type']."</label>");}
								else if(isDP($resultat['id'])==1 AND isEnough($resultat['id'])==1 AND isFull($resultat['id'],$resultat['max_part'])==0){echo ("<label style='color: green'>".$resultat['type']."</label>");}
								else if(isDP($resultat['id'])==1 AND isEnough($resultat['id'])==1 AND isFull($resultat['id'],$resultat['max_part'])==1){echo ("<label style='color: orange'>".$resultat['type']."</label>");}
								else if(isDP($resultat['id'])==0 AND isFull($resultat['id'],$resultat['max_part'])==1){echo ("<label style='color: red'>".$resultat['type']."</label>");}
								else{echo ("<label style='color: grey'>".$resultat['type']."</label>");}
							}
							// Pour une plongée piscine, on vérifie qu'il y ait un DP piscine
							else if($resultat['type']=="Piscine")
							{
								if(isDP_piscine($resultat['id'])==0){echo ("<label style='color: purple'>".$resultat['type']."</label>");}
								else{echo ("<label style='color: green'>".$resultat['type']."</label>");}
							}
							else{?>	<label> <?php echo $resultat['type']?></label>	<?php } ?>
						</td>
						<td>
							<?php
							if(isset($_SESSION['pseudo'])) // Si connecté, on affiche les boutons d'ajout et de suppression d'inscription
							{?>
								<form action="affichage_evt.php" method="post">
									<input type='hidden' name='id_evt' value='<?php echo $resultat['id'];?>'>
									<button class="btn waves-effect waves-light blue darken-2" type="submit" name="submit"><?php if(strlen($resultat['titre'])>30){echo substr($resultat['titre'],0,27).'...';} else {echo $resultat['titre'];}?></button>
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
							<label><?php echo date("D-d/m", strtotime($resultat['date_evt']))."<br>".substr ($resultat['heure_evt'],0,5)?></label>						
						</td>
						<td>
						<?php
							$datenow = date("Y-m-d");
							$heurenow = date("H:i:s");
/*							echo $datenow." ";
							echo $heurenow." ";
							echo $resultat['date_lim']." ";
							echo $resultat['heure_lim']." ";
							if($resultat['date_lim']<$datenow){echo "La date foire";}
*/
							if($resultat['date_lim']<$datenow OR ($resultat['date_lim']==$datenow AND $resultat['heure_lim']>$heurenow))
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
								if(isset($_SESSION['pseudo'])) // Si connecté, on affiche les boutons d'ajout et de suppression d'inscription
								{
									if($_SESSION['niv_plongeur']>=$resultat['niveau_min']) // Si le mec à le niveau nécessaire, on lui propose de s'incrire, sinon, non
									{
										?><input type='hidden' name='id_evt' value='<?php echo $resultat['id'];?>'> <?php
										if($deja_inscrit==1)  		// Si la personne est déjà inscrite à la sortie, on lui offre la possibilité de se désinscrire
										{
											?>
											<input type="hidden" name="act" value = "D">
											<button class="btn waves-effect waves-light red darken-2" type="submit" name="submit"><i class="material-icons">cancel</i></button>
										<?php }		// Sinon de s'inscrire
										else
										{
											if($date_limi_passee == 1)		// Si la date lmite d'inscription est passée, on grise la case
											{
												?><button class="btn disabled"><i class="material-icons">check_circle</i></button><?php
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
            <span> Legende des couleurs : </span> <span style='color: grey;'>Pas d'exigences</span> / <span style='color: brown;'>Pas de DP et pas assez de monde</span> / <span style='color: purple;'>Pas de DP mais assez de monde</span> / <span style='color: blue;'>Un DP, pas assez de monde</span> / <span style='color: green;'>Un DP et assez de monde</span> / <span style='color: orange;'>Sortie complète</span> / <span style='color: red;'>Sortie complète mais sans DP</span>
        </div>


	</div>
	</div>


	<?php include("tools/footer.php"); ?>
	<!--  Scripts-->
    <?php include("tools/scripts.php"); ?>

</body>

</html>

