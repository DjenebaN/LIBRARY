<?php

class Pret
{
    private $bdd;

    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajouterPret($Id_API , $Id_Lecteur , $date_Emprunt , $date_retour)
    {
        $req = $this -> bdd -> prepare("INSERT INTO PRET (Id_API, Id_Lecteur, Date_Emprunt, Date_Retour) VALUES (:Id_API , :Id_Lecteur , :date_Emprunt , :date_retour)");
        $req -> bindParam (':Id_API' , $Id_API);
        $req -> bindParam (':Id_Lecteur' , $Id_Lecteur);
        $req -> bindParam (':date_Emprunt' , $date_Emprunt);
        $req -> bindParam (':date_retour' , $date_retour);
        return $req -> execute();
    }

    public function afficherPrets($Id_Lecteur, $Id_Etat) 
    {
        if ($Id_Etat) {
            $stmt = $this->bdd->prepare("SELECT Id_Pret, Id_API, Date_Emprunt, Date_Retour, Frais FROM PRET WHERE Id_Lecteur = :Id_Lecteur AND Id_Etat = :Id_Etat");
            $stmt->bindParam(':Id_Lecteur', $Id_Lecteur, PDO::PARAM_INT);
            $stmt->bindParam(':Id_Etat', $Id_Etat, PDO::PARAM_INT);
        }else {
            $stmt = $this->bdd->prepare("SELECT Id_Pret, Id_API, Date_Emprunt, Date_Retour, Frais FROM PRET WHERE Id_Lecteur = :Id_Lecteur");
            $stmt->bindParam(':Id_Lecteur', $Id_Lecteur, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function supprimerPret($Id_Pret)
    {
        $req = $this->bdd->prepare("DELETE FROM PRET WHERE Id_Pret = ?");
        $req->execute([$Id_Pret]);

    }

    public function getEtat()
    {
        $stmt = $this->bdd->prepare("SELECT Id_Etat, Etat FROM ETAT");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function livreEmprunteLecteur($Id_API, $Id_Lecteur) 
    {
        $query = "SELECT COUNT(*) FROM PRET WHERE Id_API = :Id_API AND Id_Lecteur = :Id_Lecteur";
        $stmt = $this->bdd->prepare($query);
        $stmt->bindParam(':Id_API', $Id_API, PDO::PARAM_STR); 
        $stmt->bindParam(':Id_Lecteur', $Id_Lecteur, PDO::PARAM_INT); 
        $stmt->execute();
        return intval($stmt->fetchColumn()) > 0;
    }


    public function livreEmprunte($Id_API)
    {
        $query = "SELECT COUNT(*) FROM PRET WHERE Id_API = :Id_API";
        $stmt = $this->bdd->prepare($query);
        $stmt->bindParam(':Id_API', $Id_API, PDO::PARAM_STR); 
        $stmt->execute();
        $result = $stmt->fetchColumn();
        var_dump($result);

        return intval($result) > 0;
    }


    

}

?>