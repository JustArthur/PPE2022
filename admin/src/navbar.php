<nav>
    <ul class="list">
        <li><a href="panel">Accueil</a></li>

        <?php if($_SESSION['utilisateur'][3] == 1) { ?>
            <li><a href="voir_preadmission">Pré-admission</a>
                <ul class="dropdown">
                    <li><a href="num_secu_creer">Créer une pré-admision</a></li>
                    <li><a href="num_secu_modif">Modifier une pré-admision</a></li>
                    <li><a href="num_secu_supp">Supprimer une pré-admision</a></li>
                </ul>
            </li>
        <?php } ?>

        <?php if($_SESSION['utilisateur'][3] == 2) { ?>
            <li><a href="voir_personnel">Personnel</a>
                <ul class="dropdown">
                    <li><a href="#">Ajouter un personnel</a></li>
                    <li><a href="#">Modifier un personnel</a></li>
                    <li><a href="#">Supprimer un personnel</a></li>
                </ul>
            </li>

            <li><a href="voir_service">Service</a>
                <ul class="dropdown">
                    <li><a href="#">Ajouter un service</a></li>
                    <li><a href="#">Modifier un service</a></li>
                    <li><a href="#">Supprimer un service</a></li>
                </ul>
            </li>
        <?php } ?>

        <li><a href="statistique">Statistiques</a></li>
        <li><a href="src/deconnexion.php">Se déconnecter</a></li>
    </ul>
</nav>