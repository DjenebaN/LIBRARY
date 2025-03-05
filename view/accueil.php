
    <form method="POST" action="controller/lecteurController.php">
        <input name="nom" placeholder="Nom" type="text" required class="input">
        <input name="prenom" placeholder="Prenom" type="text" required class="input">
        <input name="email" placeholder="Email" type="email" required class="input">
        <input name="mdp" placeholder="Mot De Passe" type="password" required class="input">
        <input name="telephone" placeholder="Telephone" type="text" required class="input">
        <input name="adresse" placeholder="Adresse" type="text" required class="input">
        <input name="cp" placeholder="CP" type="text" required class="input">
        <input name="ville" placeholder="Ville" type="text" required class="input">

        <input type="hidden" name="lecteur" value="ajouter">
        <input type="submit" value="ajout">
    </form>

    <form method="POST" action="controller/lecteurController.php">
        <input name="email" placeholder="Email" type="email" required class="input">
        <input name="mdp" placeholder="Mot De Passe" type="password" required class="input">

        <input type="hidden" name="lecteur" value="connection">
        <input type="submit" value="connect">
    </form>

    <div id="Search"> 
        <form id="SearchForm" class="wrap" method="POST" onsubmit="Click(event)">
            <input id="bar" name="search" type="text" placeholder="Entrez un livre">
            <button id="SearchButton" type="submit">SEARCH</button>
        </form>
    </div>

    <div id="Resultat">
        <div id="formContainer" data-etat="<?php echo $etatLivre; ?>"></div>
    </div>

    
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/commun/footer.php'; ?>
