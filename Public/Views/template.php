<?php
    if (isset($_SESSION['popup'])) {

        echo $_SESSION['popup']->display();
        unset($_SESSION['popup']);
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gather</title>

    <link rel="stylesheet" href="./Public/assets/css/template.css">
    <link rel="stylesheet" href="./Public/assets/css/popup.css">
    <script src="https://kit.fontawesome.com/b18ab37082.js" crossorigin="anonymous"></script>

    <?php foreach ($listStyles as $key => $value) { ?>
        <link rel="stylesheet" href="./Public/assets/css/<?=$value?>">
    <?php } ?>


    <script src="./Public/assets/js/popup.js" defer></script>
    <script src="./Public/assets/js/template.js" defer></script>
    <?php foreach ($listJS as $key => $value) { ?>
        <script src="./Public/assets/js/<?= $value ?>" defer></script>

    <?php } ?>

</head>
<body>
    <header>
        <img src="https://media.discordapp.net/attachments/688764933927731218/763474237818011659/gather.png?width=1443&height=356" alt="gather" class="headerlogo">
    
        <button id="navbarBtn">
            <i class="fas fa-bars"></i>
        </button>
    </header>


    <div class="navbarContainer" id="navbarC">
        <button id="closeBtn">
            <i class="fas fa-times"></i>
        </button>
        <nav class="navbar">
            <?php if (empty($_SESSION['user'])) {?>
            <a href="" class="navLink">
                <i class="fas fa-sign-in-alt"></i>
                Connexion
            </a>
            <a href="" class="navLink">
                <i class="fas fa-user-plus"></i>                
                Inscription
            </a>
            <?php } else {?>

            <a href="" class="navLink">
                <i class="far fa-address-card"></i>
                Profil
            </a>
            <a href="" class="navLink">
                    <i class="fas fa-sign-out-alt"></i>
                Déconnexion
            </a>

            <p class="navTitle">
                Categories
            </p>
            <?php foreach($_SESSION['user']->getUserCategories() as $key => $categ) {?>
            <a href="" class="navLink subLink">
                <i class="fas fa-chevron-right"></i>
                <?= $categ->getName() ?>
            </a>
            <?php } ?>
            <a href="" class="navLink categLink">
                <i class="fas fa-folder-plus"></i>   
                Catégorie
            </a>

            <?php if($_SESSION['user']->getRank() == 'admin') {?>
                <a href="" class="navLink">
                    <i class="fas fa-users-cog"></i>   
                    Administration
                </a>

            <?php }} ?>
        </nav>
    </div>

    
    <?= $content ?>

</body>
</html>