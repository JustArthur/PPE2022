<?php
    include_once('../include.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style/panel.css">
    <link rel="stylesheet" href="../style/navBar.css">

    <title>Bienvenue, <?= $_SESSION['utilisateur'][1] ?></title>
</head>
<body>

    <?php
        require_once('src/navbar.php');
    ?>
    
</body>
</html>