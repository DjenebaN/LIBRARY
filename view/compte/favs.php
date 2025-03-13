<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/model/favModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/bdd/bdd.php';

if(isset($_GET['Id_Lecteur'])) {
    $Id_Lecteur = $_GET['Id_Lecteur'];
} else {
    echo 'Pas de id';
    exit;
}

$fav = new Fav ($bdd);
$sesFavs = $fav -> mesFavs($Id_Lecteur);

?>

<div class="tousPrets">

<?php

foreach ($sesFavs as $unFav) {
    echo "<div class='favori' data-id-api='{$unFav['Id_API']}' data-id-fav='{$unFav['Id_Fav']}'>";
    echo "<div class='details-favori' id='details-favori-{$unFav['Id_API']}'></div>";
    echo "</div>";
}
?>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/commun/footer.php';
?>