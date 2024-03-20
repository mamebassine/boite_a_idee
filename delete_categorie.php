<!-- delete_categorie.php -->
<?php
// Inclure le fichier de connexion à la base de données si nécessaire
// Exemple : include_once 'connexion.php';

// Vérifier si l'ID de la catégorie est passé via la requête GET
if(isset($_GET['id'])) {
    $categorieId = $_GET['id'];
    

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "application_boite_a_idee_collaborative";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Supprimer la catégorie avec l'ID spécifié
    $sql = "DELETE FROM categorie WHERE id = $categorieId";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Catégorie supprimée avec succès.</p>";
        echo '<div class="btn-container">
                <button class="btn btn-yes" onclick="window.location.href=\'listcrud_categorie.php\'">Oui</button>
                <button class="btn btn-no" onclick="window.location.href=\'listcrud_categorie.php\'">Non</button>
              </div>';
              
    } else {
        echo "Erreur lors de la suppression de la catégorie : " . $conn->error;
    }

    // Fermer la connexion
    $conn->close();
} else {
    echo "ID de catégorie non spécifié.";
}
?>
