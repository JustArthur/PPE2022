<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
    include_once('include.php');

    require_once('profil.php');
?>

<nav>
    <a href="panel.php" class="home">Accueil</a>

    <?php if($role[0] == 1) {?>
        <a href="_pages/preadmission.php" class="preadmission">Pré-admission</a>
    <?php } ?>

    <?php if($role[0] == 2) {?>
        <a href="medecin.php" class="medecin">Ajouter un médecin</a>
        <a href="service.php" class="service">Ajouter un service</a>
    <?php } ?>

    <?php if($role[0] == 1 || $role[0] == 2 || $role[0] = 3) {?>
            <a href="stats.php" class="stats">Statistiques</a>
    <?php }?>

    <a href="setting.php" class="setting">Paramètres</a>
    <a href="deconnexion.php" class="deco">Se déconnecter</a>
</nav>