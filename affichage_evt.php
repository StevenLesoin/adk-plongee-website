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
            <span class="flow-text" col s12">Consultation d'un événement :</span>
        </div>
		<div class="row center">
            <p><a href="liste_evenements.php">Lien vers la liste de tous les événements</a></p>
        </div>
		
		
		<?php if((isset($_POST['id_evt']) AND htmlspecialchars($_POST['id_evt'])!='')OR(isset($_POST['id_evt_local']) AND htmlspecialchars($_POST['id_evt_local'])!=''))		// Si on vient de cette page ou de la liste des événements
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
					$req2= $bdd->query('UPDATE inscriptions SET commentaire = "'.$comm_plong.'" WHERE (id_evt ="'.$id_evt.'" AND id_membre = "'.$_SESSION['id'].'")'); // 	### 1 a remplacer par l'ID du mec Loggé
					$req2->closeCursor(); //requête terminée
			}
			if($_SESSION['privilege']=="administrateur")		// On autorise la suppression
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
		}				
			$result = $bdd->query("SELECT * FROM evenements WHERE id = '$id_evt'");
			$row = $result->fetch();
			$result->closeCursor(); //requête terminée
			
				
		
				// Même trame que le formulaire de création
			?> 
			<div class="row center">
				<div class="row center">									
					<div class="col s1">
						<i class="material-icons prefix">add_circle</i>
					</div> 
					<div class="col s4" align="left" >
						<u><b>Type d'évènement</b></u> : <?php echo $row[1]; ?>
					</div> 	
					<div class="col s7" align="left" >
						<u><b>Publié par</b></u> : <?php echo $row[11]." le ".$row[12]; ?>
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
						<u><b>Niveau mini</b></u> : <?php echo $row[7]; ?>
					</div> 	
					<div class="col s1">
						<i class="material-icons prefix">group</i>
					</div> 
					<div class="col s3" align="left" >
						<u><b>Nombre de participants max</b></u> : <?php echo $row[9]; ?>
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
				
				<!-- Affichage des inscrits -->
			    <div class="row center">
					<span class="flow-text" col s12"> Affichage des membres inscrits :</span>
				</div>
			    <div class="row center">
					<div class="col s2" align="left" >
						<u><b>Nom</b></u>
					</div> 
					<div class="col s2" align="left">
						<u><b>Prénom</b></u>
					</div> 
					<div class="col s2" align="left" >
						<u><b>Niveau</b></u>
					</div> 
					<div class="col s6" align="left" >
						<u><b>Commentaire</b></u>
					</div> 
				</div>
				<?php
				$test_passage=0;
				//Affichage de la liste des inscrits membres: 
				$req2= $bdd->prepare('SELECT * FROM inscriptions WHERE id_evt="'.$id_evt.'" ORDER BY time_inscr'); // On va chercher dans la liste d'inscription, les id des personnes inscrites
				$req2->execute(array());
				while ($inscrit = $req2->fetch())		// Tant qu'il y a des inscrits, on les affiche
				{
					$test_passage=1;
					$req3= $bdd->prepare('SELECT * FROM membres WHERE id="'.$inscrit[1].'"'); // 
					$req3->execute(array());
					$donnees_membre = $req3->fetch();
					
					$id_membre = $donnees_membre[0];
					$nom_membre = $donnees_membre[3];
					$prenom_nembre = $donnees_membre[4];
					$niv_membre = $donnees_membre[6];
					$comm_membre = $inscrit[3];
					
					echo("<div class='row center'>");	// Nouvelle ligne
					// Afficher le nom du membres 
					echo("<div class='col s2' align='left'>");
					echo $nom_membre;
					echo("</div>");
					// Afficher le prénom du membre
					echo("<div class='col s2' align='left'>");
					echo $prenom_nembre;
					echo("</div>");
					// Afficher le niveau du memebre
					echo("<div class='col s2' align='left'>");
					echo $niv_membre;						// ## Champ à recadrer avec le bon champ du niveaux des gars dans l'évolution de la table membre
					echo("</div>");
					if($_SESSION['privilege']=="administrateur")		// On affiche une possibilité de supprimer quelqu'un pour les admins
					{
						// Afficher le commentaire du memebre en 5 unités et un bouton pour supprimer un membre
						echo("<div class='col s5' align='left'>");
						echo $comm_membre;					
						echo("</div>");
						echo("<div class='col s1' align='left'>");?>
						<form action="affichage_evt.php" method="post">
							<input type='hidden' name='id_evt_local' value=<?php echo $id_evt?> > 		
							<input type='hidden' name='id_inscrit' value='<?php echo $id_membre?>' >
							<button class="waves-effect waves-teal btn-flat" type="submit" name="submit"><a><i class="material-icons">cancel</i></a></button>
						</form>	<?php				
						echo("</div>");
					}
					else
					{
						// Afficher le commentaire du memebre en 6 unités de longueur
						echo("<div class='col s6' align='left'>");
						echo $comm_membre;					
						echo("</div>");
					}
					
					// Fin de la nouvelle ligne
					echo("</div>");
					$req3->closeCursor(); //requête terminée
				}
				// Affichage des invités
				$req4= $bdd->prepare('SELECT * FROM invites WHERE id_evt="'.$id_evt.'"'); // On va chercher dans la liste d'inscription, les id des personnes inscrites
				$req4->execute(array());
				while ($inscrit_invit = $req4->fetch())		// Tant qu'il y a des inscrits, on les affiche
				{
					$test_passage=1;
					$nom_invit = $inscrit_invit[1];
					$prenom_invit = $inscrit_invit[2];
					$niv_invit = $inscrit_invit[3];
					$comm_invit = $inscrit_invit[4];
					echo("<div class='row center'>");	// Nouvelle ligne
					// Afficher le nom du membres 
					echo("<div class='col s2' align='left'>");
					echo $nom_invit;
					echo("</div>");
					// Afficher le prénom du membre
					echo("<div class='col s2' align='left'>");
					echo $prenom_invit;
					echo("</div>");
					// Afficher le niveau du memebre
					echo("<div class='col s2' align='left'>");
					echo $niv_invit;						
					echo("</div>");
					if($_SESSION['privilege']=="administrateur")		// On affiche une possibilité de supprimer quelqu'un pour les admins
					{
						// Afficher le commentaire du memebre en 5 unités et un bouton pour supprimer un membre
						echo("<div class='col s5' align='left'>");
						echo $comm_invit;					
						echo("</div>");
						echo("<div class='col s1' align='left'>");?>
						<form action="affichage_evt.php" method="post">
							<input type='hidden' name='id_evt_local' value=<?php echo $id_evt?> > 		
							<input type='hidden' name='prenom' value='<?php echo $prenom_invit?>' >
							<input type='hidden' name='nom' value='<?php echo $nom_invit?>' >
							<button class="waves-effect waves-teal btn-flat" type="submit" name="submit"><a><i class="material-icons">cancel</i></a></button>
						</form>	<?php				
						echo("</div>");
					}
					else
					{
						// Afficher le commentaire du memebre en 6 unités de longueur
						echo("<div class='col s6' align='left'>");
						echo $comm_invit;					
						echo("</div>");
					}
					// Fin de la nouvelle ligne
					echo("</div>");	
				}
				$req4->closeCursor(); //requête terminée
				if($test_passage==0)
				{	// Pas de sorties à afficher?>
					<div class="row center">
						<span class="flow-text" col s12">Quoi !!?? Personne d'inscrit ?????? Regardes la météo et inscrits toi si tu es sur(e) de toi ;-)</span>
					</div>
				
					<?php
				}				
				$req2->closeCursor(); //requête terminée
			?>
			
			</div>
				<!--   Ajout d'un invité   -->
				<div class="row center">
				</div>
				<div class="row center">
					<span class="flow-text" col s12"> Ajout d'un invité :</span>
				</div>
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
							<select class = "browser-default" name="niveau_invit">
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
						<button class="waves-effect waves-teal btn-flat" type="submit" name="submit"><a><i class="material-icons">add_circle</i></a></button>	
					</div>
					</form>
				</div>
				<!--   Ajout d'un commentaire   -->
				<div class="row center">
				</div>
				<div class="row center">
					<span class="flow-text" col s12"> Un commentaire sur la plongée / l'inscription ?</span>
				</div>
				<div class="row center">
					<form class="col s12" action="affichage_evt.php" method="post">								
					<input type="hidden" name="id_evt_local" value = "<?php echo($id_evt);?>">	<!-- Renvoi de l'id de l'évènement pour l'afficher une fois le commentaire publié -->
					<div class="input-field col s11">
						<input id="comm_plong" type="text" class="validate" name='comm_plong'>
						<label for="comm_plong">Commentaire</label>		
					</div>
					<div class="input-field col s1">
						<button class="waves-effect waves-teal btn-flat" type="submit" name="submit"><a><i class="material-icons">add_circle</i></a></button>	
					</div>
					</form>
				</div>			
			<?php
		}
		else
		{
			echo ("<div class='row center'><span class='flow-text' col s12'>Vous n'avez pas sélectionné de d'événement à afficher</span></div>");
		}	?>
		
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