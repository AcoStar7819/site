<?php

include('./classes/NewsStore.php');

$db = new NewsStore();
$pageId = 1;
if (isset($_COOKIE["pageId"])) {
    $pageId = (int)$_COOKIE["pageId"];
}
if (isset($_POST["newPageId"])) {
    $pageId = (int)$_POST["newPageId"];
    setcookie("pageId", $pageId);
}

$localeId = 1;
if (isset($_COOKIE["localeId"])) {
    $localeId = (int)$_COOKIE["localeId"];
}
if (isset($_POST["newLocaleId"])) {
    $localeId = (int)$_POST["newLocaleId"];
    setcookie("localeId", $localeId);
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
    <form action="/news" method="post" target="_self">
        <input type="hidden" name="newLocaleId" value="" id="curLocale"/>
        <input type="submit" value="Русский" onclick="setLanguage(2)">
        <input type="submit" value="Английский" onclick="setLanguage(1)">
    </form>
</div>
<div class="line">
    <div class="panel" style="margin-bottom: auto;">
        <h1>Создать новость</h1>
        <span>Язык: <?= LocalesStore::getName($localeId) ?></span>
        <form action="/news" method="post" target="_self" autocomplete="off" id="defaultForm">
            <label for="title">Заголовок</label>
            <input type="text" name="title" required>
            <label for="text">Текст</label>
            <input type="text" name="text" required>
            <input type="submit" value="Отправить на сервер" disabled>
            <?php
            if (isset($_POST["title"]) && isset($_POST["text"])) {
                $title = htmlspecialchars($_POST["title"]);
                $text = htmlspecialchars($_POST["text"]);
                if ($title != "" && $text != "") {
                    $db->addNews($title, $text, $localeId);
                    header('Refresh:0; url=news');
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
            <form action="/news" method="post" target="_self" style="
                            display: flex;
                            align-items: center;
                            width: 100%;
                        ">
                <input type="hidden" name="newPageId" value="" id="curPage"/>
                <input type="submit" value="Назад" onclick="setPage(<?= $pageId ?> - 1)">
                <span style=" display: block; margin-top: 15px; "><?= $pageId ?></span>
                <input type="submit" value="Вперёд" onclick="setPage(<?= $pageId ?> + 1)">
            </form>
        </div>
    </div>
</div>
<script src="script.js"></script>
<script>
    function setPage(newPageId) {
        document.querySelector("#curPage").value = newPageId;
    }

    function setLanguage(newLanguage) {
        console.log(newLanguage);
        document.querySelector("#curLocale").value = newLanguage;
    }
</script>
</body>
</html>