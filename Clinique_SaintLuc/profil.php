<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include_once('include.php');

    switch($_SESSION['role']) {
        case 1:
            $role = array(1, "Secretaire");
        break;

        case 2:
            $role = array(2, "Administrateur");
        break;

        case 3:
            $role = array(3, "Médecin");
        break;
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="_style/sidebar.css">
    <link rel="stylesheet" href="_style/panel.css">

    <title><?= $role[1] ?></title>
</head>
<body>
    <?php
        require_once('_assets/sidebar.php');
    ?>

    <div class="container">
        <h1>Bonjour vous êtes un(e) <?= $role[1] ?></h1>

        <?php 
            if($role[0] == 1) {
                require_once('_pages/secretaire.php');
        ?>
        <!--<a href="_pages/preadmission.php">Faire une préadmission</a>-->
        <?php } ?>
    </div>
</body>
</html>