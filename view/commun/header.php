<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/style/style.css" />
    <title>Document</title>
</head>
<body>

<h1> Header</h1>

<nav>

    <ul>
        <?php if (isset($_SESSION['Id_Lecteur'])) { ?>
                <li> <a href="index.php?page=Accueil"> Accueil </a> </li>
                <li> <a href="index.php?page=compte&ID_Lecteur=<?php echo htmlspecialchars($_SESSION['Id_Lecteur'])?>"> Mon Profil</a> </li>
                <li> <a href="index.php?page=logOut"> Log out</a> </li>
        <?php 
            }else {?>
                <li> <a href="index.php?page=Accueil"> Les livres </a> </li>
                <li> <a href="index.php?page=Accueil"> Log In </a> </li>
            <?php }
            ?>
    </ul>
</nav>

