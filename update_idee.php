<?php
// Inclure le fichier de configuration et établir la connexion
require_once "connectioncrud.php";

// Initialiser les variables avec des valeurs par défaut
$ID = $Titre_idee = $Commentaires_idee = $Categorie_idee = $DateSoumission_idee = $Etat_idee = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $ID = isset($_POST['ID']) ? $_POST['ID'] : "";
    $Titre_idee = isset($_POST['Titre_idee']) ? $_POST['Titre_idee'] : "";
    $Commentaires_idee = isset($_POST['Commentaires_idee']) ? $_POST['Commentaires_idee'] : "";
    $Categorie_idee = isset($_POST['Categorie_idee']) ? $_POST['Categorie_idee'] : "";
    $DateSoumission_idee = isset($_POST['DateSoumission_idee']) ? $_POST['DateSoumission_idee'] : "";
    $Etat_idee = isset($_POST['Etat_idee']) ? $_POST['Etat_idee'] : "";

    // Mettre à jour les données dans la base de données en utilisant une requête préparée pour éviter les injections SQL
    $sql = "UPDATE boite_a_idee SET
            Titre_idee = ?,
            Commentaires_idee = ?,
            Categorie_idee = ?,
            DateSoumission_idee = ?,
            Etat_idee = ?
            WHERE ID = ?";
    
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("sssssi", $Titre_idee, $Commentaires_idee, $Categorie_idee, $DateSoumission_idee, $Etat_idee, $ID);

    if ($stmt->execute()) {
        // Rediriger vers la page listcrud_idee.php
        header("Location: listcrud_idee.php");
        exit(); // Assurez-vous de terminer le script après la redirection
    } else {
        echo "Erreur lors de la mise à jour : " . $stmt->error;
    }

    // Fermer la requête préparée
    $stmt->close();
} else {
    // Si le formulaire n'a pas été soumis, récupérer les données de la base de données pour le formulaire de modification
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM boite_a_idee WHERE ID = ?";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $ID = $row['ID'];
            $Titre_idee = $row['Titre_idee'];
            $Commentaires_idee = $row['Commentaires_idee'];
            $Categorie_idee = $row['Categorie_idee'];
            $DateSoumission_idee = $row['DateSoumission_idee'];
            $Etat_idee = $row['Etat_idee'];
        } else {
            echo "Aucune idée trouvée avec cet identifiant.";
        }
    } else {
        echo "Aucun identifiant d'idée fourni.";
    }
}

// Fermer la connexion à la base de données
$connexion->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les idées</title>
    <style>
       body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 {
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }
        .btn-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-save {
            background-color: #3498db;
            color: white;
        }
        .btn-cancel {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Modifier les idées.</h2>
        <form action="update_idee.php" method="post">
            <input type="hidden" name="ID" value="<?= htmlspecialchars($ID) ?>">

            <label for="Titre_idee">Titre de l'idée:</label>
            <input type="text" name="Titre_idee" value="<?= htmlspecialchars($Titre_idee) ?>" required>

            <label for="Commentaires_idee">Commentaires sur l'idée:</label>
            <textarea name="Commentaires_idee" rows="4" required><?= htmlspecialchars($Commentaires_idee) ?></textarea>

            <label for="Categorie_idee">Catégorie de l'idée:</label>
            <input type="text" name="Categorie_idee" value="<?= htmlspecialchars($Categorie_idee) ?>" required>

            <label for="DateSoumission_idee">Date de soumission:</label>
            <input type="date" name="DateSoumission_idee" value="<?= htmlspecialchars($DateSoumission_idee) ?>" required>

            <label for="Etat_idee">État de l'idée:</label>
            <select name="Etat_idee" required>
                <option value="En attente" <?= ($Etat_idee === "En attente") ? "selected" : "" ?>>En attente</option>
                <option value="Approuvé" <?= ($Etat_idee === "Approuvé") ? "selected" : "" ?>>Approuvé</option>
                <option value="Rejeté" <?= ($Etat_idee === "Rejeté") ? "selected" : "" ?>>Rejeté</option>
            </select>

            <div class="btn-container">
                <button type="submit" class="btn btn-save">Enregistrer</button>
                <a href="listcrud_idee.php" class="btn btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>
