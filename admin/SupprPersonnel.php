<?php
    include_once('../include.php');
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    if(isset($_GET["id"])AND is_numeric($_GET["id"]))
    {
        $id = htmlentities($_GET['id']);
        $sql= $DB->exec("DELETE FROM personnel where id = " . $id . ";");
    }
    header("Location: ajout_service.php");
?>
