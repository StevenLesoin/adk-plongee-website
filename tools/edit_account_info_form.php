  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
        <div class="row center">
            <span class="flow-text col s12">Veuillez compléter les nouvelles informations pour votre compte :</span>
            </div>
            <div class="row center">
                <form class="col s12" action="edit_account_info.php" method="post">
                    <div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <input placeholder="<?php echo $_SESSION['pseudo']; ?>" id="login" type="text" class="validate" name="login">
                            <!-- <label for="login">Pseudo</label> -->
                            <span class="helper-text">Pseudo</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">email</i>
                            <input placeholder="<?php echo $_SESSION['email']; ?>" id="email" type="email" class="validate" name="email">
                            <!-- <label for="email">email</label> -->
                            <span class="helper-text">Email</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_box</i>
                            <input placeholder="<?php echo $_SESSION['prenom']; ?>" id="surname" type="text" class="validate" name='surname'>
                            <!-- <label for="surname">Prénom</label> -->
                            <span class="helper-text">Prénom</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_box</i>
                            <input placeholder="<?php echo $_SESSION['nom']; ?>" id="name" type="text" class="validate" name='name'>
                            <!-- <label for="name">Nom</label> -->
                            <span class="helper-text">Nom</span>
                        </div>
                        <div class="row center">
                            <span class="flow-text">Veuillez saisir votre mot de passe :</span>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">https</i>
                            <input id="password" type="password" class="validate" name='password'>
                            <label for="password">Mot de passe</label>
                        </div>
                    </div>
                    <div class="row center">
                        <button class="btn waves-effect waves-light blue darken-4" type="submit" name="submit">Valider les modifications</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>