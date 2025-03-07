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
    try {
        // Début de la transaction
        $this->bdd->beginTransaction();

        // Vérifier si le livre existe déjà dans la base
        $req = $this->bdd->prepare("SELECT Id_Livre FROM LIVRE WHERE Id_API = :Id_API");
        $req->bindParam(':Id_API', $Id_API);
        $req->execute();
        $livre = $req->fetch(PDO::FETCH_ASSOC);

        if ($livre) {
            // Si le livre existe, récupérer son Id_Livre
            $Id_Livre = $livre['Id_Livre'];
        } else {
            // Si le livre n'existe pas, on l'ajoute dans la base
            $req = $this->bdd->prepare("INSERT INTO LIVRE (Id_API, Titre, Auteur, Annee, Image_URL, Etat) VALUES (:Id_API, :Titre, :Auteur, :Annee, :Image_URL, 1)");
            $req->bindParam(':Id_API', $Id_API);
            $req->bindParam(':Titre', $Titre);
            $req->bindParam(':Auteur', $Auteur);
            $req->bindParam(':Annee', $Annee);
            $req->bindParam(':Image_URL', $Image_URL);
            $req->execute();
            $Id_Livre = $this->bdd->lastInsertId();  // Récupérer l'ID du livre inséré
        }

        // Ajouter le prêt dans la base
        $reqPret = $this->bdd->prepare("INSERT INTO PRET (Id_Livre, Id_Lecteur, Date_Emprunt, Date_Retour) VALUES (:Id_Livre, :Id_Lecteur, :date_Emprunt, :date_retour)");
        $reqPret->bindParam(':Id_Livre', $Id_Livre);
        $reqPret->bindParam(':Id_Lecteur', $Id_Lecteur);
        $reqPret->bindParam(':date_Emprunt', $date_Emprunt);
        $reqPret->bindParam(':date_retour', $date_retour);
        $reqPret->execute();

        // Mise à jour de l'état du livre à "Emprunté" (2)
        $stmtLivre = $this->bdd->prepare("UPDATE LIVRE SET Etat = 2 WHERE Id_Livre = :Id_Livre");
        $stmtLivre->bindParam(':Id_Livre', $Id_Livre, PDO::PARAM_INT);
        $stmtLivre->execute();

        // Mise à jour de l'état du prêt si nécessaire (par exemple 4 signifie "Emprunté")
        $stmtPret = $this->bdd->prepare("UPDATE PRET SET Etat = 4 WHERE Id_Livre = :Id_Livre");
        $stmtPret->bindParam(':Id_Livre', $Id_Livre, PDO::PARAM_INT);
        $stmtPret->execute();

        // Commit de la transaction
        $this->bdd->commit();

        // Retourner true si tout s'est bien passé
        return true;

    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction et renvoyer un message d'erreur
        $this->bdd->rollBack();
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}


    public function afficherPrets($Id_Lecteur, $Id_Etat = null) {
        if ($Id_Etat !== null) {
            $stmt = $this->bdd->prepare("SELECT P.Id_Pret, P.Id_Livre, L.Titre, L.Image_URL, P.Date_Emprunt, P.Date_Retour, P.Frais, E.Etat AS Etat_Livre
                            FROM PRET P
                            JOIN LIVRE L ON P.Id_Livre = L.Id_Livre
                            JOIN ETAT E ON P.Etat = E.Id_Etat
                            WHERE P.Id_Lecteur = :Id_Lecteur AND E.Id_Etat = :Id_Etat");
            $stmt->bindParam(':Id_Lecteur', $Id_Lecteur, PDO::PARAM_INT);
            $stmt->bindParam(':Id_Etat', $Id_Etat, PDO::PARAM_INT);
        } else {
            $stmt = $this->bdd->prepare("SELECT P.Id_Pret, P.Id_Livre, L.Titre, L.Image_URL, P.Date_Emprunt, P.Date_Retour, P.Frais, E.Etat AS Etat_Livre
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
    
            if ($dateActuelle > $dateRetour) { // Si la date actuelle dépasse la date de retour
                // Calcul des jours de retard
                $interval = $dateRetour->diff($dateActuelle);
                $joursRetard = $interval->days;
                $nouveauxFrais = $joursRetard * 0.20; // 0.20€ par jour de retard
    
                // Mettre à jour les frais uniquement si la valeur a changé
                if ($nouveauxFrais != $pret['Frais']) {
                    // Mettre à jour les frais dans la table PRET
                    $stmt1 = $this->bdd->prepare("UPDATE PRET SET Frais = :frais WHERE Id_Pret = :Id_Pret");
                    $stmt1->bindParam(':frais', $nouveauxFrais, PDO::PARAM_STR);
                    $stmt1->bindParam(':Id_Pret', $pret['Id_Pret'], PDO::PARAM_INT);
                    $stmt1->execute();
    
                    // Mettre à jour les frais du lecteur en recalculant la somme totale des frais
                    $stmt2 = $this->bdd->prepare("UPDATE LECTEUR 
                        SET Frais = (SELECT SUM(Frais) FROM PRET WHERE Id_Lecteur = :Id_Lecteur) 
                        WHERE Id_Lecteur = :Id_Lecteur");
                    $stmt2->bindParam(':Id_Lecteur', $Id_Lecteur, PDO::PARAM_INT);
                    $stmt2->execute();

                    $stmt3 = $this->bdd->prepare("UPDATE PRET SET Etat = 3 WHERE Id_Pret = :Id_Pret");
                    $stmt3->bindParam(':Id_Pret', $pret['Id_Pret'], PDO::PARAM_INT);
                    $stmt3->execute();
                }
            }
        }
    
        return $prets;
    }
    
       
    

    public function getEtatsRetardCours()
    {
        $stmt = $this->bdd->prepare("SELECT Id_Etat, Etat FROM ETAT WHERE Etat IN ('En Cours', 'En Retard')");
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
    
}

?>