<?php

/**
 * 
 *  @title : 
 *  @author :  
 *  @brief : 
 * 
 */

    $listStyles = ['admin.css'];
    $listJS = [];

    ob_start();
?>

<main>
    <h1>
        Partie administration
    </h1>
    <table>
        <thead>
            <tr>
                <td>
                    Pseudo
                </td>
                <td>
                    Rank
                </td>
                <td>
                    Statut
                </td>
                <td>
                    Action
                </td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $key => $value) { ?>
            <tr>
                <td>
                    <?=$value->getUsername()?>
                </td>
                <td>
                <?php if ($value->getRank() == 'user') {
                    echo ('Utilisateur');      
                }  else {
                    echo ('administrateur');   
                }?>
                </td>
                <td>
                <?php if ($value->getUser_status() == 1) {?>
                    <p class="green">
                        Actif
                    </p>
                <?php } else if ($value->getUser_status() == 2) { ?>
                    <p class="orange">
                        Désactivé
                    </p>
                <?php } else if ($value->getUser_status() == 3) {?>
                    <p class="red">
                        Banni
                    </p>
                <?php } else {?>
                    <p class="blue">
                        Non actif
                    </p>
                <?php }?>
                </td>
                <td class="actionC">
                    <form action="" method="post">
                        <input type="hidden" name="userid" value="<?=$value->getUser_id()?>">
                        <?php if ($value->getUser_status() == 1) { ?> 
                        <button type="submit" name="submit" value="ban">
                            <i class="fas fa-hammer"></i>
                            bannir
                        </button>
                        <button type="submit" name="submit" value="désactiver">
                            <i class="fas fa-ghost"></i>
                            Désactiver
                        </button>
                        <?php } else { ?>
                        <button type="submit" name="submit" value="activ">
                            <i class="fas fa-level-up-alt"></i>
                            Activer
                        </button>
                        <?php } ?>
                    </form>
                </td>
            </tr>

        <?php } ?>
        </tbody>

    </table>
</main>

<?php

    $content = ob_get_clean();

    require_once __DIR__.'/../template.php';


?>