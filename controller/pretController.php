<?php

include ('../bdd/bdd.php');
include ('../model/pretModel.php');


if (isset($_POST ['pret'])) {

    $pretController = new PretController ($bdd);

    switch ($_POST['pret']){

        case 'ajouter':
            $pretController -> ajout();
            break;
        default :
            echo "Action non reconnue.";
            break;
    }
}


class PretController
{
    private $pret;

    function __construct($bdd)
    {
        $this -> pret = new Pret ($bdd);
    }

    public function ajout()
{
    if (isset($_POST['Id_API'], $_POST['Titre'], $_POST['Auteur'], $_POST['Annee'], $_POST['Image_URL'], $_POST['Id_Lecteur'], $_POST['date_Emprunt'], $_POST['date_retour'])) {
        
        $this->pret->ajouterLivreEtPret($_POST['Id_API'], $_POST['Titre'], $_POST['Auteur'], $_POST['Annee'], $_POST['Image_URL'], $_POST['Id_Lecteur'], $_POST['date_Emprunt'], $_POST['date_retour']);

        header('Location: http://127.0.0.1/LIBRARY/');
        exit();
    } else {
        echo "Tous les champs sont requis.";
    }
}


}


?>
