 <!-- A faire  
 
- Mettre une ligende sur le calendrier pour la saisie de la date de la sortie
- Mettre le type d'élément en plus petit (Largeur 6) et centré
- Pour sélectionner un champ, il faut cliquer sur la ligne, c'est super chiant (Du au conflit de CSS surement)
  
 -->
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>ADK plongée - Nouvel Evenement</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

 <!-- Pour faire marcher le calendrier  -->
  <!-- #### Attention, casse le remplissange des champs qui se met au dessus lors de la saisie  -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 

  <!--		A decommenter
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/init.js"></script>
  
  -->
  
</head>
 
<body>

<?php include("navbar.php"); ?>
  
 <?php
/*$pass_hache = password_hash("LucieCarof1*", PASSWORD_DEFAULT);
echo $pass_hache; */
?>

  
  <div class="section no-pad-bot" id="index-banner">
  	<div class="container">
    	<br><br>
		    <div class="row center">
            <span class="flow-text" col s12">Création d'un nouvel évènement :</span>
            </div>	
			
			<div class="row center">
                <form class="col s12" action="ajpl_temp.php" method="post">
					<div class="row center">
						<!-- A decommenter
						<label>Type d'évènement *</label>
						  <select name="type" class="browser-default">
							<option value="1">Plongée</option>
							<option value="2">Piscine</option>
							<option value="3">Théorie</option>
							<option value="4">Sondage</option>
							<option value="5">Vie du club</option>
						  </select>
						  -->
                        <div class="input-field col s12">
                            <i class="material-icons prefix">device_hub</i>
                            <input id="icon_prefix" type="text" class="validate" name="type">
                            <label for="icon_prefix">Type*</label>
                        </div>
					</div>
					<div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">title</i>
                            <input id="icon_prefix" type="text" class="validate" name="titre">
                            <label for="icon_prefix">Titre*</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">date_range</i>
                            <input id="icon_prefix" type="text" class="validate" name="date_evt">
                            <label for="icon_prefix">Date*</label>
                        </div>
						<!--   A decommenter
							<div class="input-field col s6">
                            <i class="material-icons prefix">#</i>
							<input type="text" id="datepicker" name='date_evt'>
                        </div>-->
                    </div>
					<div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">watch</i>
                            <input id="icon_prefix" type="text" class="validate" name="heure"> 
                            <label for="icon_prefix">Heure de RDV*</label>
                        </div>
						<div class="input-field col s6">
                            <i class="material-icons prefix">timer_off</i>
							<input id="icon_prefix" type="text" class="validate" name="date_limite"> 
							<label for="icon_prefix">Date Limite d'inscription*</label>
                        </div>
                    </div>
					<div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">flare</i>
                            <input id="niveau_min" type="text" class="validate" name="niveau_min">
                            <label for="icon_prefix">Niveau mini</label>
							
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">toys</i>
							<input id="niveau_min" type="text" class="validate" name="niveau_min">
							<label for="icon_prefix">Lieu *</label>
						
						 <!-- Dropdown Trigger -->
  <a class='dropdown-trigger btn' href='#' data-target='dropdown1'>Lieu*</a>

  <!-- Dropdown Structure -->
  <ul id='dropdown1' class='dropdown-content'>
    <li><a href="#!">one</a></li>
    <li><a href="#!">two</a></li>
    <li class="divider" tabindex="-1"></li>
    <li><a href="#!">three</a></li>
    <li><a href="#!"><i class="material-icons">view_module</i>four</a></li>
    <li><a href="#!"><i class="material-icons">cloud</i>five</a></li>
  </ul>
						
						
						
						
						
						</div>
                    </div>
					<div class="row center">
                        <div class="input-field col s12">
							<i class="material-icons prefix">event_note</i>
                            <input id="remarques" type="text" class="validate" name='remarques'>
                            <label for="icon_prefix">Remarques</label>
						</div>
					</div>			

                    <div class="row center">
                        <button class="btn waves-effect waves-light blue darken-4" type="submit" name="submit">Publier la sortie</button> 
                    </div>
                </form>
            </div>
        </div>
  	</div>
  </div>
  
   <?php include("tools/footer.php"); ?>
  
  </body>
 </html>


