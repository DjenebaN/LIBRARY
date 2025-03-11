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
            <div class="logo"></div>
            <div class="profilPic">
                <div class="pic">aaa</div>
                <div class="name">aaa</div>
            </div>
            <div class="barLIste">
                <ul>
                    <li> <a href="index.php?page=Accueil">Livres</a> </li>
                <?php if (isset($_SESSION['Id_Lecteur'])) { ?>
                    <li> <a href="index.php?page=compte&Id_Lecteur=<?php echo htmlspecialchars($_SESSION['Id_Lecteur'])?>"> Mon Profil</a> </li>
                    <li> <a href="index.php?page=logOut">Log Out</a> </li>
                <?php } else { ?>
                    <li> <a href="index.php?page=logIn">Log In</a> </li>
                    <?php } ?>
                    <li class="compteLi">#</li>
                </ul>
            </div>
            <div class="sns">aaa</div>
        </div> 
        <div class="sDot"></div>
        <div class="sLine"></div>
    </div>
    