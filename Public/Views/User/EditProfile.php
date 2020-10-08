<?php
/**
 *
 *  @title : Edit Profile
 *  @author :  Alison palatuik
 *  @brief : edit user profile page
 *
 */

    $listStyles = ['editProfile.css'];
    $listJS = [];

    ob_start();
 ?>
<main>
    <div>
        <h2>Edition du profil</h2>

        <div>
            <form method="POST" enctype="multipart/form-data">
                <div class="container">
                    <div class="inputT">
                        <label>Pseudo :</label>
                        <input type="text" name="newUsername" placeholder="Pseudo" value="" />
                    </div>
                    <input type="submit" name="action" value="Modifier le pseudo" /><br /><br />
                </div>

                <div class="container">
                    <div class="inputT">
                        <label>Mail :</label>
                        <input type="text" name="newMail" placeholder="Mail" />
                    </div>
                    <input type="submit" name="action" value="Modifier l'email" /><br /><br />
                </div>

                <div class="pwd">
                    <div class="inputT">
                        <label>Mot de passe :</label>
                        <input type="password" name="newPwd" placeholder="Mot de passe"/><br /><br />                
                    </div>
                    <div class="inputT">
                        <label>Confirmation - mot de passe :</label>
                        <input type="password" name="pwdVerif" placeholder="Confirmation du mot de passe" />
                    </div>
                    <input type="submit" name="action" value="Modifier le mot de passe" /><br /><br />
                </div>


            </form>
        </div>
    </div>
</main>

<?php
$content = ob_get_clean();
require_once __DIR__.'/../template.php';
?>