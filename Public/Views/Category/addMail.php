<?php

/**
 * 
 *  @title : 
 *  @author :  
 *  @brief : 
 * 
 */

    $listStyles = ['category.css', 'addMail.css'];
    $listJS = [''];

    ob_start();
?>

<main>

    <div class="categoryInformation">
        <h1 class="categoryName">
            <?= $category->getName()?>
        </h1>
        <a class="editCategLink" href="/php/editCategory?category=<?=$category->getId()?>">
            <i class="fas fa-undo-alt"></i>
            Retour
        </a>
    </div>


    <h3>
        Ajout d'une source email
    </h3>
    <form action="" method="post">
        <div>
            <label for="mailType" class="label">
                Fournisseur adresse e-mail
            </label>
            <select required name="mailType" id="mailType" required>
                <option value="gmail">Gmail</option>
                <option value="icloud">ICloud</option>
                <option value="outlook">Outlook</option>
                <option value="yahoo">Yahoo</option>
            </select>
        </div>

        <div>
            <input type="email" required name="email" placeholder="Votre email">
            <input type="password" required name="password" placeholder="Mot de passe de votre compte email">
        </div>

        <p class="warning">
            Condition de selection des mails, <b>au moins une condition</b>.
        </p>

        <input type="text" name="authorFrom" placeholder="adresse mail de l'expéditeur">
        <input type="text" name="subjectFrom" placeholder="sujet des emails souhaités">

        <button type="submit" name="submit" class="submit" value="sourceMail">Ajouter la source email</button>
    </form>
</main>





<?php

    $content = ob_get_clean();

    require_once __DIR__.'/../template.php';


?>