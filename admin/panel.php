<?php
    include_once('../include.php');

    //-- Empêche la connexion si un utilisateur n'est pas connecté ----------------
    if(empty($_SESSION['utilisateur'][5])) {

        $textLog = "Tentative de connexion forcé par le lien URL";
        $dateLog = date('Y-m-d H:i');
                            
        $log = $DB->prepare("INSERT INTO log (idUser, nomLog, dateTimeLog) VALUES(?, ?, ?);");
        $log->execute([$_SESSION['utilisateur'][5], $textLog, $dateLog]);
                                
        header('Location: src/deconnexion.php');
        exit;
    }

    $dateAujourdhui = date('Y-m-d');

    //-- Vide les SESSIONS pour une pré-admission ----------------
    $_SESSION['patient'] = array();
    $_SESSION['personneConfiance'] = array();
    $_SESSION['personnePrevenir'] = array();
    $_SESSION['hospitalisation'] = array();
    $_SESSION['couvertureSociale'] = array();

    //-- Pour empêcher l'ouverture des pages suivantes sans passer par les requises ----------------
    $_SESSION['creer_admission'] = array(
        false, //0
        false, //1
        false, //2
        false, //3
        false //4
    );

    // -- Ajoute 5 semaines à la date d'aujourd'hui ----------------
    $date5sem = new DateTime(); 
    $date5sem->modify('+5 weeks');
    $date5sem = $date5sem->format('Y-m-d');


    // -- Défini l'anné et le numéro de la semaine pour calculer les informations de la semaines ----------------
    $anneeChoix = date('Y');
    $semChoix = date('W');

    $timeStampPremierJanvier = strtotime($anneeChoix . '-01-01');
    $jourPremierJanvier = date('w', $timeStampPremierJanvier);
    
    //-- Recherche du N° de semaine du 1er janvier -------------------
    $numSemainePremierJanvier = date('W', $timeStampPremierJanvier);
    
    //-- Nombre à ajouter en fonction du numéro précédent ------------
    $decallage = ($numSemainePremierJanvier == 1) ? $semChoix - 1 : $semChoix;

    //-- Timestamp du jour dans la semaine recherchée ----------------
    $timeStampDate = strtotime('+' . $decallage . 'weeks', $timeStampPremierJanvier);
    
    //-- Recherche du lundi de la semaine en fonction de la ligne précédente ---------
    $jourDebutSemaine = ($jourPremierJanvier == 1) ? date('Y-m-d', $timeStampDate) : date('Y-m-d', strtotime('last monday', $timeStampDate));
    $jourFinSemaine = ($jourPremierJanvier == 1) ? date('Y-m-d', $timeStampDate) : date('Y-m-d',strtotime(' sunday', $timeStampDate));

    //-- Récupères les pré-admissions prévu pour les 5 semaines à venir ----------------
    $dernierePrea = $DB->prepare("SELECT * FROM preadmission p INNER JOIN operations o ON p.idOperation  = o.id WHERE o.dateOperation >= ? AND o.dateOperation <= ? AND p.status != 'Annulé' AND p.status != 'Terminé' AND p.idMedecin = ?");
    $dernierePrea->execute([$jourDebutSemaine, $date5sem, $_SESSION['utilisateur'][5]]);
    $dernierePreaFetch = $dernierePrea->fetchAll();
    $dernierePreaCount = $dernierePrea->rowcount();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style/panel.css">
    <link rel="stylesheet" href="../style/navBar.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Bienvenue, <?= $_SESSION['utilisateur'][0] . ' ' . $_SESSION['utilisateur'][1] ?></title>

    <link rel="icon" href="../img/logo.png" type="image/icon type">
</head>
<body>
    <script>
        localStorage.removeItem('errorSession');
    </script>

    <?php 
        //-- Appel le fichier navbar ----------------
        require_once('src/navbar.php');
    ?>
    
    <main>
        <?php if($_SESSION['utilisateur'][3] == 1) {
            //-- Appel le fichier information ----------------
            require_once('src/information.php');
        } ?>

        <?php if($_SESSION['utilisateur'][3] == 3) {?>
        <div class="profil">
            <div class="infos">
                <div class="nom"><?= $_SESSION['utilisateur'][1] ?> <span class="color"><?= $_SESSION['utilisateur'][0] ?></span></div>
                <div class="role"><?= $_SESSION['utilisateur'][4] ?></div>
            </div>

            <div class="last-prea">
                <h3>Vos pré-admissions des 5 prochaines semaines (de la plus récente à la plus vieille) </h3>

                <ul class="list-prea-last">
                    <?php 

                        if($dernierePreaCount == 0) { ?>
                            <li class="list-item">
                                <p>Aucune pré-admission prévu dans les 5 semaines</p>
                            </li>
                        <?php } else {
                            foreach($dernierePreaFetch as $preadmission) {
                                $chercheMedecin = $DB->prepare("SELECT * FROM personnel WHERE id = ?");
                                $chercheMedecin->execute([$preadmission['idMedecin']]);
                                $chercheMedecin = $chercheMedecin->fetch();

                                $select_prea = $DB->prepare('SELECT * from preadmission INNER JOIN operations on preadmission.idOperation = operations.id INNER JOIN patient on preadmission.idPatient = patient.numSecu where preadmission.id = ? order by operations.dateOperation and preadmission.status = "En cours";');
                                $select_prea->execute([$preadmission['id']]);
                                $select_prea = $select_prea->fetch();
                            
                            ?>
                                <li class="list-item">
                                    <div>
                                        <label>Nom et prénom du patient : </label>
                                        <?= $select_prea['nomNaissance'] . ' ' . $select_prea['prenom'] ?>
                                    </div>

                                    <div>
                                        <label>Date d'anniversaire : </label>
                                        <?= $select_prea['dateNaissance'] ?>
                                    </div>

                                    <div>
                                        <label>Date de l'opération : </label>
                                        <?= $preadmission['dateOperation'] ?>
                                    </div>

                                    <div>
                                        <label>Heure de l'opération : </label>
                                        <?= $preadmission['heureOperation'] ?>
                                    </div>

                                    <div>
                                        <label>Chambre : </label>
                                        N°<?= $preadmission['idChambre'] ?>
                                    </div>

                                    <?php if($preadmission['status'] == 'En cours') {?>
                                    <div class="btns">
                                        <a style="background: red;" href="changeStatut?id=<?= $preadmission['id']?>">Clôturer la pré-admission</a>
                                    </div>

                                    <?php } else if($preadmission['dateOperation'] == $dateAujourdhui) { ?>
                                    <div class="btns">
                                        <a style="background: #00A3FE;" href="changeStatut?id=<?= $preadmission['id']?>">Prendre en charge</a>
                                    </div>

                                    <?php } else { ?>
                                    <div class="btns">
                                        <a style="background: black; cursor: not-allowed;" href="">Pas encore disponible</a>
                                    </div>
                                    <?php } ?>
                                </li>
                    <?php } } ?>
                </ul>
            </div>
        </div>
        <?php } ?>
    </main>

    <script src="js/expireConnexion.js"></script>
</body>
</html>