<?php
    include_once('../include.php');

    $_SESSION['preadmission'] = array('', '', '', '', '', '');

    $preadmission = $DB->prepare("SELECT * FROM preadmission WHERE status != 'Terminé'");
    $preadmission->execute();
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

    <title>Document</title>
</head>
<body>
    <?php require_once('src/navbar.php'); ?>

    <main>
        <ul class="list">
            <?php

                foreach($preadmission as $all) {

                    if(isset($_POST)) {
    
                        if(isset($_POST["modif_".$all['id']])) {
    
                            $_SESSION['preadmission'] = array(
                                $all['id'], //0
                                $all['idPatient'], //1
                                $all['idMedecin'], //2
                                $all['idOperation'], //3
                                $all['idChambre'], //4
                                $all['status'] //5
                            );
    
                            var_dump($_SESSION['preadmission']);
    
                            header('Location: modif_admission');
                            // exit;
                        }
                    }
                
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
                    $jour = date_format($date, 'd-m-Y');

                    $heure = date_create($info_operation['heureOperation']);
                    $horraire = date_format($heure, 'H:i');
            ?>
                <li class="list-item">
                    <h3>Pré-admission pour <?= $info_patient['nomNaissance'] . ' ' . $info_patient['prenom'] ?></h3><br>

                    <ul class="list-patient">
                        <li class="list-item-patient">
                            <strong style="text-decoration: underline;">Status :</strong> <?= $all['status'] ?>
                        </li><br>

                        <li class="list-item-patient">
                            <strong style="text-decoration: underline;">Numéro de sécurité sociale :</strong> <?= $info_patient['numSecu'] ?>
                        </li><br>

                        <li class="list-item-patient">
                            <strong style="text-decoration: underline;">Adresse :</strong> <?= $info_patient['adresse'] . ' | ' . $info_patient['ville']?>
                        </li><br>

                        <li class="list-item-patient">
                            <strong style="text-decoration: underline;">Numéro de téléphone :</strong> <?= $info_patient['telephone'] ?>
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

                        <form class="btn" method="POST">
                            <button type="submit" name="modif_<?= $all['id'] ?>" class="modif">Modifier la préadmission</button>

                            <button type="submit" name="supp_<?= $all['id'] ?>" class="supp">Supprimer la préadmission</button>
                        </form>
                    </ul>
                </li>
            <?php }

                
            ?>
        </ul>
    </main>
    
</body>
</html>