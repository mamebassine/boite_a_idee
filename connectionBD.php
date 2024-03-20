<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$nom_base_de_donnees = "application_boite_a_idee_collaborative";

// Connexion globale à la base de données
$connexion = null;

function connecter()
{
    global $connexion, $serveur, $utilisateur, $mot_de_passe, $nom_base_de_donnees;
    
    // Vérifie si la connexion est déjà établie
    if ($connexion !== null) {
        return $connexion;
    }

    // Créer une nouvelle connexion
    $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $nom_base_de_donnees);

    if ($connexion->connect_error) {
        die("La connexion a échoué : " . $connexion->connect_error);
    }

    return $connexion;
}
?>
