<?php
function getBdd($servername, $username, $password) {

    try{
        $conn = new PDO("mysql:host=$servername;dbname=ap2022; charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }



    catch(PDOException $e){
        echo "Erreur : " . $e->getMessage();
    }

    return $conn;

}

?>