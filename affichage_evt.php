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
		
		
		<?php if(isset($_POST['id_evt']) AND $_POST['id_evt']!='')
		{	// Récupération des données de la plongée dont l'ID est "$_POST['evt_id']"
			$id_evt = htmlspecialchars($_POST['id_evt']);
			include("tools/data_base_connection.php");						
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
					<div class="col s11" align="left" >
						<u><b>Type d'évènement</b></u> : <?php echo $row[1]; ?>
						
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
						<u><b>Date Sortie</b></u> : <?php echo $row[3]; ?>
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
						<u><b>Date limite d'inscription</b></u> : <?php echo $row[5]; ?>
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
				//Affichage de la liste des inscrits : 
				$req2= $bdd->prepare('SELECT * FROM inscriptions WHERE id_evt="'.$id_evt.'"'); // On va chercher dans la liste d'inscription, les id des personnes inscrites
				$req2->execute(array());
				while ($inscrit = $req2->fetch())		// Tant qu'il y a des inscrits, on les affiche
				{
					$test_passage=1;
					$req3= $bdd->prepare('SELECT * FROM membres WHERE id="'.$inscrit[1].'"'); // 
					$req3->execute(array());
					$donnees_membre = $req3->fetch();
					echo("<div class='row center'>");	// Nouvelle ligne
					// Afficher le nom du membres 
					echo("<div class='col s2' align='left'>");
					echo $donnees_membre[3];
					echo("</div>");
					// Afficher le prénom du membre
					echo("<div class='col s2' align='left'>");
					echo $donnees_membre[4];
					echo("</div>");
					// Afficher le niveau du memebre
					echo("<div class='col s2' align='left'>");
					echo $donnees_membre[6];						// ## Champ à recadrer avec le bon champ du niveaux des gars dans l'évolution de la table membre
					echo("</div>");
					// Afficher le commentaire du memebre
					echo("<div class='col s2' align='left'>");
					echo "A venir";						// ## Champ à recadrer en allant le chercher dans la bdd inscriptions (A faire)avec les niveaux des gars
					echo("</div>");
					// Fin de la nouvelle ligne
					echo("</div>");
					$req3->closeCursor(); //requête terminée
				}
				if($test_passage==0)
				{	// Pas de sorties à afficher?>
					<div class="row center">
						<span class="flow-text" col s12">Quoi !!?? Personne d'inscrit ?????? Regardes la météo et inscrits toi si tu es sur(e) de toi ;-)</span>
					</div>
				
					<?php
				}				
				$req2->closeCursor(); //requête terminée
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