<?php
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

// Définir des variables par défaut
$nomCategorie = $descriptionCategorie = $couleurCategorie = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nomCategorie = $conn->real_escape_string($_POST['NomCategorie']);
    $descriptionCategorie = $conn->real_escape_string($_POST['Description_categorie']);
    $couleurCategorie = $conn->real_escape_string($_POST['Couleur_categorie']);

    // Vérifier si l'ID de la catégorie est passé via la requête GET
    if (isset($_GET['id'])) {
        $categorieId = $conn->real_escape_string($_GET['id']);

        // Mettre à jour les données de la catégorie dans la base de données
        $updateSql = "UPDATE categorie SET NomCategorie=?, Description_categorie=?, Couleur_categorie=? WHERE id=?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("sssi", $nomCategorie, $descriptionCategorie, $couleurCategorie, $categorieId);

        // Vérifier l'exécution de la requête
        if ($stmt->execute()) {
            // Redirection vers listcrud_categorie.php après l'enregistrement des modifications
            header("Location: listcrud_categorie.php");
            exit();
        } else {
            echo "Erreur lors de l'enregistrement des modifications : " . $stmt->error;
        }

        // Fermer la déclaration préparée
        $stmt->close();
    } else {
        echo "ID de catégorie non spécifié.";
    }
}

// Vérifier si l'ID de la catégorie est passé via la requête GET
if (isset($_GET['id'])) {
    $categorieId = $conn->real_escape_string($_GET['id']);

    // Récupérer les données de la catégorie spécifique
    $sql = "SELECT NomCategorie, Description_categorie, Couleur_categorie FROM categorie WHERE id = $categorieId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $detailsCategorie = $result->fetch_assoc();
    } else {
        echo "Aucune catégorie trouvée avec cet ID.";
        // Vous pouvez rediriger l'utilisateur ou gérer l'erreur d'une autre manière.
    }
}

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la catégorie</title>
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
        <h2>Modifier la catégorie :</h2>
        <form action="#" method="post">
            <label for="NomCategorie">Nom de la catégorie:</label>
            <input type="text" name="NomCategorie" value="<?php echo $detailsCategorie['NomCategorie']; ?>" required>

            <label for="Description_categorie">Description de la catégorie:</label>
            <textarea name="Description_categorie" rows="4" required><?php echo $detailsCategorie['Description_categorie']; ?></textarea>

            <label for="Couleur_categorie">Couleur de la catégorie:</label>
            <input type="text" name="Couleur_categorie" value="<?php echo $detailsCategorie['Couleur_categorie']; ?>" required>

            <div class="btn-container">
                <button class="btn btn-save" type="submit">Enregistrer les modifications</button>
                <button class="btn btn-cancel" onclick="window.location.href='listcrud_categorie.php'">Annuler</button>
            </div>
        </form>
    </div>
</body>
</html>
