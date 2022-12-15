<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    include_once('include.php');

    $req = $DB->prepare("SELECT * FROM patient");
    $req->execute();
    $req = $req->fetchAll();

?>

    <ul class="list-patient">

<?php
    foreach($req as $req_patient) {
        $nomPrenom = $req_patient['nomNaissance'] . ' ' . $req_patient ['prenom'];
        $numSecu = $req_patient['numSecu'];
?>
        <div class="div-card-patient">
            <div class="nom"><?= $nomPrenom ?></div>
            <div class="numSecu"><?= $numSecu ?></div>
        </div>

<?php
    }
?>
    </ul>