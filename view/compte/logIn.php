<main class="main-content">


    <div class ="formLogin">
        <form class="form1log" method="POST" action="controller/lecteurController.php">
                <input name="nom" placeholder="Nom" type="text" required class="input">
                <input name="prenom" placeholder="Prenom" type="text" required class="input">
                <input name="email" placeholder="Email" type="email" required class="input">
                <input name="mdp" placeholder="Mot De Passe" type="password" required class="input">

                <input type="hidden" name="lecteur" value="ajouter">
                <input type="submit" value="ajout">
            </form>

            <form class="form2log" method="POST" action="controller/lecteurController.php">
                <input name="email" placeholder="Email" type="email" required class="input">
                <input name="mdp" placeholder="Mot De Passe" type="password" required class="input">

                <input type="hidden" name="lecteur" value="connection">
                <input type="submit" value="connect">
            </form>
    </div>
</main>
    
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/LIBRARY/view/commun/footer.php'; ?>
