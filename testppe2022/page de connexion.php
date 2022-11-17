<?php
session_start();
include('./funtion bdd.php');
$conn = getBdd('localhost', 'root', 'root');
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
    <label for="email"> Entrez votre email ></label>
    <input type="text"  name="email">
<br>
    <label for="Numsecu"> Entrez votre Numsecur </label>
    <input type="password" name="Numsecu">
    <br>
<input type="submit" name="connexion" >
    </form>
</body>
</html>
