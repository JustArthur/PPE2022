<?php
session_start();
include('./funtion bdd.php');
$conn = getBdd('localhost', 'root', '');
if(isset($_POST['connexion'])) {
    if (empty($_POST['email'])) {
        echo "Le champ email est vide. <br>";
    } else {
        if (empty($_POST['Numsecur'])) {
            echo "Le champ Numsecur est vide. <br>";
        } else {

        }
    }
    $email = htmlspecialchars($_POST['email']);
    $Numsecur = $_POST['Numsecur'];
    $res = $conn->prepare("SELECT * FROM testppe2022.patients WHERE email = '" . $email . "' AND Numsecur = '" . $Numsecur . "'");
    $res->execute(array($Numsecur, $email));
    $resutilisateur= $res->rowCount();
    if ($resutilisateur == 1) {
        $userinfo = $res->fetch();
        header("Location: page utilisateur.php");
    }else{
        echo"vous avez rentree un mauvais Numsecur ou mauvais email";
    }
}
?>