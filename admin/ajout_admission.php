<?php
    include_once('../include.php');

    if(empty($_SESSION['utilisateur'][5]) || $_SESSION['utilisateur'][3] != 1) {
        header('Location: panel.php');
        exit;
    }

    if($_SESSION['creer_admission'][0] != true) {
        header('Location: num_secu_creer.php');
        exit;
    }

    $dateMax = date('Y-m-d', time());

    $erreur = '';
    
    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['next'])) {

            if($civilite != 'none') {
                $numSecu = $_SESSION['patient'][0];
                $bool = $_SESSION['patient'][11];

                //Voir si il est mineur ou non
                $dateDepart = $dateNaissance;
                $dateAujourdhui = date('Y-m-d');
            
                $duree = 18;
            
                $dateDepartTimestamp = strtotime($dateDepart);
            
                $dateFin = date('Y-m-d', strtotime('+'.$duree.' year', $dateDepartTimestamp));
            
                if($dateFin >= $dateAujourdhui) {
                    $mineur = true;
                } else {
                    $mineur = false;
                }
    

                //Les sessions
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
                    '0'.$telephone, //10
                    $bool, //11
                    $mineur //12
                );

                $_SESSION['creer_admission'] = array(
                    true, //0
                    true, //1
                    false, //2
                    false, //3
                    false //4 
                );
    
                header('Location: contact_patient.php');
                exit;
            } else {
                $erreur = 'Veillez choisir le sexe du patient.';
            }            
        }
    }

    switch($_SESSION['patient'][1]) {
        case 'Homme':
            $homme = 'selected';
            $femme = '';
        break;

        case 'Femme':
            $homme = '';
            $femme = 'selected';
        break;

        default:
            $homme = '';
            $femme = '';
        break;
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

    <title>Information sur le patient</title>
    <link rel="icon" href="../img/logo.png" type="image/icon type">

</head>
<body>
    <?php
        require_once('src/navbar.php');
    ?>


    <main>
        <h2>Information sur le patient</h2>

        <form method="post">

            <?php if($erreur != '') { ?><div class="erreur"><?= $erreur ?></div><?php } ?>

            <input required disabled style="cursor: not-allowed; border-radius: 10px 10px 0 0;" type="text" name="" value="<?= $_SESSION['patient'][0] ?>" placeholder="Numéro de sécurité sociale">

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
    
    <script src="js/expireConnexion.js"></script>
    
</body>
</html>