<?php
    class Inscription {

        private $valid;

        private $erreur_insc;
        
        public function verification_inscription($NumSecu, $NomNaissance, $NomEpouse, $Prenom, $Civilite, $CodePostal, $Email, $Telephone, $Adresse, $Ville, $DateNaissance) {

            global $DB;

            //Variables d'entrées
            $NumSecu = (int) trim($NumSecu);
            $NomNaissance = (String) trim($NomNaissance);
            $NomEpouse = (String) trim($NomEpouse);
            $Prenom = (String) trim($Prenom);
            $Civilite = (String) trim($Civilite);
            $CodePostal = (int) trim($CodePostal);
            $Email = (String) trim($Email);
            $Telephone = (int) trim($Telephone);
            $Adresse = (String) trim($Adresse);
            $Ville = (String) trim($Ville);
            $DateNaissance = (String) trim($DateNaissance);


            //Variables déclarés
            $this->erreur = (String) '';
            $this->valid = (boolean) true;

            switch ($Civilite) {
                case 'None':
                    $Civilite = "Autre";
                    $this->valid = true;
                break;

                case 'Il':
                    $Civilite = 'Il';
                    $this->valid = true;
                break;

                case 'Elle':
                    $Civilite = 'Elle';
                    $this->valid = true;
                break;

                case 'Iel':
                    $Civilite = 'Iel';
                    $this->valid = true;
                break;
            }


            if($this->valid){

                $req = $DB->prepare("INSERT INTO patient (numSecu, civilite, nomNaissance, nomEpouse, prenom, dateNaissance, adresse, codePostal, ville, email, telephone) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
                $req->execute(array($NumSecu, $Civilite, $NomNaissance, $NomEpouse, $Prenom, $DateNaissance, $Adresse, $CodePostal, $Ville, $Email, $Telephone));
                
                header('Location: ../profil.php');
                exit();
            }

            return [$this->erreur];
        }
    }
?>