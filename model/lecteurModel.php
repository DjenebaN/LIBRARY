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

    public function ajouterLecteur($nom , $prenom , $email , $mdp , $telephone, $adresse, $cp, $ville)
    {
        $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);

        $req = $this -> bdd -> prepare("INSERT INTO LECTEUR (Nom, Prenom, Email, MDP, Telephone, Adresse, CP, Ville) VALUES (:nom , :prenom , :email , :mdp , :telephone , :adresse , :cp , :ville)");
        $req -> bindParam (':nom' , $nom);
        $req -> bindParam (':prenom' , $prenom);
        $req -> bindParam (':email' , $email);
        $req -> bindParam (':mdp' , $hashedPassword);
        $req -> bindParam (':telephone' , $telephone);
        $req -> bindParam (':adresse' , $adresse);
        $req -> bindParam (':cp' , $cp);
        $req -> bindParam (':ville' , $ville);
        return $req -> execute();
    }

    public function supprimerLecteur($Id_Lecteur)
{
    $stmt = $this->bdd->prepare('DELETE FROM LECTEUR WHERE Id_Lecteur = ?');
    $stmt->execute([$Id_Lecteur]);
}


    public function modifierLecteur($nom, $prenom, $email, $mdp, $telephone, $adresse, $cp, $ville, $Id_Lecteur) {
        $stmt = $this->bdd->prepare("UPDATE LECTEUR SET Nom = :nom, Prenom = :prenom, Email = :email, MDP = :mdp, Adresse = :adresse, CP = :cp , Ville = :ville WHERE Id_Lecteur = :Id_Lecteur");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mdp', $mdp);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':cp', $cp);
        $stmt->bindParam(':ville', $ville);
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