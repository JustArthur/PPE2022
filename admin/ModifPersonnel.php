<?php
    include_once('../include.php');
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    if(isset($_GET["id"])AND is_numeric($_GET["id"]))
    {
        $id = htmlentities($_GET["id"]);
        $sql ="SELECT id,nom,prenom,service,role FROM personnel where id =".$id."";
        $sql = $DB->query($sql);
        $personnel = $sql->fetch();
    }
    if(isset($_POST['Modifpersonelle'])) {
        if(isset($_POST["nom"])and isset($_POST["prenom"])and isset($_POST["service"]) and isset($_POST["role"]))
        {
            $id = htmlentities($_GET["id"]);
            $personnel['nom'] = $_POST['nom'];
            $personnel['prenom']= $_POST['prenom'];
            $personnel['service'] = $_POST['service'];
            $personnel['role'] = $_POST['role'];
            
            $sql = $DB->prepare("UPDATE personnel SET nom = ? , prenom = ? , service = ?, role= ? where id = " . $id . ";");
            $sql->execute(array( $personnel['nom'],$personnel['prenom'],$personnel['service'],$personnel['role']));
        }
    }

?>
<html>
    <head>

    </head>
    <body>
        <form method="post">
            <fieldset>
                <legend>Modification personelle</legend>
                <center><input name="id" type="hidden" value="<?php if(isset($personnel["id"])) echo $personnel["id"];?>"/>
                <label>Nom</label>
                <input name="nom" type="text" value="<?php if(isset($personnel["nom"])) echo $personnel["nom"];?>"/>
                <label>prenom</label>
                <input name="prenom" type="text" value="<?php if(isset($personnel["prenom"])) echo $personnel["prenom"];?>"/>
                <label>service</label>
                <input name="service" type="text" value="<?php if(isset($personnel["service"])) echo $personnel["service"];?>"/>
                <label>role</label>
                <input name="role" type="number" value="<?php if(isset($personnel["role"])) echo $personnel["role"];?>"/>
                </center>
                <br><br>
                <center><input type="submit" name="Modifpersonelle" value ="modifier"/></center>
            </fieldset>
        </form>
    </body>
</html>
