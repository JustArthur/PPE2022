<?php 
    require_once('../include.php');

    if(empty($_SESSION['utilisateur'][5]) || $_SESSION['utilisateur'][3] != 1) {
        header('Location: panel.php');
        exit;
    }
    
    $service = $DB->prepare("SELECT DISTINCT(service) FROM personnel WHERE service != 'Aucun'");
    $service->execute();
    $service = $service->fetchAll();

    $dateMin = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style/inputPDF.css">
    <link rel="stylesheet" href="../style/navBar.css">

    <title>Clinique LPF - Créer un pdf</title>
    <link rel="icon" href="../img/logo.png" type="image/icon type">
</head>
<body>

    <?php
        require_once('src/navbar.php');
    ?>
    <form action="class/classPDF.php" method="post" class="formulaire">
        <h2>Générer un PDF</h2>

        <label for="service">Choisir un service</label>
        <select name="service">
            <option value="null" hidden>Choisir un service</option>
            <?php foreach($service as $services) {?>
            <option value="<?= $services['service'] ?>"><?= $services['service'] ?></option>
            <?php } ?>
        </select>

        <label for="dateSemaine">Choisir le jour de la semaine</label>
        <input type="date" name="dateSemaine" min="<?= $dateMin ?>">

        <input type="submit" name="next" value="Générer le pdf">
    </form>

    <script src="js/expireConnexion.js"></script>
</body>
</html>