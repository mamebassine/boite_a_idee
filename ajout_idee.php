<?php
session_start(); // Démarrez la session si ce n'est pas déjà fait

include("connectionBD.php");

// Appel de la fonction connecter pour obtenir la connexion
$connexion = connecter();

// Initialisez $id_categorie à une valeur par défaut
$id_categorie = null;

// Vérifiez si l'utilisateur est connecté (par exemple, s'il y a une variable de session contenant l'ID de l'utilisateur)
if (isset($_SESSION['id_utilisateur'])) {
    $id_utilisateur = $_SESSION['id_utilisateur'];
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
   
}

if (isset($_POST['soumettre_idee'])) {
    // Récupérer les données du formulaire
    $titre_idee = $_POST['titre_idee'];
    $commentaires_idee = $_POST['commentaires_idee'];
    $categorie_idee = $_POST['categorie_idee'];
    $etat_idee = $_POST['etat_idee'];

    // Récupérer l'ID de la catégorie depuis la base de données en fonction de la catégorie soumise
    $queryCategorie = "SELECT ID FROM categorie WHERE Nomcategorie = ?";
    $stmtCategorie = $connexion->prepare($queryCategorie);

    // Vérifier la préparation de la requête
    if ($stmtCategorie) {
        $stmtCategorie->bind_param("s", $categorie_idee);
        $stmtCategorie->execute();
        $stmtCategorie->bind_result($id_categorie);
        $stmtCategorie->fetch();
        $stmtCategorie->close();
    } else {
        echo "Erreur lors de la préparation de la requête : " . $connexion->error;
    }

    // Préparer la requête SQL
    $requeteBoiteIdee = "INSERT INTO boite_a_idee (Titre_idee, Commentaires_idee, Categorie_idee, DateSoumission_idee, Etat_idee, ID_utilisateur, ID_categorie)
                        VALUES (?, ?, ?, NOW(), ?, ?, ?)";

    // Préparer la requête
    $stmt = $connexion->prepare($requeteBoiteIdee);

    // Vérifier la préparation de la requête
    if ($stmt) {
        // Lier les paramètres
        $stmt->bind_param("ssssii", $titre_idee, $commentaires_idee, $categorie_idee, $etat_idee, $id_utilisateur, $id_categorie);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Idée soumise avec succès.";
            header("Location: listcrud_idee.php");
            exit();
        } else {
            echo "Erreur lors de l'exécution de la requête : " . $stmt->error;
        }

        // Fermer la requête préparée
        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête : " . $connexion->error;
    }
}

// Fermer la connexion à la base de données
$connexion->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ajouter une Idée</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-image: url('image2.jpg'); /* Utilisez le chemin de l'image pour l'arrière-plan */
    background-size: cover;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
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
    


        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }

        .container {
            width: 25%;
            margin: 10px auto;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1{
            text-decoration: none;
            color: white;  
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-top: 10px; /* Modification pour un espacement plus propre */
        }

        input, textarea, select {
            width: 70%;
            padding: 5px;
            margin-top: 3px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #428bca;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3071a9;
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
    <h1>Formulaire d'Ajout d'Idee</h1>
    <div class="container">
        <h2>Ajouter une Idée</h2>

        <form action="#" method="post">
            <label for="titre_idee">Titre de l'idée:</label>
            <input type="text" id="titre_idee" name="titre_idee" required>

            <label for="commentaires_idee">Commentaires:</label>
            <textarea id="commentaires_idee" name="commentaires_idee" rows="4" required></textarea>

            <label for="categorie_idee">Catégorie:</label>
            <input type="text" id="categorie_idee" name="categorie_idee" required>

            <!-- Ajout du menu déroulant pour l'état de l'idée -->
            <label for="etat_idee">État de l'idée:</label>
            <select id="etat_idee" name="etat_idee" required>
                <option value="En Cours">En Cours</option>
                <option value="Approuvée">Approuvée</option>
                <option value="En Attente">En Attente</option>
                <option value="Refusée">Refusée</option>
                <!-- Ajoutez d'autres options au besoin -->
            </select>

            <!-- Champ pour l'ID de l'utilisateur (peut être masqué selon votre logique) -->
            <input type="hidden" id="id_utilisateur" name="id_utilisateur" value="<?php echo $id_utilisateur; ?>">

            <!-- Champ caché pour l'ID de la catégorie -->
            <input type="hidden" id="id_categorie" name="id_categorie" value="<?php echo $id_categorie; ?>">

            <!-- Bouton de soumission -->
            <input type="submit" name="soumettre_idee" value="Soumettre">
        </form>
    </div>
</body>
</html>
