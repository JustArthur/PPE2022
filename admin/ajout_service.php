<?php
    include_once('../include.php');

?>

<html>
    <head>

    </head>
    <body>
        <form method="post">
            <label for="login">login</label>
            <input name="login" type="text" required>
            <br>
            <label for="password">Password</label>
            <input name="password" type="password" required>
            <br>
            <label for="nom">Nom</label>
            <input name="nom">
            <br>
            <label for="prenom">Prenom</label>
            <input name="prenom" type="text" required>
            <br>
            <label for="service">service</label>
            <input name="service" type="text" required>
            <br>
            <label for="role">role</label>
            <input name="role" type="number" required>
            <br>
            <button name="ajouter">Ajouter</button>
        </form>
        <button name="voir">Voir</button>
        <br><br>
    </body>
    <?php
        if (isset($_POST['ajouter'])) {
            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']);
            $nom = htmlspecialchars($_POST['nom']);
            $prenom  = htmlspecialchars($_POST['prenom']);
            $service = htmlspecialchars($_POST['service']);
            $role = htmlspecialchars($_POST['role']);
            $sql =("INSERT INTO personnel (login, password,nom,prenom,service,role) VALUE (?,?,?,?,?,?)");
            $reponse = $DB->prepare($sql);
            $reponse = $reponse->execute(array($login,$password,$nom, $prenom,$service,$role));
            
        }   
    ?> 
    <?php
        $reqpersonnels= $DB->prepare('SELECT nom,prenom,service,role FROM personnel');
        $reqpersonnels->execute();
        $personnels = $reqpersonnels->fetchall();
        foreach($personnels as $personnel){
            echo $personnel['nom'].'<span>  </span>',$personnel['prenom'].'</span>',$personnel['service'].'</span>',$personnel['role'].'<br>';
        }
    ?>
</html>