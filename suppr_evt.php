<?php
// On démarre la session AVANT d'écrire du code HTML
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Suppression évènements</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>

<?php include("tools/navbar.php"); ?>

<?php
if($_SESSION['privilege']=="administrateur")		// On autorise l'accès à cette page
{
			// Traitement des suppressions
		if(isset($_POST['id_evt']) AND $_POST['id_evt']!='')
		{	// Clic sur un des boutons, on va récupérer le numéro ID de l'événement pour le supprimer
			include("tools/data_base_connection.php");						
			
			// 1 - On supprime les inscrits clubs
			
			$req2= $bdd->prepare('DELETE FROM inscriptions WHERE id_evt=:id_evt');	// On supprime l'inscription à cette plongée
			$req2->execute(array(
			  'id_evt' => $_POST['id_evt']));				 
					// ## Ce serait bien d'envoyer un mail pour notifier au mec
			  $req2->closeCursor(); //requête terminée
			
			// 2 - On supprime les inscrits invités
			
			$req2= $bdd->prepare('DELETE FROM invites WHERE id_evt=:id_evt');	// On supprime l'inscription du gus
			$req2->execute(array(
			  'id_evt' => $_POST['id_evt']));			  
			$req2->closeCursor(); //requête terminée
			
			// 3 - On supprime la sortie
			
			$req2= $bdd->prepare('DELETE FROM evenements WHERE id=:id');	// On supprime l'inscription du gus
			$req2->execute(array(
			  'id' => $_POST['id_evt']));			   
			$req2->closeCursor(); //requête terminée
		}	
?>

<!--	Affichage des plongées  -->
  <div class="section no-pad-bot" id="index-banner">
  	<div class="container">
    	<br><br>
        <div class="row center">
            <span class="flow-text" col s12"><b style='color: red;'>ATTENTION - Page de SUPPRESSION des évènements !! </b></span>
        </div>
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
					<label>Titre</label>
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
						<label><?php echo $resultat['type']?></label>							
					</div>
					<div class="input-field col s2">
						<label><?php if(strlen($resultat['titre'])>20){echo substr($resultat['titre'],0,17).'...';} else {echo $resultat['titre'];}?>"</label>
					</div>
					<div class="input-field col s2">
						<label><?php echo date("D-d/m/Y", strtotime($resultat['date_evt']))."<br>".$resultat['heure_evt']?></label>							
					</div>
					<div class="input-field col s2">
						<label><?php echo date("D-d/m/Y", strtotime($resultat['date_lim']))."<br>".$resultat['heure_lim']?></label>							
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
						<!-- Formulaire pour faire l'inscription ou la désincription en passant l'ID de la plongée en paramètre-->
						<form action="suppr_evt.php" method="post">
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
								if($inscrit[1]==$_SESSION['id'])	// ### 1 à remplacer par l'ID du mec connecté
								{
									$deja_inscrit=1;
								}
								$nb_part++;
							}
							while ($inscrit_invit = $req4->fetch())		// Dans la table des invités, on vient aussi les compter
							{$nb_part++;}
							// On affiche le nombre de participants
							echo "<label>".($nb_part."/".$resultat['max_part']."</label>");
							// On rentre la valeur de l'ID de la plongée en cours d'affichage pour le formulaire de la ligne
							?><input type='hidden' name='id_evt' value='<?php echo($resultat['id']);?>'>
							<button class="waves-effect waves-teal btn-flat" type="submit" name="submit"><a><i class="material-icons">cancel</i></a></button>
							<?php
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
					<span class="flow-text" col s12">Il n'existe pas de sorties</span>
				</div>
			
				<?php
			}
			$req1->closeCursor(); //requête terminée
		?>	
		</div>
    </div>
  </div>
<?php	
} 
else		// La personne qui accède à la page n'est pas admin
{?>
	<div class="section no-pad-bot" id="index-banner">
  	<div class="container">
    	<div class="row center">
            <span class="flow-text" col s12">Vous n'avez pas accès à cette page</span>
        </div>
	</div>
	</div>
<?php
}
?>
  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
	<!--  Scripts-->
    <?php include("tools/scripts.php"); ?>

</body>

