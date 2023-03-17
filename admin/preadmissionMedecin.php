<?php
    include_once('../include.php');

    $select_prea = $DB->prepare('SELECT * from preadmission INNER JOIN operations on preadmission.idOperation = operations.id INNER JOIN patient on preadmission.idPatient = patient.numSecu where preadmission.id = ?');
    $select_prea->execute([$_GET['id']]);
    $select_prea = $select_prea->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style/preadmissionMedecin.css">
    <link rel="stylesheet" href="../style/navBar.css">

    <title>Pré-admission de ?</title>
</head>
<body>
    <?php
        require_once('src/navbar.php');
    ?>

    <main>
        <div>
            <label>Nom et prénom du : </label>
            <?= $select_prea['nomNaissance'] . ' ' . $select_prea['prenom'] ?>
        </div>

        <div>
            <label>Date de l'opération : </label>
            <?= $select_prea['dateOperation'] ?>
        </div>

        <div>
            <label>Heure de l'opération : </label>
            <?= $select_prea['heureOperation'] ?>
        </div>
    </main>

</body>
</html>