<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des idées</title>
    <style>
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
    align-items: center;
}
table {
            width: 80%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .crud-actions {
            margin-top: 20px;
        }

        .crud-button {
            margin-right: 10px;
            background-color: #3071a9;
            color: #ffffff;
            cursor: pointer;
        }

        .logo {
            width: 100px;
            height: 100px;
            background-image: url('votre_logo.png');
            background-size: cover;
            border: 5px solid #3498db;
            border-radius: 10px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
        }

        .action-buttons button {
            padding: 5px 10px;
            margin: 0 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .modify-button {
            background-color: #428bca;
            color: #ffffff;
        }

        .read-button {
            background-color: #5bc0de;
            color: #ffffff;
        }

        .delete-button {
            background-color: #d9534f;
            color: #ffffff;
        }

        .action-buttons a {
            text-decoration: none;
            color: inherit;
        }

        header {
            background-color: #333;
            width: 100%;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav {
            flex-grow: 1;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav a {
            text-decoration: none;
            color: #fff;
        }

         .logo img {
        max-width: 100%;
        height: auto;
    }

        .logo {
    width: 100px; /* Ajustez la largeur selon vos besoins */
    height: 100px; /* Ajustez la hauteur selon vos besoins */
    background-image: url('bilogo.png'); /* Chemin de l'image de fond */
    background-size: cover; /* Ajuste la taille de l'image de fond pour couvrir le conteneur */
    border: 5px solid #3498db; /* Bordure solide de 5 pixels de couleur bleue */
    border-radius: 10px; /* Coins arrondis de 10 pixels (pour une bordure circulaire) */
    
}
</style>
</head>
<body>
<header>
    <div class="logo">
        <img src="votre_logo.png" alt="">
    </div>
    <nav>
        <ul>
            <li><a href="ajout_idee.php">Boite a idee</a></li>
            <li><a href="ajout_categorie.php">Categorie</a></li>
            <li><a href="deconnexion.php">Déconnexion</a></li>
        </ul>
    </nav>
    <?php
    // Vérifier si une session est active
    if (isset($_SESSION['Email_utilisateur'])) {
        echo '<h2>Bienvenue, ' . $_SESSION['Email_utilisateur'] . '!</h2>';
    }
    ?>
</header>
<h1>Liste des idées</h1>
<div class="crud-actions">
    <button class="crud-button" onclick="location.href='ajout_idee.php'"> A AJOUTER</button>
</div>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Commentaires</th>
        <th>Catégorie</th>
        <th>Date de Soumission</th>
        <th>État</th>
        <th>ID Utilisateur</th>
        <th>ID Catégorie</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    require_once('connectionBD.php');
    $connexion = connecter();
    // Récupérer les idées depuis la base de données
    $sql = "SELECT * FROM boite_a_idee";
    $result = $connexion->query($sql);
    // Afficher les idées dans le tableau
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['Titre_idee']}</td>
                    <td>{$row['Commentaires_idee']}</td>
                    <td>{$row['Categorie_idee']}</td>
                    <td>{$row['DateSoumission_idee']}</td>
                    <td>{$row['Etat_idee']}</td>
                    <td>{$row['ID_utilisateur']}</td>
                    <td>{$row['ID_categorie']}</td>";
            echo "<td class='action-buttons'> 
                    <button class='modify-button'><a href='update_idee.php?id={$row['ID']}'>Modifier</a></button>
                    <button class='read-button'><a href='read_idee.php?id={$row['ID']}'>Lire</a></button>
                    <button class='delete-button'><a href='delete_idee.php?id={$row['ID']}'>Supprimer</a></button>
                </td>";
        }
    } else {
        echo "<tr><td colspan='8'>Aucune idée trouvée</td></tr>";
    }
    $connexion->close();
    ?>
    </tbody>
</table>
</body>
</html>
