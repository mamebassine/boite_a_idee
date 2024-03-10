<?php
// Informations de connexion à la base de données
$serveur = "localhost";             // Nom du serveur MySQL
$utilisateur = "root";              // Nom d'utilisateur MySQL
$mot_de_passe = "";                  // Mot de passe MySQL 
$base_de_donnees = "application_boite_a_idee_collaborative"; // Nom de la base de données MySQL
// Initialisation de la connexion en dehors de la condition
$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);
// Vérification de la réussite de la connexion
if ($connexion->connect_error) {
    // Si la connexion échoue, affiche un message d'erreur et arrête le script
    die("La connexion a échoué : " . $connexion->connect_error);
}
// À ce stade, la connexion à la base de données a réussi et est stockée dans la variable $connexion. 
?>
