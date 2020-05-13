
  <?php  
  // Définition des constantes du club : 

	define("CST_niv_min_DP",5);					// Au club, un DP est N5 mini
	define("CST_niv_min_encad_DP_piscine",1);	// E1 pour être DP piscine 
	define("CST_min_membres_sorties",4);		// 4 inscrits minimum, possibilité d'un invité sur les 4. 
	define("CST_invité_pos",1);					// Possiblité de remplacer un membre par un invité seulement
	define("CST_invite_comptent",0);			// Les invités ne comptent pas comme des inscrits car il ne sont pas prioritaires -> On permet l'inscription même si c'est complet a cause d'invités
  
  include("tools/data_base_connection.php");	
  
  // fonction qui détermine si il y a un DP présent sur l'événement
  // Renvoi 1 si y'a un DP, 0 sinon
  function isDP($id_evt){
	include("tools/data_base_connection.php");	
	$yaunDP=0;
	$req2= $bdd->prepare('SELECT * FROM inscriptions WHERE id_evt="'.$id_evt.'"'); 
	$req2->execute(array());
	
	while ($inscrit = $req2->fetch() AND $yaunDP==0)		// Tant qu'il y a des inscrits, on les affiche
	{
		$id_inscrit = $inscrit[1];	
		$req3= $bdd->prepare('SELECT * FROM membres WHERE id="'.$id_inscrit.'"'); // 
		$req3->execute(array());
		$donnees_membre = $req3->fetch();
					
		$id_membre = $donnees_membre[0];
		$nom_membre = $donnees_membre[3];
		$prenom_membre = $donnees_membre[4];
		$certif_membre = $donnees_membre[11];
		$niv_membre = $donnees_membre[8];
		$niv_encad = $donnees_membre[9];
		$comm_membre = $inscrit[3];
		
		if($niv_membre>=CST_niv_min_DP)
		{
			$yaunDP=1;
		}
		$req3->closeCursor(); //requête terminée
	}
	$req2->closeCursor(); //requête terminée
	
	return $yaunDP;	
  }
  
  // Fonction qui détermine si il y a un DP piscine présent sur l'événement
  // Renvoi 1 si y'a un DP, 0 sinon
   function isDP_piscine($id_evt){
	include("tools/data_base_connection.php");	
	$yaunDP=0;
	$req2= $bdd->prepare('SELECT * FROM inscriptions WHERE id_evt="'.$id_evt.'"'); 
	$req2->execute(array());
	
	while ($inscrit = $req2->fetch() AND $yaunDP==0)		// Tant qu'il y a des inscrits, on les affiche
	{
		$id_inscrit = $inscrit[1];
		$req3= $bdd->prepare('SELECT * FROM membres WHERE id="'.$id_inscrit.'"'); // 
		$req3->execute(array());
		$donnees_membre = $req3->fetch();
					
		$id_membre = $donnees_membre[0];
		$nom_membre = $donnees_membre[3];
		$prenom_membre = $donnees_membre[4];
		$certif_membre = $donnees_membre[11];
		$niv_membre = $donnees_membre[8];
		$niv_encad = $donnees_membre[9];
		$comm_membre = $inscrit[3];
		
		if($niv_encad>=CST_niv_min_encad_DP_piscine)
		{
			$yaunDP=1;
		}
		$req3->closeCursor(); //requête terminée
	}
	$req2->closeCursor(); //requête terminée

	
	return $yaunDP;	
  }
  
  
  // Fonction qui détermine si il y a suffisament d'inscrits à cette sortie
  // Statut actuel : 3 membres + 1 invité ou 4 membres
  // Renvoi 1 si les conditions de nombres sont OK, 0 sinon
  function isEnough($id_evt)
  {
	include("tools/data_base_connection.php");	
	$nb_membres = 0;
	$nb_invites = 0;
	
	$req2= $bdd->prepare('SELECT * FROM inscriptions WHERE id_evt="'.$id_evt.'"'); 
	$req2->execute(array());
	$req4= $bdd->prepare('SELECT * FROM invites WHERE id_evt="'.$id_evt.'"'); 
	$req4->execute(array());
	
	while ($req2->fetch())		// Dans la table des membres
	{
		$nb_membres++;
	}
	while ($req4->fetch())		// Dans la table des membres
	{
		$nb_invites++;
	}
	if($nb_membres>=CST_min_membres_sorties OR ($nb_membres==(CST_min_membres_sorties-CST_invité_pos) AND $nb_invites>=CST_invité_pos))
	{
		$enough = 1;
	}
	else
	{
		$enough = 0;
	}
	$req2->closeCursor(); //requête terminée
	$req4->closeCursor(); //requête terminée
	return $enough;
  }
  
  // Fonction qui détermine si la sortie est complète
  // Renvoi 1 si la sortie est complète, 0 sinon
  // Les invités ne comptent pas car non prioritaires sauf si la constante CST_invite_comptent est à 1! 
  
  function isFull($id_evt,$nb_max)
  {
	include("tools/data_base_connection.php");	
	$nb_membres = 0;
	$nb_invites = 0;
	
	$req2= $bdd->prepare('SELECT * FROM inscriptions WHERE id_evt="'.$id_evt.'"'); 
	$req2->execute(array());
	$req4= $bdd->prepare('SELECT * FROM invites WHERE id_evt="'.$id_evt.'"'); 
	$req4->execute(array());
	
	while ($req2->fetch())		// Dans la table des membres
	{
		$nb_membres++;
	}
	while ($req4->fetch())		// Dans la table des membres
	{
		$nb_invites++;
	}
	// On compte le nombre de mecs en prennant en compte les invités ou pas (paramètre)
	if(($nb_membres+(CST_invite_comptent*$nb_invites))<$nb_max)
	{
		$max = 0;
	}
	else
	{
		$max = 1;
	}
	$req2->closeCursor(); //requête terminée
	$req4->closeCursor(); //requête terminée
	return $max;
  }
  
  ?>