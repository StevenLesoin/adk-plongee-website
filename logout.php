<?php
session_start(); // On démarre la session AVANT d'écrire du code HTML
session_unset(); //Detruit toutes les variables de la session en cours
session_destroy();//Destruit la session en cours
header('location: index.php');
?>

