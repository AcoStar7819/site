<?php

require_once "classes/Model.php";

class NewsTextDatabase extends Model
{
    protected $table = "news_text";
    protected $columns = [
      "id",
      "news_id",
      "locale_id",
      "title",
      "text",
    ];
}