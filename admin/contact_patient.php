<?php
    include_once('../include.php');

    if($_SESSION['creer_admission'][0] != true && $_SESSION['creer_admission'][1] != true) {
        header('Location: num_secu_creer');
        exit;
    }

    $PersonneConfiance = $DB->prepare("SELECT * FROM contact WHERE idPatient = ? AND confiance = 1");
    $PersonneConfiance->execute([$_SESSION['patient'][0]]);
    $PersonneConfiance = $PersonneConfiance->fetch();

    $PersonnePrevenir = $DB->prepare("SELECT * FROM contact WHERE idPatient = ? AND prevenir = 1");
    $PersonnePrevenir->execute([$_SESSION['patient'][0]]);
    $PersonnePrevenir = $PersonnePrevenir->fetch();

    if(isset($PersonneConfiance['id'])) {
        $_SESSION['personneConfiance'] = array(
            $PersonneConfiance['nom'], //0
            $PersonneConfiance['prenom'], //1
            '0'.$PersonneConfiance['telephone'], //2
            $PersonneConfiance['adresse'], //3
            $PersonneConfiance['idPatient'], //4
            $PersonneExiste = true //5
        );
        
    } else {
        $_SESSION['personneConfiance'] = array('', '', '', '', '', false);
    }
    
    if(isset($PersonnePrevenir['id'])) {
        $_SESSION['personnePrevenir'] = array(
            $PersonnePrevenir['nom'], //0
            $PersonnePrevenir['prenom'], //1
            '0'.$PersonnePrevenir['telephone'], //2
            $PersonnePrevenir['adresse'], //3
            $PersonnePrevenir['idPatient'], //4
            $PersonneExiste = true //5
        );
        
    } else {
        
        $_SESSION['personnePrevenir'] = array('', '', '', '', '', false);
    }

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['next'])) {
            $_SESSION['personneConfiance'] = array(
                $nomConfiance, //0
                $prenomConfiance, //1
                $telConfiance, //2
                $adresseConfiance, //3
                $_SESSION['patient'][0] //4
            );

            $_SESSION['personnePrevenir'] = array(
                $nomPrevenir, //0
                $prenomPrevenir, //1
                $telPrevenir, //2
                $adressePrevenir, //3
                $_SESSION['patient'][0] //4
            );

            $_SESSION['creer_admission'] = array(
                true, //0
                true, //1
                true, //2
                false, //3
                false //4
            );

            header('Location: hospitalisation');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta required name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style/ajoutAdmission.css">
    <link rel="stylesheet" href="../style/navBar.css">

    <title>Document</title>
</head>
<body>
    <?php
        require_once('src/navbar.php');
    ?>

    <main>

        <form method="post">
            <h2>Personne de confiance</h2>

            <!-- <div class="erreur">test</div> -->

            <input type="text" required name="nomConfiance" value="<?= $_SESSION['personneConfiance'][0] ?>" placeholder="Nom de la personne de confiance">

            <input type="text" required name="prenomConfiance" value="<?= $_SESSION['personneConfiance'][1] ?>" placeholder="Prénom de la personne de confiance">

            <input type="tel" required name="telConfiance" value="<?= $_SESSION['personneConfiance'][2] ?>" placeholder="Téléphone de la personne de confiance">

            <input type="text" required name="adresseConfiance" value="<?= $_SESSION['personneConfiance'][3] ?>" placeholder="Adresse de la personne de confiance">



            <h2>Personne à prévenir</h2>

            <input type="text" required name="nomPrevenir" value="<?= $_SESSION['personnePrevenir'][0] ?>" placeholder="Nom de la personne à prévenir">

            <input type="text" required name="prenomPrevenir" value="<?= $_SESSION['personnePrevenir'][1] ?>" placeholder="Prénom de la personne à prévenir">

            <input type="text" required name="telPrevenir" value="<?= $_SESSION['personnePrevenir'][2] ?>" placeholder="Téléphone de la personne à prévenir">

            <input type="text" required name="adressePrevenir" value="<?= $_SESSION['personnePrevenir'][3] ?>" placeholder="Adresse de la personne à prévenir">

            <input type="submit" required name="next" value="Continuer">
        </form>
    </main>
</body>
</html>