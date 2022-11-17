<?php
    session_start();
    include('./funtion bdd.php');
    $conn = getBdd('localhost', 'root', 'root');
?>
<html>
<head>
</head>
<body>

</body>
 <h3> Personne a prevenir </h3>
    <form method="post" action="funtion%20formulaire.php">
            <label for="nomPp">entrez le nom  </label>
            <input type="text" name="nomPp"><br><br>
            <label for="prenomPp"> entrez le prenom</label>
            <input type="text" name="prenomPp"><br><br>
            <label for="adressePp"> entrez l'adresse </label>
            <input type="text" name="adressePp"><br><br>
            <label for=telPp>entrez le telophone</label>
            <input type="number" name="telPp">
    </form>
<h3>Personne de confiance</h3>
      <form method="post" action="funtion%20formulaire.php">
                <label for="nomPc">entrez le nom  </label>
                <input type="text" name="nomPc"><br><br>
                <label for="prenomPc"> entrez le prenom</label>
                <input type="text" name="prenomPc"><br><br>
                <label for="adressePc"> entrez l'adresse </label>
                <input type="text" name="adressePc"><br><br>
                <label for="telPc">entrez le telophone</label>
                <input type="number" name="telPc"><br><br>
      </form>
      <input type="submit" name="confirmation" >
</html>