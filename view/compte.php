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
$mesPrets = $prets -> afficherPrets($ID);

echo '<p>Nom : ' . htmlspecialchars($detailLecteur['Nom']) . '</p>';
echo '<p>Prenom : ' . htmlspecialchars($detailLecteur['Prenom']) . '</p>';
echo '<p>Email : ' . htmlspecialchars($detailLecteur['Email']) . '</p>';

foreach ($mesPrets as $pret) {
    echo "Livre : " . htmlspecialchars($pret['Titre']) . "</br>";
}

?>