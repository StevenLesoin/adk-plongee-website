  <?php  
  // Définition des constantes du club : 

	define("CST_add_site","http://www.adkplongee.ovh/");
  
	define("CST_Ajout_Evt",2);					// 3ième champ de la table pour les préférences de mail associés à un nouvel événement
	define("CST_Modf_Evt",3);					// 4ième champ de la table pour les préférences de mail associés à une modification d'événement
	define("CST_Suppression_Evt",4);			// 5ième champ de la table pour les préférences de mail associés à la suppression
	define("CST_Sortie_Annulee",5);				// 6ième champ de la table pour les préférences de mail associés à l'annulation d'un evénement si pas les conditions nécessaires
 ?>


  <ul id="club_navBar" class="dropdown-content">
	  <li><a href="fonctionnement_site.php">FAQ</a></li>
  </ul>
  
  <ul id="outils_navBar" class="dropdown-content">
	 <li><a href="liste_evenements.php">Liste des événements</a></li>
	 <li><a href="creation_evt.php">Ajout d'événement</a></li>
  </ul>
  
	<ul id="outils_admin_navBar" class="dropdown-content">
		<li><a href="suppr_evt.php">Suppression d'événements</a></li>
		<li><a href="admin.php">Infos membres</a></li>
	</ul>
  
<div class="navbar-fixed">
  <nav class="blue darken-4 col s12" role="navigation">
    <div class="nav-wrapper container">
      <img class="responsive-img" src="img/logo_adk.png" alt="Logo ADK plongée" id="logoAdkNavbar">
      <a id="logo-container" href="index.php" class="brand-logo">ADK plongée</a>
      <a href="#" data-target="mobile-navbar" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="#">Contact</a></li>
        <!-- Dropdown Trigger -->
        <li><a class="dropdown-trigger" href="#!" data-target="club_navBar">Le club<i class="material-icons right">arrow_drop_down</i></a></li>

        <?php  
			    // Affichage pour les membres
          if(isset($_SESSION['pseudo']) AND isset($_SESSION['privilege'])) // Si membre
          {
            ?>
			      <li><a class="dropdown-button" href="#!" data-target="outils_navBar">Outils<i class="material-icons right">arrow_drop_down</i></a></li>
            <?php   
			      // Affichage pour les Admins en plus des membres
			if($_SESSION['privilege']=='administrateur' OR $_SESSION['privilege']=='bureau') // Si admin
            {
            ?>
				  <li><a class="dropdown-button" href="#!" data-target="outils_admin_navBar">Outils Admin<i class="material-icons right">arrow_drop_down</i></a></li>
            <?php 
            }
            ?>
            <li><a href="logout.php">Déconnexion</a></li>
            <li><a href="home.php">Mon compte (<?php echo $_SESSION['pseudo']; ?>)</a></li>
          <?php 
          }
          else // Si non membre
          {
            ?>
            <li><a href="login.php">Accès membre</a></li>
            <?php 
          }
        ?>

      </ul>
    </div>
  </nav>
</div>
 
      <ul class="sidenav" id="mobile-navbar">
        <li><a href="#">Contact</a></li>
        <li><a href="fonctionnement_site.php">FAQ</a></li>

        <?php  
            // Affichage pour les membres
            if(isset($_SESSION['pseudo']) AND isset($_SESSION['privilege'])) // Si membre
            {
              ?>
              <li><a href="liste_evenements.php">Liste des événements</a></li>
              <li><a href="creation_evt.php">Ajout d'événement</a></li>
              <?php   
              // Affichage pour les Admins en plus des membres
              if($_SESSION['privilege']==('administrateur' OR 'bureau')) // Si admin
              {
              ?>
                <li><a href="suppr_evt.php">Suppression d'événements</a></li>
                <li><a href="admin.php">Infos membres</a></li>
              <?php 
              }
              ?>
              <li><a href="logout.php">Déconnexion</a></li>
              <li><a href="home.php">Mon compte (<?php echo $_SESSION['pseudo']; ?>)</a></li>
            <?php 
            }
            else // Si non membre
            {
              ?>
              <li><a href="login.php">Accès membre</a></li>
              <?php 
            }
          ?>
      </ul>
