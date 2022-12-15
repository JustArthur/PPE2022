<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include_once('include.php');
 ?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="_style/style.css">
    <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
    <title>Se connecter - Hospital Saint Luc</title>
</head>
<body>
    <div class="left">
            <form class="box connexionBox" method="post">
                <h2>Connexion à votre compte<span class="dot">.</span></h2><br><br>

                    <label for="login" class="form__label">Identifiant</label><br>
                    <?php if(isset($erreur)) { echo $erreur;} ?>
                    <input  name="login" id="mail" class="form__input" placeholder="Identifiant">

                    <br><br>
                    <label for="password" class="form__label2">Mot de passe</label><br>
                    <?php if(isset($erreur)) { echo '<div class="error">'.$erreur.'</div>';} ?>
                    <input type="password" name="password" id="password" class="form__input">

                    <br><br>
        
                <label for="captcha" class="form__label3">Vérification au captcha</label>
                <div class="field">
                    <img src="captcha.php" class="imgCaptcha"/>
                    <input class="form__input" name="captcha" type="text" placeholder="Saisissez le numéro affiché">
                </div>
            
                <button class="btn1" name="connexion">Me connecter</button>
        </form>
    </div>
    <div class="cercle"></div>
    <img src="/img/img.png" alt="">
    
</body>
</html>
<?php
if(isset($_POST['connexion'])) {

    $login = htmlspecialchars($_POST['login']);
    $password = $_POST['password'];


    if(!empty($login) AND !empty($password) AND isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"]) {
        
        $requser = $DB->prepare('select * from personnel where login = ? and password = ?');
        $requser->execute(array($login, $password));
        $userexist = $requser->rowCount();

        if ($userexist == 1 ) {
           
            $userinfo = $requser->fetch();
            
            $_SESSION['nom'] = $userinfo['nom'];
            $_SESSION['prenom'] = $userinfo['prenom'];
            $_SESSION['service'] = $userinfo['service'];
            $_SESSION['role'] = $userinfo['role'];

            header("Location: profil.php");
            exit();

        } else {
            $erreur = "Mauvais nom d'utilisateur ou mot de passe !";
        }
    }
}
?>