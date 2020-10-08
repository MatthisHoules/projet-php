<?php

$listStyles = ['sign.css'];
$listJS = ['sign.js'];

ob_start();

?>

<main>
    <!-- <img src="./Public/assets/images/amouvLogoWhite.svg" alt="" class="signLogo"> -->

    <a href="" class="backButton">
        <i class="fas fa-chevron-left"></i>
    </a>
    <form action="" method="POST">
        <p class="signTitle">
            Connectez-vous
        </p>

        <div class="inputContainer">
            <label for="mailInput">Adresse E-mail</label>
            <input type="email" name="mailInput" placeholder="ex : bernard.delpas@gmail.com" id="mailInput">
        </div>

        <div class="inputContainer">
            <label for="pwdInput">Mot de passe</label>
            <div class="pwdInput">
                <input type="password" name="pwdInput" placeholder="Mot de passe" id="pwdInput">
                <button class="pwdTrigger" data-toggle="pwdInput" type="button">
                    <i class="far fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="buttonContainer">
            <button type="submit" name="submit" value="submit">
                Connexion
            </button>
        </div>

    </form>
    <p><a class="link" href="SignUp.php">Pas de compte ? s'inscrire</a></p>
    <p><a class="link" href="SignUp.php">Mot de passe oublié ?</a></p>
</main>


<?php
$content = ob_get_clean();
require_once __DIR__.'/../template.php';
?>