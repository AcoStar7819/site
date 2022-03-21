<?php

namespace classes;

use \classes\Database\Users as Database;

class User
{
    static private Database $db;

    static private string|null $login;
    static private int|null $id;

    /**
     * Загрузка статичного класса
     *
     * @return void
     */
    static public function load(): void
    {
        self::$db = new Database();
    }

    /**
     * Регистрация нового пользователя
     *
     * @param string $login
     * @param string $pass
     * @return bool
     */
    static public function register(string $login, string $pass): bool
    {
        if (count(self::$db->where('login', $login)->select()->run()) > 0) {
            // Пользователь уже существует
            return false;
        }

        if (strlen($login) > 32 || strlen($pass) > 32) {
            // Слишком длинные строки
            return false;
        }

        // Создание пользователя
        $password = password_hash($pass, PASSWORD_BCRYPT);
        self::$db->insert([
            'login' => $login,
            'password' => $password,
        ])->run();

        self::finishAuth(
            $login,
            // ID новосозданного пользователя:
            self::$db->where('login', $login)->select(['id'])->run()[0]->id
        );
        return true;
    }

    /**
     * Авторизация пользователя
     *
     * @param string $login
     * @param string $pass
     * @return bool
     */
    static public function login(string $login, string $pass): bool
    {
        if (strlen($login) > 32 || strlen($pass) > 32) {
            // Слишком длинные строки
            return false;
        }

        $arr = self::$db->where('login', $login)->select([
            'id',
            'password'
        ])->run();
        if (count($arr) == 0) {
            // Пользователь не существует
            return false;
        }

        $hash = $arr[0]->password;
        if (!password_verify($pass, $hash)) {
            // Пароль не подошёл
            return false;
        }

        self::finishAuth($login, $arr[0]->id);
        return true;
    }

    /**
     * Деавторизация пользователя
     *
     * @return void
     */
    static public function logout(): void
    {
        self::$login = null;
        self::$id = null;
        session_destroy();
    }

    /**
     * Проверка авторизованности пользователя
     *
     * @return bool
     */
    static public function isLogged(): bool
    {
        if (isset(self::$login) && self::$login != "") {
            return true;
        }
        return false;
    }

    /**
     * Отмечаем сессию как уже залогиненную
     *
     * @param string $login
     * @param int $id
     * @return void
     */
    static public function finishAuth(string $login, int $id): void
    {
        self::$login = $login;
        self::$id = $id;

        if (!isset($_SESSION['user_login'])) {
            session_start();
        }

        $_SESSION['user_login'] = $login;
        $_SESSION['user_id'] = $id;
    }

    /**
     * Получение ID пользователя
     *
     * @return int|null
     */
    static public function getId(): int|null
    {
        if (self::isLogged()) {
            return self::$id;
        }
        return null;
    }

    /**
     * Получение логина пользователя
     *
     * @return string|null
     */
    static public function getLogin(): string|null
    {
        if (self::isLogged()) {
            return self::$login;
        }
        return null;
    }
}

User::load();