<?php

namespace classes\Controllers;

use \classes\User as User;

class Account
{
    public static function render()
    {
        if (isset($_POST["register"]) && isset($_POST["login"]) && isset($_POST["password"])) {
            $reg = (int)$_POST["register"];
            $login = $_POST["login"];
            $password = $_POST["password"];
            //  TODO: login register возвращают bool, говорить пользователю результат
            if ($reg == 0)
            {
                User::login($login, $password);
            } else {
                User::register($login, $password);
            }
        }

        $content = '';
        if (User::isLogged()) {
            $content = render('././Templates/account.php', [
                'login' => 'логин',
                'id' => 'id'
            ]);
        } else {
            $content = render('././Templates/auth.php', []);
        }

        echo render('././Templates/layout.php', [
            'title' => 'Аккаунт',
            'content' => $content
        ]);
    }
}