<?php
    include('./classes/NewsStore.php');

    $db = new NewsStore();
    $pageId = 1;
    if(isset($_GET["pageId"])) {
        $pageId = (int) $_GET["pageId"];
        if ($pageId < 1)
            $pageId = 1;
    }

    $localeId = 1;
    if(isset($_GET["localeId"])) {
        $localeId = (int) $_GET["localeId"];
        if ($localeId < 1)
            $localeId = 1;
    }
?>
<!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>News</title>
    </head>
    <body>
        <div class="navigation">
            <a href="/">Основная страница</a>
            <a href="/news">Новости</a>
            <br>
            <a href="/news?pageId=<?=$pageId?>&localeId=2">Русский</a>
            <a href="/news?pageId=<?=$pageId?>&localeId=1">English</a>
        </div>
        <div class="line">
            <div class="panel" style="margin-bottom: auto;">
                <h1>Создать новость</h1>
                <span>Язык: <?= LocalesStore::getName($localeId) ?></span>
                <form action="/news?localeId=2" method="post" target="_self" autocomplete="off" id="defaultForm">
                    <label for="title">Заголовок</label>
                    <input type="text" name="title" required>
                    <label for="text">Текст</label>
                    <input type="text" name="text" required>
                    <input type="submit" value="Отправить на сервер" disabled>
                    <?php
                        if(isset($_POST["title"]) && isset($_POST["text"])) {
                            $title = htmlspecialchars($_POST["title"]);
                            $text = htmlspecialchars($_POST["text"]);
                            if($title != "" && $text != "")
                            {
                                $db->addNews($title, $text, $localeId);
                                header('Refresh:0; url=news.php');
                            }
                        }
                    ?>
                </form>
            </div>
            <div class="panel">
                <h1>Новости</h1>
                    <!--    Загрузка новостей   -->
                    <?php
                        $news = $db->getNews($pageId, $localeId);
                        if ($news) {
                            foreach ($news as $row) {
                                echo "<div class=\"news\"><h2>" . $row->getTitle() . "</h2>" .
                                    $row->getText() .
                                    "<em>Опубликовано " . $row->getDate() . "</em></div>";
                            }
                        } else {
                            echo "<strong>Новостей нет.</strong>";
                        }
                    ?>
                    <!--    Переключение страниц    -->
                    <div class="pagesNav">
                        <a href="/news?pageId=<?=$pageId - 1?>&localeId=<?=$localeId?>">Назад</a>
                        <span><?=$pageId?></span>
                        <a href="/news?pageId=<?=$pageId + 1?>&localeId=<?=$localeId?>">Вперёд</a>
                    </div>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>