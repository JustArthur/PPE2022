<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include_once('include.php');

    $code = random_int(1000, 9999); 

    if(isset($_POST)) {
        extract($_POST);

        if(isset($_POST['connexion'])) {

            $identifiant = htmlspecialchars(trim($identifiant));
            $password = htmlspecialchars(trim($password));
    
    
            if(isset($_SESSION['captcha']) && !empty($_POST['reponse'])) {
                if($_SESSION['captcha'] == $reponse) {
                    if(!empty($identifiant) && !empty($password)) {
                    
                        $requser = $DB->prepare('SELECT * FROM personnel WHERE login = ? AND password = ?');
                        $requser->execute(array($identifiant, $password));
                        $userexist = $requser->rowCount();
            
                        if ($userexist == 1 ) {
                        
                            $userinfo = $requser->fetch();
                            $_SESSION['utilisateur'] = array(
                                $userinfo['nom'], //0
                                $userinfo['prenom'], //1
                                $userinfo['service'], //2
                                $userinfo['role'] //3
                            );
            
                            header("Location: admin/panel");
                            exit();
            
                        } else {
                            $erreur = "Mauvais identifiant ou mot de passe.";
                        }
                    } else {
                        $erreur = "Les champs identifiant et mot de passe sont vides.";
                    }
                } else {
                    $erreur = 'La réponse au captcha incorrect.';
                }
            } else {
                $erreur = "Certains champs sont vides.";
            }
        }
    }

    $_SESSION['captcha'] = $code; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style/style.css">

    <title>Connexion</title>
</head>
<body>
    <main>
        <div class="gauche">
            <h1>Bon retour parmi nous <span>!</span></h1>

            <div class="formulaire">
                <h3>Connexion à votre compte</h3>

                <?php if(isset($erreur)) { ?><div class="erreur"><?= $erreur ?></div><?php } ?>

                <form method="POST">
                    <input type="text" name="identifiant" id="" placeholder="Votre identifiant">
                    <input type="password" name="password" id="" placeholder="Votre mot de passe">

                    <div class="div_captcha">
                        <input type="text" maxlength="4" minlength="1" name="reponse" id="" placeholder="Réponse au captcha">
                        <div class="chiffre">
                            <?= $_SESSION['captcha'] ?>
                        </div>
                    </div>

                    <input type="submit" name="connexion" value="Se connecter">
                </form>
            </div>
        </div>

        <div class="droite"></div>
    </main>
</body>
</html>