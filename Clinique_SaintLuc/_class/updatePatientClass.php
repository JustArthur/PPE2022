<?php
    class Update {

        private $valid;

        private $erreur_updt;
        
        public function updatePatient($NumSecu, $NomNaissance, $NomEpouse, $Prenom, $Civilite, $CodePostal, $Email, $Telephone, $Adresse, $Ville, $DateNaissance) {

            global $DB;

            //Variables d'entrées
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

                $req = $DB->prepare("UPDATE patients SET nom=?, nomEpouse=?, prenom=?, cp=?, email=?, tel=?, adresse=?, ville=?, dateNaissance=?, Civilite=? WHERE Numsecu=?");
                $req->execute(array($NomNaissance, $NomEpouse, $Prenom, $CodePostal, $Email, $Telephone, $Adresse, $Ville, $DateNaissance, $Civilite, $NumSecu));

                header('Location: ../profil.php');
                exit();
            }

            return [$this->erreur];
        }
    }
?>