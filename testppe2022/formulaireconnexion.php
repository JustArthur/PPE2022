<?php
session_start();
include('./funtion bdd.php');
$conn = getBdd('localhost', 'root', 'root');
if(isset($_POST['connexion'])) {
        if (empty($_POST['email'])) {
            echo "Le champ email est vide. <br>";
        }else{
            echo"";
        }
        if (empty($_POST['Numsecu'])) {
            echo "Le champ Numsecu est vide. <br>";
        }else{
            echo"";
        }

        if (!empty($_POST['email'] AND !empty($_POST['Numsecu']))) {
            echo "Le champ email est vide. <br> et le champ numsecu est vide";
        }


    }
    $email = htmlspecialchars($_POST['email']);
    $Numsecu = $_POST['Numsecu'];
    $res = $conn->prepare("SELECT * FROM testppe2022.patients WHERE email = '" . $email . "' AND Numsecu = '" . $Numsecu . "'");
    $res->execute(array($Numsecu, $email));
    $resutilisateur= $res->rowCount();
    if ($resutilisateur == 1) {
        $userinfo = $res->fetch();
        header("Location: page utilisateur.php");
    }else{
        echo"vous avez rentree un mauvais Numsecur ou mauvais email";
    }
?>