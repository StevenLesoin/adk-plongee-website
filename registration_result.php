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
  include("tools/navbar.php"); 

  include("tools/data_base_connection.php");

  if(isset($_POST['login']) AND isset($_POST['password1']) AND isset($_POST['password2']) AND isset($_POST['email']) AND isset($_POST['name']) AND isset($_POST['surname']))
  {
    // Vérification de la validité des informations
    $pseudo = htmlspecialchars($_POST['login']);
    $req1 = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
    $req1->execute(array(
        'pseudo' => $pseudo));
    $resultat = $req1->fetch();
    if(!$resultat)
    {
      if($_POST['password1']==$_POST['password2'])
      {
        if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email']))
        {
          echo 'L\'adresse ' . $_POST['email'] . ' est <strong>valide</strong> !';
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
        }
        else
        {
          echo 'L\'adresse ' . htmlspecialchars($_POST['email']) . ' n\'est pas valide.';
        }
      }
      else
      {
        echo 'Les deux mots de passe saisis sont différents.';
      }
    }
    else
    {
      echo 'Ce pseudo n\'est pas disponible.';
    }
  }
  else
  {
    echo 'Un champ n\a pas été rempli.';
  } 

  include("tools/footer.php"); 
  ?>

  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  </body>

</html>