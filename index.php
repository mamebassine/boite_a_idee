<?php
session_start();
require_once('connectionBD.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Valider les données du formulaire (n'oubliez pas de le faire !)
    if(isset($_POST['Email_utilisateur']) && isset($_POST['Motdepasse_utilisateur'])) {
        $Email_utilisateur = $_POST['Email_utilisateur'];
        $Motdepasse_utilisateur = $_POST['Motdepasse_utilisateur'];

        $conn = connecter(); // Utilisez la fonction connect() du fichier connectionBD.php

        // Utilisation de requêtes préparées pour éviter les injections SQL
        $stmt = $conn->prepare("SELECT id, Email_utilisateur FROM utilisateur WHERE Email_utilisateur = ? AND Motdepasse_utilisateur = ?");
        $stmt->bind_param("ss", $Email_utilisateur, $Motdepasse_utilisateur);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['Email_utilisateur'] = $user['Email_utilisateur'];
            header('Location: ajout_idee.php'); // Redirection vers ajout_idee.php après la connexion
            exit();
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }

        // Fermer la requête préparée
        $stmt->close();
        // Fermer la connexion à la base de données
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <title>Connexion</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-image: url('image3.png'); /* Utilisez le chemin de l'image pour l'arrière-plan */
    background-size: cover;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

h2 {
    text-align: center;
    margin-top: 160px;
    color: #007bff;
}

form {
    width: 300px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            padding: 10px 18px;
            border: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        p a {
            color: #007bff;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
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
    <h2>Connexion</h2>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="Email_utilisateur">Nom d'utilisateur:</label>
        <input type="text" name="Email_utilisateur" required>
        <br>
        <label for="Motdepasse_utilisateur">Mot de passe:</label>
        <input type="password" name="Motdepasse_utilisateur" required>
        <br>
        <button type="submit">Se Connecter</button>
    </form>
    <p>
        Vous n'avez pas de compte ? <a href="inscriptionutilisateur.php">S'inscrire</a>
       
    </p>
</body>
</html>
