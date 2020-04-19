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

  <?php 
    if(empty($_POST['login']) AND empty($_POST['password1']) AND empty($_POST['password2']) AND empty($_POST['email']) AND empty($_POST['name']) AND empty($_POST['surname'])) // La page est vierge
    {
      include("tools/registration_form.php");
    }
    else if(empty($_POST['login']) OR empty($_POST['password1']) OR empty($_POST['password2']) OR empty($_POST['email']) OR empty($_POST['name']) OR empty($_POST['surname'])) // Un ou plusieurs champs du formulaire sont vides
    {
      include("tools/registration_failure.php"); 
      include("tools/registration_form.php"); 
    }
    else // Tous les champs du formulaire sont remplis 
    {
      include("tools/data_base_connection.php");
      // Vérification de la validité des informations
      $pseudo = htmlspecialchars($_POST['login']);
      $req1 = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
      $req1->execute(array(
        'pseudo' => $pseudo));
      $resultat = $req1->fetch();
      if(!$resultat) // Le pseudo est disponible
      {
        if($_POST['password1']==$_POST['password2']) 
        {
          if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'])) // L'email a une forme valide
          {
            // Hachage du mot de passe
            $pass_hache = password_hash($_POST['password1'], PASSWORD_DEFAULT);

            // Insertion
            $req2= $bdd->prepare('INSERT INTO membres(pseudo, mdp, email, nom, prenom, privilege) VALUES(:pseudo, :password, :email, :nom, :prenom, \'membre\')');
            $privilege = "membre";
            $req2->execute(array(
              'pseudo' => $pseudo,
              'password' => $pass_hache,            
              'email' => $_POST['email'],
              'nom' => $_POST['name'],
              'prenom' => $_POST['surname']));

            include("tools/registration_success.php"); 
            $req2->closeCursor(); //requête terminée
            ?>
            <div class="row center">
              <a class="waves-effect waves-light btn blue darken-4" href="login.php">Se connecter</a>
            </div>
            <?php
          }
          else // L'email n'a pas une forme valide
          {
            include("tools/registration_failure.php"); 
            include("tools/registration_form.php");        
          }
        }
        else
        {
          include("tools/registration_failure.php"); 
          include("tools/registration_password_failure.php");
          include("tools/registration_form.php");  
        }
      }
      else // Le pseudo est déjà pris
      {
        include("tools/registration_failure.php"); 
        include("tools/registration_login_failure.php");
        include("tools/registration_form.php");  
      }

      $req1->closeCursor(); //requête terminée
    }

  ?>


  <?php include("tools/footer.php"); ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>

</html>