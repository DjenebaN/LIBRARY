<?php

include ('../bdd/bdd.php');
include ('../model/favModel.php');


if (isset($_POST ['fav'])) {

    $favController = new FavController ($bdd);

    switch ($_POST['fav']){

        case 'ajouter':
            $favController -> ajout();
            break;
        case 'supprimer':
            $favController -> supprimer();
            break;
        default :
            echo "Action non reconnue.";
            break;
    }
}


class FavController
{
    private $fav;

    function __construct($bdd)
    {
        $this -> fav = new Fav ($bdd);
    }

    public function ajout()
    {
        if (isset($_POST['Id_Lecteur'], $_POST['Id_API'])) {
            
            if ($this->fav->misEnFav($_POST['Id_Lecteur'], $_POST['Id_API'])) {
                echo "Ce livre à été retiré de vos favoris";
                exit();
            } else {
                $this->fav->ajouterFav($_POST['Id_Lecteur'], $_POST['Id_API']);
                header('Location: http://127.0.0.1/LIBRARY/index.php?page=livres');
                exit();
            }
        }
    }


    public function supprimer()
    {
        if (isset($_POST['Id_Fav'])) {
            $this->fav->supprimerFav($_POST['Id_Fav']);
            header('Location: http://127.0.0.1/LIBRARY/index.php?page=livres');
            exit();

        } else {
            echo "Erreur : Aucune ID de prêt reçue.";
        }
    }
}



?>
