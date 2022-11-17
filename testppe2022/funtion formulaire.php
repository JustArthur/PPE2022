<?php
session_start();
include('./funtion bdd.php');
$conn = getBdd('localhost', 'root', 'root');
       $Numsecu = $_POST['Numsecu'];
       $nom = $_POST['nom'];
       $prenom =$_POST['prenom'];
       $dateNaissance= $_POST['dateNaissance'];
       $adresse = $_POST['adresse'];
       $ville =$_POST['ville'];
       $email =$_POST['email'];
       $tel = $_POST['tel'];
       $cp = $_POST['cp'];
       $sql ="INSERT INTO patients( nom, prenom,dateNaissance,adresse,Numsecu,ville,email,tel,cp) VALUES ( :nom,:prenom,:dateNaissance,:adresse,:Numsecu,:ville,:email,:tel,:cp)";
       $res = $conn->prepare($sql);
       $exec = $res->execute(array(":nom"=>$nom,":prenom"=>$prenom,":dateNaissance"=>$dateNaissance ,":adresse"=>$adresse , ":Numsecu"=>$Numsecu,":ville"=>$ville, ":email"=>$email,":tel"=>$tel, ":cp"=>$cp));
       if($exec){
           echo"donnees inserees";
       }else{
           echo"echec de l'operation d insertion";
       }


?>