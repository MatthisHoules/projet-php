<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gather</title>

    <link rel="stylesheet" href="./Public/assets/css/template.css">
    <script src="https://kit.fontawesome.com/b18ab37082.js" crossorigin="anonymous"></script>

    <?php foreach ($listStyles as $key => $value) { ?>
        <link rel="stylesheet" href="./Public/assets/css/<?=$value?>">
    <?php } ?>


    <?php foreach ($listJS as $key => $value) { ?>
        <script src="./Public/assets/js/<?= $value ?>" defer></script>

    <?php } ?>

</head>
<body>
    
    <?= $content ?>

</body>
</html>