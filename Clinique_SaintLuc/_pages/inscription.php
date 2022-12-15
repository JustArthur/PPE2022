<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
    include_once('../include.php');

    $NumSecu = $_GET['numSecu'];
    $PatientDisponible = true;
    $PatientPasDisponible = true;

    $req = $DB->prepare("SELECT * FROM patient WHERE numSecu = ?");
    $req->execute(array($NumSecu));
    $req = $req->fetch();

    if(isset($req['numSecu'])) {
        $PatientDisponible = true;
        $PatientPasDisponible = false;

        $NomNaissance = $req['nomNaissance'];
        $NomEpouse = $req['nomEpouse'];
        $Prenom = $req['prenom'];
        $CodePostal = $req['codePostal'];
        $Email = $req['email'];
        $Telephone = $req['telephone'];
        $Adresse = $req['adresse'];
        $Ville = $req['ville'];
        $DateNaissance = $req['dateNaissance'];
        $Civilite = $req['civilite'];

    } else {
        $PatientDisponible = false;
        $PatientPasDisponible = true;

        $NomNaissance = '';
        $NomEpouse = '';
        $Prenom = '';
        $CodePostal = null;
        $Email = '';
        $Telephone = null;
        $Adresse = '';
        $Ville = '';
        $DateNaissance = '';
        $Civilite = '';
    }

    switch($Civilite) {
        case null:
            $selected_elle = '';
            $selected_il = '';
            $selected_iel = '';
        break;

        case 'Il':
            $selected_il = 'selected';
            $selected_elle = '';
            $selected_iel = '';
        break;

        case 'Elle':
            $selected_il = '';
            $selected_elle = 'selected';
            $selected_iel = '';
        break;

        case 'Iel':
            $selected_il = '';
            $selected_elle = '';
            $selected_iel = 'selected';
        break;
    }

    if($PatientPasDisponible) {
        if(!empty($_POST)) {
            extract($_POST);

            if(isset($_POST['inscription'])) {
                [$erreur_insc] = $_INSCRIPTION->verification_inscription($NumSecu, $NomNaissance, $NomEpouse, $Prenom, $Civilite, $CodePostal, $Email, $Telephone, $Adresse, $Ville, $DateNaissance);

            } 
        }
    } elseif($PatientDisponible) {
        if(!empty($_POST)) {
            extract($_POST);

            if(isset($_POST['update'])) {
                [$erreur_updt] = $_UPDATE_PATIENT->updatePatient($NumSecu, $NomNaissance, $NomEpouse, $Prenom, $Civilite, $CodePostal, $Email, $Telephone, $Adresse, $Ville, $DateNaissance);
            }

            if(isset($_POST['delete'])) {
                [$erreur_del] = $_DELETE_PATIENT->deletePatient($NumSecu);

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
    <title>S'inscrire - Hospital Saint Luc</title>
</head>
<body>
    <div class="left">
        <form id="form" name="form" method="post">

                <label for="NumSecu" class="form__label">Numéro de sécurité sociale<span class="star"> *</span></label><br>
                <input type="text" name="NumSecu" id="NumSecu" class="form__input" value="<?= $NumSecu ?>" required maxlength="15" minlength="15" placeholder="101010111111111">

                <?php if(isset($erreur)){ echo '<p class="error">'.$erreur.'</p>';}?>
                <label for="Civilite" class="form__label">Civ<span class="star"> *</span></label>
                <select name="Civilite" id="Civilite" class="form__input_choice" required>
                    <option value="none">Choisi votre civilité</option>
                    <option <?= $selected_il ?> value="Il">Il</option>
                    <option <?= $selected_elle ?> value="Elle"">Elle</option>
                    <option <?= $selected_iel ?> value="Iel"">Iel</option>
                </select>

                <label for="NomNaissance" class="form__label">Nom de naissance<span class="star"> *</span></label><br>
                <input type="text" name="NomNaissance" id="NomNaissance" value="<?= $NomNaissance ?>" class="form__input" required>

                <label for="NomEpouse" class="form__label">Nom d'épouse</label><br>
                <input type="text" name="NomEpouse" id="NomEpouse" value="<?= $NomEpouse ?>" class="form__input">      

                <label for="Prenom" class="form__label">Prénom<span class="star"> *</span></label><br>
                <input type="text" name="Prenom" id="Prenom" value="<?= $Prenom ?>" class="form__input" required>

                <label for="DateNaissance" class="form__label">Date de naissance<span class="star"> *</span></label><br>
                <input type="text" name="DateNaissance" value="<?= $DateNaissance ?>" id="DateNaissance" placeholder="AAAA-MM-JJ" class="form__input" required>

                <label for="Adresse" class="form__label">Adresse<span class="star"> *</span></label><br>
                <input type="text" name="Adresse" id="Adresse" value="<?= $Adresse ?>" class="form__input" required">

                <label for="CodePostal" class="form__label">Code postale<span class="star"> *</span></label><br>
                <input type="text" name="CodePostal" id="CodePostal" value="<?= $CodePostal ?>" class="form__input" required maxlength="5">

                <label for="Ville" class="form__label">Ville<span class="star"> *</span></label><br>
                <input type="text" name="Ville" id="Ville" value="<?= $Ville ?>" class="form__input" required>

                <label for="Email" class="form__label">Adresse mail<span class="star"> *</span></label><br>
                <input type="email" name="Email" id="Email" value="<?= $Email ?>"class="form__input" required placeholder="mon@adresse.mail">

                <label for="Telephone" class="form__label">Téléphone<span class="star"> *</span></label><br>
                <input type="tel" name="Telephone" id="Telephone" value="<?= $Telephone ?>"class="form__input" required minlength="10" maxlength="10">

                <?php if($PatientDisponible) { ?>

                    <input type="submit" name="update" value="Modifier et Continuer" class="btn1">
                    <!--<input type="submit" name="delete" value="Supprimer" class="btn2">-->

                <?php } elseif($PatientPasDisponible) { ?>

                    <input type="submit" name="inscription" value="Ajouter" class="btn1">

                <?php } ?>
        </form>
    </div>
</body>
</html>