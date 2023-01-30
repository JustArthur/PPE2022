<?php
    include_once('../include.php');

    $_SESSION['hospitalisation'] = array();

    if($_SESSION['creer_admission'][0] != true && $_SESSION['creer_admission'][1] != true && $_SESSION['creer_admission'][2] != true) {
        header('Location: num_secu_creer');
        exit;
    }

    $dateMin = date('Y-m-d', time());
    $erreur = '';

    $docteur = $DB->prepare("SELECT * FROM personnel WHERE role = 3");
    $docteur->execute();
    $docteur = $docteur->fetchAll();

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['next'])) {

            if($operation != 0 && $docteur != 0) {
                $_SESSION['hospitalisation'] = array(
                    $operation, //0
                    $dateHospitalisation, //1
                    $heureHospitalisation, //2
                    $docteur //3
                );

                $_SESSION['creer_admission'] = array(
                    true, //0
                    true, //1
                    true, //2
                    true, //3
                    false //4
                );

                header('Location: couverture');
                exit;
            } else {
                $erreur = "Certain champs sont invalides.";
            }
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
    <?php
        require_once('src/navbar.php');
    ?>

    <main>
        <h2>Hospitalisation</h2>

        <form method="post">

            <?php if($erreur != '') { ?><div class="erreur"><?= $erreur ?></div><?php } ?>

            <select name="operation" id="">
                <option hidden value=0>Choisir l'opération</option>
                <option value=1>Ambulatoire chirugie</option>
                <option value=2>Hospitalisation (une nuit minimum)</option>
            </select>

            <input type="date" name="dateHospitalisation" id="" min="<?= $dateMin ?>">

            <input type="time" name="heureHospitalisation" id="">

            <select name="docteur" id="">
                <option hidden value=0>Choisir le médecin</option>

                <?php foreach($docteur as $req) { ?>
                    <option value=<?= $req['id'] ?> ><?= $req['nom'] . ' ' . $req['prenom'] ?></option>
                <?php } ?>
                
            </select>

            <input type="submit" name="next" value="Continuer">
        </form>
    </main>
</body>
</html>