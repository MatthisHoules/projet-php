<?php

/**
 * 
 *  @title : 
 *  @author :  
 *  @brief : 
 * 
 */

    $listStyles = ['category.css', 'editCateg.css'];
    $listJS = ['informationList.js'];

    ob_start();
?>

<main>
    <div class="categoryInformation">
        <h1 class="categoryName">
            <?= $category->getName()?>
        </h1>

        <a class="editCategLink" href="/php/category?category=<?=$category->getId()?>">
            <i class="fas fa-undo-alt"></i>
            Retour
        </a>
    </div>

    <div class="listSources">
        <h3>
            Liste des sources 
        </h3>

        <div class="sourceList">
        <?php foreach ($category->getListSources() as $key => $source) { ?>
            <div class="list">
                <div class="left">
                    <p class="listTitle">
                        <?php
                            if ($source->getFrom() == 'RSS') {
                        ?>
                            <i class="fas fa-rss"></i>
                        <?php
                            } else if ($source->getFrom() == 'TWITTER') {
                        ?>
                            <i class="fab fa-twitter"></i>
                        <?php
                            } else {
                        ?>
                            <i class="far fa-envelope"></i>
                        <?php 
                            } 
                        ?>

                        <?=$source->getName()?>
                    </p>    

                    <p class="listValue">
                        <?= $source->getValue() ?>
                    </p>
                </div>

                <form action="" method="post">
                    <input type="hidden" name="id" value="<?=$source->getId()?>">
                    <button type="submit" name="deleteSource" value="delete" class="deleteSourceButton">
                        <i class="far fa-trash-alt"></i> Supprimer la source
                    </button>
                </form>
        
            </div>

        <?php } ?>
        </div>

        <div class="addSourceC">
            <h3>
                Ajouter une source Twitter
            </h3>
            <form action="" method="post">
                <div class="twtTV">
                    <select name="twitterType" id="" class="twitterType">
                        <option value="hashtag">
                            #
                        </option>
                        <option value="account">
                            @
                        </option>
                    </select>
                    <input type="text" name="value" class="valueAddTwt" placeholder="valeur">
                </div>
                <div>
                    <input type="text" class="nameAddtwt" name="name" class="sourceName" placeholder="nom de la source">
                </div>
                <div>
                    <button type="submit" name="twitterSource" class="twitteradds" value="submit">
                        Ajouter la source
                    </button>
                </div>
            </form>
        </div>
        <div class="addSourceC">
            <h3>
                Ajouter une source RSS
            </h3>
            <form action="" method="post">
                <div>
                    <input type="text" class="rssItem" name="value" placeholder="URL">
                </div>
                <div>
                    <input type="text" class="rssItem" name="name" placeholder="Nom">
                </div>
                <div>
                    <button class="rssbtn" type="submit" name="rssSource">
                        Ajouter la source
                    </button>
                </div>
            </form>
        </div>
        
        <div class="addSourceMail">
            <a href="/php/addmail?category=<?=$_GET['category']?>">
                Ajouter une source mail
            </a>
        </div>

        <div class="deleteSourceC">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?=$_GET['category']?>">
                <button type="submit" name="deleteCateg" class="deleteCateg" value="submit">
                    <i class="far fa-trash-alt"></i> Supprimer la catégorie
                </button>
            </form>
        </div>
    </div>

</main>



<?php

    $content = ob_get_clean();

    require_once __DIR__.'/../template.php';


?>