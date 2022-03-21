<?php

namespace classes\Controllers;

use \classes\User as User;

class Account
{
    public static function render()
    {
        $authError = 'false';
        if (isset($_POST["auth"]) && isset($_POST["login"]) && isset($_POST["password"])) {
            $auth = (int)$_POST["auth"];
            $login = $_POST["login"];
            $password = $_POST["password"];

            if ($auth == 0)
            {
                if (!User::login($login, $password))
                {
                    $authError = 'true';
                }
            } else {
                if (!User::register($login, $password))
                {
                    $authError = 'true';
                }
            }
        } else if (isset($_POST["logout"])) {
            User::logout();
        }

        $content = '';
        if (User::isLogged()) {
            $content = render('././Templates/account.php', [
                'login' => User::getLogin(),
                'id' => User::getId()
            ]);
        } else {
            $content = render('././Templates/auth.php', [
                'authError' => $authError
            ]);
        }

        echo render('././Templates/layout.php', [
            'title' => 'Аккаунт',
            'content' => $content
        ]);
    }
}