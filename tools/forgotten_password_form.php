  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
        <div class="row center">
            <span class="flow-text col s12">Veuillez saisir les informations suivantes :</span>
            </div>
            <div class="row center">
                <form class="col s12" action="forgotten_password.php" method="post">
                    <div class="row center">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="pseudo" type="text" class="validate" name="pseudo">
                            <label for="pseudo">Pseudo</label>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input id="email" type="email" class="validate" name="email">
                            <label for="email">email</label>
                            <span class="helper-text" data-error="wrong" data-success="right"></span>
                        </div>
                    </div>
                    <div class="row center">
                        <button class="btn waves-effect waves-light blue darken-4" type="submit" name="submit">Générer un nouveau mot de passe</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>