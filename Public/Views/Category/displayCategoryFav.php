<?php

/**
 * 
 *  @title : 
 *  @author :  
 *  @brief : 
 * 
 */

    $listStyles = ['category.css'];
    $listJS = ['informationList.js'];

    ob_start();
?>

<main>
    <div class="categoryInformation">
        <h1 class="categoryName">
            <?= $category->getName() ?> <span> - Favoris</span>
        </h1>
        <a class="editCategLink" href="/php/editCategory?category=<?=$category->getId()?>">
            <i class="fas fa-cog"></i>
            Modifier la catégorie
        </a>
    </div>

    <div class="categoryLinksC">
        <a href="/php/category?category=<?=$_GET['category']?>" class="categoryL"><i class="fas fa-bullhorn"></i> Flash Infos</a>
        <a href="/php/fav?category=<?=$_GET['category']?>" class="categoryL"><i class="fas fa-heart"></i> Favoris</a>
    </div>


    <div class="informationsList">
        <?php foreach ($category->getListInformations() as $key => $info) { ?>
        <div class="information" id="<?=$key?>">
            <div class="topInfo">
                <div class="sourceInfo">
                    <?php
                        if ($info->getSource()->getFrom() == 'RSS') {
                    ?>
                        <i class="fas fa-rss"></i>
                    <?php
                        } else if ($info->getSource()->getFrom() == 'TWITTER') {
                    ?>
                        <i class="fab fa-twitter"></i>
                    <?php
                        } else {
                    ?>
                        <i class="far fa-envelope"></i>
                    <?php
                        }
                    ?>
                    <p class="sourcefromC">
                        <?= $info->getSource()->getName()?> <br>
                        <?= $info->getDateWFormat()?>
                    </p>
                </div>

                <div class="shareC">
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?=$info->getId()?>">
                        <button type="submit" class="submitP" name="submit" value="fav"><i class="fas fa-heart-broken"></i><span>Favoris</span></button>
                    </form>
                </div>

            </div>
            <a class="infoTitle" href="http://localhost/php/article?article=<?=$info->getId()?>">
                <?php
                    if ($info->getSource()->getFrom() == 'TWITTER') {
                        echo '@'.$info->getName();
                    } else {
                        echo $info->getName();
                    }
                    ?>
            </a>
            <p class="infoText">
                <?= $info->getValue()?> <br>
            </p>

            <?php
                if ($info->getSource()->getFrom() == 'RSS') {
            ?>
            <a target="_blank" class="linkInfo" href="<?=$info->getDetails()?>">Accéder à l'article <i class="fas fa-angle-right"></i></a>
            <?php 
                } 
            ?>
            <div class="bottomArticle">
                <div class="shareC">
                    <i class="fas fa-share-alt"></i>
                    <p class="linkShare">
                        http://localhost/php/article?article=<?=$info->getId()?>
                    </p>
                </div>
                <div class="sinceC">
                    <i class="far fa-heart"></i>
                    <p>
                        Favoris depuis le <?= date('d/m/Y H:i:s', $info->getFav()) ?>
                    </p>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>
    <div class="moreButtonC">
        <button id="moreButton">
            <span>
                Voir plus <i class="fas fa-search-plus"></i>
            </span>
            <span id="nbArticleR">
                
            </span>
        </button>
    </div>
</main>



<?php

    $content = ob_get_clean();

    require_once __DIR__.'/../template.php';


?>