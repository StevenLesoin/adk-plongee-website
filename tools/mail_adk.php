<?php
function sendMailAdk($p_destinataire,$p_objet,$p_message)
{
	$destinataire = $p_destinataire;
	$expediteur = 'test@adk.fr';
	$copie = NULL;
	$copie_cachee = NULL;
	$objet = $p_objet; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Reply-To: '.$expediteur."\n"; 
	$headers .= 'From: "ADK plongée website"<'.$expediteur.'>'."\n"; 
	$headers .= 'Delivered-to: '.$destinataire."\n"; 
	$headers .= 'Cc: '.$copie."\n"; 
	$headers .= 'Bcc: '.$copie_cachee."\n\n";   
	$message = $p_message;

	return mail($destinataire, $objet, $message, $headers);
}
?>