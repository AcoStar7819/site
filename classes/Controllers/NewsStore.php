<?php

namespace classes\Controllers;

class NewsStore
{
    private \classes\Database\News $news_db;
    private \classes\Database\NewsText $text_db;

    public function __construct()
    {
        $this->news_db = new \classes\Database\News;
        $this->text_db = new \classes\Database\NewsText;
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

    public function getNews(int $page = 1, int $localeId = 1): array|null
    {
        if (!LocalesStore::isLocaleExists($localeId)) {
            return null;
        }

        $offset = ($page - 1) * 6;
        $result = $this->news_db->run("
        SELECT news.date, news_text.title, news_text.text FROM news 
        INNER JOIN news_text ON news.id = news_text.news_id AND news_text.locale_id = {$localeId} 
        ORDER BY news.date DESC LIMIT 6 OFFSET {$offset};
        ");
        return $result;
    }
}