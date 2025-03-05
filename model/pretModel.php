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

        $stmt = $this->bdd->prepare("UPDATE LIVRE SET Etat = 2 WHERE Id_Livre = :Id_Livre");
        $stmt->bindParam(':Id_Livre', $Id_Livre, PDO::PARAM_INT);
        $stmt->execute();

        return $req->execute();
    }

    public function afficherPrets($Id_Lecteur, $Id_Etat = null) {
        if ($Id_Etat !== null) {
            $stmt = $this->bdd->prepare("SELECT P.Id_Pret, P.Id_Livre, L.Titre, L.Image_URL, P.Date_Emprunt, P.Date_Retour, E.Etat AS Etat_Livre
                            FROM PRET P
                            JOIN LIVRE L ON P.Id_Livre = L.Id_Livre
                            JOIN ETAT E ON P.Etat = E.Id_Etat
                            WHERE P.Id_Lecteur = :Id_Lecteur AND E.Id_Etat = :Id_Etat");
            $stmt->bindParam(':Id_Lecteur', $Id_Lecteur, PDO::PARAM_INT);
            $stmt->bindParam(':Id_Etat', $Id_Etat, PDO::PARAM_INT);
        } else {
            $stmt = $this->bdd->prepare("SELECT P.Id_Pret, P.Id_Livre, L.Titre, L.Image_URL, P.Date_Emprunt, P.Date_Retour, E.Etat AS Etat_Livre
                            FROM PRET P
                            JOIN LIVRE L ON P.Id_Livre = L.Id_Livre
                            JOIN ETAT E ON P.Etat = E.Id_Etat
                            WHERE P.Id_Lecteur = :Id_Lecteur");
            $stmt->bindParam(':Id_Lecteur', $Id_Lecteur, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $prets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($prets as $pret) {
            $dateRetour = new DateTime($pret['Date_Retour']);
            $dateActuelle = new DateTime();
    
            if ($dateActuelle > $dateRetour && $pret['Etat_Livre'] != 'En retard') {
                // Mise à jour de l'état du livre
                $stmt1 = $this->bdd->prepare("UPDATE LIVRE SET Etat = 3 WHERE Id_Livre = ?");
                $stmt1->execute([$pret['Id_Livre']]);
    
                // Calcul des jours de retard
                $interval = $dateRetour->diff($dateActuelle);
                $joursRetard = $interval->days;
    
                if ($joursRetard > 0) {
                    // Calcul des frais de retard (20 centimes par jour)
                    $frais = $joursRetard * 0.20;
    
                    // Mise à jour des frais du lecteur
                    $stmt2 = $this->bdd->prepare("UPDATE LECTEUR SET Frais = Frais + :frais WHERE Id_Lecteur = :Id_Lecteur");
                    $stmt2->bindParam(':frais', $frais, PDO::PARAM_STR);
                    $stmt2->bindParam(':Id_Lecteur', $Id_Lecteur, PDO::PARAM_INT);
                    $stmt2->execute();
                }
            }
        }
    
        return $prets;
    }    
    

    public function getEtatsRetardCours()
    {
        $stmt = $this->bdd->prepare("SELECT Id_Etat, Etat FROM ETAT WHERE Etat IN ('En Retard', 'En Cours')");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEtatsDispEmp()
    {
        $stmt = $this->bdd->prepare("SELECT Id_Etat, Etat FROM ETAT WHERE Etat IN ('Emprunté', 'Disponible')");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);    
    }


    public function supprimerPret($Id_Pret, $Id_Livre)
    {
        $req = $this->bdd->prepare("DELETE FROM PRET WHERE Id_Pret = ?");
        $req->execute([$Id_Pret]);

        $stmt = $this->bdd->prepare("DELETE FROM LIVRE WHERE Id_Livre = ?");
        return $stmt->execute([$Id_Livre]);

        
    }

    public function calculerFraisRetard($Id_Lecteur)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM PRET WHERE Id_Lecteur = :Id_Lecteur AND Date_Retour < CURDATE() AND etat = 4");  // 4 = "En cours"
        $stmt->bindParam(':Id_Lecteur', $Id_Lecteur);
        $stmt->execute();

        $fraisTotaux = 0;

        while ($pret = $stmt->fetch()) {
            $dateRetour = new DateTime($pret['Date_Retour']);
            $dateActuelle = new DateTime();

            $interval = $dateRetour->diff($dateActuelle);
            $joursRetard = $interval->days;

            if ($joursRetard > 0) {
                $fraisTotaux += $joursRetard * 0.20;
            }
        }

        return $fraisTotaux;
    }

    public function mettreAJourFrais($Id_Lecteur, $frais)
    {
        $stmt = $this->bdd->prepare("UPDATE LECTEUR SET Frais = Frais + :frais WHERE Id_Lecteur = :Id_Lecteur");
        $stmt->bindParam(':frais', $frais);
        $stmt->bindParam(':Id_Lecteur', $Id_Lecteur);
        return $stmt->execute();
    }

    

}

?>