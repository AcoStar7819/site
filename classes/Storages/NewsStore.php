<?php

namespace classes\Storages;

class NewsStore
{
    private static bool $loaded = false;
    private static \classes\Database\News $news_db;
    private static \classes\Database\NewsText $text_db;

    /**
     * Загрузка статичного класса
     *
     * @return void
     */
    public static function load()
    {
        if (self::$loaded) {
            return;
        }

        self::$loaded = true;

        self::$news_db = new \classes\Database\News;
        self::$text_db = new \classes\Database\NewsText;
    }

    /**
     * Добавление новости
     *
     * @param string $title
     * @param string $text
     * @param int $localeId
     * @param int $newsId
     * @return bool
     */
    public static function addNews(string $title, string $text, int $localeId = 1, int $newsId = 0): bool
    {
        if (!LocalesStore::isLocaleExists($localeId)) {
            return false;
        }

        //  Создание новой записи в таблице с новостями
        if ($newsId == 0) {
            self::$news_db->insert()->run();
            $result = self::$news_db->run("SELECT MAX(id) as id FROM news;");

            if (count($result) > 0) {
                $newsId = $result[0]["id"];
            }
        }

        self::$text_db->insert([
            'news_id' => $newsId,
            'locale_id' => $localeId,
            'title' => $title,
            'text' => $text
        ])->run();

        return true;
    }

    /**
     * Получение новостей (От 0 до 6)
     *
     * @param int $page
     * @param int $localeId
     * @return array|null
     */
    public static function getNews(int $page = 1, int $localeId = 1): array|null
    {
        if (!LocalesStore::isLocaleExists($localeId)) {
            return null;
        }

        $offset = ($page - 1) * 6;
        $result = self::$news_db->run(
            "
        SELECT news.date, news_text.title, news_text.text FROM news 
        INNER JOIN news_text ON news.id = news_text.news_id AND news_text.locale_id = {$localeId} 
        ORDER BY news.date DESC LIMIT 6 OFFSET {$offset};
        "
        );
        return $result;
    }
}

NewsStore::load();