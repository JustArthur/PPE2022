<?php
session_start();
include('funtion bdd.php');
?>
<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Ma page de test</title>
</head>
<body>
    <h1>Formulaire d'inscription </h1>
    <form method="post" action="funtion%20formulaire.php">
            <label for="Numsecur">entrez votre numero de securite social </label>
            <input type="text" name="Numsecur" maxlength="15"><br><br>
            <label for="nom"> entrez votre nom</label>
            <input type="text" name="nom"  />
            <label for="prenom"> entrez votre prenom </label>
            <input type="text" name="prenom"  /><br><br>
            <label for="dateNaissance"> entrez votre date de naissance </label>
            <input type="date" name="dateNaissance">
            <br><br>
            <label for="adresse">entrez votre adresse</label>
            <input type="text" name="adresse">
            <label for="ville">entrez votre ville</label>
            <input type="text" name="ville">
            <br><br>
            <label form="email">entrez votre email</label>
            <input type="text" name="email">
            <label form="tel">entrez votre numero de telephone </label>
            <input type="tel" name="tel">
            <br><br>
            <input type="submit" >
    </form>
</body>
</html>
