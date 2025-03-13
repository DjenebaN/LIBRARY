<?php
session_start();

// Définir la page par défaut comme étant 'accueil' si aucune page n'est spécifiée
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// Condition spécifique pour ne pas inclure le header sur la page d'accueil
if ($page !== 'accueil') {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/commun/header.php';
}

switch ($page) {
    case 'prets' :
        include($_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/compte/prets.php');
        break;

    case 'logOut' :
        include($_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/compte/logOut.php');
        break;

    case 'logIn' :
        include($_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/compte/logIn.php');
        break;

    case 'favoris' :
        include($_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/compte/favs.php');
        break;

    case 'livres' :
        include($_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/livres.php');
        break;

    default:
        include($_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/accueil.php');
        break;
}
?>
