function Click(event) {
    event.preventDefault();

    const searchInput = document.getElementById("bar").value.trim();
    if (searchInput === "") return;

    const formattedSearch = searchInput.split(" ").join("+");
    const apiUrl = "https://www.googleapis.com/books/v1/volumes?q=" + formattedSearch;

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const Livres = document.getElementById('Livres');
            Livres.innerHTML = "";

            if (!data.items || data.items.length === 0) {
                Livres.innerHTML = "<p>Aucun livre trouvé.</p>";
                return;
            }

            data.items.forEach(livre => {
                const unLivre = document.createElement('div');
                unLivre.className = "unLivre"

                const miniTitre = document.createElement('div');
                miniTitre.className = "miniTitre"
                miniTitre.textContent = "📖 " + (livre.volumeInfo.title ? livre.volumeInfo.title.toUpperCase() : "Inconnu");
                unLivre.appendChild(miniTitre);

                /*
                // Auteur(s)
                const AuteurLivre = document.createElement('p');
                AuteurLivre.textContent = "✍️ Auteur : " + (livre.authors ? livre.authors.join(", ") : "Inconnu");
                bookContainer.appendChild(AuteurLivre);
                */

                const miniDate = document.createElement('div');
                miniDate.className = "miniDate"
                miniDate.textContent = "📅 Année : " + (livre.volumeInfo.publishedDate || "Inconnue");
                unLivre.appendChild(miniDate);

                if (livre.volumeInfo.imageLinks && livre.volumeInfo.imageLinks.thumbnail) {
                    const miniLivre = document.createElement('img');
                    miniLivre.className = "miniLivre"
                    miniLivre.src = livre.volumeInfo.imageLinks.thumbnail;
                    miniLivre.alt = `Couverture de ${livre.volumeInfo.title}`;
                    unLivre.appendChild(miniLivre);
                }

                const boutonVoir = document.createElement('button');
                boutonVoir.className = "btnVoir";
                boutonVoir.textContent = "Voir";
                boutonVoir.onclick = function() {
                    afficherDetails(livre);
                };
                unLivre.appendChild(boutonVoir);

                Livres.appendChild(unLivre);
            });

        })
        .catch(error => {
            console.error("Erreur lors de la récupération des données :", error);
        });
}

function afficherDetails(livre) {
    const Livres = document.getElementById('Livres');
    Livres.innerHTML = "";

    const details = document.getElementById('newDetailsSection');
    details.innerHTML = '';  // Réinitialiser les détails

    const titre = document.createElement('h2');
    titre.textContent = livre.volumeInfo.title;

    const auteur = document.createElement('p');
    auteur.textContent = "Auteur(s) : " + (livre.volumeInfo.authors ? livre.volumeInfo.authors.join(", ") : "Inconnu");

    const description = document.createElement('p');
    description.textContent = "Description : " + (livre.volumeInfo.description || "Aucune description disponible.");

    const date = document.createElement('p');
    date.textContent = "Date de publication : " + (livre.volumeInfo.publishedDate || "Inconnue");

    const image = document.createElement('img');
    image.src = livre.volumeInfo.imageLinks ? livre.volumeInfo.imageLinks.thumbnail : 'default.jpg';
    image.alt = `Couverture de ${livre.volumeInfo.title}`;

    const empruntForm = document.createElement('form');
    empruntForm.className = "empruntForm";
    empruntForm.method = "POST";
    empruntForm.action = "controller/pretController.php";

    const Id_API = document.createElement('input');
    Id_API.type = "hidden";
    Id_API.name = "Id_API";
    Id_API.value = livre.id;
    empruntForm.appendChild(Id_API);

    const Id_LecteurInput = document.createElement('input');
    Id_LecteurInput.type = "hidden";
    Id_LecteurInput.name = "Id_Lecteur";
    Id_LecteurInput.value = Id_Lecteur;
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

    const actionPret = document.createElement('input');
    actionPret.type = "hidden";
    actionPret.name = "pret";
    actionPret.value = "ajouter";
    empruntForm.appendChild(actionPret);

    const bttPret = document.createElement('button');
    bttPret.type = "submit";
    bttPret.textContent = "Emprunter";
    empruntForm.appendChild(bttPret);

    const favForm = document.createElement('form');
    favForm.className = "empruntForm";
    favForm.method = "POST";
    favForm.action = "controller/favController.php";

    favForm.appendChild(Id_LecteurInput);
    favForm.appendChild(Id_API);

    const actionFav = document.createElement('input');
    actionFav.type = "hidden";
    actionFav.name = "fav";
    actionFav.value = "ajouter";
    favForm.appendChild(actionFav);

    const bttFav = document.createElement('button');
    bttFav.type = "submit";
    bttFav.textContent = "Favoris";
    favForm.appendChild(bttFav);

    details.appendChild(titre);
    details.appendChild(auteur);
    details.appendChild(date);
    details.appendChild(description);
    details.appendChild(image);
    details.appendChild(empruntForm);
    details.appendChild(favForm);
}

document.addEventListener('DOMContentLoaded', function () {
    const livres = document.querySelectorAll('.livre');

    livres.forEach(function (livreElement) {
        const idAPI = livreElement.getAttribute('data-id-api');

        fetch(`https://www.googleapis.com/books/v1/volumes/${idAPI}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Livre non trouvé');
                } else {
                    const detailsDiv = livreElement.querySelector('.details-livre');
                    detailsDiv.innerHTML = '';

                    const titre = document.createElement('h3');
                    titre.textContent = data.volumeInfo.title;

                    const image = document.createElement('img');
                    image.src = data.volumeInfo.imageLinks ? data.volumeInfo.imageLinks.thumbnail : 'default.jpg';
                    image.alt = `Couverture de ${data.volumeInfo.title}`;

                    const retourForm = document.createElement('form');
                    retourForm.className = "retourForm";
                    retourForm.method = "POST";
                    retourForm.action = "controller/pretController.php";

                    const inputIdPret = document.createElement('input');
                    inputIdPret.type = "hidden"; 
                    inputIdPret.name = "Id_Pret";
                    inputIdPret.value = livreElement.dataset.idPret;
                    console.log(inputIdPret.value);
                    retourForm.appendChild(inputIdPret);

                    const actionRetour = document.createElement('input');
                    actionRetour.type = "hidden";
                    actionRetour.name = "pret";
                    actionRetour.value = "supprimer";
                    retourForm.appendChild(actionRetour);

                    const bttRetour = document.createElement('button');
                    bttRetour.type = "submit";
                    bttRetour.textContent = "Retourner";
                    retourForm.appendChild(bttRetour);

                    detailsDiv.appendChild(titre);
                    detailsDiv.appendChild(image);
                    detailsDiv.appendChild(retourForm);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des détails du livre:', error);
            });
    });
});
