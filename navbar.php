

  <ul id="club_navBar" class="dropdown-content">
    <li><a href="#">Historique</a></li>
    <li><a href="#">Le club en chiffres</a></li>
  </ul>
  
  <ul id="outils_navBar" class="dropdown-content">
	<li><a href="liste_evenements.php">Liste des événements</a></li>
	<li><a href="#">Sites de plongées</a></li>
  </ul>
  
	<ul id="outils_admin_navBar" class="dropdown-content">
		<li><a href="suppr_evt.php">Suppression d'événements</a></li>
	</ul>
  
  
  <nav class="blue darken-4" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="index.php" class="brand-logo">ADK-plongée</a>
      <ul class="right hide-on-med-and-down">
                <!-- Dropdown Trigger -->
        <li><a class="dropdown-button" href="#!" data-activates="club_navBar">Le club<i class="material-icons right">arrow_drop_down</i></a></li>

        <li><a href="#">Contact</a></li>

        <?php  
			// Affichage pour les membres
          if(isset($_SESSION['pseudo']) AND isset($_SESSION['privilege'])) // Si membre
          {
            ?>
			  <li><a class="dropdown-button" href="#!" data-activates="outils_navBar">Outils<i class="material-icons right">arrow_drop_down</i></a></li>
			  
            <li><a href="logout.php">Déconnexion</a></li>
            <li><a href="home.php"><?php echo $_SESSION['pseudo']; ?></a></li>
            <?php   
			// Affichage pour les Admins en plus des membres
            if($_SESSION['privilege']='administrateur') // Si admin
            {
              ?>
				<li><a class="dropdown-button" href="#!" data-activates="outils_admin_navBar">Outils Admin<i class="material-icons right">arrow_drop_down</i></a></li>
              <?php 
            }
          }

          else // Si non membre
          {
            ?>
            <li><a href="login.php">Accès membre</a></li>
            <?php 
          }
        ?>

      </ul>
      <ul id="nav-mobile" class="sidenav">
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>