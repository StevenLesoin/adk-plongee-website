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
                        <div class="input-field col s6 offset-s3">
                            <i class="material-icons prefix">local_pharmacy</i>
                            <input value="<?php echo date('d-m-Y', strtotime($resultat['certif_med'])); ?>" id="certif_med" class="datepicker" name='certif_med'> 
                            <span class="helper-text">Date du certificat médical</span>
                        </div>
                        <div class="input-field col s6 offset-s3">
                            <select name="privilege">
                                <?php
                                if($resultat['privilege']=='membre'){
                                ?> 
                                    <option value="membre">Membre</option>
                                    <option value="bureau">Bureau</option>
                                    <option value="administrateur">Administrateur</option>
                                <?php
                                }else if($resultat['privilege']=='bureau'){
                                ?> 
                                    <option value="bureau">Bureau</option>
                                    <option value="membre">Membre</option>
                                    <option value="administrateur">Administrateur</option>
                                <?php
                                }else if($resultat['privilege']=='administrateur'){
                                ?> 
                                    <option value="administrateur">Administrateur</option>
                                    <option value="membre">Membre</option>
                                    <option value="bureau">Bureau</option>
                                <?php
                                }
                                ?>
                            </select>
                            <label>Type de compte</label>
                        </div>
                        <div class="input-field col s6">
                            <!-- <i class="material-icons prefix">school</i> -->
                            <select name="niv_plongeur">
                                <option value="<?php echo $resultat['niv_plongeur']; ?>">N<?php echo $resultat['niv_plongeur']; ?></option>
                                <option value="0">N0</option>
                                <option value="1">N1</option>
                                <option value="2">N2</option>
                                <option value="3">N3</option>
                                <option value="3">N4</option>
                                <option value="3">N5</option>
                            </select>
                            <label>Niveau de plongée</label>
                            <i class="material-icons prefix">school</i>
                        </div>
                        <div class="input-field col s6">
                            <select name="niv_encadrant">
                                <option value="<?php echo $resultat['niv_encadrant']; ?>">E<?php echo $resultat['niv_encadrant']; ?></option>
                                <option value="0">E0</option>
                                <option value="1">E1</option>
                                <option value="2">E2</option>
                                <option value="3">E3</option>
                                <option value="3">E4</option>
                            </select>
                            <label>Niveau d'encadrement</label>
                            <i class="material-icons prefix">supervisor_account</i>
                        </div>
                        <div class="input-field col s6">
                            <select name="actif_saison">
                                <?php
                                if($resultat['actif_saison'] == 1){
                                ?> 
                                    <option value="1">Actif</option>
                                    <option value="0">Inactif</option>
                                <?php
                                }else if($resultat['actif_saison'] == 0){
                                ?> 
                                    <option value="0">Inactif</option>
                                    <option value="1">Actif</option>
                                <?php
                                }
                            ?>                                      
                            </select>
                            <label>Etat d'activité</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="inscription_valide">
                                <?php
                                if($resultat['inscription_valide'] == 1){
                                ?> 
                                    <option value="1">Validé</option>
                                    <option value="0">En attente</option>
                                <?php
                                }else if($resultat['inscription_valide'] == 0){
                                ?> 
                                    <option value="0">En attente</option>
                                    <option value="1">Validé</option>
                                <?php
                                }
                                ?> 
                            </select>
                            <label>Statut de l'inscription</label>
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
                <form class="col s12" action="edit_members_resume.php" method="post">
                    <input type="hidden" name="edit_member_id" value="<?php echo $_POST['edit_member_id'] ?>" />
                    <input type="hidden" name="delete_member_id" value="<?php echo $_POST['edit_member_id'] ?>" />
                    <br><br><br><br>
                    <button class="btn waves-effect waves-light red darken-2" type="submit" name="submit">Supprimer le compte</button> 
                </form>
            </div>
        </div>
    </div>
  </div>