<?php

spl_autoload_register();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

\classes\Storages\Navigation::go($uri);