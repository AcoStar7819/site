<?php

require_once "classes/Model.php";

class NewsDatabase extends Model
{
    protected $table = "news";
    protected $columns = [
        "id",
        "date",
    ];
}