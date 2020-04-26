  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
        <div class="row center">
            <span class="flow-text col s12">Veuillez compléter les nouvelles informations pour le compte :</span>
            </div>
            <div class="row center">
                <form class="col s12" action="edit_members_resume.php" method="post">
                    <div class="row center">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <input value="<?php echo $resultat['pseudo']; ?>" value="<?php echo $resultat['pseudo']; ?>" id="login" type="text" class="validate" name="login">
                            <span class="helper-text">Pseudo</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">email</i>
                            <input value="<?php echo $resultat['email']; ?>" id="email" type="email" class="validate" name="email">
                            <span class="helper-text">Email</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_box</i>
                            <input value="<?php echo $resultat['prenom']; ?>" id="surname" type="text" class="validate" name='surname'>
                            <span class="helper-text">Prénom</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_box</i>
                            <input value="<?php echo $resultat['nom']; ?>" id="name" type="text" class="validate" name='name'>
                            <span class="helper-text">Nom</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">school</i>
                            <input value="<?php echo $resultat['niv_plongeur']; ?>" id="niv_plongeur" type="text" class="validate" name='niv_plongeur'>
                            <span class="helper-text">Niveau de plongée</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">supervisor_account</i>
                            <input value="<?php echo $resultat['niv_encadrant']; ?>" id="niv_encadrant" type="text" class="validate" name='niv_encadrant'>
                            <span class="helper-text">Niveau d'encadrement</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">local_pharmacy</i>
                            <input value="<?php echo $resultat['certif_med']; ?>" id="certif_med" type="text" class="validate" name='certif_med'>
                            <span class="helper-text">Date du certificat médical</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <input value="<?php echo $resultat['actif_saison']; ?>" id="actif_saison" type="text" class="validate" name='actif_saison'>
                            <span class="helper-text">Etat d'activité</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <input value="<?php echo $resultat['privilege']; ?>" id="privilege" type="text" class="validate" name='privilege'>
                            <span class="helper-text">Type de compte</span>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">account_circle</i>
                            <input value="<?php echo $resultat['inscription_valide']; ?>" id="inscription_valide" type="text" class="validate" name='inscription_valide'>
                            <span class="helper-text">Statut de l'inscription</span>
                        </div>
                    </div>
                    <div class="row center">
                        <span class="flow-text">Veuillez saisir votre mot de passe :</span>
                        <div class="input-field">
                            <i class="material-icons prefix">https</i>
                            <input id="password" type="password" class="validate" name='password'>
                            <label for="password">Mot de passe</label>
                        </div>
                        <input type="hidden" name="edit_member_id" value="<?php echo $_POST['edit_member_id'] ?>" />
                        <button class="btn waves-effect waves-light blue darken-4" type="submit" name="submit">Valider les modifications</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>