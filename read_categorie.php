<!-- read_categorie.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lire la catégorie</title>
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
        p {
            margin-bottom: 10px;
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
        .btn-edit {
            background-color: #3498db;
            color: white;
        }
        .btn-back {
            background-color: #2ecc71;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Détails de la catégorie :</h2>
        <?php
            // Inclure le fichier de connexion à la base de données si nécessaire
            // Exemple : include_once 'connexion.php';

            // Vérifier si l'ID de la catégorie est passé via la requête GET
            if(isset($_GET['id'])) {
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

                // Échapper l'ID de la catégorie
                $categorieId = $conn->real_escape_string($_GET['id']);

                // Récupérer les données de la catégorie spécifique
                $sql = "SELECT NomCategorie, Description_categorie, Couleur_categorie FROM categorie WHERE id = $categorieId";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<p><strong>Nom :</strong> " . $row["NomCategorie"] . "</p>";
                    echo "<p><strong>Description :</strong> " . $row["Description_categorie"] . "</p>";
                    echo "<p><strong>Couleur :</strong> " . $row["Couleur_categorie"] . "</p>";
                } else {
                    echo "Aucune catégorie trouvée avec cet ID.";
                }

                // Fermer la connexion
                $conn->close();
            } else {
                echo "ID de catégorie non spécifié.";
            }
        ?>
        <div class="btn-container">
            <button class="btn btn-edit" onclick="window.location.href='listcrud_categorie.php?id=<?php echo $categorieId; ?>'">Lire</button>
            <button class="btn btn-back" onclick="window.location.href='listcrud_categorie.php'">Retour</button>
        </div>
    </div>
</body>
</html>
