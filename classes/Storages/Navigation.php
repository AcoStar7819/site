<?php

namespace classes\Storages;

require_once('classes\controllers\render.php');
use function \classes\controllers\render;

class Navigation
{
    private static string $defaultFunction = 'render';
    private static string $defaultPage = '';
    private static array $pages = [
        // Основная страница
        '' => [
            'controller' => 'Main@render'
        ],

        // Новости
        'news' => [
            'controller' => 'News'
        ],

        // Тестовая страница
        'test' => [
            'test2' => [
                'controller' => 'News'
            ]
        ]
    ];

    /**
     * Отправка пользователя на страницу
     *
     * @param array|string $uri
     * @return void
     */
    public static function go(array|string $uri): void
    {
        if (gettype($uri) != "array")
        {
            $uri = trim($uri, '/');
            $uri = explode('/', $uri);
        }

        $target = '';
        $path = self::$pages;
        foreach ($uri as $u)
        {
            $u = strtolower($u);

            if (isset($path[$u]) && $u != 'controller')
            {
                $path = $path[$u];
                if (isset($path['controller']))
                {
                    $target = $path['controller'];
                }
            }
            else {
                self::go(self::$defaultPage);
                return;
            }
        }

        if ($target == '')
        {
            self::go(self::$defaultPage);
            return;
        }

        $function = self::$defaultFunction;
        if (strpos($target, '@'))
        {
            $arr = explode('@', $target);
            $target = $arr[0];
            $function = $arr[1];
        }
        $target = "\classes\Controllers\\" . $target;
        $target::$function();
    }
}