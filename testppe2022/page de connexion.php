<?php
session_start();
include('./funtion bdd.php');
$conn = getBdd('localhost', 'root', 'root');
$erreur = "";
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Ma page de test</title>
</head>
<body>
<h1>Page de connexion  </h1>
<br>
    <form method="post" action="formulaireconnexion.php">
    <label for="login"> Entrez votre login ></label>
    <input type="text"  name="login">
<br>
    <label for="password"> Entrez votre Numsecur </label>
    <input type="password" name="password">
    <br>
    <div class="field">
        <img src="captcha.php" class="imgCaptcha"/>
        <input class="input" name="captcha" type="text" placeholder="Réponse au captcha">
        </div>
            <button class="button is-primary buttonConnexion" name="formconnexion">Me connecter</button>
        <?php
             echo $erreur;
        ?>
    </div>
     </form>
</body>
</html>
<?php
if(isset($_POST['formconnexion'])) {
    $login= htmlspecialchars($_POST['login']);
    $password = $_POST['password'];

    if(!empty($login) AND !empty($password) AND isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"]) {
        $requser = $conn->prepare("select * from ap2022.information where login = ? and password = ?");
        $requser->execute(array($login, $password));
        $userexist = $requser->rowCount();
        if($userexist == 1) {
            $userinfo = $requser->fetch();
            header("Location: bdd.php");
        } else {
            $erreur = "<br /><br /> <div class='notification is-danger'>Mauvais nom d'utilisateur ou mot de passe ! </div>";
        }
    } else {
        $erreur = "<br /><br /> <div class='notification is-danger'>Tous les champs doivent être complétés ! </div>";
    }
}
?>