<?php

/**
 * 
 *  @title : 
 *  @author :  
 *  @brief : 
 * 
 */

    $listStyles = ['category.css', 'blog.css'];
    $listJS = ['informationList.js', 'blog.js'];

    ob_start();
?>

<div id="followC" class="nodisplay">
    <div id="followingC" class="nodisplay">
        <div class="topF">
            Abonnements
            <button id="closeFollowingC" class="closeButton">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="listF">
            <?php 
            if (sizeof($user->getUserFollowing()) == 0) {
            ?>
            <p class="noF">
                Aucun abonnement.
            </p>
            <?php }
            foreach ($user->getUserFollowing() as $key => $value) { ?>
            <div class="itemF">
                <a href="http://localhost/php/blog?user=<?=$value->getUserFollow()->getUser_id()?>">
                    <?= ucfirst(strtolower($value->getUserFollow()->getFirst_name())).' '.ucfirst(strtolower($value->getUserFollow()->getLast_name())) ?>
                </a>
                <p class="dateFollow">
                    Depuis le <?= date('d/m/Y H:i:s', $value->getDate()) ?>
                </p>
            </div>
            <?php } ?>
        </div>
    </div>


    <div id="followerC" class="nodisplay">
        <div class="topF">
            Abonnés
            <button id="closeFollowerC" class="closeButton">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="listF">
        <?php 
            if (sizeof($user->getUserFollower()) == 0) {
        ?>
            <p class="noF">
                Aucun abonnés.
            </p>
        <?php 
            }
            foreach ($user->getUserFollower() as $key => $value) { ?>
            <div class="itemF">
                <a href="http://localhost/php/blog?user=<?=$value->getUserFollow()->getUser_id()?>">
                    <?= ucfirst(strtolower($value->getUserFollow()->getFirst_name())).' '.ucfirst(strtolower($value->getUserFollow()->getLast_name())) ?>
                </a>
                <p class="dateFollow">
                    Depuis le <?= date('d/m/Y H:i:s', $value->getDate()) ?>
                </p>
            </div>
        <?php 
            } 
        ?>
        </div>
    </div>
</div>

<main>
    <div class="categoryInformation">
        <h1 class="categoryName">
            <?= $user->getUsername() ?> <span> - Blog</span>
        </h1>
    </div>

    <div class="userContainer">
        <div class="leftContainer">
            <p class=item>
                <?= ucfirst(strtolower($user->getFirst_name())).' '.ucfirst(strtolower($user->getLast_name())) ?>
            </p>
        </div>
        <div class="rightContainer">
            <button id="followingB">
                <b><?= sizeof($user->getUserFollowing()) ?></b> abonnements
            </button>
            <button id="followerB">
                <b><?= sizeof($user->getUserFollower()) ?></b> abonnés
            </button>

            <form action="" method="post">
                <button type="submit" name="follow">
                    <?php
                        if ($user->isUserFollow($_GET['user'])) {
                    ?>
                    Se désabonner
                    <?php 
                        } else {
                    ?>
                    S'abonner
                    <?php   
                        }
                    ?>
                </button>
            </form>
        </div>
    </div>


    <div class="informationsList">
        <?php foreach ($user->getBlog() as $key => $info) { ?>
        <div class="information" id="<?=$key?>">
            <div class="topInfo">
                <div class="sourceInfo">
                    <?php
                        if ($info->getSource() == 'RSS') {
                    ?>
                        <i class="fas fa-rss"></i>
                    <?php
                        } else if ($info->getSource() == 'TWITTER') {
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
                        <?= $info->getDateWFormat()?>
                    </p>
                </div>

            </div>
            <h3 class="infoTitle">
                <?php
                    if ($info->getSource() == 'TWITTER') {
                        echo '@'.$info->getName();
                    } else {
                        echo $info->getName();
                    }
                ?>
            </h1>
            <p class="infoText">
                <?= $info->getValue()?> <br>
            </p>

            <?php
                if ($info->getSource() == 'RSS') {
            ?>
            <img class="informationArticle" src="<?=$info->getImg()?>" alt="">
            <?php
                }
            ?>

            <?php
                if ($info->getSource() == 'RSS') {
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
                        Ajouté au blog le <?= date('d/m/Y H:i:s', $info->getBlog()) ?>
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