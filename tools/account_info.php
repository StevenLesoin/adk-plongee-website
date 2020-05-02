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
                        <span class="helper-text" data-error="wrong" data-success="right">Pseudo</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">email</i>
                        <input id="email" type="email" class="validate center" name="email" disabled value="<?php echo $_SESSION['email']; ?>">
                        <span class="helper-text" data-error="wrong" data-success="right">Email</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">account_box</i>
                        <input id="surname" type="text" class="validate center" name='surname'  disabled value="<?php echo $_SESSION['prenom']; ?>">
                        <span class="helper-text" data-error="wrong" data-success="right">Prénom</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">account_box</i>
                        <input id="name" type="text" class="validate center" name='name' disabled value="<?php echo $_SESSION['nom']; ?>">
                        <span class="helper-text" data-error="wrong" data-success="right">Nom</span>
                    </div>
                </div>
                <div class="row center">
                    <a class="waves-effect waves-light btn blue darken-4" href="edit_account_info.php">Modifier ces informations</a>
                </div>
                <div class="row center">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">school</i>
                        <input id="niv_plongeur" type="text" class="validate center" name='niv_plongeur' disabled value="N<?php echo $_SESSION['niv_plongeur']; ?>">
                        <span class="helper-text" data-error="wrong" data-success="right">Niveau de plongée</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">supervisor_account</i>
                        <input id="niv_encadrant" type="text" class="validate center" name='niv_encadrant' disabled value="E<?php echo $_SESSION['niv_encadrant']; ?>">
                        <span class="helper-text" data-error="wrong" data-success="right">Niveau d'encadrement</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">local_pharmacy</i>
                        <input id="certif_med" type="text" class="validate center" name='certif_med' disabled value="<?php echo date('d-m-Y', strtotime($_SESSION['certif_med'])); ?>">
                        <span class="helper-text" data-error="wrong" data-success="right">Date du certificat médical</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="privilege" type="text" class="validate center" name="privilege" disabled value="<?php echo $_SESSION['privilege']; ?>">
                        <span class="helper-text" data-error="wrong" data-success="right">Type de compte</span>
                    </div>
                </div>
                <div class="row center">
                    <a class="waves-effect waves-light btn blue darken-4" href="edit_password.php">Modifier le mot de passe</a>
                </div>
            </form>
        </div>
    </div>
    </div>
  </div>