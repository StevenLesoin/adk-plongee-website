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
			<div class="row center">
				<div class="input-field col s1">
					<label>Type</label>							
				</div>
				<div class="input-field col s2">
					<label>Titre <u>(Lien vers sortie)</u></label>
				</div>
				<div class="input-field col s2">
					<label>Date</label>							
				</div>
				<div class="input-field col s2">
					<label>Date Limite</label>							
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
			$test_passage = 0;
			while ($resultat = $req1->fetch())
			{
				$test_passage = 1;
				// On rempli le tableau avec les différentes lignes
				?>
				<div class="row center">
					<div class="input-field col s1">
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
					</div>
					<div class="input-field col s2">
						<?php
						if(isset($_SESSION['pseudo'])) // Si connecté, on affiche les boutons d'ajout et de suppression d'inscription
						{?>
							<form action="affichage_evt.php" method="post">
								<input type='hidden' name='id_evt' value='<?php echo $resultat['id'];?>'>
								<label><input name="submit" type="submit" style="border: none ; background-color: transparent;" value="<?php if(strlen($resultat['titre'])>20){echo substr($resultat['titre'],0,17).'...';} else {echo $resultat['titre'];}?>"/></label>
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
					</div>
					<div class="input-field col s2">
						<label><?php echo date("D-d/m/Y", strtotime($resultat['date_evt']))."<br>".$resultat['heure_evt']?></label>							
					</div>
					<div class="input-field col s2">
						<label><?php echo date("D-d/m/Y", strtotime($resultat['date_lim']))."<br>".$resultat['heure_lim']?></label>							
					</div>
					<div class="input-field col s1">
						<label><?php echo "N".$resultat['niveau_min']?></label>							
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
							// On affiche le nombre de participants
							echo "<label>".($nb_part."/".$resultat['max_part']."</label>");
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
										<button class="waves-effect waves-teal btn-flat" type="submit" name="submit"><a><i class="material-icons">cancel</i></a></button>
									<?php }		// Sinon de s'inscrire
									else{
										?> 
										<input type="hidden" name="act" value = "I">
										<button class="waves-effect waves-teal btn-flat" type="submit" name="submit"><a><i class="material-icons">check_circle</i></a></button>
										<?php } 
								}
								else
								{
									echo "<br><label><b style='color: red;'>N".$resultat['niveau_min']." mini</b></label>";
								}
							}
							$req2->closeCursor(); //requête terminée
							?>
						</form>
					</div>
				</div>
			<?php
			}
			if($test_passage==0)
			{	// Pas de sorties à afficher?>
			    <div class="row center">
					<span class="flow-text" col s12">Hoooooooo, il n'y a pas de sorties pour l'instant. Je sais... moi aussi j'ai envie de pleurer.</span>
				</div>
			
				<?php
			}
			$req1->closeCursor(); //requête terminée
		?>	
		<div class="row center">
            <span> Legende des couleurs : </span> <span style='color: grey;'>Pas d'exigences</span> / <span style='color: brown;'>Pas de DP et pas assez de monde</span> / <span style='color: purple;'>Pas de DP mais assez de monde</span> / <span style='color: blue;'>Un DP, pas assez de monde</span> / <span style='color: green;'>Un DP et assez de monde</span> / <span style='color: orange;'>Sortie complète</span> / <span style='color: red;'>Sortie complète mais sans DP</span>
        </div>


		
		</div>
    </div>
  </div>

	<?php include("tools/footer.php"); ?>
	<!--  Scripts-->
    <?php include("tools/scripts.php"); ?>

</body>

</html>

