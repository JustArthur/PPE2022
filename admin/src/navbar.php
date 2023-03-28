<nav>
    <ul class="list">
        <li><a href="panel.php">Accueil</a></li>

        <?php if($_SESSION['utilisateur'][3] == 1) { ?>
            <li><a href="voir_preadmission.php">Pré-admission</a>
                <ul class="dropdown">
                    <li><a href="num_secu_creer.php">Créer une pré-admision</a></li>
                    <li><a href="num_secu_modif.php">Modifier une pré-admision</a></li>
                    <li><a href="num_secu_supp.php">Supprimer une pré-admision</a></li>
                </ul>
            </li>

            <li><a href="pdf_semaine.php">Créer un PDF</a></li>
        <?php } ?>

        <?php if($_SESSION['utilisateur'][3] == 2) { ?>
            <li><a href="ajout_service.php">Personels</a></li>
            <li><a href="ajout_service.php">Services</a></li>
        <?php } ?>

        <li><a href="statistique.php">Statistiques</a></li>
        <li><a href="src/deconnexion.php">Se déconnecter</a></li>
    </ul>
</nav>