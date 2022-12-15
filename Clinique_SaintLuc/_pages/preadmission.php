<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
    include_once('../include.php');
    
    $valid = false;

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['verification'])) {
            $req = $DB->prepare("SELECT numSecu FROM patients WHERE numSecu = ?");
            $req->execute(array($NumSecu));
            $req = $req->fetch();

            if($req['numSecu']) {
                $idNumSecu = $req['numSecu'];
                $valid = true;
            } else {
                $idNumSecu = $_POST['numSecu'];
                $valid = true;
            }

            if($valid) {
                header('Location: inscription.php?numSecu='.$idNumSecu);
                exit;
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
            <h2>Ajouter ou rechercher un patients<span class="dot">.</span></h2><br><br>
                <label for="numSecu" class="form__label">Numéro de sécurité sociale<span class="star"> *</span></label><br>
                <input type="text" name="numSecu" id="numSecu" class="form__input" required placeholder="101010111111111">

                <input type="submit" name="verification" value="Suivant" class="btn1">
        </form>
</div>

</body>
</html>