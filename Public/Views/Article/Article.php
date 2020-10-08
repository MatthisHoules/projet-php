<?php

/**
 * 
 *  @title : Article

 *  @brief : article view 
 * 
 */

    $listStyles = ['category.css'];
    $listJS = ['informationList.js'];

    ob_start();
?>

<main>
    <div class="categoryInformation">
        <h1 class="categoryName">
            Article
        </h1>
    </div>

    <div class="informationsList">
        <div class="information">
            <div class="topInfo">
                <div class="sourceInfo">
                    <?php
                        if ($article->getSource() == 'RSS') {
                    ?>
                        <i class="fas fa-rss"></i>
                    <?php
                        } else if ($article->getSource() == 'TWITTER') {
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
                        <?= $article->getDateWFormat()?>
                    </p>
                </div>

            </div>
            <h3 class="infoTitle">
                <?php
                    if ($article->getSource() == 'TWITTER') {
                        echo '@'.$article->getName();
                    } else {
                        echo $article->getName();
                    }
                ?>
            </h1>
            <?php
                if ($article->getSource() == 'RSS') {
            ?>
            <p>
                <?= $article->getImg()?> <br>
            </p>

            <?php
                } else {
            ?>
            <p class="infoText">
                <?= $article->getValue()?> <br>
            </p>
            <?php    
                }
            ?>

            <?php
                if ($article->getSource() == 'RSS') {
            ?>
            <a target="_blank" class="linkInfo" href="<?=$article->getDetails()?>">Accéder à l'article <i class="fas fa-angle-right"></i></a>
            <?php 
                } 
            ?>

            <div class="bottomArticle">
                <div>
                    <i class="fas fa-share-alt"></i>
                    <p class="linkShare">
                        http://localhost/php/article?article=<?=$article->getId()?>
                    </p>
                </div>
            </div>
        </div>
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