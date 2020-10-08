<?php

/**
 * 
 *  @title createCategory.php 
 *  @brief  
 * 
 */

    $listStyles = [];
    $listJS = [];

    ob_start();
?>

<main>
    <div class="createCategoryC">
        <h3>
            Crée une nouvelle catégorie
        </h3>

        <form action="" method="post">
            <input type="text" required name="categName" placeholder="nom de la catégorie">
            <button type="submit" name="submit" value="submit">
                <i class="fas fa-folder-plus"></i> Créer la catégorie
            </button>
        </form>
    </div>
</main>



<?php

    $content = ob_get_clean();

    require_once __DIR__.'/../template.php';


?>