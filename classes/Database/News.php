<?php

namespace classes\Database;

/**
 * База данных news
 */
class News extends \classes\Model
{
    protected string $table = "news";
    protected array $columns = [
        "id",
        "date",
    ];
}