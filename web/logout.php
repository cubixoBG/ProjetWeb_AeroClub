<?php
session_start(); // On récupère la session en cours
session_unset(); // On vide toutes les variables de session
session_destroy(); // On détruit techniquement la session

// On redirige vers la page de connexion ou l'accueil
header("Location: espace_membre.php");
exit();
?>