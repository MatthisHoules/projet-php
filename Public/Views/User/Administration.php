
        <!Doctype html>
        <html>
    <head>
        <title>Panel Admin</title>
        <head>
    <body>
    <div>
        <h3>Espace Admin</h3>
        <ul>
            <?php while($usersList->fetch()) {?>

                <li><?= $users['mail']?> | <?= $users['username']?> | <?= $users['first_name']?> | <?= $users['last_name']?> <a href="admin.php?id=<?= $users['user_id']?>">Gérer</a></li>
            <?php } ?>
        </ul>
        <?php
        if(isset($client_id)){?>
            <h3>Gérer : <?= $userInfo['username']?></h3>
            <?php if(isset($errorMessage)){?> <p style="color: red;"><?= $errorMessage?></p><?php } ?>
            <?php if(isset($successMessage)){?> <p style="color: green;"><?= $successMessage?></p><?php } ?>
            <div align="left">
                <form method="POST" action="" enctype="multipart/form-data">
                    <label for="username">Pseudo :</label>
                    <input type="text" name="username" placeholder="Pseudo" value="<?php echo $userInfo['username']; ?>" /><br /><br />
                    <label>Mail :</label>
                    <input type="email" name="email" placeholder="Mail" value="<?php echo $userInfo['mail']; ?>" /><br /><br />
                    <label>Mot de passe :</label>
                    <input type="password" name="mdp" placeholder="Mot de passe"/><br /><br />
                    <input type="submit" name="edit" value="Editer" />
                    <input type="submit" name="delete" value="Supprimer" />
                    <?php if($userInfo['user_status']== 0){?>
                        <input type="submit" name="ban" value="Désactiver" />
                    <?php }elseif ($userInfo['user_status']== 2) { ?>
                        <input type="submit" name="unban" value="Réactiver" />
                    <?php } ?>
                </form>
                <?php if(isset($msg)) { echo $msg; } ?>
            </div>
        <?php } ?>
    </div>
    </body>