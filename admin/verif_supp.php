<?php
    include_once('../include.php');

    if(!isset($_SESSION['utilisateur'][5]) AND $_SESSION['utilisateur'][3] != 1) {
        header('Location: panel');
        exit;
    }

    $cherchePrea = $DB->prepare("SELECT idOperation FROM preadmission WHERE id = ?");
    $cherchePrea->execute([$_GET['id']]);
    $cherchePrea = $cherchePrea->fetch();

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['oui'])) {
            $supp = $DB->prepare("UPDATE preadmission SET status='Annulé' WHERE id = ?");
            $supp->execute([$_GET['id']]);

            $textLog = "Annulation d'une pré-admission";
            $dateLog = date('Y-m-d H:i');

            $log = $DB->prepare("INSERT INTO log (idUser, nomLog, dateTimeLog) VALUES(?, ?, ?);");
            $log->execute([$_SESSION['utilisateur'][5], $textLog, $dateLog]);

            header('Location: panel');
            exit;
        }

        if(isset($_POST['non'])) {
            header('Location: voir_preadmission');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style/navBar.css">
    <link rel="stylesheet" href="../style/voirAdmission.css">

    <title>Confirmer la suppression</title>
</head>
<body>
    <?php require_once('src/navbar.php'); ?>

    <div class="notif">
        <form class="confirm" method="post">
            <h3>Voulez-vous vraiment supprimer<br>cette pré-admission ?</h3>
    
            <div method="post" class="btns">
                <button type="submit" name="oui">Oui</button>
                <button type="submit" name="non">Non</button>
            </div>
        </form>
    </div>
</body>
</html>