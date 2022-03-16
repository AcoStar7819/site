<?php

namespace classes\Database;

/**
 * База данных news_text
 */
class NewsText extends \classes\Model
{
    protected string $table = "news_text";
    protected array $columns = [
      "id",
      "news_id",
      "locale_id",
      "title",
      "text",
    ];
}