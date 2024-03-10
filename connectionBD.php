<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "application_boite_a_idee_collaborative";

function connect()
{
    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }
return $conn;
}
?>
