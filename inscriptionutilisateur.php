<?php
session_start();
require_once('connectionBD.php');
$connexion = connecter();
if (isset($_POST['inscrire'])) {
    $nom = $connexion->real_escape_string($_POST['nom']);
    $prenom = $connexion->real_escape_string($_POST['prenom']);
    // Ajout des champs manquants
    $adresse = $connexion->real_escape_string($_POST['adresse']);
    $tel = $connexion->real_escape_string($_POST['tel']);
    $email = $connexion->real_escape_string($_POST['email']);
    $mot_de_passe_formulaire = $connexion->real_escape_string($_POST['pwd1']);
    // $mot_de_passe = password_hash($mot_de_passe_formulaire, PASSWORD_DEFAULT);
    $requeteUtilisateur = "INSERT INTO utilisateur (Nom_utilisateur, Prenom_utilisateur, Adresse_utilisateur, Tel_utilisateur, Email_utilisateur, MotdePasse_utilisateur, DateConnexion_utilisateur)
    VALUES (?, ?, ?, ?, ?, ?, NOW())";

$stmt = $connexion->prepare($requeteUtilisateur);
$stmt->bind_param("ssssss", $nom, $prenom, $adresse, $tel, $email, $mot_de_passe_formulaire);

if ($stmt->execute()) {
        echo "Inscription utilisateur réussie.";
        // Après l'insertion réussie dans la table utilisateur
        header("Location: ajout_idee.php");
        exit();
    } else {
        echo "Erreur lors de l'inscription dans la table 'utilisateur' : " . $stmt->error;
    }
$stmt->close();
}
$connexion->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Formulaire d'inscription</title>
    <style>
body {
    background-image: url('2image.png');
            font-family: Arial, sans-serif;
            background-color: gray;
            margin: 1px;
        }
       h3, h4 {
                    color: #0e0e0e;
                    text-align: right;
                    margin-right: 13%;
                    margin-bottom: 10%;
                }
                

        fieldset {
            
            width: 25%; /* Vous pouvez ajuster la largeur selon vos besoins */
            max-width: 30%; /* Optionnel : définissez une largeur maximale */
            margin: 3px auto;
            margin-right: 5%;
            padding: 1px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            float: right;
            margin-top: 4%;
        }

        table {
            width: 100%;
        }

        td {
            padding: 2px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="password"] {
            width: 50%;
            padding: 3px;
            margin: 2px 0;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #428bca;
            color: #0b0b0b;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3071a9;
        }
                /* menu */
       
    header {
        background-color:#333;
        width: 100%;
        color: #fff;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .logo {
    width: 100px; /* Ajustez la largeur selon vos besoins */
    height: 100px; /* Ajustez la hauteur selon vos besoins */
    background-image: url('bilogo.png'); /* Chemin de l'image de fond */
    background-size: cover; /* Ajuste la taille de l'image de fond pour couvrir le conteneur */
    border: 5px solid #3498db; /* Bordure solide de 5 pixels de couleur bleue */
    border-radius: 10px; /* Coins arrondis de 10 pixels (pour une bordure circulaire) */
    
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
    </style>
</head>
<body>
<header>
<div class="logo"></div>
       <?php
        // Vérifier si une session est active
        if (isset($_SESSION['Email_utilisateur'])) {
            echo '<h2>Bienvenue, ' . $_SESSION['Email_utilisateur'] . '!</h2>';
        }
        ?>
    </header>
    <fieldset>
        <form action="inscriptionutilisateur.php" method="post"> <!-- le bon chemin ici -->
            <h4>Formulaire d'inscription</h4>
            <hr>
            <table>
                <tr>
                    <td>Nom: </td><td><input type="text" name="nom" value="" required><br><br></td>
                </tr>
                <tr>
                    <td>Prénom: </td><td><input type="text" name="prenom" value="" required><br><br></td>
                </tr>
                <tr>
                    <td>Adresse: </td><td><input type="text" name="adresse" value="" required><br><br></td> 
                </tr>
                <tr>
                    <td>N° téléphone : </td><td><input type="tel" name="tel" value="" required><br><br></td> 
                </tr>
                <tr>
                    <td>Email</td><td><input type="email" name="email" value=""><br><br required></td> 
                </tr>
                <tr>
                    <td>Mot de passe </td><td><input type="password" name="pwd1" value="" required><br><br></td> 
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" id="submit" name="inscrire" value="S'inscrire" required></td> 
                </tr>
            </table>
        </form>
    </fieldset>
      </body>
</html>

