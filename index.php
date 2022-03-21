<?php

spl_autoload_register();
session_start();
if (isset($_SESSION['user_login']) && isset($_SESSION['user_id']))
{
    \classes\User::finishAuth($_SESSION['user_login'], (int)$_SESSION['user_id']);
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

\classes\Storages\Navigation::go($uri);