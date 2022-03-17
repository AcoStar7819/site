<?php

namespace classes\Controllers;

/**
 * Рендер шаблона
 *
 * @param $template
 * @param array $params
 * @return string
 */
function render($template, array $params = []): string
{
    ob_start();
    extract($params);
    require($template);
    return ob_get_clean();
}