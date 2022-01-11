<?php
    include('./classes/Date.php');
    include('./classes/Database.php');
    $db = new Database("root", "");
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
                    <?php
                        $news = $db->getNews();
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
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>