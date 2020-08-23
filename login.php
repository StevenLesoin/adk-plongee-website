<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>ADK plongée login</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>

<?php include("tools/navbar.php"); ?>

  <div class="section no-pad-bot" id="index-banner">
  	<div class="container">
    	<br><br>
        <div class="row center">
            <span class="flow-text" col s12">Indentifiez-vous pour accéder à l'espace membre :</span>
            </div>
            <div class="row center">
                <form class="col s12" action="home.php" method="post">
                    <div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="icon_prefix" type="text" class="validate" name="login">
                            <label for="icon_prefix">Pseudo</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">https</i>
                            <input id="password" type="password" class="validate" name='password'>
                            <label for="password">Mot de passe</label>
                        </div>
                    </div>
	                <div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">email</i>
                            <input id="mail" type="text" class="validate" name="mail">
                            <label for="mail">Ou Mail</label>
                        </div>
                        <div class="input-field col s6">
                        </div>
                    </div>
                    <div class="row center">
                        <button class="btn waves-effect waves-light blue darken-4" type="submit" name="submit">Se connecter</button> 
                    </div>
                    <div class="row center">
                        <a class="waves-effect waves-light btn blue darken-4" href="registration.php">Créer un compte</a>
                    </div>
                    <div class="row center">
                        <a class="waves-effect waves-light btn blue darken-4" href="forgotten_password.php">Mot de passe oublié</a>
                    </div>
                </form>
            </div>
        </div>
  	</div>
  </div>

  <div id="index-banner" class="parallax-container">
    <div class="parallax"><img class="responsive-img" src="img/bioSurTole1.jpg" alt="Unsplashed background img 1"></div>
  </div>

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <?php include("tools/scripts.php"); ?>

</body>


</html>