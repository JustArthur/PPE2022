<?php
    include_once('../include.php');

    $textLog = "Deconnexion d'un utilisateur";
    $dateLog = date('Y-m-d H:i');

    $log = $DB->prepare("INSERT INTO log (idUser, nomLog, dateTimeLog) VALUES(?, ?, ?);");
    $log->execute([$_SESSION['utilisateur'][5], $textLog, $dateLog]);

    $_SESSION['utilisateur'] = array();
    
    $_SESSION['patient'] = array();
    $_SESSION['personneConfiance'] = array();
    $_SESSION['personnePrevenir'] = array();
    $_SESSION['hospitalisation'] = array();
    $_SESSION['couvertureSociale'] = array();
    $_SESSION['creer_admission'] = array();

    session_destroy();

    header('Location: ../index');
    exit;
?>