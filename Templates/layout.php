<!DOCTYPE html>
<?php
    if (!isset($additionalNavigation))
        $additionalNavigation = '';
?>
    <head>
        <link rel="stylesheet" href="../style.css">
        <title><?= $title; ?></title>
    </head>
    <body>
        <div class="navigation">
            <a href="/">Основная страница</a>
            <a href="../../news">Новости</a>
            <?= $additionalNavigation ?>
        </div>
        <div class="line">
            <?= $content; ?>
        </div>
        <script src="../script.js"></script>
    </body>
</html>
