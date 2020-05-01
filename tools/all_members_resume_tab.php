<!-- $resultat must be set in php before include this page -->
    <div class="container">
      <table class="striped responsive-table">
        <thead>
          <tr>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Pseudo</th>
              <th>Email</th>
              <th>Type de compte</th>
              <th>Niveau de plongée</th>
              <th>Niveau d'encadrement</th>
              <th>Etat d'activité</th>
              <th>Date certificat médical</th>
              <th>Validité inscription</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while($resultat = $req0->fetch())
          { 
          ?>
            <tr>
              <td><?php echo $resultat['nom'] ?></td>
              <td><?php echo $resultat['prenom'] ?></td>
              <td><?php echo $resultat['pseudo'] ?></td>
              <td><?php echo $resultat['email'] ?></td>
              <td><?php echo $resultat['privilege'] ?></td>
              <td><?php echo $resultat['niv_plongeur'] ?></td>
              <td><?php echo $resultat['niv_encadrant'] ?></td>
              <td>
                  <?php
                    if($resultat['actif_saison'] == 1){
                    ?><p class="center green-text">ACTIF</p><?
                    }else if($resultat['actif_saison'] == 0){
                    ?><p class="center orange-text">INACTIF</p><?php 
                    }
                  ?>
              </td>
              <td><?php echo $resultat['certif_med'] ?></td>
              <td><?php
                    if($resultat['inscription_valide'] == 1)
                    {
                    ?>
                      <p class="center green-text">OK</p>
                    <?
                    }
                    else if($resultat['inscription_valide'] == 0)
                    {
                    ?>
                      <form action="admin.php" method="post">
                        <input type="hidden" name="validate_registration" value="1" />
                        <input type="hidden" name="validate_registration_member_id" value="<?php echo $resultat['id'] ?>" />
                        <button class="btn waves-effect waves-light red darken-2" type="submit" name="submit">Valider</button>
                      </form>
                    <?php
                    }
                  ?>  
              </td>
              <td>
                <form action="admin.php" method="post">
                  <input type="hidden" name="edit_member_id" value="<?php echo $resultat['id'] ?>" />
                  <button class="btn waves-effect waves-light blue darken-4" type="submit" name="submit">Mofifier</button>
                </form>
              </td>
            </tr>
          <?php 
          } 
          ?>
        </tbody>
      </table>
    </div>