function Click(event) {
    event.preventDefault();  // Empêche l'envoi du formulaire et le rechargement de la page
    
    const searchInput = document.getElementById("bar").value.trim();
    if (searchInput === "") return; // Empêche une recherche vide

    const formattedSearch = searchInput.split(" ").join("+");  // Remplace les espaces par des "+"
    const apiUrl = "https://openlibrary.org/search.json?q=" + formattedSearch;

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const Resultat = document.getElementById('Resultat');
            Resultat.innerHTML = "";  // Réinitialiser le contenu

            if (!data.docs || data.docs.length === 0) {
                Resultat.innerHTML = "<p>Aucun livre trouvé.</p>";
                return;
            }

            data.docs.forEach(livre => {
                const livreRes = document.createElement('div');
                livreRes.className = "livreRes"; // Applique la classe pour le style CSS
                
                // Contenu du livre
                const Nom = document.createElement('div');
                Nom.className = "Nom";
                Nom.textContent = "Titre : " + (livre.title ? livre.title.toUpperCase() : "Inconnu");
                livreRes.appendChild(Nom);

                const AuteurLivre = document.createElement('div');
                AuteurLivre.textContent = "Auteur : " + (livre.author_name ? livre.author_name.join(", ") : "Inconnu");
                livreRes.appendChild(AuteurLivre);

                const DatePubli = document.createElement('div');
                DatePubli.textContent = "Année : " + (livre.first_publish_year || "Inconnue");
                livreRes.appendChild(DatePubli);

                const Image = document.createElement('img');
                Image.className = "Image";
                Image.src = livre.cover_i
                    ? `https://covers.openlibrary.org/b/id/${livre.cover_i}-L.jpg`
                    : "view/style/default.jpg";
                Image.alt = `Couverture de ${livre.title}`;
                livreRes.appendChild(Image);

                // Formulaire pour l'emprunt
                const empruntForm = document.createElement('form');
                empruntForm.className = "empruntForm";
                empruntForm.method = "POST";
                empruntForm.action = "controller/pretController.php";

                // Création des champs cachés pour l'emprunt (comme dans ton exemple)
                const Id_Livre = document.createElement('input');
                Id_Livre.type = "hidden";
                Id_Livre.name = "Id_Livre";
                Id_Livre.value = livre.key;
                empruntForm.appendChild(Id_Livre);

                const Id_LecteurInput = document.createElement('input');
                Id_LecteurInput.type = "hidden";
                Id_LecteurInput.name = "Id_Lecteur";
                Id_LecteurInput.value = Id_Lecteur; // Assure-toi que Id_Lecteur est défini quelque part
                empruntForm.appendChild(Id_LecteurInput);

                const Date_Emprunt = document.createElement('input');
                Date_Emprunt.type = "hidden";
                Date_Emprunt.name = "date_Emprunt";
                Date_Emprunt.value = new Date().toISOString().split('T')[0];
                empruntForm.appendChild(Date_Emprunt);

                const date_Emprunt = new Date(Date_Emprunt.value);
                const date_Retour = new Date(date_Emprunt);
                date_Retour.setDate(date_Retour.getDate() + 14);
                const formattedDateRetour = date_Retour.toISOString().split('T')[0];

                const Date_Retour = document.createElement('input');
                Date_Retour.type = "hidden";
                Date_Retour.name = "date_retour";
                Date_Retour.value = formattedDateRetour;
                empruntForm.appendChild(Date_Retour);

                const Id_API = document.createElement('input');
                Id_API.type = "hidden";
                Id_API.name = "Id_API";
                Id_API.value = livre.key;
                empruntForm.appendChild(Id_API);

                const Titre = document.createElement('input');
                Titre.type = "hidden";
                Titre.name = "Titre";
                Titre.value = livre.title;
                empruntForm.appendChild(Titre);

                const Auteur = document.createElement('input');
                Auteur.type = "hidden";
                Auteur.name = "Auteur";
                Auteur.value = livre.author_name ? livre.author_name.join(", ") : "Inconnu";
                empruntForm.appendChild(Auteur);

                const Annee = document.createElement('input');
                Annee.type = "hidden";
                Annee.name = "Annee";
                Annee.value = livre.first_publish_year || "Inconnue";
                empruntForm.appendChild(Annee);

                const Image_URL = document.createElement('input');
                Image_URL.type = "hidden";
                Image_URL.name = "Image_URL";
                Image_URL.value = livre.cover_i ? `https://covers.openlibrary.org/b/id/${livre.cover_i}-L.jpg` : "view/style/default.jpg";
                empruntForm.appendChild(Image_URL);

                const actionPret = document.createElement('input');
                actionPret.type = "hidden";
                actionPret.name = "pret";
                actionPret.value = "ajouter";
                empruntForm.appendChild(actionPret);

                const bttPret = document.createElement('button');
                bttPret.type = "submit";
                bttPret.textContent = "Emprunter";
                empruntForm.appendChild(bttPret);

                livreRes.appendChild(empruntForm);
                Resultat.appendChild(livreRes);
            });

        })
        .catch(error => {
            console.error("Erreur lors de la récupération des données :", error);
        });
}
