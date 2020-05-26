
<?php  function isValid($date, $format = 'd/m/Y'){
    $dt = DateTime::createFromFormat($format, $date);
    return $dt && $dt->format($format) === $date;
  }
  ?>

<?php  function isInscrit($id_membre, $id_evt){
    include("tools/data_base_connection.php");
	$req2= $bdd->prepare('SELECT * FROM inscriptions WHERE id_evt=:id_evt'); 
	$req2->execute(array(
				'id_evt' => $id_evt));
	$dt=0;
	while ($inscrit = $req2->fetch())		// Dans la table des membres
	{
		if($inscrit[1]==$_SESSION['id'])	// Est ce que la ligne récupéré correspond à l'inscription du membre connecté
		{
			$dt=1;
		}
	}	
	return $dt;
  }
  ?> 

  
<?php function isPasMalade(){ // Si connecté, on propose d'ajouter une plongée, sinon, on ne montre pas le lien

	// Determination de la date d'il y a un an
	$yaunan = strtotime('-1 year -1 day');		// timestamp d'il y a un an	
	$yaunanmoinsunmois = strtotime('-1 year +1 month');
	if(strtotime($_SESSION['certif_med'])<$yaunan)		// Si le gars est pas à jour de certif médical, on lui affiche une message énorme en rouge sur les inscriptions
	{?>
		<div class="row center">
			<span class="flow-text" col s12"><b style='color: red;'>Attention, votre certificat médical n'est pas à jour !!</b></span>
		</div>
	<?php
	}
	else if(strtotime($_SESSION['certif_med'])<$yaunanmoinsunmois)
	{?>
		<div class="row center">
			<span class="flow-text" col s12"><b style='color: orange;'>Attention, votre certificat médical expire le <?php echo date("D-d/m/Y",strtotime('+1 year',strtotime($_SESSION['certif_med'])))?></b></span>
		</div>
	<?php
	}
}?>  
  
  								