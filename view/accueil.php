<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <!-- Vous pouvez ajouter vos styles ou autre contenu ici -->
</head>
<body>
    <h1>Bienvenue sur la page d'accueil</h1>

    <div class ="formLogin">
        <form class="form1log" method="POST" action="controller/lecteurController.php">
            <div>
                <label for="Nom">Nom</label><br>
                <div class="input-wrapper">
                    <input type="text" placeholder="Nom" name="nom" class="input">
                </div>
            </div>
            <div>
                <label for="Prenom">Prenom</label><br>
                <div class="input-wrapper">
                    <input type="text" placeholder="Prenom" name="prenom" class="input">
                </div>
            </div>
            <div>
                <label for="Email">Email</label><br>
                <div class="input-wrapper">
                    <input type="email" placeholder="email" name="email" class="input">
                </div>
            </div>
            <div>
                <label for="MDP">Mot de passe</label><br>
                <div class="input-wrapper">
                    <input type="password" placeholder="Mot De Passe" name="mdp" class="input">
                </div>
            </div>
                <input type="hidden" name="lecteur" value="ajouter">
                <button class="log"><input type="submit" value="Inscription"></button>
        </form>

        <form class="form2log" method="POST" action="controller/lecteurController.php">
            <div>
                <label for="MDP">Email</label><br>
                <div class="input-wrapper">
                        <input type="email" placeholder="Email" name="email" class="input">
                </div>
            </div>
            <div>
                <label for="MDP">Mot de passe</label><br>
                <div class="input-wrapper">
                    <input name="mdp" placeholder="Mot De Passe" type="password" class="input">
                </div>
            </div>
                <input type="hidden" name="lecteur" value="connection">
                <button class="log"><input type="submit" value="Connection"></button>
        </form>
    </div>
</body>
</html>

<style>
    /* From Uiverse.io by adamgiebl */ 
.input-wrapper input {
  background-color: #eee;
  border: none;
  width: 90%;
  height: 30px;
  border-radius: 1rem;
  color: lightcoral;
  box-shadow: 0 0.4rem #dfd9d9;
  cursor: pointer;
  padding-left: 10px;
}


.input-wrapper input:focus {
  outline-color: lightcoral;
}

    body{
        background-color: linear-gradient(to bottom right, #F0F8FF, #CBC3E3);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .formLogin{
        display: flex;
        flex-direction: row;
        gap: 20px;
    }

    .form1log{
        display: flex;
        flex-direction: column;
        height: 300px;
        width: 300px;
        background-color: rgba(240, 248, 255, 0.1);
        gap: 10px;
        padding: 10px;
        border-radius: 20px;
        justify-content: center;
    }

    .form2log{
        display: flex;
        flex-direction: column;
        height: 300px;
        width: 300px;
        background-color: rgba(240, 248, 255, 0.1);
        gap: 10px;
        padding: 10px;
        border-radius: 20px;
        justify-content: center;
    }

    /* From Uiverse.io by portseif */ 
.log {
  background-color: #ffffff;
  border: 1px solid rgb(209, 213, 219);
  border-radius: 0.5rem;
  color: #111827;
  width: fit-content;
  line-height: 1.25rem;
  padding: 0.75rem 1rem;
  text-align: center;
  -webkit-box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  cursor: pointer;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  -webkit-user-select: none;
  -ms-touch-action: manipulation;
  touch-action: manipulation;
  margin-left: 100px;
  margin-top: 10px;
  text-align: center;
}

.log input{
    background-color: transparent;
    border: none;
}

.log:hover {
  background-color: #f9fafb;
}

.log:focus {
  outline: 2px solid rgba(0, 0, 0, 0.1);
  outline-offset: 2px;
}

.log:focus-visible {
  -webkit-box-shadow: none;
  box-shadow: none;
}


</style>