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

  <?php include("tools/navbar.php"); ?>


  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <h1 class="header center yellow-text">Bienvenue !</h1>
        <div class="row center">
          <img class="row center" src="img/logo_adk.png" alt="Logo ADK plongée" id="logoAdk">
        </div>
      </div>
    </div>
    <div class="parallax"><img class="responsive-img" src="img/tole2.jpg" alt="Unsplashed background img 1"></div>
  </div>

  <div class="container">
    <div class="section">
      <!--   Icon Section   -->
      <div class="row">
        <div class="col s4">
          <div class="icon-block">
            <h2 class="center blue-text text-darken-4"><i class="material-icons">sentiment_very_satisfied</i></h2>
            <h5 class="center">A propos</h5>
            <p class="light">Site web du club associatif de plongée de l'ADK (Association sportive du Comité d'Entreprise de Thales DMS Brest) bla bla bla.</p>
          </div>
        </div>
        <div class="col s4">
          <div class="icon-block">
            <h2 class="center blue-text text-darken-4"><i class="material-icons">group</i></h2>
            <h5 class="center">Le site</h5>
            <p class="light">Description outils et capacités du site pour les membres bla bla bla</p>
          </div>
        </div>
        <div class="col s4">
          <div class="icon-block">
            <h2 class="center blue-text text-darken-4"><i class="material-icons">share</i></h2>
            <h5 class="center">Actualité</h5>
            <p class="light">Partage de l'actualité du club, de médias et de retour d'expèriences bla bla bla</p>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div id="index-banner" class="parallax-container">
    <div class="parallax"><img class="responsive-img" src="img/tole1.jpg" alt="Unsplashed background img 1"></div>
  </div>

  <!-- <img class="responsive-img" src="img/tole2.jpg"> -->
        

  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <?php include("tools/scripts.php"); ?>

</body>


</html>
