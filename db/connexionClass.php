<?php
    class Connexion {

        private $valid;

        private $err_pseudo;
        private $err_pass;

        public function verification_connexion($pseudo, $password) {

            global $DB;

            $pseudo = trim($pseudo);
            $password = trim($password);

            $this->valid = (boolean) true;

            if(empty($pseudo)) {
                $this->valid = false;
                $this->err_pseudo = "Ce champ ne peut pas être vide.";
            }
            
            if(empty($password)) {
                $this->valid = false;
                $this->err_pass = "Ce champ ne peut pas être vide.";
            }

            if($this->valid) {
                $req = $DB->prepare("SELECT mdp FROM Utilisateur WHERE pseudo = ?");

                $req->execute(array($pseudo));

                $req = $req->fetch();

                if(isset($req['mdp'])) {
                    if(!password_verify($password, $req['mdp'])) {
                        $this->valid = false;
                        $this->err_pseudo = "Le mot de passe ou le pseudo est incorrect";
                    }

                } else {
                    $this->valid = false;
                    $this->err_pseudo = "Le mot de passe ou le pseudo est incorrect";
                }
            }


            if($this->valid){
                $req = $DB->prepare("SELECT * FROM Utilisateur WHERE pseudo = ?");

                $req->execute(array($pseudo));

                $req_user = $req->fetch();

                if(isset($req_user['id'])) {
                    $date_connexion = date('Y-m-d H:i:s');

                    $req = $DB->prepare("UPDATE Utilisateur SET date_connexion = ? WHERE id = ?");
                    $req->execute(array($date_connexion, $req_user['id']));
                    
                    $_SESSION['id'] = $req_user['id'];
                    $_SESSION['pseudo'] = $req_user['pseudo'];
                    $_SESSION['Nom'] = $req_user['Nom'];
                    $_SESSION['Prenom'] = $req_user['Prenom'];
                    $_SESSION['mail'] = $req_user['mail'];
                    $_SESSION['role'] = $req_user['role'];
                    $_SESSION['avatar'] = $req_user['avatar'];

                    header('Location: index.php');
                    exit;
            
                } else {
                    $this->valid = false;
                    $this->err_pseudo = "Le mot de passe ou le pseudo est incorrect";
                }
            }

            return [$this->err_pseudo, $this->err_pass];

        }
    }
?>