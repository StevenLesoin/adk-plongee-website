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
              <td><?php echo $resultat['actif_saison'] ?></td>
              <td><?php echo $resultat['certif_med'] ?></td>
              <td><?php echo $resultat['inscription_valide'] ?></td>
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