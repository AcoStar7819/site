<?php
$cfg = require "config.php";

class NewsDatabase
{
    private $connection;

    public function __construct()
    {
        global $cfg;

        $this->$connection = new mysqli($cfg["DB_HOST"], $cfg["DB_USERNAME"], $cfg["DB_PASSWORD"]);
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $this->$connection->query("CREATE DATABASE IF NOT EXISTS `site`;");
        $this->$connection->close();

        $this->$connection = new mysqli($cfg["DB_HOST"], $cfg["DB_USERNAME"], $cfg["DB_PASSWORD"], "site");
        $this->$connection->query("
            CREATE TABLE IF NOT EXISTS `site`.`news` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` TINYTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `text` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`) USING BTREE
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB
            ;
        ");
    }

    public function addNews(string $title, string $text)
    {
        $this->$connection->query("INSERT INTO `site`.`news` (`title`, `text`) VALUES ('{$title}', '{$text}');", MYSQLI_ASYNC);
    }

    public function getNews(int $page = 1)
    {
        $offset = ($page - 1) * 6;
        $result = $this->$connection->query("
            SELECT * FROM (
                SELECT title, text, UNIX_TIMESTAMP(date) as date FROM `site`.`news` LIMIT 6 OFFSET {$offset}
            ) AS `page` ORDER BY `page`.`date` DESC;");
        if ($result->num_rows > 0)
        {
            return $result;
        } else {
            return NULL;
        }
    }
}