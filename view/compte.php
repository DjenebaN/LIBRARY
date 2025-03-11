<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/model/lecteurModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/model/pretModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/bdd/bdd.php';

if(isset($_GET['Id_Lecteur'])) {
    $Id_Lecteur = $_GET['Id_Lecteur'];
} else {
    echo 'Pas de id';
    exit;
}

$lecteur = new Lecteur($bdd);
$ceLecteur = $lecteur->unLecteur($Id_Lecteur);

$pret = new Pret($bdd);
$etats = $pret->getEtat();
$Id_Etat = isset($_POST['Id_Etat']) && !empty($_POST['Id_Etat']) ? $_POST['Id_Etat'] : null;

$sesPrets = $pret->afficherPrets($Id_Lecteur, $Id_Etat);

echo 'Nom : ' . htmlspecialchars($ceLecteur['Nom']) . '<br>';
echo 'Prenom : ' . htmlspecialchars($ceLecteur['Prenom']) . '<br>';
?>

<div id="filtreCours">
    <h2> Filter by : </h2>
    <form method="POST" action="">
            <select name="Id_Etat">
                <option value="">Toutes les Etats</option>
                    <?php foreach ($etats as $unEtat) : ?>
                        <option value="<?php echo htmlspecialchars($unEtat['Id_Etat']); ?>" 
                            <?php echo ($Id_Etat !== null && $Id_Etat == $unEtat['Id_Etat']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($unEtat['Etat']); ?>
                        </option>
                    <?php endforeach; ?>
            </select>
        <button type="submit">Filtrer</button>
    </form>
</div>


<?php
foreach ($sesPrets as $unPret) {
        echo "<div class='livre' data-id-api='{$unPret['Id_API']}' data-id-pret='{$unPret['Id_Pret']}'>";
        echo "<div class='details-livre' id='details-livre-{$unPret['Id_API']}'></div>";
        echo "<p>Retour prévu le : {$unPret['Date_Retour']}</p>";
        echo "</div>";
}
?>


<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/commun/footer.php';
?>
