<?php
    session_start();
    
    include_once('_db/connexionBD.php');
    include_once('_class/inscriptionPatientClass.php');
    include_once('_class/updatePatientClass.php');
    include_once('_class/deletePatientClass.php');

    $_INSCRIPTION = new Inscription;
    $_UPDATE_PATIENT = new Update;
    $_DELETE_PATIENT = new Delete;
?>