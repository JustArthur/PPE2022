<?php

function conexionbdd()
{
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    try {
            $conn = new PDO("mysql:host=$servername;dbname=testppe2022", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         echo 'Connexion réussie';
    }
    catch(PDOException $e)
    {
        echo "Erreur : " . $e->getMessage();
    }

}

?>