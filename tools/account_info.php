  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
        <div class="row center">
            <span class="flow-text" col s12">Mon compte :</span>
        </div>
        <div class="row center">
            <form class="col s12" action="registration.php" method="post">
                <div class="row center">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="login" type="text" class="validate center" name="login" disabled value="<?php echo $_SESSION['pseudo']; ?>">
                        <!-- <label for="login">Pseudo</label> -->
                        <span class="helper-text" data-error="wrong" data-success="right">Pseudo</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">email</i>
                        <input id="email" type="email" class="validate center" name="email" disabled value="<?php echo $_SESSION['email']; ?>">
                        <!-- <label for="email">email</label> -->
                        <span class="helper-text" data-error="wrong" data-success="right">Email</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">account_box</i>
                        <input id="surname" type="text" class="validate center" name='surname'  disabled value="<?php echo $_SESSION['prenom']; ?>">
                        <!-- <label for="surname">Prénom</label> -->
                        <span class="helper-text" data-error="wrong" data-success="right">Prénom</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">account_box</i>
                        <input id="name" type="text" class="validate center" name='name' disabled value="<?php echo $_SESSION['nom']; ?>">
                        <!-- <label for="name">Nom</label> -->
                        <span class="helper-text" data-error="wrong" data-success="right">Nom</span>
                    </div>
                </div>
                <div class="row center">
                    <a class="waves-effect waves-light btn blue darken-4" href="edit_account_info.php">Modifier ces informations</a>
                </div>
                <div class="row center">
                    <a class="waves-effect waves-light btn blue darken-4" href="edit_password.php">Modifier le mot de passe</a>
                </div>
            </form>
        </div>
    </div>
    </div>
  </div>