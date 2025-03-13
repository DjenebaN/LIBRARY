<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/LIBRARY/view/style/style.css">
    <title>Document</title>
</head>
<body>

    <div class="side">
        <div class="bar">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                </svg>
            </div>
            <div class="profilPic">
                <div class="pic"><span class="dotProfile"><img src="view/style/pp.png" alt="Girl in a jacket"></span></div>
                <div class="name"><?php echo htmlspecialchars($_SESSION['nom']) . " " . htmlspecialchars($_SESSION['prenom'])?></div>
            </div>
            <div class="barLIste">
                <ul>
                    <li> <a href="index.php?page=livres"><div>Livres</div></a> </li>
                <?php if (isset($_SESSION['Id_Lecteur'])) { ?>
                    <li> <a href="index.php?page=prets&Id_Lecteur=<?php echo htmlspecialchars($_SESSION['Id_Lecteur'])?>"> <div>Mes Prets</div></a> </li>
                    <li> <a href="index.php?page=favoris&Id_Lecteur=<?php echo htmlspecialchars($_SESSION['Id_Lecteur'])?>"> <div>Mes Favs</div></a> </li>
                    <li> <a href="index.php?page=logOut"><div>Log Out</div></a> </li>
                <?php } else { ?>
                    <li> <a href="index.php?page=logIn"><div>Log In</div></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div> 
        <div class="sDot"></div>
        <div class="sLine"></div>
    </div>
    