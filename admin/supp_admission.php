<?php
    include_once('../include.php');

    if(!isset($_SESSION['utilisateur'][5]) AND $_SESSION['utilisateur'][3] != 1) {
        header('Location: panel');
        exit;
    }

    $erreur = '';
    
    if(isset($_GET['id'])) {

        $cherchePrea = $DB->prepare("SELECT * FROM preadmission WHERE id = ?");
        $cherchePrea->execute([$_GET['id']]);
        $cherchePrea = $cherchePrea->fetch();

        $_SESSION['supp_admission'] = array (
            $cherchePrea['id'], //0
            $cherchePrea['idPatient'], //1
            $cherchePrea['idMedecin'], //2
            $cherchePrea['idOperation'], //3
            $cherchePrea['idChambre'], //4
            $cherchePrea['status'] //5
        );

        $chercherOperation = $DB->prepare("SELECT * FROM operations WHERE id = ? AND idPatient = ?");
        $chercherOperation->execute([$_SESSION['supp_admission'][3], $_SESSION['supp_admission'][1]]);
        $chercherOperation = $chercherOperation->fetch();

        $docteur_Preadmission = $DB->prepare("SELECT id, nom, prenom FROM personnel WHERE id = ?");
        $docteur_Preadmission->execute([$_SESSION['supp_admission'][2]]);
        $docteur_Preadmission = $docteur_Preadmission->fetch();
    
        $docteur = $DB->prepare("SELECT * FROM personnel WHERE role = 3 AND id != ?");
        $docteur->execute([$_SESSION['supp_admission'][2]]);
        $docteur = $docteur->fetchAll();

    } else {
        $chercherOperation = $DB->prepare("SELECT * FROM operations WHERE id = ? AND idPatient = ?");
        $chercherOperation->execute([$_SESSION['preadmission'][3], $_SESSION['preadmission'][1]]);
        $chercherOperation = $chercherOperation->fetch();
    
        $docteur_Preadmission = $DB->prepare("SELECT id, nom, prenom FROM personnel WHERE id = ?");
        $docteur_Preadmission->execute([$_SESSION['preadmission'][2]]);
        $docteur_Preadmission = $docteur_Preadmission->fetch();
    
        $docteur = $DB->prepare("SELECT * FROM personnel WHERE role = 3 AND id != ?");
        $docteur->execute([$_SESSION['preadmission'][2]]);
        $docteur = $docteur->fetchAll();
    }

    switch($chercherOperation['nomOperation']) {
        case 'Hospitalisation':
            $hospitalisation = 'selected';
            $Ambulatoire = '';
            break;
        
        case 'Ambulatoire chirugie':
            $hospitalisation = '';
            $Ambulatoire = 'selected';
            break;

        default:
        $hospitalisation = '';
        $Ambulatoire = '';
    }

    $dateMin = date('Y-m-d', time());

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['next'])) {
            header('Location: couverture_supp');
            exit;

        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../style/ajoutAdmission.css">
    <link rel="stylesheet" href="../style/navBar.css">
    <title>Document</title>
</head>
<body>
    <?php require_once('src/navbar.php'); ?>

    <main>
        <h2>Supprimer la pré-admission</h2>

        <form method="post">

            <?php if($erreur != '') { ?><div class="erreur"><?= $erreur ?></div><?php } ?>

            <select style="cursor:not-allowed" disabled name="operation" id="">
                <option hidden value=0>Choisir l'opération</option>
                <option value=1 <?= $Ambulatoire ?> >Ambulatoire chirugie</option>
                <option value=2 <?= $hospitalisation ?> >Hospitalisation (une nuit minimum)</option>
            </select>

            <input type="date" style="cursor:not-allowed" disabled value="<?= $chercherOperation['dateOperation'] ?>" name="dateHospitalisation" id="" min="<?= $dateMin ?>">

            <input type="time" style="cursor:not-allowed" disabled value="<?= $chercherOperation['heureOperation'] ?>" name="heureHospitalisation" id="">

            <select style="cursor:not-allowed" disabled name="docteur" id="">
                <option value=<?= $docteur_Preadmission['id'] ?> ><?= $docteur_Preadmission['nom'] . ' ' . $docteur_Preadmission['prenom'] ?></option>
                <?php foreach($docteur as $req) { ?>
                    <option value=<?= $req['id'] ?> ><?= $req['nom'] . ' ' . $req['prenom'] ?></option>
                <?php } ?>
            </select>

            <input type="submit" name="next" value="Continuer pour supprimer">
        </form>
    </main>
</body>
</html>