<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des catégories</title>
    <style>
        /* Style global du document */
        body {
    font-family: Arial, sans-serif;
   background-size: cover;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
/* Style du conteneur principal */
        .container {
            width: 80%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2{
            text-align: center;
        }

        /* Style du tableau */
        table {
            width: 50%;
            border-collapse: collapse;
            margin-top: 20px;
        text-align: center;
        margin: 20px auto; /* Centre le tableau horizontalement avec un espacement de 20px en haut et en bas */
        }

        /* Style des cellules du tableau (th et td) */
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        /* Style des en-têtes de colonnes du tableau (th) */
        th {
            background-color: #f2f2f2;
            width: 5%;
        }

        /* Style de la section d'actions (bouton Ajouter) */
        .actions {
            margin-bottom: 10px;
            text-align: right;
        }

        /* Style du bouton Ajouter */
        .btn-ajouter {
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 10px;
        }

        /* Style des boutons (Modifier, Lire, Supprimer) */
        .btn {
            flex: 1;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
            color: white;
        }
        .boutoncrud{
            display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: center;
    
        }

        /* Style du bouton Modifier */
        .btn-modifier {
            background-color: #428bca;
        color: #ffffff;
        }

        /* Style du bouton Lire */
        .btn-lire {
            background-color: #5bc0de;
        color: #ffffff;
        }

        /* Style du bouton Supprimer */
        .btn-supprimer {
            background-color: #d9534f;
        color: #ffffff;
        }

    </style>
</head>
<body>

    <!-- Contenu de la page -->
    <div class="container">
        <!-- Titre -->
        <h2>Liste des catégories :</h2>

        <!-- Section Ajouter -->
        <div class="actions">
            <a class="btn btn-ajouter" href="ajout_categorie.php">Ajouter</a>
        </div>

        <!-- Section Tableau -->
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

            // Récupérer les données de la table "categorie"
            $sql = "SELECT id, NomCategorie, Description_categorie, Couleur_categorie FROM categorie";
            $result = $conn->query($sql);
          
            // Afficher les données dans un tableau HTML avec des liens pour CRUD
            echo "<table>";
            echo "<tr><th>ID</th><th>Nom</th><th>Description</th><th>Couleur</th><th>Actions</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["NomCategorie"] . "</td>";
                echo "<td>" . $row["Description_categorie"] . "</td>";
                echo "<td>" . $row["Couleur_categorie"] . "</td>";
                echo "<td class='boutoncrud'>
                        <a class='btn btn-modifier' href='update_categorie.php?id=" . $row["id"] . "'>Modifier</a>
                        <a class='btn btn-lire' href='read_categorie.php?id=" . $row["id"] . "'>Lire</a>
                        <a class='btn btn-supprimer' href='delete_categorie.php?id=" . $row["id"] . "'>Supprimer</a>
                      </td>";
                echo "</tr>";
            }

            echo "</table>";

            // Fermer la connexion
            $conn->close();
        ?>
    </div>
</body>
</html>
