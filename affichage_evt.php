<?php
// On démarre la session AVANT d'écrire du code HTML
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Détail d'un évènement</title>
   
  
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    
	<!-- Fonctions de la feuille -->

  
</head>

<body>

<?php include("tools/navbar.php"); ?>
<?php include("tools/data_evts.php"); ?>
<?php include("tools/fonctions_unitaires.php"); ?>
<?php 
	$italic =0;					// Gestion de l'affichage de la liste d'attente 
	$personne_log_inscrite=0; 	// Vérification si le mec connecté est inscrit
	
	$datenow = date("Y-m-d");
	$heurenow = date("H:i:s");
	
	?>

<?php
/*$pass_hache = password_hash("LucieCarof1*", PASSWORD_DEFAULT);
echo $pass_hache; */

if(isset($_SESSION['pseudo'])) // Si déjà connecté
{?>
  <div class="section no-pad-bot" id="index-banner">
  	<div class="container">
    	<br><br>
        <div class="row center">
            <span class="flow-text" col s12">Consultation d'un événement :</span>
        </div>
		<div class="row center">
            <p><a href="liste_evenements.php">Lien vers la liste de tous les événements</a></p>
        </div>
		
		<?php 
		// affichage d'un message si le certificat medical n'est pas perimé
			isPasMalade();
		
		// Traitement des formulaires
		if((isset($_POST['id_evt']) AND htmlspecialchars($_POST['id_evt'])!='')OR(isset($_POST['id_evt_local']) AND htmlspecialchars($_POST['id_evt_local'])!=''))		// Si on vient de cette page ou de la liste des événements
		{	// Récupération des données de la plongée dont l'ID est "$_POST['evt_id']"
		
			include("tools/data_base_connection.php");	

			if((isset($_POST['id_evt']) AND htmlspecialchars($_POST['id_evt'])!=''))	// On vient d'un page extérieure
			{
				$id_evt = htmlspecialchars($_POST['id_evt']);
			}
			else													// On vient de cette même page et on doit ajouter un commentaire ou un invité
			{
				$id_evt = htmlspecialchars($_POST['id_evt_local']);	// On reprend l'id de l'événement
				if(isset($_POST['nom_invit']) AND htmlspecialchars($_POST['nom_invit'])!='' AND isset($_POST['prenom_invit']) AND htmlspecialchars($_POST['prenom_invit'])!='')	// Tous les champs sont remplis pour l'ajout d'un invité
				{
					$datecourante = date_create();
					$datecourantes = (string)date_format($datecourante, 'd-m-Y H:i:s');
					$nom_invit = htmlspecialchars($_POST['nom_invit']);
					$prenom_invit = htmlspecialchars($_POST['prenom_invit']);
					$niveau_invit = htmlspecialchars($_POST['niveau_invit']);
					$comm_invit = "Invité par ".$_SESSION['nom']." ".$_SESSION['prenom']." à ".$datecourantes." : ".htmlspecialchars($_POST['comm_invit']);					// Ajouter le nom de la personne qui inscrit
					$time_inscr = new DateTime();
					$req2= $bdd->prepare('INSERT INTO invites(id_evt, nom, prenom, niveau, commentaire) VALUES(:id_evt, :nom, :prenom, :niveau, :commentaire)');
					$req2->execute(array(
					  'id_evt' => $_POST['id_evt_local'],
					  'nom' => $nom_invit,
					  'prenom' => $prenom_invit,
					  'niveau' => $niveau_invit,
					  'commentaire' => $comm_invit));				
				}
				if(isset($_POST['comm_plong']) AND htmlspecialchars($_POST['comm_plong'])!='')			// Il y a un commentaire (En plus de l'inscription d'un membre, on autorise)
				{
					$comm_plong = htmlspecialchars($_POST['comm_plong']);
						// On va lire "inscription" pour pouvoir ajouter un commentaire (On écrase le précédent)
						$req2= $bdd->prepare('UPDATE inscriptions SET commentaire =:commentaire WHERE (id_evt =:id_evt AND id_membre =:session_id)'); // 
						$req2->execute(array(
						'commentaire' => $comm_plong,
						'id_evt' => $id_evt,
						'session_id' => $_SESSION['id']));
						$req2->closeCursor(); //requête terminée
					
				}
				if($_SESSION['privilege']=="administrateur" OR $_SESSION['privilege']=="bureau")		// On autorise la suppression
				{
					if(isset($_POST['id_inscrit']) AND htmlspecialchars($_POST['id_inscrit'])!='')			// On demande de supprimer un membre
					{
						$id_inscrit = htmlspecialchars($_POST['id_inscrit']);
							// On va lire "inscription" pour supprimer le mec en question
							$req2= $bdd->query('DELETE FROM inscriptions WHERE (id_evt ="'.$id_evt.'" AND id_membre = "'.$id_inscrit.'")'); // 	Suppression de l'inscrit club
							$req2->closeCursor(); //requête terminée
					}
					if(isset($_POST['prenom']) AND htmlspecialchars($_POST['prenom'])!='')					// On demande de supprimer un invité
					{
						$prenom = htmlspecialchars($_POST['prenom']);
						$nom = htmlspecialchars($_POST['nom']);
							// On va lire "invités" pour supprimer le mec en question
							$req2= $bdd->query('DELETE FROM invites WHERE (id_evt ="'.$id_evt.'" AND prenom = "'.$prenom.'" AND nom = "'.$nom.'")'); // 	Suppression de l'inscrit club
							$req2->closeCursor(); //requête terminée
					}
				}	
				// Gestion de l'inscription du membre loggé sur cette page
				if(isset($_POST['desinscription']) AND htmlspecialchars($_POST['desinscription'])!='')			// On demande de supprimer un membre
				{
					// On va lire "inscription" pour supprimer le mec en question
					$req2= $bdd->query('DELETE FROM inscriptions WHERE (id_evt ="'.$id_evt.'" AND id_membre = "'.$_SESSION['id'].'")'); // 	Suppression de l'inscrit club
					$req2->closeCursor(); //requête terminée
				}
				if(isset($_POST['inscription']) AND htmlspecialchars($_POST['inscription'])!='')			// On ajoute le mec
				{						
					$time_inscr = new DateTime();
					$req2= $bdd->prepare('INSERT INTO inscriptions(id_evt, id_membre, commentaire) VALUES(:id_evt, :id_membre, :commentaire)');
					$req2->execute(array(
				  'id_evt' => $id_evt,
				  'id_membre' => $_SESSION['id'],
				  'commentaire' => ""));	
					$req2->closeCursor(); //requête terminée					  	
				}				
			}				
			$result = $bdd->query("SELECT * FROM evenements WHERE id = '$id_evt'");
			$row = $result->fetch();
			$result->closeCursor(); //requête terminée
			
			$type_evt = $row[1];
			$publicateur = $row[11];
			$date_publi = $row[12];
			$nb_max_part = $row[9];
			$niv_min = $row[7];
			$date_lim_inscr = $row[5];
			$heure_lim_inscr = $row[6];
			?>	
			<div class="card-panel blue darken-4" align=center> 
				<font size="5pt">
					<?php
					//On affiche le staut actuel de la sortie : 
					if($type_evt=="Plongée")
					{
						if(isDP($id_evt)==0 AND isEnough($id_evt)==0){echo ("<p style='color: white'>Pour le moment : Pas assez de participants / Pas de DP <br> <b><u>Sortie non assurée</u></b></p>");}
						elseif(isDP($id_evt)==0 AND isEnough($id_evt)==1){echo ("<p style='color: white'>Pour le moment : Assez de participants / Pas de DP <br> <b><u>Sortie non assurée</u></b></p>");}
						elseif(isDP($id_evt)==1 AND isEnough($id_evt)==0){echo ("<p style='color: white'>Pour le moment : Pas assez de participants / DP inscrit <br> <b><u>Sortie non assurée</u></b></p>");}
						elseif(isDP($id_evt)==1 AND isEnough($id_evt)==1 AND isFull($id_evt,$nb_max_part)==0){echo ("<p style='color: white'>Pour le moment : Assez de participants / DP <br> <b><u>Sortie assurée et il reste de la place</u></b></p>");}
						elseif(isDP($id_evt)==1 AND isEnough($id_evt)==1 AND isFull($id_evt,$nb_max_part)==1){echo ("<p style='color: white'>Pour le moment : Assez de participants / DP <br> <b><u>Sortie assurée mais complète (Inscrivez vous pour liste d'attente)</u></b></p>");}
						elseif(isDP($id_evt)==0 AND isFull($id_evt,$nb_max_part)==1){echo ("<p style='color: white'>Pour le moment : Assez de participants / Pas de DP <br> <b><u>Sortie non assurée</u></b></p>");}
					}
					// Pour une plongée piscine, on vérifie qu'il y ait un DP piscine
					elseif($type_evt=="Piscine")
					{
						if(isDP_piscine($id_evt)==0){echo ("<p style='color: white'>Pour le moment : Attente d'inscription d'un DP <br> <u><b>Séance non assurée</u></b></p>");}
						else{echo ("<p style='color: white'>Pour le moment : DP présent <br> <u><b>Séance assurée</u></b></p>");}
					}
						// Même trame que le formulaire de création
					?> 
				</font>
			</div>
			<div class="row center">
				<!-- Affichage du lien de modification si admin ou propriétaire de la sortie -->
				<?php if($_SESSION['privilege']=="administrateur" OR $_SESSION['privilege']=="bureau" OR ($_SESSION['nom']." ".$_SESSION['prenom'])==$publicateur )
				{ ?>
					<div class="row center">									
						<form action="modif_evt.php" method="post">
								<input type='hidden' name='id_mod' value=<?php echo $id_evt?>> 		
								<button class="btn waves-effect waves-light blue darken-2" type="submit" name="submit"><i class="material-icons">border_color</i>&nbsp; Modifier l'événement</button>
						</form>		
						
					</div>	<?php 
				} ?>
				
				<div class="row center">									
					<div class="col s1">
						<i class="material-icons prefix">add_circle</i>
					</div> 
					<div class="col s4" align="left" >
						<u><b>Type d'évènement</b></u> : <?php echo $type_evt; ?>
					</div> 	
					<div class="col s7" align="left" >
						<u><b>Publié par</b></u> : <?php echo $publicateur." le ".$date_publi; ?>
					</div> 						
				</div>
				<div class="row center">
					<div class="col s1">
						<i class="material-icons prefix">title</i>
					</div> 
					<div class="col s11" align="left" >
						<u><b>Titre</b></u> : <?php echo $row[2]; ?>
						
					</div> 	
				</div>
				<div class="row center">
					<div class="col s1">
						<i class="material-icons prefix">date_range</i>
					</div> 
					<div class="col s5" align="left" >
						<u><b>Date Sortie</b></u> : <?php echo (date("D-d/m/Y", strtotime($row[3]))); ?>
					</div> 	
					<div class="col s1">
						<i class="material-icons prefix">watch</i>
					</div> 
					<div class="col s5" align="left" >
						<u><b>Heure Sortie</b></u> : <?php echo $row[4]; ?>
					</div> 	
				</div>
				<div class="row center">
					<div class="col s1">
						<i class="material-icons prefix">timer_off</i>
					</div> 
					<div class="col s5" align="left" >
						<u><b>Date limite d'inscription</b></u> : <?php echo (date("D-d/m/Y", strtotime($row[5]))); ?>
					</div> 	
					<div class="col s1">
						<i class="material-icons prefix">timer_off</i>
					</div> 
					<div class="col s5" align="left" >
						<u><b>Heure limite d'inscription</b></u> : <?php echo $row[6]; ?>
					</div> 	
				</div>
				<div class="row center">
					<div class="col s1">
						<i class="material-icons prefix">flare</i>
					</div> 
					<div class="col s2" align="left" >
						<u><b>Niveau mini</b></u> : <?php echo $niv_min; ?>
					</div> 	
					<div class="col s1">
						<i class="material-icons prefix">group</i>
					</div> 
					<div class="col s3" align="left" >
						<u><b>Nombre de participants max</b></u> : <?php echo $nb_max_part; ?>
					</div> 
					<div class="col s1">
						<i class="material-icons prefix">toys</i>
					</div> 
					<div class="col s3" align="left" >
						<u><b>Lieu</b></u> : <?php echo $row[8]; ?>
					</div> 							
				</div>
				<div class="row center">
					<div class="col s1">
						<i class="material-icons prefix">event_note</i>
					</div> 
					<div class="col s11" align="left" >
						<u><b>Remarques</b></u> : <?php echo $row[10]; ?>
					</div> 
				</div>
		
				<div class="row center">
				</div>
			</div>	
			<div class="card-panel blue darken-4" align=center> 
				<div class="row center">
					<div class="col s6" align="right">
						<p style='color: white'>S'inscrire / se désinscrire :</p> 
					</div>
					<div div class="col s6" align="left">
						<form action="affichage_evt.php" method="post">
							<input type='hidden' name='id_evt_local' value=<?php echo $id_evt?>> 							
							<?php
							// On affiche la possiblité de s'inscrire ou de se désinscrire		
							if(isset($_SESSION['pseudo'])AND ($_SESSION['inscription_valide']==1) AND ($_SESSION['actif_saison']==1)) // Si connecté, actif pour la saison et validé, on affiche les boutons d'ajout et de suppression d'inscription
							{
								if($_SESSION['niv_plongeur']>=$niv_min) // Si le mec à le niveau nécessaire, on lui propose de s'incrire, sinon, non
								{
									if(isInscrit($_SESSION['id'], $id_evt))  		// Si la personne est déjà inscrite à la sortie, on lui offre la possibilité de se désinscrire
									{
										?>
										<input type='hidden' name='desinscription' value='desinscription'> 
										<button class="btn waves-effect waves-light red darken-2" type="submit" name="submit">Se désinscrire</button>
									<?php }		// Sinon de s'inscrire
									else
									{
										$date_limi_passee = 0;
										if($date_lim_inscr<$datenow OR ($date_lim_inscr==$datenow AND $heure_lim_inscr<$heurenow))
										{
											$date_limi_passee = 1;
										}
										if($date_limi_passee == 1)		// Si la date lmite d'inscription est passée, on grise la case
										{
											?><button class="btn disabled">Trop tard !</button><?php
										}	
										else				// On autorise l'inscription
										{?>
											<input type='hidden' name='inscription' value='inscription'> 
											<button class="btn waves-effect waves-light green darken-2" type="submit" name="submit">S'inscrire</button>
										<?php 
										}
									} 
								}
								else
								{
									?>
									<button class="btn disabled"><?php echo "<b style='color: red;'>N".$niv_min." min</b>";?></button>
									<?php
								}
							}?>
						</form>
					</div>
				</div>
			</div>
				<!-- Affichage des inscrits -->
			<div class="row center">
				<span class="flow-text" col s12"> Affichage des membres inscrits :</span>
			</div>
			<div class="responsive-table"	>
			<!-- On insert une table dans un DIV pour les inscrits -->
				<table class="striped responsive-table">
					<thead>
					  <tr>
						  <th>Nom</th>
						  <th>Prénom</th>
						  <th>Niveau</th>
						  <th></th>			<!-- Colonne pour afficher qui est DP ou autres infos -->		
						  <th>Commentaire</th>
						  <th></th>			<!-- Colonne pour supprimer un mambre si on est admin -->
					  </tr>
					</thead>
					
					
					<tbody>				
				
					<?php
					$test_passage=0;
					//$yaunan = strtotime('-1 year -1 day');		// timestamp d'il y a un an	
					$unanavantsortie = strtotime('-1 year -1 day',(strtotime($row[3])));
					//Affichage de la liste des inscrits membres: 
					$req2= $bdd->prepare('SELECT * FROM inscriptions WHERE id_evt="'.$id_evt.'" ORDER BY time_inscr'); // On va chercher dans la liste d'inscription, les id des personnes inscrites dans l'ordre d'inscription
					$req2->execute(array());
					
					$DP_present=0;
					$num_inscrit=0;
					while ($inscrit = $req2->fetch())		// Tant qu'il y a des inscrits, on les affiche
					{
						$test_passage=1;			// On valide le fait qu'on est passé pour ne pas afficher le message de sortie vide
						$num_inscrit++;				// On ajoute un participants pour la liste d'attente
						$req3= $bdd->prepare('SELECT * FROM membres WHERE id="'.$inscrit[1].'"'); // 
						$req3->execute(array());
						$donnees_membre = $req3->fetch();
						
						$id_membre = $donnees_membre[0];
						if($id_membre == $_SESSION['id']){$personne_log_inscrite=1;}
						$nom_membre = $donnees_membre[3];
						$prenom_membre = $donnees_membre[4];
						$certif_membre = $donnees_membre[11];
						$niv_membre = $donnees_membre[8];
						$niv_encad = $donnees_membre[9];
						$comm_membre = $inscrit[3];
						// On va voir si le nombre d'inscrits est atteint
						// Lors qu'il est atteint, la première fois, on affiche "Liste d'attente"
						if($num_inscrit==($nb_max_part+1))
						{?>
							<tr style='color: grey'>
								<td colspan=6>
									<table class="centered">
										<thead>
										  <tr>
											  <th><u><b> Liste d'attente </u></b></th>
										  </tr>
										</thead><tbody>	</tbody>
										</table>
								</td>
							</tr>
							<tr style='color: grey' font='italic'>
							<?php $italic=1;				// Pour passer les textes en italic?>
						<?php
						}
						// Ensuite, on continue de mettre à la suite les lignes en liste d'attente, et affichage en gris toujours
						elseif($num_inscrit>($nb_max_part+1))
						{?>
							<tr style='color: grey' font='italic'>
							<?php $italic=1;				// Pour passer les textes en italic?>
						<?php
						}
						//Et enfin, on affiche une ligne en rouge si le certificat médical est HS
						elseif(strtotime($certif_membre)<$unanavantsortie AND ($type_evt=="Plongée" OR $type_evt=="Piscine"))		// Si le gars est pas à jour de certif médical, on affiche sa ligne en rouge -> Gaulé Capi on t'a vu !! 
						{?>
							<tr style='color: red'>
						<?php	
						}
						else
						{?>
							<tr>	<!-- Nouvelle ligne --> <?php
						}?>
						
						<!-- Afficher le nom du membre -->
						<td><?php if($italic==1){echo "<i>";} echo $nom_membre;?></td>
						<!-- Afficher le prénom du membre -->
						<td><?php if($italic==1){echo "<i>";} echo $prenom_membre;?></td>
						<!-- Afficher le niveau du membre -->
						<td><?php if($italic==1){echo "<i>";} if($niv_encad!=0){echo "N".$niv_membre."/E".$niv_encad;}	else{echo "N".$niv_membre;}?></td>					
						<!-- Afficher le DP -->
						<td><?php if($DP_present==0 AND ($niv_membre==5 OR $niv_encad>=3))		// Si pas encore de DP et que le plus ancien inscrit est N5 ou E3 -> Il est DP
												{
													echo "<b>DP</b>";
													$DP_present=1;
												}
									else{echo"-";}
									?>
						</td>
						<?php
						if($_SESSION['privilege']=="administrateur" OR $_SESSION['privilege']=="bureau")		// On affiche une possibilité de supprimer quelqu'un pour les admins
						{
							// Afficher le commentaire du memebre en 5 unités et un bouton pour supprimer un membre 
							?>
							<td> <?php if($italic==1){echo "<i>";} if($comm_membre=='' OR empty($comm_membre)){echo "-";} else{echo $comm_membre;}?></td>
							<td>
							<form action="affichage_evt.php" method="post">
								<input type='hidden' name='id_evt_local' value=<?php echo $id_evt?>> 		
								<input type='hidden' name='id_inscrit' value=<?php echo $id_membre?>>
								<button class="btn waves-effect waves-light red darken-2" type="submit" name="submit"><i class="material-icons">cancel</i></button>
							</form>					
							</td> <?php
						}
						else
						{
							// Afficher le commentaire du memebre en 6 unités de longueur
							?>
							<td align='left'><?php if($italic==1){echo "<i>";} if($comm_membre==''){echo "-";} else{echo $comm_membre;} ?></td> 
							<td>-</td>				<!-- Case vide pour le bouton de suppression qui n'existe pas si on est pas admin-->
							<?php
						}
						// Fin de la nouvelle ligne
						if($num_inscrit>($nb_max_part))
						{ $italic=0;				// Pour passer les textes en italic
							?></tr> <?php		// Fin de la balise italique si on est dans les listes d'autorise
						}
						else
						{?>
							</tr>  <?php		// Fin de la ligne simple sinon
						}
						$req3->closeCursor(); //requête terminée
					}
					// Affichage des invités
					$req4= $bdd->prepare('SELECT * FROM invites WHERE id_evt="'.$id_evt.'"'); // On va chercher dans la liste d'inscription, les id des personnes inscrites
					$req4->execute(array());
					while ($inscrit_invit = $req4->fetch())		// Tant qu'il y a des inscrits, on les affiche
					{
						$test_passage=1;			// On valide le fait qu'on est passé pour ne pas afficher le message de sortie vide
						$num_inscrit++;				// On ajoute un participants pour la liste d'attente
						$nom_invit = $inscrit_invit[1];
						$prenom_invit = $inscrit_invit[2];
						$niv_invit = $inscrit_invit[3];
						$comm_invit = $inscrit_invit[4];
						
						if($num_inscrit==($nb_max_part+1))
						{?>
							<tr style='color: grey'>
								<td colspan=6>
									<table class="centered">
										<thead>
										  <tr>
											  <th><u><b> Liste d'attente </u></b></th>
										  </tr>
										</thead><tbody>	</tbody>
										</table>
								</td>
							</tr>
							<tr style='color: grey' font='italic'>
							<?php $italic=1;				// Pour passer les textes en italic?>
						<?php
						}
						// Ensuite, on continue de mettre à la suite les lignes en liste d'attente, et affichage en gris toujours
						elseif($num_inscrit>($nb_max_part+1))			
						{?>
							<tr style='color: grey'>
							<?php $italic=1;				// Pour passer les textes en italic?>
						<?php
						}	
						else
						{					// On affiche une ligne normale?>					
							<tr> <?php
						}?>
						<!-- Afficher le nom du membre -->
						<td><?php if($italic==1){echo "<i>";} echo $nom_invit;?></td>
						<!-- Afficher le prénom du membre -->
						<td><?php if($italic==1){echo "<i>";} echo$prenom_invit;?></td>
						<!-- Afficher le niveau du membre -->
						<td><?php if($italic==1){echo "<i>";} echo$niv_invit;?></td>					
						<!-- Case vide pour DP -->
						<td>-</td>					
						<?php
						if($_SESSION['privilege']=="administrateur" OR $_SESSION['privilege']=="bureau")		// On affiche une possibilité de supprimer quelqu'un pour les admins
						{
							// Afficher le commentaire du memebre en 5 unités et un bouton pour supprimer un membre
							?>
							<td><?php if($italic==1){echo "<i>";} if($comm_invit==''){echo "-";} else{echo $comm_invit;}?></td>
							<td>
								<form action="affichage_evt.php" method="post">
									<input type='hidden' name='id_evt_local' value=<?php echo $id_evt?> > 		
									<input type='hidden' name='prenom' value='<?php echo $prenom_invit?>' >
									<input type='hidden' name='nom' value='<?php echo $nom_invit?>' >
									<button class="btn waves-effect waves-light red darken-2" type="submit" name="submit"><i class="material-icons">cancel</i></button>
								</form>	
							</td>
							<?php				
						}
						else
						{	?>
							<!-- Afficher le commentaire du memebre en 6 unités de longueur -->
							<td align='left'><?php if($italic==1){echo "<i>";} if($comm_invit==''){echo "-";} else{echo $comm_invit;} ?></td> 
							<td>-</td>				<!-- Case vide pour le bouton de suppression qui n'existe pas si on est pas admin-->
							<?php
						}
						// Fin de la nouvelle ligne
						if($num_inscrit>($nb_max_part))
						{?>
							<?php $italic=0;				// Pour passer les textes en italic?>
							</tr>		<!-- Fin de la balise italique si on est dans les listes d'autorise --> <?php
						}
						else
						{?>
							</tr>			<!-- Fin de la ligne simple sinon --> <?php
						}
					}
					$req4->closeCursor(); //requête terminée
					if($test_passage==0)
					{	// Pas de sorties à afficher?>
						<tr class="row center">
							<td colspan=6>
							<span>Quoi !!?? Personne d'inscrit ?????? Regardes la météo et inscrits toi si tu es sur(e) de toi ;-)</span>
							</td>
						</tr>
					
						<?php
					}				
					$req2->closeCursor(); //requête terminée?>
					
					</tbody>
				</table>
			
			</div>
				<!--   Ajout d'un invité   -->
				<div class="row center">
				</div>
				<div class="row center">
					<span class="flow-text" col s12"> Ajout d'un invité :</span>
				</div>
				<?php
				// On offre la possibilité d'inscrire un invité que si la date limite n'est pas dépassée
				if($date_lim_inscr<$datenow OR ($date_lim_inscr==$datenow AND $heure_lim_inscr<$heurenow))
				{?>
					<div class="row center">
					<span col s12"><i>La date limite d'inscription est dépassée, ajout d'un invité impossible</i></span>
					</div>
				<?php	
				}
				else
				{?>
					<div class="row center">
						<span col s12"><i>Licence et certificat médical de moins d'un an nécéssaire - Sera contrôlé par le DP</i></span>
					</div>
					<div class="row center">
						<form class="col s12" action="affichage_evt.php" method="post">								
							<input type="hidden" name="id_evt_local" value = '<?php echo($id_evt);?>'>	<!-- Renvoi de l'id de l'évènement pour l'afficher une fois l'inscription faite -->
							<div class="input-field col s2">
								<i class="material-icons prefix">add_circle</i>
								<input id="nom_invit" type="text" class="validate" name='nom_invit'>
								<label for="nom_invit">Nom *</label>		
							</div>
							<div class="input-field col s2">
								<input id="prenom_invit" type="text" class="validate" name='prenom_invit'>
								<label for="prenom_invit">Prénom *</label>		
							</div>
							<div class="input-field col s2">
								<select name="niveau_invit">
								  <option value = "N0">N0</option>
								  <option value = "N1">N1</option>
								  <option value = "N2">N2</option>
								  <option value = "N3">N3</option>
								  <option value = "N4">N4</option>
								  <option value = "E1">E1</option>
								  <option value = "E2">E2</option>
								  <option value = "E3">E3</option>
								  <option value = "E4">E4</option>
								  <option value = "Autre">Autre</option>
								</select>										
							</div>	
							<div class="input-field col s5">
								<input id="comm_invit" type="text" class="validate" name='comm_invit'>
								<label for="comm_invit">Commentaire</label>		
							</div>
						<div class="input-field col s1">
							<button class="btn waves-effect waves-light green darken-2" type="submit" name="submit"><i class="material-icons">add_circle</i></button>
						</div>
						</form>
					</div>
					<?php
				}?>
				<!--   Ligne vie pour démarquer la fin de l'affichage des inscrits   -->
				<div class="row center">
				</div>
				<!--   Ajout d'un commentaire seulement pour les personnes inscrites   -->
				<?php 
				if($personne_log_inscrite==1)
				{ ?>
				<div class="row center">
					<span class="flow-text" col s12"> Modifier mon commentaire (Remplace le précédent)</span>
				</div>
				<div class="row center">
					<form class="col s12" action="affichage_evt.php" method="post">								
					<input type="hidden" name="id_evt_local" value = "<?php echo($id_evt);?>">	<!-- Renvoi de l'id de l'évènement pour l'afficher une fois le commentaire publié -->
					<div class="input-field col s11">
						<input id="comm_plong" type="text" class="validate" name='comm_plong'>
						<label for="comm_plong">Commentaire</label>		
					</div>
					<div class="input-field col s1">
						<button class="btn waves-effect waves-light green darken-2" type="submit" name="submit"><i class="material-icons">add_circle</i></button>	
					</div>
					</form>
				</div> <?php
				}
				?>
				
			<?php
		}
		else
		{
			echo ("<div class='row center'><span class='flow-text' col s12'>Vous n'avez pas sélectionné de d'événement à afficher</span></div>");
		}	
		?>
  	</div>
  </div>

<?php
}

else	// Pas loggé
{
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