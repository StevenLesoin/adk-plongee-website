  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
        <div class="row center">
            <span class="flow-text col s12">Veuillez compléter les nouvelles informations pour votre compte :</span>
            </div>
            <div class="row center">
                <form class="col s12" action="edit_password.php" method="post">
                    <div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">https</i>
                            <input id="new_password1" type="password" class="validate" name="new_password1">
                            <label for="new_password1">Nouveau mot de passe</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">https</i>
                            <input id="new_password2" type="password" class="validate" name="new_password2">
                            <label for="new_password2">Confirmer le nouveau mot de passe</label>
                        </div>
                        <div class="row center">
                            <?php 
                            if($_SESSION['oubli_mdp'] == 1) // Si connexion avec mot de passe temporaire
                            {
                            ?>   
                                <span class="flow-text">Veuillez saisir votre mot de passe provisoir :</span>
                            <?php
                            }else{
                            ?> 
                                <span class="flow-text">Veuillez saisir votre mot de passe actuel :</span>
                            <?php
                            }
                            ?> 
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">https</i>
                            <input id="password" type="password" class="validate" name='password'>
                            <label for="password">Mot de passe actuel</label>
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