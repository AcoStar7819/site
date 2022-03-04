<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case "/news":
        require "./news.php";
        break;
    default:
        require "./main.php";
}