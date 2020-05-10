<?php
// On démarre la session AVANT d'écrire du code HTML
session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>ADK plongée</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>

	<?php 
	if(isset($_SESSION['pseudo'])) // Si déjà connecté
    {
    	if($_SESSION['oubli_mdp'] == 1) // Si connexion avec mot de passe temporaire
		{
			header('location: edit_password.php');
		}
		else if($_SESSION['inscription_valide']==0) // Inscription non validé
		{
			include("tools/navbar.php"); 
			include("tools/print_msg.php"); // Define printMsg function 
			$email = $_SESSION['email'];
  			printMsg('Votre demande d\'inscription n\'a pas encore été validé par l\'administateur. Vous recevrez un email à l\'adresse '. $email.' lorsque celle-ci aura été traité.','',''); 
		}
		else
		{
	    	include("tools/navbar.php"); 
	    	?>
	    	<div class="container">
	    		<br><br>
		        <div class="row center">
		            <span class="flow-text" col s12">Supports de formations :</span>
		        </div>
	    		<div class="row">
			    	<ul class="collapsible">
					    <li>
					      <div class="collapsible-header"><i class="material-icons">child_friendly</i>N1</div>
					      	<div class="collapsible-body">
							    <table>
							        <thead>
							          <tr>
							              <th>Formation</th>
							              <th>Téléchargement</th>
							          </tr>
							        </thead>

							        <tbody>
							          <tr>
							            <td>ADD</td>
							            <td><a href="formations/N1/test.pdf">lien</a></td>
							          </tr>
							          <tr>
							            <td>La bière d'après plongée</td>
							            <td><a href="formations/N1/test.pdf">lien</a></td>
							          </tr>
							        </tbody>
							    </table>
					      	</div>
					    </li>
					    <li>
					      <div class="collapsible-header"><i class="material-icons">directions_walk</i>N2</div>
					      <div class="collapsible-body"><span>Contenu à venir</span></div>
					    </li>
					    <li>
					      <div class="collapsible-header"><i class="material-icons">directions_run</i>N3</div>
					      <div class="collapsible-body"><span>Contenu à venir</span></div>
					    </li>
					    <li>
					      <div class="collapsible-header"><i class="material-icons">supervisor_account</i>N4</div>
					      <div class="collapsible-body"><span>Contenu à venir</span></div>
					    </li>
					    <li>
					      <div class="collapsible-header"><i class="material-icons">directions_boat</i>N5</div>
					      <div class="collapsible-body"><span>Contenu à venir</span></div>
					    </li>
				  	</ul>
				  	<ul class="collapsible">
					    <li>
					      <div class="collapsible-header"><i class="material-icons">star_border</i>E1</div>
					      <div class="collapsible-body"><span>Contenu à venir</span></div>
					    </li>
					    <li>
					      <div class="collapsible-header"><i class="material-icons">star_half</i>E2</div>
					      <div class="collapsible-body"><span>Contenu à venir.</span></div>
					    </li>
					    <li>
					      <div class="collapsible-header"><i class="material-icons">star</i>E3</div>
					      <div class="collapsible-body"><span>Contenu à venir</span></div>
					    </li>
					    <li>
					      <div class="collapsible-header"><i class="material-icons">stars</i>E4</div>
					      <div class="collapsible-body"><span>Contenu à venir</span></div>
					    </li>
				  	</ul>
				  	<ul class="collapsible">
					    <li>
					      <div class="collapsible-header"><i class="material-icons">access_time</i>Nitrox base</div>
					      <div class="collapsible-body"><span>Contenu à venir</span></div>
					    </li>
					    <li>
					      <div class="collapsible-header"><i class="material-icons">update</i>Nitrox confirmé</div>
					      <div class="collapsible-body"><span>Contenu à venir</span></div>
					    </li>
				  	</ul>
		  		</div>
		  	</div>
      		<?php
    	}
    }
	else
	{
		header('location: login.php');
	}
	?>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <?php include("tools/scripts.php"); ?>

  </body>


</html>