<?php
session_start();
include('./funtion bdd.php');
$conn = getBdd('localhost', 'root', '');
       $Numsecur = $_POST['Numsecur'];
       $nom = $_POST['nom'];
       $prenom =$_POST['prenom'];
       $dateNaissance= $_POST['dateNaissance'];
       $adresse = $_POST['adresse'];
       $ville =$_POST['ville'];
       $email =$_POST['email'];
       $tel = $_POST['tel'];
       $cp = $_POST['cp'];
       $sql ="INSERT INTO patients( nom, prenom,dateNaissance,adresse,Numsecur,ville,email,tel,cp) VALUES ( :nom,:prenom,:dateNaissance,:adresse,:Numsecur,:ville,:email,:tel,:cp)";
       $res = $conn->prepare($sql);
       $exec = $res->execute(array(":nom"=>$nom,":prenom"=>$prenom,":dateNaissance"=>$dateNaissance ,":adresse"=>$adresse , ":Numsecur"=>$Numsecur,":ville"=>$ville, ":email"=>$email,":tel"=>$tel, ":cp"=>$cp));
       if($exec){
           echo"donnees inserees";
       }else{
           echo"echec de l'operation d insertion";
       }


?>