<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    session_start();
    include_once('include.php');
    $error = "";
    $valid = false;
    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['inscription'])) {

            if($_POST['Civ'] == 'none') {
                $valid = false;
            } elseif($_POST['Civ'] != 'none') {

                $numSecu = $_POST['NumSecu'];
                $fk_contact = 1;
                $fk_role = 0;
                $fk_documents = 1;
                $nomNaissance = $_POST['NomNaissance'];
                $nomEpouse = $_POST['NomEpouse'];
                $prenom = $_POST['Prenom'];
                $civilite = 1;
                $codePostal = $_POST['CodePostal'];
                $email = $_POST['AdresseMail'];
                $telephone = $_POST['Telephone'];
                $adresse = $_POST['Adresse'];
                $ville = $_POST['Ville'];
                $dateNaissance = $_POST['DateNaissance'];


                $req = $DB->prepare("INSERT INTO patients(Numsecu, fk_contact, fk_role, fk_documents, nom, nomEpouse, prenom, civilité, cp, email, tel, adresse, ville, dateNaissance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
                $req->execute(array($numSecu, $fk_contact, $fk_role, $fk_documents, $nomNaissance, $nomEpouse, $prenom, $civilite, $codePostal, $email, $telephone, $adresse, $ville, $dateNaissance));
                if($req){
                    echo"données inserer";
                    header('Location: ok.php');
                    exit();
                }else{
                    $error = "erreur";
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
    <link rel="stylesheet" href="_style/style.css">
    <title>S'inscrire - Hospital Saint Luc</title>
</head>
<body>
    <div class="left">
        <form id="form" name="form" method="post">
            <h2>Formulaire d'inscription<span class="dot">.</span></h2><br><br>
                <label for="NumSecu" class="form__label">Numéro de sécurité sociale<span class="star"> *</span></label><br>
                <input type="text" name="NumSecu" id="NumSecu" class="form__input" required maxlength="21" minlength="15" placeholder="101010111111111 ou 1 01 01 01 111 111 11">

                <?php if(isset($erreur_civ)){ echo '<label class="error">'.$erreur_civ.'</label>';}?>
                <label for="Civ" class="form__label">Civ<span class="star"> *</span></label>
                <select name="Civ" id="Civ" class="form__input_choice" required>
                    <option value="none">Choisi votre civilité</option>
                    <option value="Celibataire">Célibataire</option>
                    <option value="Marie"">Marié</option>
                </select>

                <label for="NomNaissance" class="form__label">Nom de naissance<span class="star"> *</span></label><br>
                <input type="text" name="NomNaissance" id="NomNaissance" class="form__input" required>

                <label for="NomEpouse" class="form__label">Nom d'épouse</label><br>
                <input type="text" name="NomEpouse" id="NomEpouse" class="form__input">      

                <label for="Prenom" class="form__label">Prénom<span class="star"> *</span></label><br>
                <input type="text" name="Prenom" id="Prenom" class="form__input" required>


                <label for="DateNaissance" class="form__label">Date de naissance<span class="star"> *</span></label><br>
                <input type="date" name="DateNaissance" id="DateNaissance" class="form__input" required>

                <label for="Adresse" class="form__label">Adresse<span class="star"> *</span></label><br>
                <input type="text" name="Adresse" id="Adresse" class="form__input" required">

                <label for="CodePostal" class="form__label">Code postale<span class="star"> *</span></label><br>
                <input type="text" name="CodePostal" id="CodePostal" class="form__input" required maxlength="5">

                <label for="Ville" class="form__label">Ville<span class="star"> *</span></label><br>
                <input type="text" name="Ville" id="Ville" class="form__input" required>

                <label for="AdresseMail" class="form__label">Adresse mail<span class="star"> *</span></label><br>
                <input type="email" name="AdresseMail" id="AdresseMail" class="form__input" required placeholder="mon@adresse.mail">

                <label for="Telephone" class="form__label">Téléphone<span class="star"> *</span></label><br>
                <input type="tel" name="Telephone" id="Telephone" class="form__input" required minlength="10" maxlength="10">

                <input type="submit" name="inscription" value="Suivant" class="btn1">
        </form>
</div>
<div class="cercle"></div>
<img src="_img/img.png">

</body>
</html>