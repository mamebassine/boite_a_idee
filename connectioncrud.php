<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = ""; // Assurez-vous que le mot de passe est correct si nécessaire
$base_de_donnees = "application_boite_a_idee_collaborative";

// Initialisation de la connexion
$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

// Vérifier si la connexion a échoué
if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}
?>