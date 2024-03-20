<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
</head>
<body>
    <h1>Vous êtes sur le point de vous déconnecter.</h1>
    <form action="deconnection.php" method="post">
        <button type="submit">Se déconnecter</button>
    </form>
</body>
</html>
<?php
session_start();

// Détruire toutes les données de session
session_unset();
session_destroy();

// Rediriger vers une autre page ou afficher un message de déconnexion
header("Location: index.php"); // Redirige vers la page d'accueil par exemple
exit;
?>

