<?php

include ('../bdd/bdd.php');
include ('../model/pretModel.php');


if (isset($_POST ['pret'])) {

    $pretController = new PretController ($bdd);

    switch ($_POST['pret']){

        case 'ajouter':
            $pretController -> ajout();
            break;
        case 'supprimer':
            $pretController -> supprimer();
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
        if (isset($_POST['Id_API'], $_POST['Id_Lecteur'], $_POST['date_Emprunt'], $_POST['date_retour'])) {
            var_dump($_POST['Id_API']);
            var_dump($_POST['Id_Lecteur']);
            if ($this->pret->livreEmprunteLecteur($_POST['Id_API'], $_POST['Id_Lecteur'])) {
                echo "Vous avez déjà emprunté ce livre.";
                exit();
            }
            if ($this->pret->livreEmprunte($_POST['Id_API'])) {
                echo "Ce livre a déjà été emprunté par quelqu'un d'autre.";
                exit();
            } else {
                $this->pret->ajouterPret($_POST['Id_API'], $_POST['Id_Lecteur'], $_POST['date_Emprunt'], $_POST['date_retour']);
                header('Location: http://127.0.0.1/LIBRARY/index.php?page=livres');
                exit();
            }
        }
    }


    



    public function supprimer()
    {
        // Vérification de l'ID du prêt
        if (isset($_POST['Id_Pret'])) {
            $idPret = $_POST['Id_Pret'];
            echo "ID du prêt: " . $idPret;  // Afficher l'ID du prêt pour le débogage
    
            if (is_numeric($idPret)) {
                $this->pret->supprimerPret($idPret);
                header('Location: http://127.0.0.1/LIBRARY/index.php?page=livres');
                exit();
            } else {
                echo "Erreur : L'ID du prêt n'est pas valide.";
            }
        } else {
            echo "Erreur : Aucune ID de prêt reçue.";
        }
    }
}



?>
