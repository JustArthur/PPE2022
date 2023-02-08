<?php
    include_once('../include.php');

    if(!isset($_SESSION['utilisateur'][5]) AND $_SESSION['utilisateur'][3] != 1) {
        header('Location: panel');
        exit;
    }

    $couverture = $DB->prepare("SELECT * FROM couverture WHERE numSecu = ?");
    $couverture->execute([$_SESSION['preadmission'][1]]);
    $couverture = $couverture->fetch();

    $nomPrenom = $DB->prepare("SELECT nomNaissance, prenom FROM patient WHERE numSecu = ?");
    $nomPrenom->execute([$_SESSION['preadmission'][1]]);
    $nomPrenom = $nomPrenom->fetch();

    $_SESSION['couvertureSociale'] = array(
        $couverture['numSecu'], //0
        $couverture['organisme'], //1
        $couverture['assure'], //2
        $couverture['ald'], //3
        $couverture['nomMutuelle'], //4
        $couverture['numAdherent'] //5
    );

    switch($_SESSION['couvertureSociale'][2]) {
        case 'oui':
            $assureOui = 'selected';
            $assureNon = '';
            break;

        case 'non':
            $assureOui = '';
            $assureNon = 'selected';
            break;

        default:
            $aldOui = '';
            $aldNon = '';
            break;
    }

    switch($_SESSION['couvertureSociale'][3]) {
        case 'oui':
            $aldOui = 'selected';
            $aldNon = '';
            break;

        case 'non':
            $aldOui = '';
            $aldNon = 'selected';
            break;

        default:
            $aldOui = '';
            $aldNon = '';
            break;
    }

    switch($_SESSION['preadmission'][4]) {
        case 1:
            $chambreUn = 'selected';
            $chambreDeux = '';
            $chambreTrois = '';
            $chambreQuatre = '';
            break;

        case 2:
            $chambreUn = '';
            $chambreDeux = 'selected';
            $chambreTrois = '';
            $chambreQuatre = '';
            break;

        case 3:
            $chambreUn = '';
            $chambreDeux = '';
            $chambreTrois = 'selected';
            $chambreQuatre = '';
            break;

        case 4:
            $chambreUn = '';
            $chambreDeux = '';
            $chambreTrois = '';
            $chambreQuatre = 'selected';
            break;

        default:
        $chambreUn = '';
        $chambreDeux = '';
        $chambreTrois = '';
        $chambreQuatre = '';
            break;
    }

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['next'])) {

            $suppAdmission = $DB->prepare("UPDATE preadmission SET status='Annulé' WHERE id = ?");
            $suppAdmission->execute([$_SESSION['preadmission'][0]]);

            $textLog = "Modification d'une pré-admission";
            $dateLog = date('Y-m-d H:i');

            $log = $DB->prepare("INSERT INTO log (idUser, nomLog, dateTimeLog) VALUES(?, ?, ?);");
            $log->execute([$_SESSION['utilisateur'][5], $textLog, $dateLog]);

            header('Location: panel');
            exit;

        } else {
            $erreur = "Certain champs n'ont pas été remplis correctement.";
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
            <input style="cursor:not-allowed" disabled type="text" name="organisme" value="<?= $_SESSION['couvertureSociale'][1] ?>" id="" placeholder="Organisme de sécurité sociale / Nom de la caisse d'assurance maladie">

            <input style="cursor:not-allowed" disabled type="text" name="numSecuConfirm" disabled style="cursor: not-allowed;" value="<?= $_SESSION['couvertureSociale'][0] ?>" id="" placeholder="Numero de sécurité sociale">

            <div class="input">
                <select name="assure" style="cursor:not-allowed" disabled id="">
                    <option hidden value=0 >Le patient est t'il assuré ?</option>
                    <option value="oui" <?= $assureOui ?> >Oui il est assuré</option>
                    <option value="non" <?= $assureNon ?> >Non il n'est pas assuré</option>
                </select>

                <select name="ald" style="cursor:not-allowed" disabled id="">
                    <option hidden value=0 >Le patient est t'il en ALD ?</option>
                    <option value="oui" <?= $aldOui ?> >Oui il est en ALD</option>
                    <option value="non" <?= $aldNon ?> >Non il n'est pas en ALD</option>
                </select>
            </div>

            <input type="text" style="cursor:not-allowed" disabled name="nomMutuelle" id="" value="<?= $_SESSION['couvertureSociale'][4] ?>" placeholder="Nom de la mutuelle ou de l'assurance">

            <input type="text" style="cursor:not-allowed" disabled name="numAdherent" value="<?= $_SESSION['couvertureSociale'][5] ?>" id="" placeholder="Numéro d'ahérent">

            <select name="chambre" style="cursor:not-allowed" disabled id="">
                <option hidden value=0 > Chambre particulière ?</option>

                <optgroup label="Avec équipements">
                    <option value=1 <?= $chambreUn ?> >Chambre seul</option>
                    <option value=2 <?= $chambreDeux ?> >Chambre partager</option>
                </optgroup>

                <optgroup label="Sans équipements">
                    <option value=3 <?= $chambreTrois ?> >Chambre seul</option>
                    <option value=4 <?= $chambreQuatre ?> >Chambre partager</option>
                </optgroup>
            </select>

            <input type="submit" name="next" value="Je confirmer la suppression de cette pré-admission">
        </form>
    </main>
</body>
</html>