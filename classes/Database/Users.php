<?php

namespace classes\Database;

/**
 * База данных users
 */
class Users extends \classes\Model
{
    protected string $table = "users";
    protected array $columns = [
        "id",
        "login",
        "password"
    ];
}