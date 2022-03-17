<?php

spl_autoload_register();

require_once('classes\controllers\render.php');

use function \classes\controllers\render;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case "/news":
        echo render('./Templates/layout.php', [
            'title' => 'Новости',
            'content' => render('./Templates/news.php'),
            'additionalNavigation' => render('./Templates/languageSelect.php')
        ]);
        break;
    default:
        echo render('./Templates/layout.php', [
            'title' => 'Форма',
            'content' => render('./Templates/main.php')
        ]);
}