<!-- $resultat must be set in php before include this page -->
    <br><br>
    <div class="row center">
      <span class="flow-text col s12">Résumé de la liste des membres :</span>
    </div>
    <div class="container">
      <table class="striped centered responsive-table">
        <thead>
          <tr>
              <th>Inscrits</th>
              <th>Actifs</th>
              <th>Inactifs</th>
              <th>En attente de validation</th>
              <th>Certif périmé</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $nbInscrits = 0;
          $nbActifs = 0;
          $nbInactifs = 0;
          $nbAttente = 0;
          $nbCertifs = 0;
          while($resultat = $req->fetch())
          { 
            $nbInscrits++;
            if($resultat['actif_saison'] == 1){
              $nbActifs++;
            }else{
              $nbInactifs++;
            }
            if(strtotime("now") > strtotime($resultat['certif_med'].' + 1 YEAR')){ // Si certificat dépassé de plus d'un an
              $nbCertifs++;
            }
            if($resultat['inscription_valide'] == 0){
              $nbAttente++;
            }
          } 
          ?>
          <tr>
            <td><?php echo $nbInscrits ?></td>
            <td><?php echo $nbActifs ?></td>
            <td><?php echo $nbInactifs ?></td>
            <td><?php echo $nbAttente ?></td>
            <td><?php echo $nbCertifs ?></td>             
          </tr>
        </tbody>
      </table>
    </div>