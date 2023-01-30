<?php
    include_once('../include.php');
    
    if($_SESSION['creer_admission'][0] != true && $_SESSION['creer_admission'][1] != true && $_SESSION['creer_admission'][2] != true && $_SESSION['creer_admission'][3] != true && $_SESSION['creer_admission'][4] != true) {
        header('Location: num_secu_creer');
        exit;
    }

    $erreur = '';

    if(!empty($_POST)) {
        extract($_POST);

        $valid = true;

        if($_SESSION['patient'][12]) {
            if(isset($_FILES['livretFamille']) && !empty($_FILES['livretFamille'])) {
                $extensionValides = array('jpg', 'png', 'jpeg', 'pdf');

                $upload_livretFamille = strtolower(substr(strrchr($_FILES['livretFamille']['name'], '.'), 1));

                if(in_array($upload_livretFamille, $extensionValides)) {

                    $dossier = 'patients/docs/' . $_SESSION['patient'][0];

                    if(!is_dir($dossier)) {
                        mkdir($dossier);
                    }
                
                    $livretFamille = 'Ficher_livretFamille_' . $_SESSION['patient'][0] . '.' . $upload_livretFamille;

                    $chemin_livretFamille = $dossier . '/' . $livretFamille;

                    $res_livretFamille = move_uploaded_file($_FILES['livretFamille']['tmp_name'], $chemin_livretFamille);

                    if(is_readable($chemin_livretFamille)) {
                        $valid = true;
                    } else {
                        $valid = false;
                    }
                } else {
                    $valid = false;
                }
            } else {
                $valid = false;
            }
        } else {
            $livretFamille = '';
        }

        if(isset($_FILES['cni']) && !empty($_FILES['cni']['name']) && isset($_FILES['carteVitale']) && !empty($_FILES['carteVitale']['name']) && isset($_FILES['carteMutuelle']) && !empty($_FILES['carteMutuelle']['name'])) {
                
            $extensionValides = array('jpg', 'png', 'jpeg', 'pdf');

            $upload_CNI = strtolower(substr(strrchr($_FILES['cni']['name'], '.'), 1));
            $upload_CarteVitale = strtolower(substr(strrchr($_FILES['carteVitale']['name'], '.'), 1));
            $upload_CarteMutuelle = strtolower(substr(strrchr($_FILES['carteMutuelle']['name'], '.'), 1));

            if(in_array($upload_CNI, $extensionValides) && in_array($upload_CarteVitale, $extensionValides) && in_array($upload_CarteMutuelle, $extensionValides)) {

                $dossier = 'patients/docs/' . $_SESSION['patient'][0];

                if(!is_dir($dossier)) {
                    mkdir($dossier);
                }
            
                $cni = 'Ficher_CNI_' . $_SESSION['patient'][0] . '.' . $upload_CNI;
                $carteVitale = 'Ficher_carteVitale_' . $_SESSION['patient'][0] . '.' . $upload_CarteVitale;
                $carteMutuelle = 'Ficher_carteMutuelle_' . $_SESSION['patient'][0] . '.' . $upload_CarteMutuelle;

                $chemin_CNI = $dossier . '/' . $cni;
                $chemin_CarteVitale = $dossier . '/' . $carteVitale;
                $chemin_CarteMutuelle = $dossier . '/' . $carteMutuelle;

                $res_CNI = move_uploaded_file($_FILES['cni']['tmp_name'], $chemin_CNI);
                $res_CarteVitale = move_uploaded_file($_FILES['carteVitale']['tmp_name'], $chemin_CarteVitale);
                $res_CarteMutuelle = move_uploaded_file($_FILES['carteMutuelle']['tmp_name'], $chemin_CarteMutuelle);

                if(is_readable($chemin_CNI) && is_readable($chemin_CarteVitale) && is_readable($chemin_CarteMutuelle)) {
                    $valid = true;
                } else{
                    $erreur = 'Erreur images 3';
                    $valid = false;
                }
            } else { 
                $erreur = 'Erreur images 2';
                $valid = false;
            }
        } else {
            $erreur ='Erreur images 1';
            $valid = false;
        }


        if($valid) {
            if(isset($_SESSION['patient'][11]) == false) { //Si le patient n'existe pas
                $insertPatient = $DB->prepare("INSERT INTO patient (numSecu, civilite, nomNaissance, nomEpouse, prenom, dateNaissance, adresse, codePostal, ville, email, telephone, cni, carteVitale, carteMutuelle, livretFamille) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
                $insertPatient->execute([$_SESSION['patient'][0],$_SESSION['patient'][1],$_SESSION['patient'][2],$_SESSION['patient'][3],$_SESSION['patient'][4],$_SESSION['patient'][5],$_SESSION['patient'][6],$_SESSION['patient'][7],$_SESSION['patient'][8],$_SESSION['patient'][9],$_SESSION['patient'][10], $cni, $carteVitale, $carteMutuelle, $livretFamille]);


                $contactPatient = $DB->prepare("SELECT id, prevenir, confiance FROM contact WHERE idPatient = ?");
                $contactPatient->execute([$_SESSION['patient'][0]]);
                $contactPatientRow = $contactPatient->rowcount();
                $contactPatientFetch = $contactPatient->fetch();

                if($contactPatientRow == 2) {
                    $updateConfiance = $DB->prepare("UPDATE contact SET nom = ?, prenom = ?, adresse = ?, telephone = ? = ? WHERE idPatient = ? AND telephone = ? AND confiance = 1");
                    $updateConfiance->execute([$_SESSION['personneConfiance'][0], $_SESSION['personneConfiance'][1], $_SESSION['personneConfiance'][3], $_SESSION['personneConfiance'][2], $_SESSION['patient'][0], $_SESSION['personneConfiance'][2]]);
                    
                    $updateConfiance = $DB->prepare("UPDATE contact SET nom = ?, prenom = ?, adresse = ?, telephone = ? = ? WHERE idPatient = ? AND telephone = ? AND prevenir = 1");
                    $updateConfiance->execute([$_SESSION['personnePrevenir'][0], $_SESSION['personnePrevenir'][1], $_SESSION['personnePrevenir'][3], $_SESSION['personnePrevenir'][2], $_SESSION['patient'][0], $_SESSION['personnePrevenir'][2]]);

                } elseif(isset($contactPatientFetch['prevenir']) == 1 && isset($contactPatientFetch['confiance']) == 1) {
                    $updateConfiance = $DB->prepare("UPDATE contact SET nom = ?, prenom = ?, adresse = ?, telephone = ? = ? WHERE idPatient = ? AND telephone = ? AND confiance = 1 AND prevenir = 1");
                    $updateConfiance->execute([$_SESSION['personneConfiance'][0], $_SESSION['personneConfiance'][1], $_SESSION['personneConfiance'][3], $_SESSION['personneConfiance'][2], $_SESSION['patient'][0], $_SESSION['personneConfiance'][2]]);
                }

                if($contactPatientRow == 0) {
                    if(in_array($_SESSION['personneConfiance'], $_SESSION['personnePrevenir'])) {
                        $insertConfiance_et_prevenir = $DB->prepare("INSERT INTO contact (nom, prenom, adresse, telephone, idPatient, prevenir, confiance) VALUES(?, ?, ?, ?, ?, 1, 1);");
                        $insertConfiance_et_prevenir->execute([$_SESSION['personneConfiance'][0], $_SESSION['personneConfiance'][1], $_SESSION['personneConfiance'][3], $_SESSION['personneConfiance'][2], $_SESSION['patient'][0]]);

                    } else {
                        $insertConfiance = $DB->prepare("INSERT INTO contact (nom, prenom, adresse, telephone, idPatient, prevenir, confiance) VALUES(?, ?, ?, ?, ?, 0, 1);");
                        $insertConfiance->execute([$_SESSION['personneConfiance'][0], $_SESSION['personneConfiance'][1], $_SESSION['personneConfiance'][3], $_SESSION['personneConfiance'][2], $_SESSION['patient'][0]]);

                        $insertPrevenir = $DB->prepare("INSERT INTO contact (nom, prenom, adresse, telephone, idPatient, prevenir, confiance) VALUES(?, ?, ?, ?, ?, 1, 0);");
                        $insertPrevenir->execute([$_SESSION['personnePrevenir'][0], $_SESSION['personnePrevenir'][1], $_SESSION['personnePrevenir'][3], $_SESSION['personnePrevenir'][2], $_SESSION['patient'][0]]);
                    }
                }
            } else {
                $updatePatient = $DB->prepare("UPDATE patient SET civilite = ?, nomNaissance = ?, nomEpouse = ?, prenom = ?, dateNaissance = ?, adresse = ?, codePostal = ?, ville = ?, email = ?, telephone = ?, cni = ?, carteVitale = ?, carteMutuelle = ?, livretFamille = ? WHERE numSecu = ?;");
                $updatePatient->execute([$_SESSION['patient'][1],$_SESSION['patient'][2],$_SESSION['patient'][3],$_SESSION['patient'][4],$_SESSION['patient'][5],$_SESSION['patient'][6],$_SESSION['patient'][7],$_SESSION['patient'][8],$_SESSION['patient'][9],$_SESSION['patient'][10], $cni, $carteVitale, $carteMutuelle, $livretFamille, $_SESSION['patient'][0]]);

                $contactPatient = $DB->prepare("SELECT id, prevenir, confiance FROM contact WHERE idPatient = ? AND prevenir = 1 AND confiance = 1");
                $contactPatient->execute([$_SESSION['patient'][0]]);
                $contactPatientRow = $contactPatient->rowcount();

                if($contactPatientRow == 1) {
                    $updateConfiance = $DB->prepare("UPDATE contact SET nom = ?, prenom = ?, adresse = ?, telephone = ?, idPatient = ? WHERE idPatient = ? AND telephone = ? AND confiance = 1 AND prevenir = 1");
                    $updateConfiance->execute([$_SESSION['personneConfiance'][0], $_SESSION['personneConfiance'][1], $_SESSION['personneConfiance'][3], $_SESSION['personneConfiance'][2], $_SESSION['patient'][0], $_SESSION['patient'][0], $_SESSION['personneConfiance'][2]]);

                } else {
                    $updateConfiance = $DB->prepare("UPDATE contact SET nom = ?, prenom = ?, adresse = ?, telephone = ?, idPatient = ? WHERE idPatient = ? AND telephone = ? AND confiance = 1");
                    $updateConfiance->execute([$_SESSION['personneConfiance'][0], $_SESSION['personneConfiance'][1], $_SESSION['personneConfiance'][3], $_SESSION['personneConfiance'][2], $_SESSION['patient'][0], $_SESSION['patient'][0], $_SESSION['personneConfiance'][2]]);
                    
                    $updateConfiance = $DB->prepare("UPDATE contact SET nom = ?, prenom = ?, adresse = ?, telephone = ?, idPatient = ? WHERE idPatient = ? AND telephone = ? AND prevenir = 1");
                    $updateConfiance->execute([$_SESSION['personnePrevenir'][0], $_SESSION['personnePrevenir'][1], $_SESSION['personnePrevenir'][3], $_SESSION['personnePrevenir'][2], $_SESSION['patient'][0], $_SESSION['patient'][0], $_SESSION['personnePrevenir'][2]]);
                }
            }

            switch($_SESSION['hospitalisation'][0]) {
                case 1:
                    $nomOperation = 'Ambulatoire chirugie';
                    break;

                case 2:
                    $nomOperation = 'Hospitalisation';
                    break;
            }
            
            $insertOperation = $DB->prepare("INSERT INTO operations (idPatient, nomOperation, dateOperation, heureOperation, idMedecin) VALUES(?, ?, ?, ?, ?);");
            $insertOperation->execute([$_SESSION['patient'][0], $nomOperation, $_SESSION['hospitalisation'][1], $_SESSION['hospitalisation'][2], $_SESSION['hospitalisation'][3]]);

            if($_SESSION['couvertureSociale'][7] == false) {
                $insertcouverture = $DB->prepare("INSERT INTO couverture (numSecu, organisme, assure, ald, nomMutuelle, numAdherent) VALUES(?, ?, ?, ?, ?, ?);");
                $insertcouverture->execute([$_SESSION['patient'][0], $_SESSION['couvertureSociale'][1], $_SESSION['couvertureSociale'][2], $_SESSION['couvertureSociale'][3],$_SESSION['couvertureSociale'][4],$_SESSION['couvertureSociale'][5]]);
            } else {
                $updateCouverture = $DB->prepare("UPDATE couverture SET organisme = ?, assure = ?, ald = ?, nomMutuelle = ?, numAdherent = ? WHERE numSecu = ?;");
                $updateCouverture->execute([$_SESSION['couvertureSociale'][1], $_SESSION['couvertureSociale'][2], $_SESSION['couvertureSociale'][3],$_SESSION['couvertureSociale'][4],$_SESSION['couvertureSociale'][5], $_SESSION['patient'][0]]);
            }

            $selectOperationId = $DB->prepare("SELECT id FROM operations WHERE idPatient = ? AND dateOperation = ? AND heureOperation = ?");
            $selectOperationId->execute([$_SESSION['patient'][0], $_SESSION['hospitalisation'][1], $_SESSION['hospitalisation'][2]]);
            $selectOperationId = $selectOperationId->fetch();

            $insertPreadmission = $DB->prepare("INSERT INTO preadmission (idPatient, idMedecin, idOperation, idChambre) VALUES(?, ?, ?, ?);");
            $insertPreadmission->execute([$_SESSION['patient'][0], $_SESSION['hospitalisation'][3], $selectOperationId['id'], $_SESSION['couvertureSociale'][6]]);

            header('Location: num_secu_creer');
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
    <?php
        require_once('src/navbar.php');
    ?>

    <main>
        <form method="post" enctype="multipart/form-data">

            <?php if($erreur != '') { ?><div class="erreur"><?= $erreur ?></div><?php } ?>

            <label for="cni">
                Carte d'identité (Recto / Verso)
                <input required type="file" name="cni" id="">
            </label>

            <label for="carteVitale">
                Carte vitale
                <input required type="file" name="carteVitale" id="">
            </label>

            <label for="carteMutuelle">
                Carte mutuelle
                <input required type="file" name="carteMutuelle" id="">
            </label>

            <?php if(isset($_SESSION['patient'][12])) { ?>
            <label for="livretFamille">
                Livret de famille (si le patient est mineur)
                <input type="file" name="livretFamille" id="">
            </label>
            <?php } ?>

            <input type="submit" name="finish" value="Ajouter la pré-admission pour <?= $_SESSION['patient'][4] . ' ' . $_SESSION['patient'][2] ?>">
        </form>
    </main>
</body>
</html>