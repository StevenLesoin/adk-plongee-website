  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
        <div class="row center">
            <span class="flow-text" col s12">Veuillez compléter les données suivantes pour vous créer un compte :</span>
            </div>
            <div class="row center">
                <form class="col s12" action="registration.php" method="post">
                    <div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="login" type="text" class="validate" name="login">
                            <label for="login">Pseudo</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">email</i>
                            <input id="email" type="email" class="validate" name="email">
                            <label for="email">email</label>
                            <span class="helper-text" data-error="wrong" data-success="right"></span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_box</i>
                            <input id="surname" type="text" class="validate" name='surname'>
                            <label for="surname">Prénom</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_box</i>
                            <input id="name" type="text" class="validate" name='name'>
                            <label for="name">Nom</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">https</i>
                            <input id="password1" type="password" class="validate" name='password1'>
                            <label for="password1">Mot de passe</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">https</i>
                            <input id="password2" type="password" class="validate" name='password2'>
                            <label for="password2">Confirmez le mot de passe</label>
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