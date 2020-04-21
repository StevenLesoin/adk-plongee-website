<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Nouvel évènement</title>

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
            <span class="flow-text" col s12">Création d'un nouvel évènement ADK :</span>
            </div>
            <div class="row center">
                <form class="col s12" action="home.php" method="post">
                    <div class="row center">
					    <div class="input-field col s12">
							<select name="type">
							<option value="1">Plongée</option>
							<option value="2">Piscine</option>
							<option value="3">Théorie</option>
							<option value="4">Sondage</option>
							<option value="5">Vie du club</option>
							</select>
							<label>Type d'évènement *</label>
						  </div> 
                    </div>
					<div class="row center">
					        <div class="input-field col s12">
                            <i class="material-icons prefix">title</i>
                            <input id="titre" type="text" class="validate" name="titre">
                            <label for="titre">Titre *</label>
                        </div>
					</div>
					<div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">date_range</i>
                            <input id="date_evt" type="text" class="validate" name='date_evt'>
                            <label for="date_evt">Date *</label>							
                        </div>
						<div class="input-field col s6">
                            <i class="material-icons prefix">watch</i>
                            <input id="heure_evt" type="text" class="validate" name='heure_evt'>
                            <label for="heure_evt">Heure *</label>
                        </div>
                    </div>
					<div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">timer_off</i>
                            <input id="date_lim" type="text" class="validate" name='date_lim'>
                            <label for="date_lim">Date limite d'inscription *</label>
                        </div>
						<div class="input-field col s6">
                            <i class="material-icons prefix">timer_off</i>
                            <input id="heure_lim" type="text" class="validate" name='heure_lim'>
                            <label for="heure_lim">Heure limite d'inscription *</label>
                        </div>
                    </div>
					<div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">flare</i>
                            <input id="niveau_min" type="text" class="validate" name='niveau_min'>
                            <label for="niveau_min">Niveau Mini</label>	
                        </div>
						<div class="input-field col s6">
                            <i class="material-icons prefix">toys</i>
                            <input id="lieu" type="text" class="validate" name='lieu'>
                            <label for="lieu">Lieu </label>
                        </div>
                    </div>
					<div class="row center">
					     <div class="input-field col s12">
                            <i class="material-icons prefix">event_note</i>
                            <input id="remarques" type="text" class="validate" name="remarques">
                            <label for="remarques">Remarques</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
  	</div>
  </div>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/initt.js"></script>

</body>


</html>