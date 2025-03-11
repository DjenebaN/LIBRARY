<?php

class Lecteur
{

    private $bdd;

    function __construct ($bdd)
    {
        $this -> bdd = $bdd;
    }

    public function unLecteur($Id_Lecteur) 
    {
    $stmt = $this->bdd->prepare('SELECT * FROM LECTEUR WHERE Id_Lecteur = ?');
    $stmt->execute([$Id_Lecteur]);
    return $stmt->fetch();
    }

    public function ajouterLecteur($nom , $prenom , $email , $mdp)
    {
        $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);

        $req = $this -> bdd -> prepare("INSERT INTO LECTEUR (Nom, Prenom, Email, MDP) VALUES (:nom , :prenom , :email , :mdp)");
        $req -> bindParam (':nom' , $nom);
        $req -> bindParam (':prenom' , $prenom);
        $req -> bindParam (':email' , $email);
        $req -> bindParam (':mdp' , $hashedPassword);
        return $req -> execute();
    }

    public function supprimerLecteur($Id_Lecteur)
{
    $stmt = $this->bdd->prepare('DELETE FROM LECTEUR WHERE Id_Lecteur = ?');
    $stmt->execute([$Id_Lecteur]);
}


    public function modifierLecteur($nom, $prenom, $email, $mdp, $Id_Lecteur) {
        $stmt = $this->bdd->prepare("UPDATE LECTEUR SET Nom = :nom, Prenom = :prenom, Email = :email, MDP = :mdp WHERE Id_Lecteur = :Id_Lecteur");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mdp', $mdp);
        $stmt->bindParam(':Id_Lecteur', $Id_Lecteur); 
        $stmt->execute();
    }

    public function connectionLecteur($email, $mdp)
    {
        try {
            $stmt = $this->bdd->prepare("SELECT * FROM LECTEUR WHERE Email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user && password_verify($mdp, $user['MDP'])) {
                return $user;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }



}