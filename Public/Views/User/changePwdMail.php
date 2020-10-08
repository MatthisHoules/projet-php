<?php

$listStyles = ['sign.css'];
$listJS = ['sign.js'];

ob_start();

?>

<main>
    <img src="https://media.discordapp.net/attachments/688764933927731218/763474237818011659/gather.png?width=1443&height=356" alt="" class="signLogo">
    <a href="" class="backButton">
        <i class="fas fa-chevron-left"></i>
    </a>

    <form action="" method="POST">
        <p class="signTitle">
            Mot de passe oublié ?
        </p>

        <div class="inputContainer">
            <label for="mailInput">Adresse E-mail</label>
            <input type="email" name="mailInput" id="mailInput">
        </div>

        <div class="buttonContainer">
            <button type="submit" name="submit" value="submit">
                Changer mon mot de passe
            </button>
        </div>

    </form>
</main>


<?php
$content = ob_get_clean();
require_once __DIR__.'/../template.php';
?>