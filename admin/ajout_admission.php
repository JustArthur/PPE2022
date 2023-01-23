<?php

    include_once('../include.php');

    $dateMax = date('Y-m-d', time());

    $erreur = '';

    if($_SESSION['patient'][1] == "Homme") {
        $homme = 'selected';
        $femme = '';
    } elseif($_SESSION['patient'][1] == "Femme") {
        $homme = '';
        $femme = 'selected';
    } else {
        $homme = '';
        $femme = '';
    }
    
    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['next'])) {

            if($civilite != 'none') {
                $numSecu = $_SESSION['patient'][0];
                $cni = $_SESSION['patient'][11];
                $carteMutuelle = $_SESSION['patient'][12];
                $carteVitale = $_SESSION['patient'][13];
                $livretFamille = $_SESSION['patient'][14];
    
                $_SESSION['patient'] = array(
                    $numSecu, //0
                    $civilite, //1
                    $nomNaissance, //2
                    $nomEpouse, //3
                    $prenom, //4
                    $dateNaissance, //5
                    $adresse, //6
                    $codePostal, //7
                    $ville, //8
                    $email, //9
                    $telephone, //10
                    $cni, //11
                    $carteMutuelle, //12
                    $carteVitale, //13
                    $livretFamille, //14
                );
    
                header('Location: contact_patient');
                exit;
            } else {
                $erreur = 'Veillez choisir le sexe du patient.';
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
        <h2>Information sur le patient</h2>

        <form method="post">

            <?php if($erreur != '') { ?><div class="erreur"><?= $erreur ?></div><?php } ?>

            <input required disabled style="cursor: not-allowed;" type="text" name="" value="<?= $_SESSION['patient'][0] ?>" placeholder="Numéro de sécurité sociale">

            <select required name="civilite" id="">
                <option hidden value="none">Sexe du patient</option>
                <option value="Homme" <?= $homme ?> >Homme</option>
                <option value="Femme" <?= $femme ?> >Femme</option>
            </select>

            <input required type="text" name="nomNaissance" value="<?= $_SESSION['patient'][2] ?>" placeholder="Nom de naissance">

            <input type="text" name="nomEpouse" value="<?= $_SESSION['patient'][3] ?>" placeholder="Nom d'épouse (Optionel)">

            <input required type="text" name="prenom" value="<?= $_SESSION['patient'][4] ?>" placeholder="Prénom">

            <input required type="date" name="dateNaissance" value="<?= $_SESSION['patient'][5] ?>" max="<?= $dateMax ?>">
            
            <input required type="text" name="adresse" value="<?= $_SESSION['patient'][6] ?>" placeholder="Adresse">

            <input required maxlength="5" type="number" name="codePostal" value="<?= $_SESSION['patient'][7] ?>" placeholder="Code postal">

            <input required type="ville" name="ville" value="<?= $_SESSION['patient'][8] ?>" placeholder="Ville">

            <input required type="email" name="email" value="<?= $_SESSION['patient'][9] ?>" placeholder="Adresse mail">

            <input required maxlength="10" type="tel" name="telephone" value="<?= $_SESSION['patient'][10] ?>" placeholder="Numéro de téléphone">

            <input type="submit" name="next" value="Continuer">
        </form>
    </main>
    
    
</body>
</html>