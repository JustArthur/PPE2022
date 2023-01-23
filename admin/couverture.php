<?php
    include_once('../include.php');

    $couverture = $DB->prepare("SELECT * FROM couverture WHERE numSecu = ?");
    $couverture->execute([$_SESSION['patient'][0]]);
    $couverture = $couverture->fetch();

    if(isset($couverture['numSecu'])) {
        $_SESSION['couvertureSociale'] = array(
            $_SESSION['patient'][0], //0
            $couverture['organisme'], //1
            $couverture['assure'], //2
            $couverture['ald'], //3
            $couverture['nomMutuelle'], //4
            $couverture['numAdherent'], //5
            $couverture['idChambre'], //6
            $couvertureExiste = true //7
        );

        switch($_SESSION['couvertureSociale'][2]) {
            case 'Oui':
                $assureOui = 'selected';
                $assureNon = '';
                break;

            case 'Non':
                $assureOui = '';
                $assureNon = 'selected';
                break;
        }

        switch($_SESSION['couvertureSociale'][3]) {
            case 'Oui':
                $aldOui = 'selected';
                $aldNon = '';
                break;

            case 'Non':
                $aldOui = '';
                $aldNon = 'selected';
                break;
        }

    } else {
        $_SESSION['couvertureSociale'] = array($_SESSION['patient'][0], '', '', '', '', '', '', $couvertureExiste = false);
    }

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['next'])) {

            if(isset($assure) != 0 && isset($ald) != 0 && isset($chambre) != 0) {
                $_SESSION['couvertureSociale'] = array(
                    $_SESSION['patient'][0], //0
                    $organisme, //1
                    $assure, //2
                    $ald, //3
                    $nomMutuelle, //4
                    $numAdherent, //5
                    $chambre //6
                );

                header('Location: document');
                exit;

            } else {
                $erreur = "Certain champs n'ont pas été remplis correctement.";
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
        <h2>Couverture sociale du patient</h2>
        <form method="post">
            <input required type="text" name="organisme" value="<?= $_SESSION['couvertureSociale'][1] ?>" id="" placeholder="Organisme de sécurité sociale / Nom de la caisse d'assurance maladie">

            <input required type="text" name="numSecuConfirm" disabled style="cursor: not-allowed;" value="<?= $_SESSION['couvertureSociale'][0] ?>" id="" placeholder="Numero de sécurité sociale">

            <div class="input">
                <select name="assure" id="">
                    <option hidden value=0 >Le patient est t'il assuré ?</option>
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
                </select>

                <select name="ald" id="">
                    <option hidden value=0 >Le patient est t'il en ALD ?</option>
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
                </select>
            </div>

            <input required type="text" name="nomMutuelle" id="" value="<?= $_SESSION['couvertureSociale'][4] ?>" placeholder="Nom de la mutuelle ou de l'assurance">

            <input required type="text" name="numAdherent" value="<?= $_SESSION['couvertureSociale'][1] ?>" id="" placeholder="Numéro d'ahérent">

            <select name="chambre" id="">
                <option hidden value=0 > Chambre particulière ?</option>

                <optgroup label="Avec équipements">
                    <option value=1>Chambre seul</option>
                    <option value=2>Chambre partager</option>
                </optgroup>

                <optgroup label="Sans équipements">
                    <option value=3>Chambre seul</option>
                    <option value=4>Chambre partager</option>
                </optgroup>
            </select>

            <input type="submit" name="next" value="Continuer">
        </form>
    </main>
</body>
</html>