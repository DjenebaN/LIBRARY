<?php

class Fav
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

    public function ajouterFav($Id_Lecteur , $Id_API)
    {
        $req = $this -> bdd -> prepare("INSERT INTO FAVORIS (Id_Lecteur, Id_API) VALUES (:Id_Lecteur , :Id_API)");
        $req -> bindParam (':Id_Lecteur' , $Id_Lecteur);
        $req -> bindParam (':Id_API' , $Id_API);
        return $req -> execute();
    }

    public function supprimerFav($Id_Fav)
    {
        $stmt = $this->bdd->prepare('DELETE FROM FAVORIS WHERE Id_Fav = ?');
        $stmt->execute([$Id_Fav]);
    }

    public function misEnFav($Id_Lecteur , $Id_Fav)
    {
        $query = "SELECT COUNT(*) FROM FAVORIS WHERE Id_Lecteur = :Id_Lecteur AND Id_Fav = :Id_Fav";
        $stmt = $this->bdd->prepare($query);
        $stmt->bindParam(':Id_Lecteur', $Id_Lecteur, PDO::PARAM_INT);
        $stmt->bindParam(':Id_Fav', $Id_Fav, PDO::PARAM_INT);
        $stmt->execute();
        
        return intval($stmt->fetchColumn()) > 0;
    }

}