<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include_once('include.php');

    $random_int = random_int(0, 9999);
    $_SESSION['code'] = $random_int;

    if(isset($_POST)) {
        extract($_POST);

        if(isset($_POST['connexion'])) {

            $identifiant = htmlspecialchars(trim($identifiant));
            $password = htmlspecialchars(trim($password));
            $captcha = htmlspecialchars(trim($captcha));

            $captcha = (int) $captcha;
            
            if(isset($captcha) && $captcha != "" && $_SESSION["code"]==$captcha) {
                if(!empty($identifiant) && !empty($password)) {

                    $requser = $DB->prepare('SELECT * FROM personnel WHERE login = ? AND password = ?');
                    $requser->execute(array($identifiant, $password));
                    $userexist = $requser->rowCount();
        
                    if ($userexist == 1 ) {
                        $userinfo = $requser->fetch();
    
                        $_SESSION['utilisateur'] = array(
                            $userinfo['nom'],
                            $userinfo['prenom'],
                            $userinfo['service'],
                            $userinfo['role']
                        );
        
                        header("Location: admin/panel");
                        exit();
        
                    } else {
                        $erreur = "Mauvais nom d'utilisateur ou mot de passe !";
                    }
                } else {
                    $erreur = "Champs non-renseigné.";
                }
            } else {
                $erreur = "Le captcha est incorect";
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

    <link rel="stylesheet" href="style/style.css">

    <title>Document</title>
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
                        <input type="text" maxlength="4" minlength="1" name="captcha" id="" placeholder="Réponse au captcha">
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