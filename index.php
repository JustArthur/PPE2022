<?php
    include_once('include.php');

    if(isset($_SESSION['utilisateur'][5])) {
        header('Location: admin/panel.php');
        exit;
    }

    $code = random_int(1000, 9999); 

    if(isset($_POST)) {
        extract($_POST);

        if(isset($_POST['connexion'])) {

            $identifiant = htmlspecialchars(trim($identifiant));
            $password = htmlspecialchars(trim($password));
    
    
            //-- Si le captcha et la réponse du user ne sont pas vide ----------------
            if(isset($_SESSION['captcha']) && !empty($_POST['reponse'])) {

                //-- Si les deux sont égaux ----------------
                if($_SESSION['captcha'] == $reponse) {

                    //-- Si le user et le password est rempli ----------------
                    if(!empty($identifiant) && !empty($password)) {
                    
                        $selectPassword = $DB->prepare('SELECT password FROM personnel WHERE login = ?');
                        $selectPassword->execute(array($identifiant));
                        $selectPassword = $selectPassword->fetch();
            
                        if(isset($selectPassword['password'])) {
                            
                            //-- Si le password est mauvais ----------------
                            if(!password_verify($password, $selectPassword['password'])) {
                                $erreur = 'Mauvais mot de passe.';

                            } else {
                                $userinfo = $DB->prepare('SELECT * from personnel where login = ?');
                                $userinfo->execute([$identifiant]);
                                $userinfo = $userinfo->fetch();

                                switch($userinfo['role']) {
                                    case 1:
                                        $role = 'Secretaire';
                                        break;
    
                                    case 2:
                                        $role = 'Administrateur';
                                        break;
    
                                    case 3:
                                        $role = 'Medecin';
                                        break;
                                }
                                
                                $_SESSION['utilisateur'] = array(
                                    $userinfo['nom'], //0
                                    $userinfo['prenom'], //1
                                    $userinfo['service'], //2
                                    $userinfo['role'], //3
                                    $role, //4
                                    $userinfo['id'] //5
                                );
    
                                $textLog = "Connexion d'un utilisateur";
                                $dateLog = date('Y-m-d H:i');
                            
                                $log = $DB->prepare("INSERT INTO log (idUser, nomLog, dateTimeLog) VALUES(?, ?, ?);");
                                $log->execute([$_SESSION['utilisateur'][5], $textLog, $dateLog]);
                
                                header("Location: admin/panel.php");
                                exit();
                            }
            
                        } else {
                            $erreur = "Aucun utilisateur avec cet identifiant.";
                        }
                    } else {
                        $erreur = "Les champs identifiant et mot de passe sont vides.";
                    }
                } else {
                    $erreur = 'La réponse au captcha est incorrect.';
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

    <title>Connexion | Clinique LPF</title>

    <link rel="icon" href="img/logo.png" type="image/icon type">

</head>
<body>
    <main>
        <div class="gauche">
            <h1>Bon retour parmi nous <span>!</span></h1>

            <div class="formulaire">
                <h3>Connexion à votre compte</h3>

                    <script>
                        if(localStorage.getItem('errorSession') === '' || localStorage.getItem('errorSession') === null) {
                            
                        } else {
                            document.write(`<div class="erreur">`, localStorage.getItem('errorSession'), `</div>`);
                        }
                    </script>
                <?php if(isset($_POST['localStorageData'])) { ?><div class="erreur"><?= $_POST['localStorageData']; ?></div><?php }?>
                <?php if(isset($erreur)) { ?><div class="erreur active"><?= $erreur ?></div><?php } ?>

                <form method="POST">
                    <input type="text" name="identifiant" placeholder="Votre identifiant">
                    <input type="password" name="password" placeholder="Votre mot de passe">

                    <div class="div_captcha">
                        <input type="text" maxlength="4" minlength="1" name="reponse" pattern="[0-9]*" placeholder="Réponse au captcha">
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