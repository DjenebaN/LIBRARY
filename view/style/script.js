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
                unLivre.className = "unLivre";

                const Droite = document.createElement('div');
                Droite.className = "Droite";

                const Gauche = document.createElement('div');
                Gauche.className = "Gauche";

                const miniTitre = document.createElement('p');
                miniTitre.className = "miniTitre";
                miniTitre.textContent = (livre.volumeInfo.title ? livre.volumeInfo.title.toUpperCase() : "Inconnu");
                Droite.appendChild(miniTitre);

                const AuteurLivre = document.createElement('p');
                AuteurLivre.className = "AuteurLivre";
                AuteurLivre.textContent = (livre.volumeInfo.authors ? livre.volumeInfo.authors.join(", ") : "Inconnu");
                Droite.appendChild(AuteurLivre);


                const miniDate = document.createElement('p');
                miniDate.className = "miniDate";
                miniDate.textContent = (livre.volumeInfo.publishedDate || "Inconnue");
                Droite.appendChild(miniDate);

                const miniDescription = document.createElement('p');
                miniDescription.className = "miniDescription";
                miniDescription.textContent = (livre.volumeInfo.description || "Aucune description disponible.");
                Droite.appendChild(miniDescription);

                if (livre.volumeInfo.imageLinks && livre.volumeInfo.imageLinks.thumbnail) {
                    const miniLivre = document.createElement('img');
                    miniLivre.className = "miniLivre";
                    miniLivre.src = livre.volumeInfo.imageLinks.thumbnail;
                    miniLivre.alt = `Couverture de ${livre.volumeInfo.title}`;
                    Gauche.appendChild(miniLivre);
                }

                const boutonVoir = document.createElement('button');
                boutonVoir.className = "buttonVoir";
                boutonVoir.textContent = "Voir";
                boutonVoir.onclick = function() {
                    afficherDetails(livre);
                };
                Droite.appendChild(boutonVoir);

                unLivre.appendChild(Gauche);
                unLivre.appendChild(Droite);

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
    details.innerHTML = '';

    const GauchePlus = document.createElement('div');
    GauchePlus.className = "GauchePlus";

    const DroitePlus = document.createElement('div');
    DroitePlus.className = "DroitePlus";

    const BullesPlus = document.createElement('div');
    BullesPlus.className = "BullesPlus";

    const ul = document.createElement('ul');

    const TitrePlus = document.createElement('h1');
    TitrePlus.className = "TitrePlus";
    TitrePlus.textContent = livre.volumeInfo.title;

    const AuteurPlus = document.createElement('div');
    AuteurPlus.className = "AuteurPlus";
    AuteurPlus.textContent = (livre.volumeInfo.authors ? livre.volumeInfo.authors.join(", ") : "Inconnu");

    const ResumePlus = document.createElement('div');
    ResumePlus.className = "ResumePlus";
    ResumePlus.textContent = (livre.volumeInfo.description || "Aucune description disponible.");

    const Rate = document.createElement('li');
    Rate.textContent = (livre.volumeInfo.averageRating || "Aucune description disponible.");

    const DatePlus = document.createElement('li');
    DatePlus.textContent = (livre.volumeInfo.publishedDate || "Inconnue");

    const imgPlus = document.createElement('img'); // Doit être une image
    imgPlus.className = "imgPlus";
    imgPlus.src = livre.volumeInfo.imageLinks ? livre.volumeInfo.imageLinks.thumbnail : 'default.jpg';
    imgPlus.alt = `Couverture de ${livre.volumeInfo.title}`;

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
    bttPret.className = "bttPret";
    bttPret.type = "submit";
    bttPret.textContent = "Emprunter";
    
    empruntForm.appendChild(bttPret);

    const favForm = document.createElement('form');
    favForm.className = "empruntForm";
    favForm.method = "POST";
    favForm.action = "controller/favController.php";

    // Créer de nouveaux inputs pour le formulaire favoris pour éviter le conflit
    const Id_LecteurInputFav = document.createElement('input');
    Id_LecteurInputFav.type = "hidden";
    Id_LecteurInputFav.name = "Id_Lecteur";
    Id_LecteurInputFav.value = Id_Lecteur;
    favForm.appendChild(Id_LecteurInputFav);

    const Id_API_Fav = document.createElement('input');
    Id_API_Fav.type = "hidden";
    Id_API_Fav.name = "Id_API";
    Id_API_Fav.value = livre.id;
    favForm.appendChild(Id_API_Fav);

    const actionFav = document.createElement('input');
    actionFav.type = "hidden";
    actionFav.name = "fav";
    actionFav.value = "ajouter";
    favForm.appendChild(actionFav);

    const bttFav = document.createElement('button');
    bttFav.className = "bttFav";
    bttFav.type = "submit";
    bttFav.textContent = " ♥︎ ";
    favForm.appendChild(bttFav);

    const favLi = document.createElement('li');
    favLi.appendChild(favForm);
    
    ul.appendChild(Rate);
    ul.appendChild(DatePlus);
    ul.appendChild(favLi);

    BullesPlus.appendChild(ul);

    //ajout a gauche
    GauchePlus.appendChild(TitrePlus);
    GauchePlus.appendChild(AuteurPlus);
    GauchePlus.appendChild(BullesPlus);
    GauchePlus.appendChild(ResumePlus);
    GauchePlus.appendChild(empruntForm);

    //ajout a droite
    DroitePlus.appendChild(imgPlus);

    //ajout a detail
    details.appendChild(GauchePlus);
    details.appendChild(DroitePlus);
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

                    const titre = document.createElement('p');
                    titre.textContent = data.volumeInfo.title;

                    const image = document.createElement('img');
                    image.src = data.volumeInfo.imageLinks ? data.volumeInfo.imageLinks.thumbnail : '/view/style/default.jpg';
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
                    bttRetour.className = "log";
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

document.addEventListener('DOMContentLoaded', function () {
    const favoris = document.querySelectorAll('.favori'); // Changer la classe cible

    favoris.forEach(function (favoriElement) {
        const idAPI = favoriElement.getAttribute('data-id-api');

        fetch(`https://www.googleapis.com/books/v1/volumes/${idAPI}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Livre favori non trouvé');
                } else {
                    const detailsDiv = favoriElement.querySelector('.details-favori');
                    detailsDiv.innerHTML = '';

                    const titre = document.createElement('p');
                    titre.textContent = data.volumeInfo.title;

                    const image = document.createElement('img');
                    image.src = data.volumeInfo.imageLinks ? data.volumeInfo.imageLinks.thumbnail : 'default.jpg';
                    image.alt = `Couverture de ${data.volumeInfo.title}`;

                    // Formulaire pour supprimer le favori
                    const supprimerForm = document.createElement('form');
                    supprimerForm.className = "supprimerForm";
                    supprimerForm.method = "POST";
                    supprimerForm.action = "controller/favController.php";

                    const inputIdFav = document.createElement('input');
                    inputIdFav.type = "hidden";
                    inputIdFav.name = "Id_Fav";
                    inputIdFav.value = favoriElement.dataset.idFav;
                    supprimerForm.appendChild(inputIdFav);

                    const actionSupprimer = document.createElement('input');
                    actionSupprimer.type = "hidden";
                    actionSupprimer.name = "fav";
                    actionSupprimer.value = "supprimer";
                    supprimerForm.appendChild(actionSupprimer);

                    const bttSupprimer = document.createElement('button');
                    bttSupprimer.className = "log";
                    bttSupprimer.type = "submit";
                    bttSupprimer.textContent = "Supprimer des favoris";
                    supprimerForm.appendChild(bttSupprimer);

                    detailsDiv.appendChild(titre);
                    detailsDiv.appendChild(image);
                    detailsDiv.appendChild(supprimerForm);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des détails du livre favori:', error);
            });
    });
});

