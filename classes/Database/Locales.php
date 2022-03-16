<?php

namespace classes\Database;

/**
 * База данных locales
 */
class Locales extends \classes\Model
{
    protected string $table = "locales";
    protected array $columns = [
        "id",
        "names",
    ];
}