<?php
    class Delete {

        private $valid;

        private $erreur_del;
        
        public function deletePatient($NumSecu) {

            global $DB;

            //Variables déclarés
            $this->erreur_del = (String) '';
            $this->valid = (boolean) true;

            if($this->valid){

                $req = $DB->prepare("DELETE FROM patients WHERE Numsecu= ?;");
                $req->execute(array($NumSecu));

                header('Location: profil.php');
                exit();
            }

            return [$this->erreur_del];
        }
    }
?>