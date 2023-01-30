<?php
    session_start();

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