<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/model/lecteurModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/model/pretModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/bdd/bdd.php';

if (isset($_SESSION['Id_Lecteur'])) {
    $ID = $_SESSION['Id_Lecteur'];
} elseif (isset($_GET['Id_Lecteur'])) {
    $ID = $_GET['Id_Lecteur'];
} else {   
    echo 'Aucun lecteur trouvé'; 
}

$lecteur = new Lecteur($bdd);
$detailLecteur = $lecteur->unLecteur($ID);

$prets = new Pret($bdd);
$etats = $prets->getEtatsRetardCours();
$Id_Etat = isset($_POST['Id_Etat']) && !empty($_POST['Id_Etat']) ? $_POST['Id_Etat'] : null;
$mesPrets = $prets->afficherPrets($ID, $Id_Etat);

?>
<div class="compte">
    <div class="user-info">
        <p><strong>Nom :</strong> <?php echo htmlspecialchars($detailLecteur['Nom']); ?></p>
        <p><strong>Prénom :</strong> <?php echo htmlspecialchars($detailLecteur['Prenom']); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($detailLecteur['Email']); ?></p>
    </div>

    <h2>Mes Prêts</h2>

    <!-- Barre de filtre -->
    <div class="filter-bar">
        <form method="POST" action="">
            <select name="Id_Etat" class="select-filter">
                <option value="">Tous les états</option>
                <?php foreach ($etats as $etat) : ?>
                    <option value="<?php echo htmlspecialchars($etat['Id_Etat']); ?>" 
                        <?php echo ($Id_Etat !== null && $Id_Etat == $etat['Id_Etat']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($etat['Etat']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="submit-filter">Filtrer</button>
        </form>
    </div>

    <!-- Liste des prêts -->
    <div class="prets-list">
        <?php if (empty($mesPrets)) : ?>
            <p>Aucun prêt trouvé.</p>
        <?php else : ?>
            <div class="row">
                <?php foreach ($mesPrets as $pret) : ?>
                    <div class="book-item">
                        <h3><?php echo htmlspecialchars($pret['Titre']); ?></h3>
                        <img src="<?php echo htmlspecialchars($pret['Image_URL']); ?>" alt="Couverture du livre" width="150" height="200">
                        <?php if (isset($Id_Etat) && $Id_Etat == 3): ?>
                            <p>Frais de retard : <?php echo number_format($pret['Frais'], 2); ?> €</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Styles CSS (à ajouter dans un fichier séparé ou dans un bloc <style>) -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #121212;
        color: #ddd;
        margin: 0;
        padding: 0;
    }

    h2 {
        color: #fff;
        text-align: center;
        margin-top: 20px;
    }

    .user-info {
        text-align: center;
        margin: 20px 0;
        color: #ccc;
    }

    .user-info p {
        font-size: 16px;
    }

    .filter-bar {
    text-align: center;
    margin: 20px 0;
}

.select-filter, .submit-filter {
    padding: 10px;
    margin: 5px;
    background-color: #333;
    color: #ddd;
    border: 1px solid #555;
    border-radius: 5px;
}

    .select-filter:focus {
        background-color: #444;
        outline: none;
    }


    .submit-filter:hover {
        background-color: #0056b3;
    }

    .prets-list {
        margin: 0 20px;
    }

    .row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;  /* Espace entre les livres */
    justify-content: flex-start;
    width: 100%; /* Assurer que la ligne prend toute la largeur */
}

.book-item {
    flex: 1 1 18%; /* Utilise flex pour permettre à chaque livre de prendre de l'espace */
    text-align: center;
    padding: 10px;
    border-radius: 8px;
    color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    margin-bottom: 15px;
    min-width: 150px;  /* Assure une largeur minimale */
}

.book-item img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}

.book-item h3 {
    font-size: 14px;
    margin: 10px 0;
}

    .book-cover {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .pret-form {
        margin-top: 10px;
    }

    .return-btn {
        padding: 8px 16px;
        background-color: #dc3545;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .return-btn:hover {
        background-color: #c82333;
    }

    p {
        color: #bbb;
    }
    .compte{
    display: flex;
    flex-direction: column;
    }

    .row:not(:empty) {
    justify-content: flex-start;
}
.row.single-item {
    justify-content: center;
}
    /* Condition pour aligner à gauche si peu d'éléments */
.row:only-child {
    justify-content: flex-start;
}
</style>

