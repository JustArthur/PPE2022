<?php
session_start();
include('./funtion bdd.php');
$conn = getBdd('localhost', 'root', '');
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
    <label for="email"> Entrez votre identifiant ></label>
    <input type="text"  name="email">
<br>
    <label for="Numsecur"> Entrez votre mot de passe </label>
    <input type="password" name="Numsecur">
    <br>
<input type="submit" name="connexion" >
    </form>
</body>
</html>
