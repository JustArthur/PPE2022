<?php
    include_once('../include.php');

    if(!isset($_SESSION['utilisateur'][5]) AND $_SESSION['utilisateur'][3] != 1) {
        header('Location: panel');
        exit;
    }

    $preadmission = $DB->prepare("SELECT * FROM preadmission WHERE idPatient = ? AND status = 'Pas réalisé'");
    $preadmission->execute([$_SESSION['patientPrea']]);
    $preadmission = $preadmission->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style/navBar.css">
    <link rel="stylesheet" href="../style/voirAdmission.css">

    <title>Toutes les pré-admissions de <?= $_SESSION['patientPrea'] ?></title>
</head>
<body>
    <?php require_once('src/navbar.php'); ?>
    
    <main>
        <ul class="list">
            <?php

                foreach($preadmission as $all) {
                
                    $info_patient = $DB->prepare("SELECT * FROM patient WHERE numSecu = ?");
                    $info_patient->execute([$all['idPatient']]);
                    $info_patient = $info_patient->fetch();

                    $info_operation = $DB->prepare("SELECT dateOperation, heureOperation FROM operations WHERE id = ?");
                    $info_operation->execute([$all['idOperation']]);
                    $info_operation = $info_operation->fetch();

                    $info_medecin = $DB->prepare("SELECT nom, prenom FROM personnel WHERE id = ?");
                    $info_medecin->execute([$all['idMedecin']]);
                    $info_medecin = $info_medecin->fetch();

                    $date = date_create($info_operation['dateOperation']);
                    $jour = date_format($date, 'd/m/Y');

                    $heure = date_create($info_operation['heureOperation']);
                    $horraire = date_format($heure, 'H:i');
            ?>
                <li class="list-item">
                    <h3>Pré-admission pour <?= $info_patient['nomNaissance'] . ' ' . $info_patient['prenom'] ?></h3><br>

                    <ul class="list-patient">
                        <li class="list-item-patient">
                            <strong style="text-decoration: underline;">Numéro de sécurité sociale :</strong> <?= $info_patient['numSecu'] ?>
                        </li><br>

                        <li class="list-item-patient">
                            <strong style="text-decoration: underline;">Adresse :</strong> <?= $info_patient['adresse'] . ' | ' . $info_patient['ville']?>
                        </li><br>

                        <li class="list-item-patient">
                            <strong style="text-decoration: underline;">Numéro de téléphone :</strong> 0<?= $info_patient['telephone'] ?>
                        </li><br>

                        <li class="list-item-patient">
                            <strong style="text-decoration: underline;">Adresse mail :</strong> <?= $info_patient['email'] ?>
                        </li><br>

                        <li class="list-item-patient">
                            <strong style="text-decoration: underline;">Date et heure :</strong> Le <?= $jour ?> à <?= $horraire ?>
                        </li><br>

                        <li class="list-item-patient">
                            <strong style="text-decoration: underline;">Docteur en charge :</strong> <?= $info_medecin['nom'] . ' ' . $info_medecin['prenom'] ?>
                        </li><br>

                        <form method="POST" class="btn">
                            <a href="modif_admission?id=<?= $all['id']?>" class="modif">Modifier la préadmission</a>
                        </form>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </main>
    
</body>
</html>