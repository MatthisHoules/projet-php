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

<div class="UserInformation">
<?= $_SESSION['user']->getUsername() ?> <br>
<?= $_SESSION['user']->getFirst_name() ?> <?= $_SESSION['user']->getLast_name()?> <br>
<?= $_SESSION['user']->getMail() ?> <br>
<?= date('d/m/Y H:i:s', $_SESSION['user']->getDate());?>
</div>




<?php

    $content = ob_get_clean();

    require_once __DIR__.'/../template.php';


?>