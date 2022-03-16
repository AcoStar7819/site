<?php
spl_autoload_register();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case "/news":
        require_once "./classes/Templates/news.php";
        break;
    default:
        require_once "./classes/Templates/main.php";
}