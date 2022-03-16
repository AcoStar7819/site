<?php

include_once('./classes/LocalesStore.php');
include_once('./classes/Date.php');
include_once('./classes/Database/NewsDatabase.php');
include_once('./classes/Database/NewsTextDatabase.php');

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
    private $news_db;
    private $text_db;

    public function __construct()
    {
        $this->news_db = new NewsDatabase();
        $this->text_db = new NewsTextDatabase();
    }

    public function addNews(string $title, string $text, int $localeId = 1, int $newsId = 0): bool
    {
        if (!LocalesStore::isLocaleExists($localeId)) {
            return false;
        }

        //  Создание новой записи в таблице с новостями
        if ($newsId == 0) {

            $this->news_db->insert()->run();
            $result = $this->news_db->run("SELECT MAX(id) as id FROM news;");

            if (count($result) > 0) {
                $newsId = $result[0]["id"];
            }
        }

        $this->text_db->insert([
            'news_id' => $newsId,
            'locale_id' => $localeId,
            'title' => $title,
            'text' => $text
        ])->run();

        return true;
    }

    public function getNews(int $page = 1, int $localeId = 1)
    {
        if (!LocalesStore::isLocaleExists($localeId)) {
            return null;
        }

        $offset = ($page - 1) * 6;
        $this->news_db->order("date")->limit(6)->offset($offset)->select();
        $result = $this->news_db->run();
        $news = [];
        if (count($result) > 0) {
            foreach ($result as $row) {
                $this->text_db->where("news_id", $row["id"])->and()->where("locale_id", $localeId);
                $text = $this->text_db->select()->run();
                if (count($text) > 0)
                {
                    $text = $text[0];
                    $news[] = new NewsData(
                        $row["id"],
                        $text["title"],
                        $text["text"],
                        $row["date"]
                    );
                }
            }
            return $news;
        } else {
            return null;
        }
    }
}