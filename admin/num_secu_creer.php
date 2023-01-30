<?php
    include_once('../include.php');

    $_SESSION['patient'] = array();
    $_SESSION['personneConfiance'] = array();
    $_SESSION['personnePrevenir'] = array();
    $_SESSION['hospitalisation'] = array();
    $_SESSION['couvertureSociale'] = array();

    $_SESSION['creer_admission'] = array(
        false, //0
        false, //1
        false, //2
        false, //3
        false //4
    );

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
                
                $chercheNumSecu = $DB->prepare("SELECT * FROM patient WHERE numSecu = ?");
                $chercheNumSecu->execute([$numSecu]);
                $chercheNumSecu = $chercheNumSecu->fetch();

                if(isset($chercheNumSecu['numSecu'])) {
                    $_SESSION['patient'] = array(
                        $numSecu, //0
                        $chercheNumSecu['civilite'], //1
                        $chercheNumSecu['nomNaissance'], //2
                        $chercheNumSecu['nomEpouse'], //3
                        $chercheNumSecu['prenom'], //4
                        $chercheNumSecu['dateNaissance'], //5
                        $chercheNumSecu['adresse'], //6
                        $chercheNumSecu['codePostal'], //7
                        $chercheNumSecu['ville'], //8
                        $chercheNumSecu['email'], //9
                        $chercheNumSecu['telephone'], //10
                        true, //11
                        true //12
                    );

                    $_SESSION['creer_admission'] = array(
                        true, //0
                        false, //1
                        false, //2
                        false, //3
                        false //4
                    );

                    header('Location: ajout_admission');
                    exit;

                } else {
                    $_SESSION['patient'] = array($numSecu, '', '', '', '', '', '', '', '', '', false);

                    $_SESSION['creer_admission'] = array(
                        true, //0
                        false, //1
                        false, //2
                        false, //3
                        false //4
                    );

                    header('Location: ajout_admission');
                    exit;
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

    <title>Document</title>
</head>
<body>
    <?php
        require_once('src/navbar.php');
    ?>

    <form method="post">
        <h1>Créer une nouvelle pré-admission</h1>

        <?php if($erreur != '') { ?><div class="erreur"><?= $erreur ?></div><?php } ?>

        <input type="text" required name="numSecu"  required minlength="15" maxlength="15" placeholder="Numéro de sécurité sociale">

        <input type="submit" name="chercheNumSecu" value="Rechercher le patient">
    </form>
</body>
</html>