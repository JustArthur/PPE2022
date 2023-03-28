<?php
    //-- Recherche de la date du jour ----------------
    $dateAujourdhui = date('Y-m-d');

    //-- Requête pour les admission ou autres ----------------
    $nbr_admission_week = $DB->prepare("SELECT * FROM operations WHERE dateOperation >= ? AND dateOperation <= ?");
    $nbr_admission_week->execute([$jourDebutSemaine, $jourFinSemaine]);
    $nbr_admission_week = $nbr_admission_week->rowcount();

    $nbr_patient_week = $DB->prepare("SELECT * FROM preadmission WHERE dateAdmission = ?");
    $nbr_patient_week->execute([$dateAujourdhui]);
    $nbr_patient_week = $nbr_patient_week->rowcount();

    $nbr_annule_week = $DB->prepare("SELECT p.idOperation, p.status, o.dateOperation FROM preadmission p INNER JOIN operations o ON p.idOperation = o.id WHERE p.status = 'Annulé' AND o.dateOperation >= ? AND o.dateOperation <= ?");
    $nbr_annule_week->execute([$jourDebutSemaine, $jourFinSemaine]);
    $nbr_annule_week = $nbr_annule_week->rowcount();

    $nbr_encours_week = $DB->prepare("SELECT p.idOperation, p.status, o.dateOperation FROM preadmission p INNER JOIN operations o ON p.idOperation = o.id WHERE p.status = 'En cours' AND o.dateOperation >= ? AND o.dateOperation <= ?");
    $nbr_encours_week->execute([$jourDebutSemaine, $jourFinSemaine]);
    $nbr_encours_week = $nbr_encours_week->rowcount();

    $nbr_termine_week = $DB->prepare("SELECT p.idOperation, p.status, o.dateOperation FROM preadmission p INNER JOIN operations o ON p.idOperation = o.id WHERE p.status = 'Terminé' AND o.dateOperation >= ? AND o.dateOperation <= ?");
    $nbr_termine_week->execute([$jourDebutSemaine, $jourFinSemaine]);
    $nbr_termine_week = $nbr_termine_week->rowcount();

    //-- Esthetique du site si 0 ----------------
    if($nbr_admission_week == 0) {
        $nbr_admission_week = 'Aucune';
    } else {
        $nbr_admission_week = $nbr_admission_week;
    }

    if($nbr_patient_week == 0) {
        $nbr_patient_week = 'Aucun';
    } else {
        $nbr_patient_week = $nbr_patient_week;
    }

    if($nbr_annule_week == 0) {
        $nbr_annule_week = 'Aucune';
    } else {
        $nbr_annule_week = $nbr_annule_week;
    }

    if($nbr_termine_week == 0) {
        $nbr_termine_week = 'Aucune';
    } else {
        $nbr_termine_week = $nbr_termine_week;
    }

    if($nbr_encours_week == 0) {
        $nbr_encours_week = 'Aucune';
    } else {
        $nbr_encours_week = $nbr_encours_week;
    }
?>

<ul class="list-prea">
    <a href="#" class="list-item">
        <h3 class="titre">Patients</h3>
        <p class="desc"><span class="color"><?= $nbr_patient_week ?></span> patients admis pour une future pré-admission.</p>
    </a>

    <a href="#" class="list-item">
        <h3 class="titre">Pré-admissions</h3>
        <p class="desc"><span class="color"><?= $nbr_admission_week ?></span> pré-admissions prévu pour cette semaine.</p>
    </a>

    <a href="#" class="list-item">
        <h3 class="titre">Annulé</h3>
        <p class="desc"><span class="color"><?= $nbr_annule_week ?></span> pré-admissions annulées cette semaine.</p>
    </a>

    <a href="#" class="list-item">
        <h3 class="titre">En cours</h3>
        <p class="desc"><span class="color"><?= $nbr_encours_week ?></span> pré-admissions en cours cette semaine.</p>
    </a>

    <a href="#" class="list-item">
        <h3 class="titre">Terminée</h3>
        <p class="desc"><span class="color"><?= $nbr_termine_week ?></span> pré-admissions terminées cette semaine.</p>
    </a>

    <a href="ajout_admission" class="list-item">
        <h3 class="titre">Créer une nouvelle pré-admission</h3>
    </a>
</ul>