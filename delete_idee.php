<?php
// Inclure le fichier de configuration et établir la connexion
require_once "connectioncrud.php";

// Vérifier si la connexion est établie
if ($connexion->connect_error) {
    die("La connexion a échoué : " . $connexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Récupérer l'ID de l'idée à supprimer
    $id = $_POST['id'];

    // Vérifier si l'ID est spécifié
    if (!empty($id)) {
        // Requête SQL pour la suppression en utilisant une requête préparée
        $sql = "DELETE FROM boite_a_idee WHERE id=?";

        // Préparation de la requête
        $stmt = $connexion->prepare($sql);

        // Vérifier si la préparation de la requête a réussi
        if ($stmt) {
            // Liaison des paramètres et exécution de la requête
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                echo "Suppression réussie";
            } else {
                echo "Erreur de suppression : " . $stmt->error;
            }

            // Fermer le statement
            $stmt->close();
        } else {
            echo "Erreur de préparation de la requête : " . $connexion->error;
        }
    } else {
        echo "ID non spécifié pour la suppression";
    }
}

// Fermer la connexion à la base de données
$connexion->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer l'enregistrement</title>
    <style>
        /* Ajouter votre CSS ici si nécessaire */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .wrapper {
            width: 70%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div>
                <h2>Supprimer l'enregistrement</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div>
                        <input type="hidden" name="id" value="<?php echo isset($_GET["id"]) ? trim($_GET["id"]) : ''; ?>"/>
                        <p>Etes-vous sûr de vouloir supprimer cet enregistrement ?</p>
                        <p>
                            <button type="submit" name="confirmation" value="oui">OUI</button>
                            <a href="listcrud_idee.php">NON</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
