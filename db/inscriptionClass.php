<?php
    class Inscription {

        private $valid;

        private $err_pass;
        private $err_pseudo;
        
        public function verification_inscription($pseudo, $password, $confPassword) {

            global $DB;

            //Variables d'entrées
            $pseudo = (String) trim($pseudo);
            $password = (String) trim($password);
            $confPassword = (String) trim($confPassword);


            //Variables déclarés
            $this->err_pseudo = (String) '';
            $this->err_pass = (String) '';
            $this->valid = (boolean) true;

            if(empty($pseudo)) {
                $this->valid = false;
                $this->err_pseudo = "Ce champ ne peut pas être vide.";

            } else { //Cherche dans la BDD si le user exsiste
                $req = $DB->prepare("SELECT id FROM Utilisateur WHERE pseudo = ?");

                $req->execute(array($pseudo));

                $req = $req->fetch();

                if(isset($req['id'])) {
                    $this->valid = false;
                    $this->err_pseudo = "Ce pseudo est déjà pris.";
                }
            }

            if(empty($password)) {
                $this->valid = false;
                $this->err_pass = "Ce champ ne peut pas être vide.";

            } elseif($password <> $confPassword) {
                $this->valid = false;
                $this->err_pass = "Mot de passe non identitique.";
            }


            if($this->valid){
                $crypt_password = password_hash($password, PASSWORD_ARGON2ID);

                if(password_verify($password, $crypt_password)) {
                    echo 'Le mot de passe est valide.';
                } else {
                    echo 'Le mot de passe est invalide.';
                }


                $date_creation = date('Y-m-d H:i:s');

                $req = $DB->prepare("INSERT INTO Utilisateur (pseudo, mdp, date_creation, date_connexion) VALUES(?, ?, ?, ?)");
                $req->execute(array($pseudo, $crypt_password, $date_creation, $date_creation));
                
                header('Location: index.php');
                exit;
            }

            return [$this->err_pseudo, $this->err_pass];
        }
    }
?>