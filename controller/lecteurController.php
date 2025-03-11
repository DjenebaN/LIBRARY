<?php

include ('../bdd/bdd.php');
include ('../model/lecteurModel.php');


if (isset($_POST ['lecteur'])) {

    $lecteurController = new LecteurController ($bdd);

    switch ($_POST['lecteur']){

        case 'ajouter':
            $lecteurController -> ajout();
            break;
        case 'supprimer':
            $lecteurController -> supprimer();
            break;
        case 'connection':
            $lecteurController -> connection();

        case 'modifier' :
            $lecteurController -> modifier();
            break;
        default :
            echo "Action non reconnue.";
            break;
    }
}


class LecteurController
{
    private $lecteur;

    function __construct($bdd)
    {
        $this -> lecteur = new Lecteur ($bdd);
    }

    public function ajout()
    {
        if (isset ($_POST ['nom'], $_POST ['prenom'] , $_POST['email'], $_POST['mdp'])){
            $this -> lecteur -> ajouterLecteur ($_POST ['nom'], $_POST ['prenom'] , $_POST['email'], $_POST['mdp']);
            header('Location: http://127.0.0.1/LIBRARY/index.php?page=accueil');
            exit();
        } else {
            echo "Tous les champs sont requis.";
        }
    }

    public function supprimer()
    {
        if (isset ($_POST ['Id_Lecteur'])){
            $this -> lecteur -> supprimerLecteur($_POST ['Id_Lecteur']);
            header('Location: http://127.0.0.1/LIBRARY/index.php?page=accueil');
            exit();
        }
    }

    public function modifier()
    {
        if (isset ($_POST ['nom'], $_POST ['prenom'] , $_POST['email'], $_POST['mdp'], $_POST ['Id_Lecteur'])){
            $this -> lecteur -> modifierLecteur ($_POST ['nom'], $_POST ['prenom'] , $_POST['email'], $_POST['mdp'], $_POST ['Id_Lecteur']);
            header('Location: http://127.0.0.1/LIBRARY/index.php?page=accueil');
            exit();
        } else {
            echo "Tous les champs sont requis.";
        }
    }

    public function connection()
    {
        if (!empty($_POST['email']) && !empty($_POST['mdp'])) {
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
            $user = $this->lecteur->connectionLecteur($email, $mdp);
            
            if ($user) {
                session_start();
                $_SESSION['Id_Lecteur'] = $user['Id_Lecteur']; // Stocker l'ID de l'utilisateur dans la session
                $_SESSION['prenom'] = $user['Prenom']; 
                $_SESSION['nom'] = $user['Nom']; 
                $_SESSION['email'] = $user['Email']; 
                header('Location: http://127.0.0.1/LIBRARY/index.php?page=accueil'); // Redirection
                exit();
            } else {
                echo "Identifiants incorrects.";
            }
        } else {
            echo "Veuillez remplir tous les champs.";
        }
    }

}


?>
