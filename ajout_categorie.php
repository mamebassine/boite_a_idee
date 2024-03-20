<?php
session_start();

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

// Vérifier si les clés existent dans le tableau $_POST
if (isset($_POST['NomCategorie'], $_POST['Description_categorie'], $_POST['Couleur_categorie'])) {

    // Récupérer les données du formulaire
    $nomCategorie = $_POST['NomCategorie'];
    $descriptionCategorie = $_POST['Description_categorie'];
    $couleurCategorie = $_POST['Couleur_categorie'];

    // Préparer et exécuter la requête SQL avec des déclarations paramétrées
    $stmt = $conn->prepare("INSERT INTO categorie (NomCategorie, Description_categorie, Couleur_categorie) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nomCategorie, $descriptionCategorie, $couleurCategorie);

    if ($stmt->execute()) {
        // Afficher le message après les entêtes HTTP
        echo "Catégorie ajoutée avec succès.";
        
        // Redirection après l'affichage du message
        header("Location: listcrud_categorie.php");
        exit();
    } else {
        echo "Erreur: " . $stmt->error;
    }

    // Fermer la connexion
    $stmt->close();
} else {
    echo "Tous les champs du formulaire doivent être remplis.";
}

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une catégorie</title>
   <style>


body {
    font-family: Arial, sans-serif;
    background-image: url('image1.jpeg'); /* Utilisez le chemin de l'image pour l'arrière-plan */
    background-size: cover;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


.container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

label {
    display: block;
    margin-bottom: 8px;
}

input,
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    box-sizing: border-box;
}

button {
    background-color: #4caf50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

        /* menu */
       
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
        flex-grow: 1; /* Le menu prendra tout l'espace disponible entre le logo et le lien de déconnexion */
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
/* menu */



        body {
            display: flex;
            flex-direction: column;
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
        }
        .crud-button{
            background-color: #3071a9;
           color: #ffffff;
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
/* bouton CRUD */

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

       
 </style>
</head>
<body>
<header>
        <div class="logo">
            <img src="bilogo.png" alt="">
        </div>
        <nav>
            <ul>
                <li><a href="ajout_idee.php">Boite a idee</a></li>
                <li><a href="ajout_categorie.php">Categorie</a></li>
                <a href="deconnexion.php">Déconnexion</a>
            </ul>
        </nav>
    <?php
        // Vérifier si une session est active
        if (isset($_SESSION['Email_utilisateur'])) {
            echo '<h2>Bienvenue, ' . $_SESSION['Email_utilisateur'] . '!</h2>';
        }
        ?>
    </header>
    <div class="container">
        <h2>Ajouter une catégorie</h2>
        <form action="#" method="post">
            <label for="NomCategorie">Nom de la catégorie:</label>
            <input type="text" name="NomCategorie" required>

            <label for="Description_categorie">Description de la catégorie:</label>
            <textarea name="Description_categorie" rows="4" required></textarea>

            <label for="Couleur_ategorie">Couleur de la catégorie:</label>
            <input type="text" name="Couleur_categorie" required>
            <button type="submit">Ajouter la catégorie</button>
        </form>
    </div>
</body>
</html>

