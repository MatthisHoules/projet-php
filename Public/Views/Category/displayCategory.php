<?php

/**
 * 
 *  @title : 
 *  @author :  
 *  @brief : 
 * 
 */

    $listStyles = ['category.css'];
    $listJS = [];

    ob_start();
?>

<main>
    <div class="categoryInformation">
        <?= $category->getCategory_name()?> <br>
        
        <?php
            $listSources = $category->getListSources();
            for ($i = 0; $i < sizeof($listSources); ++$i) {
        ?>
        <div class="sourceL">
            <p><?=$listSources[$i]->getName()?>
            <?=$listSources[$i]->getValue()?></p>
        </div>
        <?php
            }
        ?>
    </div>

    <div class="informationsList">
        <?php foreach ($listInformations as $key => $info) { ?>
        <div class="information">
            <div class="topInfo">
            
            </div>
            <h3><?= $info->getName()?> <br></h1>
            <p>
                <?= $info->getValue()?> <br>
            </p>

            <?php
                if ($info->getSource()->getFrom() == 'RSS') {
            ?>
            <img class="informationArticle" src="<?=$info->getImg()?>" alt="">
            <?php
                }
            ?>

            <a class="linkInfo" href="<?=$info->getDetails()?>">Acceder à l'article</a>
        </div>
        <hr>
        <?php } ?>
    </div>
</main>



<?php

    $content = ob_get_clean();

    require_once __DIR__.'/../template.php';


?>