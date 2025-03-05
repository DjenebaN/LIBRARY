<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/style/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Bibliothèque</title>
</head>
<body>

<header class="header">
</header>

<aside class="sidebar">
    <nav>
        <ul>
            <li>
                <a href="index.php?page=Accueil" 
                   class="<?php echo isset($_GET['page']) && $_GET['page'] == 'Accueil' ? 'active' : ''; ?>">
                   <i class="fas fa-home"></i> Accueil
                </a>
            </li>
            
            <?php if (isset($_SESSION['Id_Lecteur'])) { ?>
                <li>
                    <a href="index.php?page=compte&ID_Lecteur=<?php echo htmlspecialchars($_SESSION['Id_Lecteur']) ?>" 
                       class="<?php echo isset($_GET['page']) && $_GET['page'] == 'compte' ? 'active' : ''; ?>">
                       <i class="fas fa-user"></i> Mon Profil
                    </a>
                </li>
                <li>
                    <a href="index.php?page=logOut" 
                       class="<?php echo isset($_GET['page']) && $_GET['page'] == 'logOut' ? 'active' : ''; ?>">
                       <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </li>
            <?php } else { ?>
                <li>
                    <a href="index.php?page=logIn" 
                       class="<?php echo isset($_GET['page']) && $_GET['page'] == 'logIn' ? 'active' : ''; ?>">
                       <i class="fas fa-sign-in-alt"></i> Connexion
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</aside>


