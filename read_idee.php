<?php
// Inclure le fichier de configuration et établir la connexion
require_once "connectioncrud.php";

// Définir $row comme un tableau vide par défaut
$row = [];

// Vérifier si l'ID est passé en paramètre (par exemple, depuis l'URL)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête SQL pour la lecture d'un enregistrement spécifique
    $sql = "SELECT * FROM boite_a_idee WHERE ID = ?";
    $stmt = $connexion->prepare($sql);

    if ($stmt) {
        // Liaison du paramètre et exécution de la requête
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Récupération du résultat
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Aucun enregistrement trouvé avec l'ID spécifié";
        }

        // Fermer le statement
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête : " . $connexion->error;
    }
} else {
    echo "ID non spécifié pour la visualisation de l'enregistrement";
}

// Fermer la connexion
$connexion->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir l'enregistrement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            width: 70%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        p {
            margin: 5px 0;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin-top: 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Voir l'enregistrement</h1>

        <label>Titre</label>
        <p><?php echo isset($row["Titre_idee"]) ? $row["Titre_idee"] : ''; ?></p>

        <label>Commentaire</label>
        <p><?php echo isset($row["Commentaires_idee"]) ? $row["Commentaires_idee"] : ''; ?></p>

        <label>Categorie</label>
        <p><?php echo isset($row["Categorie_idee"]) ? $row["Categorie_idee"] : ''; ?></p>

        <label>Date de Soumission</label>
        <p><?php echo isset($row["DateSoumission_idee"]) ? $row["DateSoumission_idee"] : ''; ?></p>

        <label>État</label>
        <p><?php echo isset($row["Etat_idee"]) ? $row["Etat_idee"] : ''; ?></p>

        <a href="listcrud_idee.php" class="btn">Retour</a>
    </div>
</body>
</html>
