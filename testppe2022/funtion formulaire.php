<?php
       session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
try {
    $conn = new PDO("mysql:host=$servername;dbname=testppe2022", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connexion réussie <br>';
}
catch(PDOException $e)
{
    echo "Erreur : " . $e->getMessage();
}
       $Numsecur = $_POST['Numsecur'];
       $nom = $_POST['nom'];
       $prenom =$_POST['prenom'];
       $dateNaissance= $_POST['dateNaissance'];
       $adresse = $_POST['adresse'];
       $ville =$_POST['ville'];
       $email =$_POST['email'];
       $tel = $_POST['tel'];
       $sql ="INSERT INTO patients( nom, prenom,dateNaissance,adresse,Numsecur,ville,email,tel) VALUES ( :nom,:prenom,:dateNaissance,:adresse,:Numsecur,:ville,:email,:tel)";
       $res = $conn->prepare($sql);
       $exec = $res->execute(array(":nom"=>$nom,":prenom"=>$prenom,":dateNaissance"=>$dateNaissance ,":adresse"=>$adresse , ":Numsecur"=>$Numsecur,":ville"=>$ville, ":email"=>$email,":tel"=>$tel));
       if($exec){
           echo"donnees inserees";
       }else{
           echo"echec de l'operation d insertion";
       }


?>