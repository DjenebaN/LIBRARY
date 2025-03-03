<?php

class Pret
{
    private $bdd;

    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajouterLivreEtPret($Id_API, $Titre, $Auteur, $Annee, $Image_URL, $Id_Lecteur, $date_Emprunt, $date_retour)
    {
        $req = $this->bdd->prepare("SELECT Id_Livre FROM LIVRE WHERE Id_API = :Id_API");
        $req->bindParam(':Id_API', $Id_API);
        $req->execute();
        $livre = $req->fetch(PDO::FETCH_ASSOC);

        if ($livre) {
            $Id_Livre = $livre['Id_Livre'];
        } else {
            $req = $this->bdd->prepare("INSERT INTO LIVRE (Id_API, Titre, Auteur, Annee, Image_URL, Etat) VALUES (:Id_API, :Titre, :Auteur, :Annee, :Image_URL, 1)");
            $req->bindParam(':Id_API', $Id_API);
            $req->bindParam(':Titre', $Titre);
            $req->bindParam(':Auteur', $Auteur);
            $req->bindParam(':Annee', $Annee);
            $req->bindParam(':Image_URL', $Image_URL);
            $req->execute();
            $Id_Livre = $this->bdd->lastInsertId();  // Récupérer le dernier Id_Livre inséré
        }

        $req = $this->bdd->prepare("INSERT INTO PRET (Id_Livre, Id_Lecteur, Date_Emprunt, Date_Retour) VALUES (:Id_Livre, :Id_Lecteur, :date_Emprunt, :date_retour)");
        $req->bindParam(':Id_Livre', $Id_Livre);
        $req->bindParam(':Id_Lecteur', $Id_Lecteur);
        $req->bindParam(':date_Emprunt', $date_Emprunt);
        $req->bindParam(':date_retour', $date_retour);

        $stmt = $this->bdd->prepare("UPDATE LIVRE SET Etat = 4 WHERE Id_Livre = :Id_Livre");
        $stmt->bindParam(':Id_Livre', $Id_Livre, PDO::PARAM_INT);
        $stmt->execute();

        return $req->execute();
    }

    public function afficherPrets($Id_Lecteur)
    {
        $req = $this->bdd->prepare("SELECT P.Id_Pret, L.Titre, P.Date_Emprunt, P.Date_Retour, E.Etat AS Etat_Livre
                                    FROM PRET P
                                    JOIN LIVRE L ON P.Id_Livre = L.Id_Livre
                                    JOIN ETAT E ON L.Etat = E.Id_Etat
                                    WHERE P.Id_Lecteur = :Id_Lecteur");
        $req->bindParam(':Id_Lecteur', $Id_Lecteur, PDO::PARAM_INT);
        $req->execute();
        $emprunts = $req->fetchAll(PDO::FETCH_ASSOC);

        return $emprunts;
    }

}

?>