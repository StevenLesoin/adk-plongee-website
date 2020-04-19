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



<?php include("navbar.php"); ?>

<?php
/*$pass_hache = password_hash("LucieCarof1*", PASSWORD_DEFAULT);
echo $pass_hache; */
?>

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
                        <button class="btn waves-effect waves-light blue darken-4" type="submit" name="submit">Se connecter</button> 
                    </div>
                </form>
            </div>
        </div>
  	</div>
  </div>

  <?php include("footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

</body>


</html>