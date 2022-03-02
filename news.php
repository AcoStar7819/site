<?php
    include('./classes/Date.php');
    include('./classes/Database.php');
    $db = new NewsDatabase("root", "");
    $pageId = 1;
    if(isset($_GET["pageId"])) {
        $pageId = (int) $_GET["pageId"];
        if ($pageId < 1)
            $pageId = 1;
    }
?>
<!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>News</title>
    </head>
    <body>
        <div class="navigation">
            <a href="index.php">Основная страница</a>
            <a href="news.php">Новости</a>
        </div>
        <div class="line">
            <div class="panel" style="margin-bottom: auto;">
                <h1>Создать новость</h1>
                <form action="news.php" method="get" target="_self" autocomplete="off" id="defaultForm">
                    <label for="title">Заголовок</label>
                    <input type="text" name="title" required>
                    <label for="text">Текст</label>
                    <input type="text" name="text" required>
                    <input type="submit" value="Отправить на сервер" disabled>
                    <?php
                        if(isset($_GET["title"]) && isset($_GET["text"])) {
                            $title = htmlspecialchars($_GET["title"]);
                            $text = htmlspecialchars($_GET["text"]);
                            if($title != "" && $text != "")
                            {
                                $db->addNews($title, $text);
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
                        $news = $db->getNews($pageId);
                        if ($news) {
                            while($row = $news->fetch_assoc()) {
                                echo "<div class=\"news\"><h2>" . $row["title"] . "</h2>" .
                                      $row["text"] .
                                      "<em>Опубликовано " . Date::getFormattedDate($row["date"], true) . "</em></div>";
                            }
                        } else {
                            echo "<strong>Новостей нет.</strong>";
                        }
                    ?>
                    <!--    Переключение страниц    -->
                    <div class="pagesNav">
                        <a href="news.php?pageId=<?=$pageId - 1?>"> Назад</a>
                        <span><?=$pageId?></span>
                        <a href="news.php?pageId=<?=$pageId + 1?>">Вперёд</a>
                    </div>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>