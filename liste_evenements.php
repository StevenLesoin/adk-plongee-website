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
				<div class="input-field col s3">
					<label>Titre</label>
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
					<div class="input-field col s3">
						<label><?php 
							if(strlen($resultat['titre'])>40)
							{echo substr($resultat['titre'],0,37).'...';}
							else 
								echo $resultat['titre'];
						?></label>							
					</div>
					<div class="input-field col s1">
						<label><?php echo $resultat['date_evt']?></label>							
					</div>
					<div class="input-field col s1">
						<label><?php echo $resultat['heure_evt']?></label>							
					</div>
					<div class="input-field col s1">
						<label><?php echo $resultat['date_lim']?></label>							
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

