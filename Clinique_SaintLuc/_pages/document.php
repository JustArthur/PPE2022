<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

    include_once("../include.php");

    //$numSecu = $_GET['numSecu'];

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_FILES['cni']) && !empty($_FILES['cni']['name'])) {

            $filename = $_FILES['cni']['tmp_name'];
                
            $extensionValides = array('jpg', 'png', 'jpeg', 'pdf');

            $extensionUpload = strtolower(substr(strrchr($_FILES['cni']['name'], '.'), 1));

            if(in_array($extensionUpload, $extensionValides)) {

                $dossier = '../_documents/patient_' . $numSecu;

                if(!is_dir($dossier)) {
                    mkdir($dossier);
                }
            
                $cni = 'Ficher_CNI_' . $numSecu . '.' . $extensionUpload;

                $chemin = $dossier . '/' . $cni;

                $resultat = move_uploaded_file($_FILES['cni']['tmp_name'], $chemin);

                if(is_readable($resultat)) {

                    $req = $DB->prepare('INSERT INTO patient (cni) VALUES(?) WHERE numSecu = ?;');
                    $req->execute(array($cni, $numSecu));
                }
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
    <link rel="stylesheet" href="../_style/style.css">
    <title>Patient</title>
</head>
<body>

<main>
    <form class="formulaire" id="form" name="form" method="POST" enctype="multipart/form-data">
        <div class="title_img">Ajouter la carte national d'identité</div><br>
        <input type="file" name="cni" id="cni"><br><br>

        <div class="title_img">Ajouter la carte vitale</div><br>
        <input type="file" name="vitale" id="vitale"><br><br>

        <div class="title_img">Ajouter la mutuelle</div><br>
        <input type="file" name="mutuelle" id="mutuelle"><br><br>

        <div class="title_img">Ajouter le livret de famille (si le patient est mineur)</div><br>
        <input type="file" name="livret_Famille" id="livret_Famille"><br><br>

        <input type="submit" name="document" value="Ajouter les documents" class="btn1">
    </form>
</main>
</body>
</html>