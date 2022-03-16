<?php

require_once "classes/Model.php";

class LocalesDatabase extends Model
{
    protected $table = "locales";
    protected $columns = [
        "id",
        "names",
    ];
}