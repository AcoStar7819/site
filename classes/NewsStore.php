<?php

include('./classes/LocalesStore.php');
include('./classes/Date.php');
$cfg = require "config.php";

class NewsData
{
    private $id;
    private $title;
    private $text;
    private $date;

    public function __construct(int $id, string $title, string $text, int $date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->date = Date::getFormattedDate($date, true);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}

class NewsStore
{
    private $connection;

    public function __construct()
    {
        global $cfg;

        $this->connection = new mysqli($cfg["DB_HOST"], $cfg["DB_USERNAME"], $cfg["DB_PASSWORD"], "site");
    }

    public function addNews(string $title, string $text, int $localeId = 1, int $newsId = 0): bool
    {
        $title = $this->connection->real_escape_string($title);
        $text = $this->connection->real_escape_string($text);

        //  Создание новой записи в таблице с новостями
        if ($newsId == 0) {
            $this->connection->query(
                "INSERT INTO `news` () VALUES ();"
            );

            $result = $this->connection->query(
                "SELECT MAX(id) as id FROM news;"
            );

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $newsId = $row["id"];
            }
        }

        if (!LocalesStore::isLocaleExists($localeId)) {
            return false;
        }

        $this->connection->query(
            "INSERT INTO `news_text` (`news_id`, `locale_id`, `title`, `text`) VALUES ('{$newsId}', '{$localeId}', '{$title}', '{$text}');",
            MYSQLI_ASYNC
        );

        return true;
    }

    public function getNews(int $page = 1, int $localeId = 1)
    {
        if (!LocalesStore::isLocaleExists($localeId)) {
            return null;
        }

        $offset = ($page - 1) * 6;
        $result = $this->connection->query(
            "SELECT id, UNIX_TIMESTAMP(date) as date FROM `news` ORDER BY `date` DESC LIMIT 6 OFFSET {$offset};"
        );

        $news = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $newsTextResult = $this->connection->query(
                    "SELECT title, text FROM `news_text` WHERE news_id = {$row["id"]} AND locale_id = {$localeId};"
                );
                if ($newsTextResult) {
                    $newsTextResult = $newsTextResult->fetch_assoc();
                    if ($newsTextResult["title"]) {
                        $news[] = new NewsData(
                            $row["id"],
                            $newsTextResult["title"],
                            $newsTextResult["text"],
                            $row["date"]
                        );
                    }
                }
            }
            return $news;
        } else {
            return null;
        }
    }
}