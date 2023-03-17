<?php
    include_once('../include.php');

    if(!isset($_SESSION['utilisateur'][5]) AND $_SESSION['utilisateur'][3] != 1) {
        header('Location: panel');
        exit;
    }

    $_SESSION['patientPrea'] = '';
    $_SESSION['preadmission'] = array();

    $erreur = '';

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['chercheNumSecu'])) {

            function is_secsocnum($numSecu){
                $numSecu = preg_replace("/[^0-9]/", "", $numSecu); 

                if ((strlen($numSecu) != 13) && (strlen($numSecu) != 15)) {
                    return 0;
                } 
                
                if (($numSecu[0] == 0) || ( $numSecu[0] > 2)){
                    return 0;
                } 
                
                if (!in_array(substr($numSecu, 3, 2), range(1, 12))){
                    return 0;
                }
                 
                return true;
            }

            if(is_secsocnum($numSecu)) {

                // $searchString = " ";
                // $replaceString = "";
                // $originalString = $numSecu;
                
                // $numSecu = str_replace($searchString, $replaceString, $originalString); 
                
                $chercherPreAdmission = $DB->prepare("SELECT * FROM preadmission WHERE idPatient = ? AND status = 'Pas réalisé'");
                $chercherPreAdmission->execute([$numSecu]);
                $chercherPreAdmissionCount = $chercherPreAdmission->rowCount();
                $chercherPreAdmission = $chercherPreAdmission->fetch();

                if($chercherPreAdmissionCount == 0) {
                    $erreur = "Ce patient est inscrit à aucune des pré-admissions disponible.";

                } elseif($chercherPreAdmissionCount == 1) {
                    $_SESSION['preadmission'] = array(
                        $chercherPreAdmission['id'], //0
                        $chercherPreAdmission['idPatient'], //1
                        $chercherPreAdmission['idMedecin'], //2
                        $chercherPreAdmission['idOperation'], //3
                        $chercherPreAdmission['idChambre'], //4
                        $chercherPreAdmission['status'] //5
                    );

                    switch($_SESSION['preadmission'][5]) {
                        case 'Annulé':
                            $erreur = 'La pré-admission à été annulé.';
                            break;
                        
                        case 'En cours':
                            $erreur = 'La pré-admission est en cours, impossible de la modifier.';
                            break;
                        
                        case 'Pas réalisé';
                            header('Location: modif_admission');
                            exit;

                            break;
                    }

                } elseif($chercherPreAdmissionCount > 1) {
                    $_SESSION['patientPrea'] = $chercherPreAdmission['idPatient'];

                    header('Location: voir_preadmission_modif');
                    exit;

                } else {
                    $erreur = "Ce patient est inscrit à aucune des pré-admissions disponible.";
                }
            } else {
                $erreur = "Ceci n'est pas un numéro de sécurité sociale valide.";
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

    <link rel="stylesheet" href="../style/numSecu.css">
    <link rel="stylesheet" href="../style/navBar.css">

    <title>Modifier une pré-admission</title>
    <link rel="icon" href="../img/logo.png" type="image/icon type">
</head>
<body>
    <?php require_once('src/navbar.php'); ?>

    <form method="post">
        <h1>Modifier une pré-admission</h1>

        <?php if($erreur != '') { ?><div class="erreur"><?= $erreur ?></div><?php } ?>

        <input type="text" required name="numSecu"  required minlength="15" maxlength="15" placeholder="Numéro de sécurité sociale">

        <input type="submit" name="chercheNumSecu" value="Rechercher le patient">
    </form>

    <script src="js/expireConnexion.js"></script>
</body>
</html>