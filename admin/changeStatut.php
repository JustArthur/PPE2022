<?php 
    include_once('../include.php');

    

    $statut = $DB->prepare('SELECT status FROM preadmission WHERE id = ?');
    $statut->execute([$_GET['id']]);
    $statut = $statut->fetch();

    if($statut['status'] == 'En cours') {
        $terminer = $DB->prepare('UPDATE clinique.preadmission SET status = ? WHERE id = ?');
        $terminer->execute(['Terminé', $_GET['id']]);

        $textLog = "Pré-admission N°" . $_GET['id'] ." clôturer";
        $dateLog = date('Y-m-d H:i');
        
        $log = $DB->prepare("INSERT INTO log (idUser, nomLog, dateTimeLog) VALUES(?, ?, ?);");
        $log->execute([$_SESSION['utilisateur'][5], $textLog, $dateLog]);

        header('Location: panel');
        exit;

    } elseif($statut['status'] == 'Pas réalisé') {
        $terminer = $DB->prepare('UPDATE clinique.preadmission SET status = ? WHERE id = ?');
        $terminer->execute(['En cours', $_GET['id']]);

        $textLog = "Pré-admission N°" . $_GET['id'] ." pris en charge";
        $dateLog = date('Y-m-d H:i');
        
        $log = $DB->prepare("INSERT INTO log (idUser, nomLog, dateTimeLog) VALUES(?, ?, ?);");
        $log->execute([$_SESSION['utilisateur'][5], $textLog, $dateLog]);

        header('Location: panel');
        exit;
    }
?>