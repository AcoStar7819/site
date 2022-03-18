<?php

namespace classes\Controllers;
use \classes\Storages\NewsStore as Store;

class News
{
    /**
     * Отображение заполненной страницы с новостями
     *
     * @return void
     */
    public static function render()
    {
        // Номер страницы новостей
        $pageId = 1;
        if (isset($_COOKIE["pageId"])) {
            $pageId = (int)$_COOKIE["pageId"];
        }
        if (isset($_POST["newPageId"])) {
            $pageId = (int)$_POST["newPageId"];
            setcookie("pageId", $pageId);
        }

        // ID языка новостей
        $localeId = 1;
        if (isset($_COOKIE["localeId"])) {
            $localeId = (int)$_COOKIE["localeId"];
        }
        if (isset($_POST["newLocaleId"])) {
            $localeId = (int)$_POST["newLocaleId"];
            setcookie("localeId", $localeId);
        }

        // Добавление новости
        if (isset($_POST["title"]) && isset($_POST["text"])) {
            $title = htmlspecialchars($_POST["title"]);
            $text = htmlspecialchars($_POST["text"]);
            if ($title != "" && $text != "") {
                Store::addNews($title, $text, $localeId);
                header('Refresh:0; url=news');
            }
        }

        // Получение списка новостей
        $loadedNews = "";
        $news = Store::getNews($pageId, $localeId);
        if ($news and count($news) > 0) {
            foreach ($news as $collection) {
                $loadedNews .= "<div class=\"news\"><h2>" . $collection->title . "</h2>" .
                    $collection->text .
                    "<em>Опубликовано " . $collection->date . "</em></div>";
            }
        } else {
            $loadedNews = "<strong>Новостей нет.</strong>";
        }

        // Отображение финальной страницы
        echo render('././Templates/layout.php', [
            'title' => 'Новости',
            'content' => render('././Templates/news.php', [
                'pageId' => $pageId,
                'localeId' => $localeId,
                'loadedNews' => $loadedNews
            ]),
            'additionalNavigation' => render('././Templates/languageSelect.php')
        ]);
    }
}