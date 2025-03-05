<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/model/lecteurModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/model/pretModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/bdd/bdd.php';

if (isset($_SESSION['Id_Lecteur'])) {
    $ID = $_SESSION['Id_Lecteur'];
} elseif (isset($_GET['Id_Lecteur'])) {
    $ID = $_GET['Id_Lecteur'];
} else {   
    echo 'rien'; 
}

$lecteur = new Lecteur ($bdd);
$detailLecteur = $lecteur -> unLecteur($ID);

$prets = new Pret($bdd);
$etats = $prets->getEtatsRetardCours();
$Id_Etat = isset($_POST['Id_Etat']) && !empty($_POST['Id_Etat']) ? $_POST['Id_Etat'] : null;
$mesPrets = $prets->afficherPrets($ID, $Id_Etat);

echo '<p>Nom : ' . htmlspecialchars($detailLecteur['Nom']) . '</p>';
echo '<p>Prenom : ' . htmlspecialchars($detailLecteur['Prenom']) . '</p>';
echo '<p>Email : ' . htmlspecialchars($detailLecteur['Email']) . '</p>';
echo '<p>Frais : ' . htmlspecialchars($detailLecteur['Frais']) . '€</p>';
?>

<h2> Filter by : </h2>
                <form method="POST" action="">
                    <select name="Id_Etat">
                        <option value="">Tous les etats</option>
                        <?php foreach ($etats as $etat) : ?>
                            <option value="<?php echo htmlspecialchars($etat['Id_Etat']); ?>" 
                                <?php echo ($Id_Etat !== null && $Id_Etat == $etat['Id_Etat']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($etat['Etat']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Filtrer</button>
                </form>

<?php
foreach ($mesPrets as $pret) {

    $Id_Pret = $pret['Id_Pret'];
    $Id_Livre = $pret['Id_Livre'];
    echo (htmlspecialchars($pret['Id_Pret']));
    echo "<div>";
    echo "<h3>Livre : " . htmlspecialchars($pret['Titre']) . "</h3>";
    echo "<h3>Etat : " . htmlspecialchars($pret['Etat_Livre']) . "</h3>";
    echo "<img src='" . htmlspecialchars($pret['Image_URL']) . "' alt='Couverture du livre' width='150' height='200'>";
    echo "</div><br>";?>

    <form method="POST" action="controller/pretController.php">
            <input type="hidden" name="Id_Pret" value="<?php echo htmlspecialchars($pret['Id_Pret']); ?>">
            <input type="hidden" name="Id_Livre" value="<?php echo htmlspecialchars($pret['Id_Livre']); ?>">
            <input type="hidden" name="pret" value="supprimer">
            <input type="submit" value="Rendre">
    </form>

<?php }

?>